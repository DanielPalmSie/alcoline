<?php

namespace Alcoline\Daniel\Application\Service;

use Alcoline\Daniel\Domain\Entity\Product;
use Alcoline\Daniel\Domain\Repository\ProductRepositoryInterface;
use Alcoline\Daniel\Domain\Services\MoneyService;
use Alcoline\Daniel\Domain\ValueObject\Name;
use Alcoline\Daniel\Domain\ValueObject\Stock;
use Money\Currency;
use Money\Money;
use Money\MoneyParser;

class VendingMachineService
{
    private ProductRepositoryInterface $productRepository;
    private MoneyParser $moneyParser;
    private Currency $currency;
    private MoneyService $moneyService;

    private const VALID_COINS = [0.01, 0.05, 0.10, 0.25, 0.50, 1.00];

    public function __construct(
        ProductRepositoryInterface $productRepository,
        MoneyParser $moneyParser,
        Currency $currency,
        MoneyService $moneyService,
    ) {
        $this->productRepository = $productRepository;
        $this->moneyParser = $moneyParser;
        $this->currency = $currency;
        $this->moneyService = $moneyService;
    }

    /**
     * Displays all products.
     *
     * @return string
     */
    public function displayProducts(): string
    {
        $products = $this->productRepository->findAll();
        $display = "Products available:\n";
        foreach ($products as $product) {
            /** @var Product $product */
            $display .= sprintf("%s - %s\n", $product->getName(), $this->moneyService->formatMoney($product->getPrice()));
        }
        return $display;
    }

    /**
     * Selects a product and shows its price.
     *
     * @param string $productName
     * @return string
     */
    public function selectProduct(string $productName): string
    {
        $name = new Name($productName);
        $product = $this->productRepository->findByName($name);

        if ($product === null) {
            return "Product not found.";
        }

        return sprintf("You selected %s. Price: %s\n", $product->getName(), $this->moneyService->formatMoney($product->getPrice()));
    }

    private function validateCoins(array $coins): bool
    {
        foreach ($coins as $coin) {
            if (!in_array((float)$coin, self::VALID_COINS, true)) {
                return false; // Найден недопустимый номинал
            }
        }
        return true; // Все монеты допустимы
    }

    /**
     * Accepts coins and returns the product and change if applicable.
     *
     * @param string $productName
     * @param array $coins Array of strings representing the coins inserted.
     * @return string
     */
    public function purchaseProduct(string $productName, array $coins): string
    {
        if (!$this->validateCoins($coins)) {
            return "One or more coins are of invalid denomination.";
        }

        $name = new Name($productName);
        $product = $this->productRepository->findByName($name);

        if ($product === null) {
            return "Product not found.";
        }

        $totalInserted = new Money(0, $this->currency);
        foreach ($coins as $coin) {
            $totalInserted = $totalInserted->add($this->moneyParser->parse((string)$coin, $this->currency));
        }

        if ($totalInserted->lessThan($product->getPrice())) {
            return "Insufficient amount inserted.";
        }

        $change = $totalInserted->subtract($product->getPrice());

        // Update product stock
        $newStock = new Stock($product->getStock()->getValue() - 1);
        $product->setStock($newStock);
        $this->productRepository->save($product);

        return sprintf("Product dispensed: %s. Change: %s\n", $product->getName(), $this->moneyService->formatMoney($change));
    }
}