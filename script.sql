CREATE TABLE IF NOT EXISTS products (
                                        id INT AUTO_INCREMENT PRIMARY KEY,
                                        name VARCHAR(255) NOT NULL,
    price DECIMAL(10, 2) NOT NULL,
    stock INT NOT NULL
    );

INSERT INTO products (name, price, stock) VALUES
                                              ('Coca-Cola', 1.50, 50),
                                              ('Snickers', 1.20, 50),
                                              ('Lay\'s Chips', 2.00, 50),
('Pepsi', 1.50, 50),
('Mars Bar', 1.25, 50),
('Sprite', 1.50, 50),
('Fanta', 1.50, 50),
('Doritos', 1.75, 50),
('Twix', 1.30, 50),
('Kit Kat', 1.20, 50),
('Mountain Dew', 1.50, 50),
('Cheese Sandwich', 2.50, 50),
('Water Bottle', 1.00, 50)

