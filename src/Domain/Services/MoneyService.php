<?php

namespace Alcoline\Daniel\Domain\Services;

use Money\Currencies\ISOCurrencies;
use Money\Currency;
use Money\Parser\DecimalMoneyParser;
use Money\Money;

class MoneyService
{
    public function createMoneyFromUserInput(string $amount, string $currencyCode): Money
    {
        $currencies = new ISOCurrencies();
        $moneyParser = new DecimalMoneyParser($currencies);
        return  $moneyParser->parse($amount, new Currency($currencyCode));
    }

    public function formatMoney(Money $money): string
    {
        $amount = $money->getAmount() / 100; // Преобразуем сумму в десятичное значение
        $currency = $money->getCurrency()->getCode(); // Получаем код валюты

        // Возвращаем форматированную строку
        return sprintf('%s %s', $currency, number_format($amount, 2, '.', ','));
    }
}