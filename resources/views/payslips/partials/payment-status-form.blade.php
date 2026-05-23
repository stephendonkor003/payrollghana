<form class="panel" method="post" action="{{ route('payslips.payment-status.update', $payslip) }}">
    @csrf
    @method('patch')
    <h2>Payment Status</h2>
    <p class="muted">Update the bank payment status that appears on the QR verification page.</p>
    <div class="form-grid">
        <div>
            <label>Status</label>
            <select name="payment_status" required>
                @foreach ($paymentStatuses as $value => $label)
                    <option value="{{ $value }}" @selected(old('payment_status', $payslip->payment_status) === $value)>{{ $label }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label>Paid Amount (GHS)</label>
            <input type="number" step="0.01" min="0" max="{{ $payslip->net_pay }}" name="paid_amount" value="{{ old('paid_amount', $payslip->paid_amount) }}">
        </div>
        <div>
            <label>Net Pay (GHS)</label>
            <input value="{{ number_format((float) $payslip->net_pay, 2) }}" readonly>
        </div>
        <div class="full">
            <label>Payment Note</label>
            <textarea name="payment_note" placeholder="Example: Returned by bank because account number could not be validated.">{{ old('payment_note', $payslip->payment_note) }}</textarea>
        </div>
    </div>
    <div class="actions" style="margin-top:16px">
        <button class="btn primary">Save Status</button>
        <button class="btn" type="submit" name="payment_status" value="paid">Mark Paid</button>
        <button class="btn" type="submit" name="payment_status" value="partially_paid">Mark Partially Paid</button>
        <button class="btn" type="submit" name="payment_status" value="returned_to_bank">Returned to Bank</button>
    </div>
</form>
