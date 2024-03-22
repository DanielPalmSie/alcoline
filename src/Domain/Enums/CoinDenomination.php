<?php

namespace Alcoline\Daniel\Domain\Enums;

enum CoinDenomination: string
{
    case Penny = '0.01';
    case Nickel = '0.05';
    case Dime = '0.10';
    case Quarter = '0.25';
    case HalfDollar = '0.50';
    case Dollar = '1.00';
}