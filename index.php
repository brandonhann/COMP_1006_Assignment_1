<?php
require_once('database.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize input
    $pizzaType = $database->sanitize($_POST['pizza_type']);
    $pizzaSize = $database->sanitize($_POST['pizza_size']);
    $quantity = $database->sanitize($_POST['quantity']);
    $specialRequests = $database->sanitize($_POST['special_requests']);
    $address = $database->sanitize($_POST['address']);
    $city = $database->sanitize($_POST['city']);
    $postalCode = $database->sanitize($_POST['postal_code']);
    $phone = $database->sanitize($_POST['phone']);

    // Manage toppings
    $toppings = ["olives", "cheese", "onions", "mushrooms", "tomato", "bacon"];
    $extraToppings = [];
    // Convert delivery to boolean
    $delivery = $_POST['delivery'] == 'yes' ? 1 : 0;

    // Loop through each topping and add it to the array if it's set
    foreach ($toppings as $topping) {
        if (isset($_POST[$topping])) {
            $extraToppings[] = $database->sanitize($_POST[$topping]);
        }
    }

    // Encode toppings into JSON for easier database storage
    $extraToppingsJson = json_encode($extraToppings);

    // Create the order
    $res = $database->create($pizzaType, $pizzaSize, $extraToppingsJson, $quantity, $specialRequests, $address, $city, $postalCode, $phone);

    /*
    if ($res) {
        print "Successfully inserted data";
    } else {
        print "Failed to insert data";
    }
*/
    // Redirect to index.php
    header("Location: https://lamp.computerstudi.es/~Brandon200547547/Assignment_1/");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Meta Tags -->
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Stylesheet, Fontawesome & Tailwind CDN -->
    <link rel="stylesheet" type="text/css" href="./styles/styles.css">
    <script src="https://kit.fontawesome.com/74bd775b1c.js" crossorigin="anonymous"></script>
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="./images/favicon.ico">

    <!-- Title -->
    <title>Order Pizza</title>
</head>

<body class="bg-gradient-to-b from-orange-50 to-neutral-100 flex flex-col min-h-screen">

    <!-- Header -->
    <header>
        <!-- Navigation -->
        <nav class="bg-orange-100 text-orange-900 p-6">
            <div class="container mx-auto flex items-center justify-between">
                <a href="#" class="flex items-center gap-2 transition ease-in-out delay-50 hover:text-red-500 hover:-translate-y-1 hover:scale-110">
                    <img src="./images/logo.png" alt="Logo" class="hidden md:block w-14 h-14">
                    <span class="text-lg md:text-xl font-bold">Mama Mia' Pizza</span>
                </a>
                <div class="hidden text-xl md:flex font-bold md:gap-4 items-center">
                    <a href="#" class="nav-anchor montserrat p-2 transition ease-in-out delay-50 hover:text-red-500 hover:-translate-y-1 hover:scale-110">Home</a>
                    <a href="#" class="nav-anchor montserrat p-2 transition ease-in-out delay-50 hover:text-red-500 hover:-translate-y-1 hover:scale-110">Menu</a>
                    <a href="#" class="nav-anchor montserrat p-2 transition ease-in-out delay-50 hover:text-red-500 hover:-translate-y-1 hover:scale-110">Contact</a>
                </div>
                <div class="flex items-center text-xl md:text-2xl">
                    <a href="#" target="_blank"><i class="fab fa-facebook mx-2 transition ease-in-out delay-50 hover:text-red-500 hover:-translate-y-1 hover:scale-110"></i></a>
                    <a href="#" target="_blank"><i class="fab fa-twitter mx-2 transition ease-in-out delay-50 hover:text-red-500 hover:-translate-y-1 hover:scale-110"></i></a>
                    <a href="#" target="_blank"><i class="fab fa-instagram mx-2 transition ease-in-out delay-50 hover:text-red-500 hover:-translate-y-1 hover:scale-110"></i></a>
                    <button id="nav-toggle" class="text-2xl md:hidden ml-4 md:ml-0 transition ease-in-out delay-50 hover:text-red-500">
                        <i class="fas fa-bars"></i>
                    </button>
                </div>
            </div>
            <!-- Responsive Nav Menu -->
            <div id="mobile-menu" class="z-50 flex flex-col justify-center items-center fixed text-xl top-0 left-0 w-full h-full bg-red-500 text-center text-white py-10 px-6 hidden md:hidden">
                <a href="#" class="montserrat block py-3">Home</a>
                <a href="#" class="montserrat block py-3">Menu</a>
                <a href="#" class="montserrat block py-3">Contact</a>
            </div>
        </nav>
    </header>



    <div class="container mx-auto mt-0 md:mt-5">
        <!-- Banner Image -->
        <img alt="Pizza Banner" src="./images/banner.jpg" class="w-full h-52 object-cover md:rounded-md">
    </div>

    <main class="w-full px-2 md:px-0 md:w-10/12 flex-grow container mx-auto mt-5 grid lg:grid-cols-4 gap-5">

        <!-- Order Form -->
        <section class="bg-orange-100 bg-opacity-30 text-orange-900 rounded-md p-5 shadow-lg lg:col-span-3 border border-neutral-300">
            <h2 class="text-2xl font-bold mb-5">Order your pizza</h2>
            <img src="./images/texture.avif" alt="Pizza Texture" class="w-full h-5 object-cover rounded-sm mb-4 shadow-sm opacity-50">
            <form id="pizzaOrderForm" class="lg:grid lg:grid-cols-2 lg:gap-4" method="post">

                <!-- Left Column -->
                <div>
                    <!-- Choose your pizza -->
                    <div class="mb-4">
                        <label class="block text-sm font-bold mb-2 text-orange-900" for="pizza_type">
                            Choose your pizza
                        </label>
                        <select class="shadow appearance-none border rounded w-full py-2 px-3 text-orange-900" id="pizza_type" name="pizza_type" required>
                            <option>Pepperoni</option>
                            <option>Meat Lovers</option>
                            <option>Veggie</option>
                            <option>Hawaiian</option>
                        </select>
                    </div>

                    <!-- Size -->
                    <div class="mb-4">
                        <label class="block text-sm font-bold mb-2 text-orange-900" for="pizza_size">
                            Size
                        </label>
                        <div>
                            <!-- Small -->
                            <input type="radio" id="small" name="pizza_size" value="small" required>
                            <label for="small">Small</label>
                            <span class="block"></span>
                            <!-- Medium -->
                            <input type="radio" id="medium" name="pizza_size" value="medium">
                            <label for="medium">Medium</label>
                            <span class="block"></span>
                            <!-- Large -->
                            <input type="radio" id="large" name="pizza_size" value="large">
                            <label for="large">Large</label>
                        </div>
                    </div>

                    <!-- Extra Toppings -->
                    <div class="mb-4 lg:grid lg:grid-cols-3">
                        <div class="lg:col-span-3">
                            <label class="block text-sm font-bold mb-2 text-orange-900" for="extra_toppings">
                                Extra Toppings
                            </label>
                        </div>
                        <div>
                            <!-- Olives -->
                            <div class="flex items-center">
                                <input type="checkbox" id="olives" name="olives" value="olives">
                                <label for="olives" class="ml-2">Olives</label>
                            </div>
                            <!-- Cheese -->
                            <div class="flex items-center">
                                <input type="checkbox" id="cheese" name="cheese" value="cheese">
                                <label for="cheese" class="ml-2">Cheese</label>
                            </div>
                            <!-- Onions -->
                            <div class="flex items-center">
                                <input type="checkbox" id="onions" name="onions" value="onions">
                                <label for="onions" class="ml-2">Onions</label>
                            </div>
                        </div>
                        <div>
                            <!-- Mushrooms -->
                            <div class="flex items-center">
                                <input type="checkbox" id="mushrooms" name="mushrooms" value="mushrooms">
                                <label for="mushrooms" class="ml-2">Mushrooms</label>
                            </div>
                            <!-- Tomato -->
                            <div class="flex items-center">
                                <input type="checkbox" id="tomato" name="tomato" value="tomato">
                                <label for="tomato" class="ml-2">Tomato</label>
                            </div>
                            <!-- Bacon -->
                            <div class="flex items-center">
                                <input type="checkbox" id="bacon" name="bacon" value="bacon">
                                <label for="bacon" class="ml-2">Bacon</label>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Column -->
                <div>
                    <!-- Quantity -->
                    <div class="mb-4">
                        <label class="block text-sm font-bold mb-2 text-orange-900" for="quantity">
                            Quantity
                        </label>
                        <input class="shadow appearance-none border rounded w-full py-2 px-3 leading-tight text-orange-900" id="quantity" type="number" min="1" name="quantity" required>
                    </div>
                    <!-- Any special requests? -->
                    <div class="mb-4">
                        <label for="special_requests" class="block text-sm font-bold mb-2 text-orange-900">
                            Any special requests?
                        </label>
                        <textarea id="special_requests" name="special_requests" class="shadow appearance-none border rounded w-full py-2 px-3 text-orange-900 leading-tight"></textarea>
                    </div>
                    <!-- Delivery? -->
                    <div class="mb-4">
                        <label for="delivery" class="block text-sm font-bold mb-2 text-orange-900">
                            For Delivery?
                        </label>
                        <div>
                            <input type="radio" id="yes" name="delivery" value="yes" required>
                            <label for="yes">Yes</label>
                            <span class="block"></span>
                            <input type="radio" id="no" name="delivery" value="no">
                            <label for="no">No</label>
                        </div>
                    </div>
                </div>

                <!-- Delivery Information -->
                <h2 class="text-2xl font-bold my-5 lg:col-span-2">Delivery Information</h2>

                <!-- Address and City -->
                <div class="lg:grid lg:grid-cols-2 lg:gap-4 lg:col-span-2">
                    <!-- Address -->
                    <div class="mb-4">
                        <label class="block text-orange-900 text-sm font-bold mb-2" for="address">
                            Address
                        </label>
                        <input class="shadow appearance-none border rounded w-full py-2 px-3 text-orange-900 leading-tight" type="text" id="address" name="address" />
                    </div>
                    <!-- City -->
                    <div class="mb-4">
                        <label class="block text-orange-900 text-sm font-bold mb-2" for="city">
                            City
                        </label>
                        <input class="shadow appearance-none border rounded w-full py-2 px-3 text-orange-900 leading-tight" type="text" id="city" name="city" />
                    </div>
                </div>

                <!-- Postal code and Phone number -->
                <div class="lg:grid lg:grid-cols-2 lg:gap-4 lg:col-span-2">
                    <!-- Postal Code -->
                    <div class="mb-4">
                        <label class="block text-orange-900 text-sm font-bold mb-2" for="postal_code">
                            Postal Code
                        </label>
                        <input class="shadow appearance-none border rounded w-full py-2 px-3 text-orange-900 leading-tight" type="text" id="postal_code" name="postal_code" />
                    </div>
                    <!-- Phone Number -->
                    <div class="mb-4">
                        <label class="block text-orange-900 text-sm font-bold mb-2" for="phone">
                            Phone Number
                        </label>
                        <input class="shadow appearance-none border rounded w-full py-2 px-3 text-orange-900 leading-tight" type="tel" id="phone" name="phone" />
                    </div>
                </div>

                <!-- Submit button -->
                <div class="flex items-center justify-between lg:col-span-2">
                    <button class="bg-green-500 shadow-md text-green-50 font-bold py-2 px-4 rounded transition ease-in-out delay-50 hover:shadow-lg hover:translate-y-1 hover:scale-110 hover:bg-green-700 duration-300" type="submit">
                        Preview Order
                    </button>
                </div>

            </form>

        </section>


        <!-- Order Summary -->
        <section class="bg-orange-100 bg-opacity-30 flex flex-col items-center text-orange-900 rounded-md p-5 shadow-lg lg:col-span-1 border border-neutral-300" id="orderDisplay">
            <h2 class="text-2xl font-bold mb-5">Your Order</h2>
            <img src="./images/texture.avif" alt="Pizza Texture" class="w-full h-5 object-cover rounded-sm mb-4 shadow-sm opacity-50">
            <div class="flex-grow w-full mb-5 lg:mb-0">

                <!-- Delivery yes/no Read Table -->
                <?php if ($lastOrder != null) : ?>
                    <div class="overflow-x-auto shadow-md my-5">
                        <table class="w-full table-auto text-center border-collapse">
                            <thead class="bg-orange-100">
                                <tr class="text-sm font-bold">
                                    <th class="border border-orange-200 py-2">Delivery</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="bg-orange-50">
                                    <td class="border border-orange-200 py-2"><?= $lastOrder['delivery'] == 1 ? 'Yes' : 'No' ?></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                <?php endif; ?>

                <!-- Toppings Read Table -->
                <?php if ($lastOrder == null) : ?>
                    <p class="my-5">No orders yet... 😔</p>
                <?php else : ?>
                    <div class="overflow-x-auto shadow-md">
                        <table class="w-full table-auto text-center border-collapse">
                            <thead class="bg-orange-100">
                                <tr class="text-sm font-bold">
                                    <th class="border border-orange-200 py-2">Pizza Type</th>
                                    <th class="border border-orange-200 py-2">Size</th>
                                    <th class="border border-orange-200 py-2">Toppings</th>
                                    <th class="border border-orange-200 py-2">Quantity</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="bg-orange-50">
                                    <td class="border border-orange-200 py-2"><?= $lastOrder['pizza_type'] ?></td>
                                    <td class="border border-orange-200 py-2"><?= $lastOrder['pizza_size'] ?></td>
                                    <td class="border border-orange-200 py-2"><?= implode(", ", json_decode($lastOrder['extra_toppings'])) ?></td>
                                    <td class="border border-orange-200 py-2"><?= $lastOrder['quantity'] ?></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                <?php endif; ?>

                <!-- Special Instructions Read Table -->
                <?php if (!empty($lastOrder['special_requests'])) : ?>
                    <div class="overflow-x-auto shadow-md my-5">
                        <table class="w-full table-auto text-center border-collapse">
                            <thead class="bg-orange-100">
                                <tr class="text-sm font-bold">
                                    <th class="border border-orange-200 py-2">Special Instructions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="bg-orange-50">
                                    <td class="border border-orange-200 py-2"><?= $lastOrder['special_requests'] ?></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                <?php endif; ?>

                <!-- Delivery Read Table -->
                <?php if ($lastOrder != null && (!empty($lastOrder['delivery_address']) || !empty($lastOrder['city']) || !empty($lastOrder['postal_code']) || !empty($lastOrder['phone_number']))) : ?>
                    <div class="overflow-x-auto shadow-md mb-5">
                        <table class="w-full table-auto text-center border-collapse">
                            <thead class="bg-orange-100">
                                <tr class="text-sm font-bold">
                                    <th class="border border-orange-200 py-2">Delivery Address</th>
                                    <th class="border border-orange-200 py-2">City</th>
                                    <th class="border border-orange-200 py-2">Postal Code</th>
                                    <th class="border border-orange-200 py-2">Phone Number</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="bg-orange-50">
                                    <td class="border border-orange-200 py-2"><?= $lastOrder['delivery_address'] ?></td>
                                    <td class="border border-orange-200 py-2"><?= $lastOrder['city'] ?></td>
                                    <td class="border border-orange-200 py-2"><?= $lastOrder['postal_code'] ?></td>
                                    <td class="border border-orange-200 py-2"><?= $lastOrder['phone_number'] ?></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                <?php endif; ?>

            </div>

            <!-- Submit button -->
            <div class="flex flex-col items-center gap-4 mt-auto">
                <form method="POST" action="clear_orders.php">
                    <!-- For testing reasons I just have this clearing the records in pizzaOrders right now -->
                    <button class="bg-green-500 shadow-md text-green-50 font-bold py-2 px-4 rounded transition ease-in-out delay-50 hover:shadow-lg hover:translate-y-1 hover:scale-110 hover:bg-green-700 duration-300" type="submit">
                        Submit Order
                    </button>
                </form>

                <img class="w-3/4 hidden lg:block rounded-sm" src="./images/poster.jpg" alt="Pizza Poster" />
            </div>
        </section>

    </main>

    <!-- Footer -->
    <footer class="bg-orange-100 text-orange-900 py-6 mt-6">
        <div class="container mx-auto px-4">
            <div class="sm:flex items-center justify-between">
                <p class="text-center sm:text-left mt-4 sm:mt-0">©2023 Mama Mia' Pizza</p>
                <div class="mt-4 sm:mt-0 text-center">
                    <a href="#" class="mx-2 inline-block text-orange-900 hover:text-red-500 transition ease-in-out duration-110">Terms
                        of Service</a>
                    <a href="#" class="mx-2 inline-block text-orange-900 hover:text-red-500 transition ease-in-out duration-110">Privacy
                        Policy</a>
                </div>
            </div>
        </div>
    </footer>


    <script src="./js/toggleNavMenu.js"></script>
</body>

</html>