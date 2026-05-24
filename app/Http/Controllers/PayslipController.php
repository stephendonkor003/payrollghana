<?php

namespace App\Http\Controllers;

use App\Models\CompanySetting;
use App\Models\Payslip;
use App\Services\PayslipQrCode;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;

class PayslipController extends Controller
{
    public function mine(Request $request)
    {
        $payslips = Payslip::with('payrollRun')
            ->where('employee_id', $request->user()->employee_id)
            ->latest()
            ->get();

        return view('payslips.mine', compact('payslips'));
    }

    public function mineShow(Request $request, Payslip $payslip)
    {
        $this->authorizeOwnPayslip($request, $payslip);

        return $this->show($payslip);
    }

    public function mineDownload(Request $request, Payslip $payslip)
    {
        $this->authorizeOwnPayslip($request, $payslip);

        return $this->download($payslip, app(PayslipQrCode::class));
    }

    public function show(Payslip $payslip)
    {
        $payslip->load('payrollRun', 'employee', 'paymentStatusUpdater');

        return view('payslips.show', $this->viewData($payslip));
    }

    public function download(Payslip $payslip, PayslipQrCode $qrCode)
    {
        $payslip->load('payrollRun', 'employee', 'paymentStatusUpdater');
        $viewData = $this->viewData($payslip);
        $viewData['qrCode'] = $qrCode->dataUri($viewData['verificationUrl']);

        try {
            $pdf = Pdf::loadView('payslips.pdf', $viewData)->setPaper('a4');
            $fileName = $this->downloadFileName($payslip);

            return response($pdf->output(), 200, [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => 'attachment; filename="'.$fileName.'"',
            ]);
        } catch (\Throwable $exception) {
            Log::error('Payslip PDF download failed', [
                'payslip_id' => $payslip->id,
                'employee_number' => $payslip->employee_number,
                'error' => $exception->getMessage(),
            ]);

            return back()->withErrors(['download' => 'The payslip PDF could not be generated. Please try again.']);
        }
    }

    public function verify(string $token, PayslipQrCode $qrCode)
    {
        $payslip = Payslip::with('payrollRun', 'employee', 'paymentStatusUpdater')
            ->where('verification_token', $token)
            ->firstOrFail();

        $viewData = $this->viewData($payslip);
        $viewData['qrCode'] = $qrCode->dataUri($viewData['verificationUrl']);

        return view('payslips.verify', $viewData);
    }

    public function updatePaymentStatus(Request $request, Payslip $payslip)
    {
        $data = $request->validate([
            'payment_status' => ['required', Rule::in(array_keys(Payslip::paymentStatuses()))],
            'paid_amount' => ['nullable', 'numeric', 'min:0', 'max:'.$payslip->net_pay],
            'payment_note' => ['nullable', 'string', 'max:1000'],
        ]);

        $paidAmount = (float) ($data['paid_amount'] ?? $payslip->paid_amount ?? 0);

        if ($data['payment_status'] === Payslip::STATUS_PAID) {
            $paidAmount = (float) $payslip->net_pay;
        }

        if (in_array($data['payment_status'], [Payslip::STATUS_PENDING, Payslip::STATUS_PROCESSING, Payslip::STATUS_RETURNED_TO_BANK, Payslip::STATUS_CANCELLED], true)) {
            $paidAmount = 0;
        }

        $payslip->update([
            'payment_status' => $data['payment_status'],
            'paid_amount' => round($paidAmount, 2),
            'payment_note' => $data['payment_note'] ?? null,
            'payment_status_updated_by' => $request->user()->id,
            'payment_status_updated_at' => now(),
        ]);

        activity('payslip-payments')
            ->causedBy($request->user())
            ->performedOn($payslip)
            ->withProperties([
                'payment_status' => $payslip->payment_status,
                'paid_amount' => $payslip->paid_amount,
                'balance' => $payslip->payment_balance,
            ])
            ->log('Updated payslip payment status');

        return back()->with('status', 'Payslip payment status updated.');
    }

    private function authorizeOwnPayslip(Request $request, Payslip $payslip): void
    {
        abort_unless($request->user()->employee_id && (int) $request->user()->employee_id === (int) $payslip->employee_id, 403);
    }

    private function viewData(Payslip $payslip): array
    {
        $token = $payslip->ensureVerificationToken();
        $verificationUrl = route('payslips.verify', $token);

        return [
            'company' => CompanySetting::current(),
            'payslip' => $payslip,
            'verificationUrl' => $verificationUrl,
            'qrCode' => app(PayslipQrCode::class)->dataUri($verificationUrl),
            'paymentStatuses' => Payslip::paymentStatuses(),
        ];
    }

    private function downloadFileName(Payslip $payslip): string
    {
        $employeeNumber = preg_replace('/[^A-Za-z0-9_-]+/', '-', $payslip->employee_number);
        $period = $payslip->payrollRun->period_end->format('Y-m');

        return trim("payslip-{$employeeNumber}-{$period}", '-').'.pdf';
    }
}
