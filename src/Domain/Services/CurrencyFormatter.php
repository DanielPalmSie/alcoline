<?php

namespace Alcoline\Daniel\Domain\Services;

use Money\Money;

class CurrencyFormatter implements CurrencyFormatterInterface
{
    public function formatMoney(Money $money): string
    {
        $amount = $money->getAmount() / 100;
        $currency = $money->getCurrency()->getCode();

        return sprintf('%s %s', $currency, number_format($amount, 2, '.', ','));
    }
}