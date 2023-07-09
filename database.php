<?php
class Database
{
    private $connection;
    function __construct()
    {
        $this->connect_db();
    }

    // Connect to the database
    public function connect_db()
    {
        $this->connection = mysqli_connect('n/a', 'n/a', 'n/a', 'n/a');
        if (mysqli_connect_error()) {
            die("Database Connection Failed" . mysqli_connect_error() . mysqli_connect_error());
        }
    }

    // Create a new order
    public function create($pizza_type, $pizza_size, $extra_toppings, $quantity, $special_requests, $delivery_address, $city, $postal_code, $phone_number)
    {
        $sql = "INSERT INTO pizzaOrders (pizza_type, pizza_size, extra_toppings, quantity, special_requests, delivery_address, city, postal_code, phone_number) VALUES ('$pizza_type', '$pizza_size', '$extra_toppings', '$quantity', '$special_requests', '$delivery_address', '$city', '$postal_code', '$phone_number')";
        $res = mysqli_query($this->connection, $sql);
        if ($res) {
            return true;
        } else {
            echo "Error: " . mysqli_error($this->connection);
            return false;
        }
    }

    // Sanitize the data
    public function sanitize($var)
    {
        $return = mysqli_real_escape_string($this->connection, $var);
        return $return;
    }

    // Fetch most recent order
    public function readLastOrder()
    {
        $query = "SELECT * FROM pizzaOrders ORDER BY id DESC LIMIT 1";
        $result = $this->connection->query($query);

        if ($result->num_rows > 0) {
            return $result->fetch_assoc();
        }

        return null;
    }

    // Clear all records from the database
    public function clearAllOrders()
    {
        $sql = "DELETE FROM pizzaOrders";
        $res = mysqli_query($this->connection, $sql);
        if (!$res) {
            die("Clearing orders failed: " . mysqli_error($this->connection));
        }
    }
}

$database = new Database();
$lastOrder = $database->readLastOrder();
