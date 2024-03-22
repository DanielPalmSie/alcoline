<?php

namespace Alcoline\Daniel\Domain\Services;

use Money\Money;

interface CurrencyFormatterInterface
{
    public function formatMoney(Money $money): string;
}