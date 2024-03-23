
# Project Name

## Getting Started

To start the project, you need to execute the `start.sh` script. This will launch all necessary Docker containers, including the PHP application and the MySQL database.

```bash
./start.sh
```

## Testing the Project

Once the project is up and running, you can test it by executing commands from within the PHP container. First, you need to enter the PHP container:

```bash
docker exec -it myapp_php bash
```

Then, navigate to the `public` directory relative to the root directory you find yourself in after entering the container:

```bash
cd public
```

From here, you can test the project functionality with the following commands:

1. **List all products:**

```bash
php index.php list
```

This command will display a list of all available products.

2. **Select a specific product (e.g., Coca-Cola):**

```bash
php index.php select Coca-Cola
```

This will show detailed information about the product.

3. **Purchase a product with the correct denomination:**

```bash
php index.php purchase "Coca-Cola" 0.25 0.25 0.50 1.00
```

This simulates the purchase of a product using the correct coin denominations.

4. **Attempt to purchase a product with an incorrect denomination:**

```bash
php index.php purchase "Coca-Cola" 0.02 0.05 1.00
```

This attempts to purchase a product using incorrect coin denominations and should result in an error message.

These commands allow you to interact with the vending machine application, testing its functionality regarding listing, selecting, and purchasing products.
