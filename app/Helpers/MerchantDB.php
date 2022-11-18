<?php

namespace App\Helpers;

class MerchantDB
{
    const register = [
        "A" => [
            "payment" => [
                "bank_transfer" => [
                    "value" => 2,
                    "type" => "percent"
                ],
                "pix" => [
                    "value" => 2,
                    "type" => "percent"
                ],
                "bank_slip" => [
                    "value" => 2,
                    "type" => "percent"
                ],
            ],
            "payout" => [
                "value" => 1,
                "type" => "percent"
            ],
            "balance" => 300,
        ],
        "B" => [
            "payment" => [
                "bank_transfer" => [
                    "value" => 1,
                    "type" => "value"
                ],
                "pix" => [
                    "value" => 1,
                    "type" => "value"
                ],
                "bank_slip" => [
                    "value" => 1,
                    "type" => "value"
                ],
            ],
            "payout" => [
                "value" => 5,
                "type" => "percent"
            ],
            "balance" => 350,
        ],
        "C" => [
            "payment" => [
                "bank_transfer" => [
                    "value" => 2,
                    "type" => "value"
                ],
                "pix" => [
                    "value" => 3,
                    "type" => "value"
                ],
                "bank_slip" => [
                    "value" => 4,
                    "type" => "value"
                ],
            ],
            "payout" => [
                "value" => 1,
                "type" => "value"
            ],
            "balance" => 10,
        ],
        "D" => [
            "payment" => [
                "bank_transfer" => [
                    "value" => 2,
                    "type" => "percent"
                ],
                "pix" => [
                    "value" => 2,
                    "type" => "percent"
                ],
                "bank_slip" => [
                    "value" => 4,
                    "type" => "value"
                ],
            ],
            "payout" => [
                "value" => 1,
                "type" => "percent"
            ],
            "balance" => 3000,
        ],
    ];

    static function all()
    {
        return self::register;
    }

}

