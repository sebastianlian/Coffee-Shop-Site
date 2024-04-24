<?php
    session_start();
    // Check if user is not logged in, redirect to login page
    if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
        header('location: login.php');
        exit;
    }

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

    include('connectDB.php'); // db connection file

    // query the database to retrieve orders data
    $sql = "SELECT * FROM orders";
    $result = mysqli_query($link, $sql); // execute the query

    // check if there are any orders
    if ($result && mysqli_num_rows($result) > 0) {
        // fetch all rows from the result set as an associative array
        $orders = mysqli_fetch_all($result, MYSQLI_ASSOC);
//        echo "Number of orders fetched: " . count($orders) . "<br>"; // Debug output
    } else {
        // if there are no orders, set $orders to an empty array
        $orders = [];
//        echo "No orders found.<br>"; // debug output
    }

//    // display orders debugger
//    foreach ($orders as $order) {
//        // Output order details
//        echo "Order ID: " . $order['order_id'] . "<br>";
//        echo "User ID: " . $order['user_id'] . "<br>";
//        echo "Brew ID: " . $order['brew_id'] . "<br>";
//        echo "Size: " . $order['size'] . "<br>";
//        echo "Quantity: " . $order['quantity'] . "<br><br>";
//    }
?>

<!DOCTYPE html>
<html lang="en">
    <?php include('header.php') ?>

    <?php include('menu.php') ?>

    <h4 class="center grey-text">Where Every Sip is Magic!</h4>

    <div class="container">
        <form action="processOrder.php" method="post" class="card-panel">
            <div class="input-field">
                <select name="product" required> <!-- Add required attribute here -->
                    <option value="" disabled selected>Choose a product</option>
                    <?php foreach($productsArray as $key => $product): ?>
                        <option value="<?php echo $key; ?>"><?php echo $product['name']; ?></option>
                    <?php endforeach; ?>
                </select>
                <label>Select Product</label>
            </div>

            <div class="input-field">
                <select name="size" required> <!-- Add required attribute here -->
                    <option value="" disabled selected>Choose a size</option>
                    <option value="small">Small</option>
                    <option value="medium">Medium</option>
                    <option value="large">Large</option>
                </select>
                <label>Select Size</label>
            </div>

            <div class="input-field">
                <input type="number" name="quantity" id="quantity" class="validate" min="1" required> <!-- Add required attribute here -->
                <label for="quantity">Enter quantity</label>
            </div>

            <button class="btn waves-effect waves-light brand" type="submit" name="action">Submit Order
                <i class="material-icons right">send</i>
            </button>
        </form>


        <div class="card-panel">
            <table class="striped">
                <thead>
                <tr>
                    <th>Item Code</th>
                    <th>Description</th>
                    <th>Small</th>
                    <th>Medium</th>
                    <th>Large</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach($productsArray as $key => $product): ?>
                    <tr>
                        <td><?php echo $key; ?></td>
                        <td><?php echo $product['name']; ?></td>
                        <td><?php echo isset($product['prices']['small']) ? '$' . number_format($product['prices']['small'], 2) : 'N/A'; ?></td>
                        <td><?php echo isset($product['prices']['medium']) ? '$' . number_format($product['prices']['medium'], 2) : 'N/A'; ?></td>
                        <td><?php echo isset($product['prices']['large']) ? '$' . number_format($product['prices']['large'], 2) : 'N/A'; ?></td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Materialize JavaScript -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var elems = document.querySelectorAll('select');
            var instances = M.FormSelect.init(elems);
        });
    </script>

    <?php include('footer.php') ?>
</html>