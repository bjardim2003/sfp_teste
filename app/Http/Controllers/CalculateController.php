<?php

namespace App\Http\Controllers;

use App\Helpers\Calculate;
use App\Helpers\MerchantDB;
use App\Http\Requests\MerchantPayoutRequest;
use App\Http\Requests\MerchantRequest;

class CalculateController extends Controller
{
    public function calculate_payment(MerchantRequest $request)
    {
        if (!isset(MerchantDB::all()[$request->merchant_id])) {
            return response([
                "status" => "ERROR",
                "message" => "Merchant not found",
            ], 421);
        }

        $value = MerchantDB::all()[$request->merchant_id]["payment"][$request->payment_method]["value"];
        $type = MerchantDB::all()[$request->merchant_id]["payment"][$request->payment_method]["type"];
        $current_balance = MerchantDB::all()[$request->merchant_id]["balance"];

        $calculated = (new Calculate)->payment($request->amount, $value, $type, $current_balance);

        return response($calculated, 200);
    }

    public function calculate_payout(MerchantPayoutRequest $request)
    {
        if (!isset(MerchantDB::all()[$request->merchant_id])) {
            return response([
                "status" => "ERROR",
                "message" => "Merchant not found",
            ], 421);
        }

        $value = MerchantDB::all()[$request->merchant_id]["payout"]["value"];
        $type = MerchantDB::all()[$request->merchant_id]["payout"]["type"];
        $current_balance = MerchantDB::all()[$request->merchant_id]["balance"];

        $calculated = (new Calculate)->payout($request->amount, $value, $type, $current_balance);

        return response($calculated, 200);
    }
}
