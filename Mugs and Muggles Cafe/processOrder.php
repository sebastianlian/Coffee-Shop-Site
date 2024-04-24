<?php
    $productsArray = [
        0 => [
            'name' => 'Caffeine Chaos',
            'prices' => [
                'small' => 4.00,
                'medium' => 4.50,
                'large' => 5.00,
            ],
        ],
        1 => [
            'name' => 'Java Jive',
            'prices' => [
                'small' => 4.25,
                'medium' => 4.75,
                'large' => 5.25,
            ],
        ],
        2 => [
            'name' => 'Velvet Vortex',
            'prices' => [
                'small' => 4.50,
                'medium' => 5.00,
                'large' => 5.50,
            ],
        ],
        3 => [
            'name' => 'Espresso Exilir',
            'prices' => [
                'small' => 4.75,
                'medium' => 5.25,
                'large' => 5.75,
            ],
        ],
        4 => [
            'name' => 'Latte Loco',
            'prices' => [
                'small' => 5.00,
                'medium' => 5.50,
                'large' => 6.00,
            ],
        ],
        5 => [
            'name' => 'Frothy Fantasy',
            'prices' => [
                'small' => 5.50,
                'medium' => 6.00,
                'large' => 6.50,
            ],
        ],
    ];

    session_start();

    // Initialize $quantity with a default value
    $quantity = 0;

    // check if the user is logged in
    if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
        // If not logged in, redirect to login page or handle appropriately
        header('location: login.php');
        exit;
    }

    // include database connection
    include('connectDB.php');

    // check if form is submitted
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Validate input
        $product = $_POST['product'] ?? null;
        $size = $_POST['size'] ?? null;
        $quantity = $_POST['quantity'] ?? null;

        // additional validation as needed

        // fetch product details based on the selected product index
        $productName = $productsArray[$product]['name']; // get product name
        $productPrices = $productsArray[$product]['prices']; // get product prices for different sizes

        // set the product price based on the selected size
        $productPrice = $productPrices[$size]; // get price for the selected size

        // insert order into database
        $userId = $_SESSION['id']; // Get user ID from session
        $brewId = $product;
        $orderDate = date('Y-m-d H:i:s');

        $sql = "INSERT INTO orders (user_id, brew_id, size, quantity, order_date) VALUES (?, ?, ?, ?, ?)";
        if ($stmt = mysqli_prepare($link, $sql)) {
            mysqli_stmt_bind_param($stmt, 'iisds', $userId, $brewId, $size, $quantity, $orderDate);

            if (!mysqli_stmt_execute($stmt)) {
                echo "Error: " . mysqli_error($link);
            }
            mysqli_stmt_close($stmt);
        } else {
            echo "Error: " . mysqli_error($link);
        }

        mysqli_close($link);
    }
?>

<!DOCTYPE html>
<html lang="en">

    <?php include('header.php') ?>
    <?php include('menu.php') ?>

    <h4 class="center grey-text">Order Confirmation Details</h4>

    <div class="container">
        <div class="row">
            <div class="col s12 m6 offset-m3">
                <?php
                if ($quantity <= 0) {
                    echo "<p class='red-text center'>You cannot refresh this page! <br> Please place a new order.</p>";
                    exit;
                }

                echo "<p>Order processed at " . date('H:i, jS F Y') . "</p>";
                echo "<p>Your order is as follows:</p>";
                echo "<p>Item ordered: $productName</p>";
                echo "<p>Size: $size</p>";
                echo "<p>Quantity: $quantity</p>";
                echo "<p>Unit price: $$productPrice</p>";

                $totalAmount = $quantity * $productPrice;

                echo "<p>Total: $" . number_format($totalAmount, 2) . "</p>";

                echo "<p>Order written.</p>";
                ?>
            </div>
        </div>
    </div>

    <!-- Materialize JavaScript -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>

    <?php include('footer.php') ?>
</html>