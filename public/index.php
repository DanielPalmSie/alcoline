<?php

require __DIR__ . '/../vendor/autoload.php';

use Alcoline\Daniel\Infrastructure\Repository\ProductRepository;
use Alcoline\Daniel\Application\Service\VendingMachineService;
use Money\Parser\DecimalMoneyParser; // Assume you have this class
use Money\Currencies\ISOCurrencies; // Assume you have this class

// Parse the command line arguments
$command = $argv[1] ?? null;
$args = array_slice($argv, 2);

// Initialize the service and dependencies
$productRepository = new ProductRepository();
$moneyParser = new DecimalMoneyParser(new ISOCurrencies());
$moneyService = new \Alcoline\Daniel\Domain\Services\MoneyService();
$vendingMachineService = new VendingMachineService($productRepository, $moneyParser, new \Money\Currency('USD'), $moneyService);

// Handle the command
switch ($command) {
    case 'list':
        echo $vendingMachineService->displayProducts();
        break;

    case 'select':
        $productName = $args[0] ?? null;
        if (!$productName) {
            echo "Please specify a product name.\n";
            break;
        }
        echo $vendingMachineService->selectProduct($productName);
        break;

    case 'purchase':
        $productName = $args[0] ?? null;
        $coins = array_slice($args, 1);
        if (!$productName || empty($coins)) {
            echo "Please specify a product name followed by coins.\n";
            break;
        }
        echo $vendingMachineService->purchaseProduct($productName, $coins);
        break;

    default:
        echo "Unknown command.\n";
        echo "Usage: php index.php [list|select|purchase] ...\n";
        break;
}