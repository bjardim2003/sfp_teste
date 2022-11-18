<?php

namespace App\Helpers;

class Calculate
{
    public function payment(float $amount, float $payment_commission_value, string $payment_commission_type, float $current_balance)
    {
        return $this->calculate($amount, $payment_commission_value, $payment_commission_type, $current_balance);
    }

    public function payout(float $amount, float $payment_commission_value, string $payment_commission_type, float $current_balance)
    {
        return $this->calculate($amount, $payment_commission_value, $payment_commission_type, $current_balance);
    }

    /**
     * @param float $value
     * @param string $payment_commission_value
     * @param string $payment_commission_type
     * @param float $current_balance
     * @return array
     */
    protected function calculate(float $amount, float $payment_commission_value, string $payment_commission_type, float $current_balance): array
    {
        list($commission, $amount_without_commission) = $this->calculateCommission($payment_commission_value, $payment_commission_type, $amount);

        return $this->setCommissionToArray($current_balance, $amount_without_commission, $amount, $commission);
    }

    /**
     * @param float $payment_commission_value
     * @param string $payment_commission_type
     * @param float $amount
     * @return array
     */
    protected function calculateCommission(float $payment_commission_value, string $payment_commission_type, float $amount): array
    {
        $commission = $payment_commission_value;
        if ($payment_commission_type == "percent") {
            $commission = ($payment_commission_value / 100) * $amount;
        }
        $amount_without_commission = $amount - $commission;

        return array($commission, $amount_without_commission);
    }

    /**
     * @param float $current_balance
     * @param mixed $amount_without_commission
     * @param float $amount
     * @param mixed $commission
     * @return array
     */
    protected function setCommissionToArray(float $current_balance, mixed $amount_without_commission, float $amount, mixed $commission): array
    {
        $return_value['old_balance'] = $current_balance;
        $return_value['new_balance'] = $current_balance + $amount_without_commission;
        $return_value['amount'] = $amount;
        $return_value['commission'] = $commission;

        return $return_value;
    }

}
