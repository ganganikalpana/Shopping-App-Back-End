<?php
namespace App\Services;

use App\Models\Payments;
use App\Models\Payment; // Import the Payment model

class PaymentService
{
    public function processPayment($orderId)
    {
        $payment = Payments::where('order_id', $orderId)->first();

        if ($payment) {
            $payment->status = 'paid'; // Update with your logic

            return true;
        }

        return false;
    }

}
