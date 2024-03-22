<?php

require __DIR__ . '/../vendor/autoload.php';

use Alcoline\Daniel\Infrastructure\Repository\ProductRepository;
use Alcoline\Daniel\Application\Service\VendingMachineService;
use Alcoline\Daniel\Infrastructure\Controller\ConsoleController;
use Alcoline\Daniel\Domain\Services\CurrencyFormatter;
use Alcoline\Daniel\Infrastructure\Storage\MYSQLConnection;
use Money\Currency;
use Money\Parser\DecimalMoneyParser;
use Money\Currencies\ISOCurrencies;

$command = $argv[1] ?? null;
$args = array_slice($argv, 2);


$db = new MYSQLConnection();
$productRepository = new ProductRepository($db);
$moneyParser = new DecimalMoneyParser(new ISOCurrencies());
$moneyService = new CurrencyFormatter();
$vendingMachineService = new VendingMachineService($productRepository, $moneyParser, new Currency('USD'), $moneyService);

$consoleController = new ConsoleController($vendingMachineService);
$consoleController->run($command, $args);