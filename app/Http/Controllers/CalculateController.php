<?php

namespace App\Http\Controllers;

use App\Http\Requests\MerchantRequest;
use Illuminate\Http\Request;

class CalculateController extends Controller
{

    protected $merchants = [];
    protected $payment_methods = [];

    public function __construct()
    {
        $this->fakerValues();
    }

    public function calculate_payment(MerchantRequest $request)
    {
        if (!isset($this->merchants[$request->merchant_id])) {
            return response([
                "status" => "ERROR",
                "message" => "Merchant not found",
            ], 421);
        }

        $calculated = $this->calculatePayment($request->amount, $request->payment_method, $request->merchant_id);

        return response($calculated, 200);
    }

    public function calculate_payout(Request $request)
    {
        if (!isset($this->merchants[$request->merchant_id])) {
            return response([
                "status" => "ERROR",
                "message" => "Merchant not found",
            ], 421);
        }

        if ($request->amount <= 0) {
            return response([
                "status" => "ERROR",
                "message" => "Amount must be positive and less than zero",
            ], 421);
        }

        $calculated = $this->calculatePayout($request->amount, $request->merchant_id);

        return response($calculated, 200);
    }

    /**
     * @param float $value
     * @param string $payment_method
     * @param string $merchant_id
     * @return array
     */
    public function calculatePayment(float $amount, string $payment_method, string $merchant_id): array
    {
        $payment_commission_value = $this->merchants[$merchant_id]["payment"][$payment_method]["value"];
        $payment_commission_type = $this->merchants[$merchant_id]["payment"][$payment_method]["type"];

        $commission = $payment_commission_value;
        if ($payment_commission_type == "percent")
        {
            $commission = ($payment_commission_value/100)*$amount;
        }

        $amount_without_commission = $amount - $commission;

        $return_value['old_balance'] = $this->merchants[$merchant_id]["balance"];
        $return_value['new_balance'] = $this->merchants[$merchant_id]["balance"] + $amount_without_commission;
        $return_value['amount'] = $amount;
        $return_value['commission'] = $commission;

        return $return_value;
    }

    /**
     * @param float $value
     * @param string $merchant_id
     * @return array
     */
    public function calculatePayout(float $amount, string $merchant_id): array
    {
        $payment_commission_value = $this->merchants[$merchant_id]["payout"]["value"];
        $payment_commission_type = $this->merchants[$merchant_id]["payout"]["type"];

        $commission = $payment_commission_value;
        if ($payment_commission_type == "percent")
        {
            $commission = ($payment_commission_value/100)*$amount;
        }

        $amount_without_commission = $amount - $commission;

        $return_value['old_balance'] = $this->merchants[$merchant_id]["balance"];
        $return_value['new_balance'] = $this->merchants[$merchant_id]["balance"] + $amount_without_commission;
        $return_value['amount'] = $amount;
        $return_value['commission'] = $commission;

        return $return_value;
    }

    /**
     * @return void
     */
    public function fakerValues(): void
    {
        $this->payment_methods = array(
            "bank_transfer",
            "pix",
            "bank_slip",
        );

        $this->merchants["A"] = array(
            "payment" => array(
                "bank_transfer" => array(
                    "value" => 2,
                    "type" => "percent"
                ),
                "pix" => array(
                    "value" => 2,
                    "type" => "percent"
                ),
                "bank_slip" => array(
                    "value" => 2,
                    "type" => "percent"
                ),
            ),
            "payout" => array(
                "value" => 1,
                "type" => "percent"
            ),
            "balance" => 300,
        );

        $this->merchants["B"] = array(
            "payment" => array(
                "bank_transfer" => array(
                    "value" => 1,
                    "type" => "value"
                ),
                "pix" => array(
                    "value" => 1,
                    "type" => "value"
                ),
                "bank_slip" => array(
                    "value" => 1,
                    "type" => "value"
                ),
            ),
            "payout" => array(
                "value" => 5,
                "type" => "percent"
            ),
            "balance" => 350,
        );

        $this->merchants["C"] = array(
            "payment" => array(
                "bank_transfer" => array(
                    "value" => 2,
                    "type" => "value"
                ),
                "pix" => array(
                    "value" => 3,
                    "type" => "value"
                ),
                "bank_slip" => array(
                    "value" => 4,
                    "type" => "value"
                ),
            ),
            "payout" => array(
                "value" => 1,
                "type" => "value"
            ),
            "balance" => 10,
        );

        $this->merchants["D"] = array(
            "payment" => array(
                "bank_transfer" => array(
                    "value" => 2,
                    "type" => "percent"
                ),
                "pix" => array(
                    "value" => 2,
                    "type" => "percent"
                ),
                "bank_slip" => array(
                    "value" => 4,
                    "type" => "value"
                ),
            ),
            "payout" => array(
                "value" => 1,
                "type" => "percent"
            ),
            "balance" => 3000,
        );
    }
}
