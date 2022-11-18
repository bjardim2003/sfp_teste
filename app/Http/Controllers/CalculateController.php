<?php

namespace App\Http\Controllers;

use App\Helpers\Calculate;
use App\Helpers\fakerDB;
use App\Http\Requests\MerchantPayoutRequest;
use App\Http\Requests\MerchantRequest;
use Illuminate\Http\Request;

class CalculateController extends Controller
{
    public function calculate_payment(MerchantRequest $request)
    {
        if (!isset(fakerDB::get()[$request->merchant_id])) {
            return response([
                "status" => "ERROR",
                "message" => "Merchant not found",
            ], 421);
        }

        $value = fakerDB::get()[$request->merchant_id]["payment"][$request->payment_method]["value"];
        $type = fakerDB::get()[$request->merchant_id]["payment"][$request->payment_method]["type"];
        $current_balance = fakerDB::get()[$request->merchant_id]["balance"];

        $calculated = (new Calculate)->payment($request->amount, $value, $type, $current_balance);

        return response($calculated, 200);
    }

    public function calculate_payout(MerchantPayoutRequest $request)
    {
        if (!isset(fakerDB::get()[$request->merchant_id])) {
            return response([
                "status" => "ERROR",
                "message" => "Merchant not found",
            ], 421);
        }

        $value = fakerDB::get()[$request->merchant_id]["payout"]["value"];
        $type = fakerDB::get()[$request->merchant_id]["payout"]["type"];
        $current_balance = fakerDB::get()[$request->merchant_id]["balance"];

        $calculated = (new Calculate)->payout($request->amount, $value, $type, $current_balance);

        return response($calculated, 200);
    }
}
