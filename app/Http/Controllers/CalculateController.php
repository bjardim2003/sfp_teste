<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CalculateController extends Controller
{
    public function calculate()
    {
        $value = 200;

        $merchantA_payment = 2;
        $merchantA_payment_type = 'perc';
        $merchantA_payout = 1;
        $merchantA_payout_type = 'perc';
        $calculated['merchant_A'] = $this->calculatePayment($value, $merchantA_payment_type, $merchantA_payment, $merchantA_payout_type, $merchantA_payout, "");

        $merchantB_payment = 1;
        $merchantB_payment_type = 'value';
        $merchantB_payout = 5;
        $merchantB_payout_type = 'perc';
        $calculated['merchant_B'] = $this->calculatePayment($value, $merchantB_payment_type, $merchantB_payment, $merchantB_payout_type, $merchantB_payout, "");

        $merchantC_payout = 1;
        $merchantC_payout_type = 'value';

        $merchantC_payment_pix = 3;
        $merchantC_payment_pix_type = 'value';
        $calculated['merchant_C_pix'] = $this->calculatePayment($value, $merchantC_payment_pix_type, $merchantC_payment_pix, $merchantC_payout_type, $merchantC_payout, "pix");

        $merchantC_payment_boleto = 3;
        $merchantC_payment_boleto_type = 'value';
        $calculated['merchant_C_boleto'] = $this->calculatePayment($value, $merchantC_payment_boleto_type, $merchantC_payment_boleto, $merchantC_payout_type, $merchantC_payout, "boleto");

        $merchantC_payment_ted = 3;
        $merchantC_payment_ted_type = 'value';
        $calculated['merchant_C_ted'] = $this->calculatePayment($value, $merchantC_payment_ted_type, $merchantC_payment_ted, $merchantC_payout_type, $merchantC_payout, "ted");

        $merchantD_payout = 1;
        $merchantD_payout_type = 'perc';

        $merchantD_payment_pix = 2;
        $merchantD_payment_pix_type = 'perc';
        $calculated['merchant_D_pix'] = $this->calculatePayment($value, $merchantD_payment_pix_type, $merchantD_payment_pix, $merchantD_payout_type, $merchantD_payout, "pix");

        $merchantD_payment_boleto = 4;
        $merchantD_payment_boleto_type = 'value';
        $calculated['merchant_D_boleto'] = $this->calculatePayment($value, $merchantD_payment_boleto_type, $merchantD_payment_boleto, $merchantD_payout_type, $merchantD_payout, "boleto");

        $merchantD_payment_ted = 2;
        $merchantD_payment_ted_type = 'perc';
        $calculated['merchant_D_ted'] = $this->calculatePayment($value, $merchantD_payment_ted_type, $merchantD_payment_ted, $merchantD_payout_type, $merchantD_payout, "ted");

        return response($calculated, 200);
    }

    /**
     * @param float $value
     * @param string $payment_type
     * @param float $payment
     * @param string $payout_type
     * @param float $payout
     * @param string $type_payment
     * @return array
     */

    public function calculatePayment(float $value, string $payment_type, float $payment, string $payout_type, float $payout, string $type_payment): array
    {
        $return_value = [];
        $return_value['total_amount'] = $value;
        $return_value['$type_payment'] = $type_payment;

        if ($value == 0) {
            return $return_value;
        }

        if ($payment == 0) {
            return $return_value;
        }

        if ($payment_type == 'perc') {
            $payment_commission_value = ($payment/100)*$value;
            $return_value['payment']['commission'] = $payment;
            $return_value['payment']['commission_type'] = $payment_type;
            $return_value['payment']['commission_value'] = $payment_commission_value;
        }

        if ($payout_type == 'perc') {
            $payout_commission_value = ($payout/100)*$value;
            $return_value['payout']['commission'] = $payout;
            $return_value['payout']['commission_type'] = $payout_type;
            $return_value['payout']['commission_value'] = $payout_commission_value;
        }

        if ($payment_type == 'value') {
            $payment_commission_value = $payment;
            $return_value['payment']['commission'] = $payment;
            $return_value['payment']['commission_type'] = $payment_type;
            $return_value['payment']['commission_value'] = $payment_commission_value;
        }

        if ($payout_type == 'value') {
            $payout_commission_value = $payout;
            $return_value['payout']['commission'] = $payout;
            $return_value['payout']['commission_type'] = $payout_type;
            $return_value['payout']['commission_value'] = $payout_commission_value;
        }

        $return_value['total_without_commission'] = ($value - $payout_commission_value) - $payment_commission_value;

        return $return_value;
    }
}
