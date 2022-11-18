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
            "pix" => [
                "key" => "123.456.789-09"
            ]
        ];

        $resposta = [
            "old_balance" => 300,
            "new_balance" => 418.8,
            "amount" => 120,
            "commission" => 1.2
        ];

        $this->post(route('calculate_payout'), $payload)->assertOk()->assertJsonFragment($resposta);

    }

    public function test_return_message_error_when_payment_method_dont_exist() {

        $payload = [
            "merchant_id" => "A",
            "customer_id" => "58f0c005-3b7d-4c75-81f3-93b9a6fee864",
            "name" => "Richard Roe",
            "email" => "richard@roe.com",
            "document" => "12345678909",
            "amount" => 120,
            "currency" => "BRL",
            "payment_method" => "nao_valido"
        ];

        $this->post(route('calculate_payment'), $payload)->assertJsonFragment(["payment_method" => ["Payment method not supported"]]);

    }

    public function test_return_message_error_when_payment_method_is_void() {

        $payload = [
            "merchant_id" => "A",
            "customer_id" => "58f0c005-3b7d-4c75-81f3-93b9a6fee864",
            "name" => "Richard Roe",
            "email" => "richard@roe.com",
            "document" => "12345678909",
            "amount" => 120,
            "currency" => "BRL"
        ];

        $this->post(route('calculate_payment'), $payload)->assertJsonFragment(["payment_method" => ["Payment method is required"]]);

    }

    public function test_amount_payment_is_ok() {

        $payload = [
            "merchant_id" => "A",
            "customer_id" => "58f0c005-3b7d-4c75-81f3-93b9a6fee864",
            "name" => "Richard Roe",
            "email" => "richard@roe.com",
            "document" => "12345678909",
            "amount" => 10,
            "currency" => "BRL",
            "payment_method" => "pix"
        ];

        $this->post(route('calculate_payment'), $payload)->assertOK();

    }

    public function test_return_message_when_amount_payment_is_zero() {

        $payload = [
            "merchant_id" => "A",
            "customer_id" => "58f0c005-3b7d-4c75-81f3-93b9a6fee864",
            "name" => "Richard Roe",
            "email" => "richard@roe.com",
            "document" => "12345678909",
            "amount" => 0,
            "currency" => "BRL",
            "payment_method" => "pix"
        ];

        $this->post(route('calculate_payment'), $payload)->assertJsonFragment(["amount" => ["Amount must be positive and less than zero"]]);

    }

    public function test_return_message_when_amount_payment_is_void() {

        $payload = [
            "merchant_id" => "A",
            "customer_id" => "58f0c005-3b7d-4c75-81f3-93b9a6fee864",
            "name" => "Richard Roe",
            "email" => "richard@roe.com",
            "document" => "12345678909",
            "currency" => "BRL",
            "payment_method" => "pix"
        ];

        $this->post(route('calculate_payment'), $payload)->assertJsonFragment(["amount" => ["Amount is required"]]);

    }

    public function test_amount_payout_is_ok() {

        $payload = [
            "merchant_id" => "A",
            "customer_id" => "58f0c005-3b7d-4c75-81f3-93b9a6fee864",
            "name" => "Richard Roe",
            "email" => "richard@roe.com",
            "document" => "12345678909",
            "amount" => 10,
            "currency" => "BRL",
            "pix" => [
                "key" => "123.456.789-09"
            ]
        ];

        $this->post(route('calculate_payout'), $payload)->assertOK();

    }

    public function test_return_message_when_amount_payout_is_zero() {

        $payload = [
            "merchant_id" => "A",
            "customer_id" => "58f0c005-3b7d-4c75-81f3-93b9a6fee864",
            "name" => "Richard Roe",
            "email" => "richard@roe.com",
            "document" => "12345678909",
            "amount" => 0,
            "currency" => "BRL",
            "pix" => [
                "key" => "123.456.789-09"
            ]
        ];

        $this->post(route('calculate_payout'), $payload)->assertJsonFragment(["amount" => ["Amount must be positive and less than zero"]]);

    }

    public function test_return_message_when_amount_payout_is_void() {

        $payload = [
            "merchant_id" => "A",
            "customer_id" => "58f0c005-3b7d-4c75-81f3-93b9a6fee864",
            "name" => "Richard Roe",
            "email" => "richard@roe.com",
            "document" => "12345678909",
            "currency" => "BRL",
            "pix" => [
                "key" => "123.456.789-09"
            ]
        ];

        $this->post(route('calculate_payout'), $payload)->assertJsonFragment(["amount" => ["Amount is required"]]);

    }

}
