<?php

namespace Test\Feature\Http\Controllers;

use Tests\TestCase;

class CalculateControllerTest extends TestCase
{
    public function test_send_payload_payment_is_valid_should_return_200_and_json_message()
    {
        $payload = [
            "merchant_id" => "A",
            "customer_id" => "58f0c005-3b7d-4c75-81f3-93b9a6fee864",
            "name" => "Richard Roe",
            "email" => "richard@roe.com",
            "document" => "12345678909",
            "amount" => 120,
            "currency" => "BRL",
            "payment_method" => "pix"
        ];

        $resposta = [
            "old_balance" => 300,
            "new_balance" => 417.6,
            "amount" => 120,
            "commission" => 2.4
        ];

        $this->post(route('calculate_payment'), $payload)->assertOk()->assertJsonFragment($resposta);

    }

    public function test_send_payload_payout_is_valid_should_return_200_and_json_message()
    {
        $payload = [
            "merchant_id" => "A",
            "customer_id" => "58f0c005-3b7d-4c75-81f3-93b9a6fee864",
            "name" => "Richard Roe",
            "email" => "richard@roe.com",
            "document" => "12345678909",
            "amount" => 120,
            "currency" => "BRL",
            "payment_method" => "pix"
        ];

        $resposta = [
            "old_balance" => 300,
            "new_balance" => 418.8,
            "amount" => 120,
            "commission" => 1.2
        ];

        $this->post(route('calculate_payout'), $payload)->assertOk()->assertJsonFragment($resposta);

    }

}
