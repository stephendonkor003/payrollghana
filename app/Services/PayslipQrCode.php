<?php

namespace App\Services;

use chillerlan\QRCode\QRCode;
use chillerlan\QRCode\QROptions;

class PayslipQrCode
{
    public function dataUri(string $url): string
    {
        $options = new QROptions([
            'scale' => 5,
            'quietzoneSize' => 2,
            'outputBase64' => true,
        ]);

        return (new QRCode($options))->render($url);
    }
}
