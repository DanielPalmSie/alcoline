<?php

namespace Alcoline\Daniel\Infrastructure\Controller;

use Alcoline\Daniel\Application\Service\VendingMachineService;

class ConsoleController
{
    public function __construct(private readonly VendingMachineService $vendingMachineService)
    {}

    public function run(string $command, array $args): void
    {
        switch ($command) {
            case 'list':
                $productsDto = $this->vendingMachineService->displayProducts();
                foreach ($productsDto as $productDto) {
                    echo sprintf("%s - %s\n", $productDto->name, $productDto->price);
                }
                break;

            case 'select':
                $productName = $args[0] ?? null;
                if (!$productName) {
                    echo "Please specify a product name.\n";
                    return;
                }
                echo $this->vendingMachineService->selectProduct($productName);
                break;

            case 'purchase':
                $productName = $args[0] ?? null;
                $coins = array_slice($args, 1);
                if (!$productName || empty($coins)) {
                    echo "Please specify a product name followed by coins.\n";
                    return;
                }
                echo $this->vendingMachineService->purchaseProduct($productName, $coins);
                break;

            default:
                echo "Unknown command.\n";
                echo "Usage: php index.php [list|select|purchase] ...\n";
                break;
        }
    }
}