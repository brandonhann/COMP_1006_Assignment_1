CREATE TABLE pizzaOrders (
    id INT AUTO_INCREMENT PRIMARY KEY,
    pizza_type VARCHAR(20),
    pizza_size VARCHAR(20),
    extra_toppings VARCHAR(255),
    quantity INT,
    special_requests TEXT,
    delivery_address VARCHAR(255),
    city VARCHAR(100),
    postal_code VARCHAR(10),
    phone_number VARCHAR(20),
    delivery BOOLEAN
);