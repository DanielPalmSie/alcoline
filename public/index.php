<?php

require __DIR__ . '/../vendor/autoload.php';

use Alcoline\Daniel\Infrastructure\Repository\ProductRepository;
use Alcoline\Daniel\Application\Service\VendingMachineService;
use Alcoline\Daniel\Infrastructure\Controller\ConsoleController;
use Alcoline\Daniel\Domain\Services\MoneyService;
use Money\Currency;
use Money\Parser\DecimalMoneyParser;
use Money\Currencies\ISOCurrencies;


$command = $argv[1] ?? null;
$args = array_slice($argv, 2);


$productRepository = new ProductRepository();
$moneyParser = new DecimalMoneyParser(new ISOCurrencies());
$moneyService = new MoneyService();
$vendingMachineService = new VendingMachineService($productRepository, $moneyParser, new Currency('USD'), $moneyService);


$consoleController = new ConsoleController($vendingMachineService);
$consoleController->run($command, $args);