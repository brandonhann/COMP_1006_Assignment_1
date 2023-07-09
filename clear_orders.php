<?php
include 'database.php';

$database = new Database();

// Call the clearAllOrders() method if the submit button is clicked
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $database->clearAllOrders();
    header("Location: https://lamp.computerstudi.es/~Brandon200547547/Assignment_1/");
}
