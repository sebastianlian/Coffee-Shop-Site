<?php
    session_start();
    include('connectDB.php');

    // Check if user is logged in
    if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
        header('location: login.php');
        exit;
    }

    // Fetch orders for the logged-in user
    $user_id = $_SESSION['id'];
    $sql = "SELECT * FROM orders WHERE user_id = $user_id";
    $result = mysqli_query($link, $sql);

    // Check if there are any orders
    if ($result && mysqli_num_rows($result) > 0) {
        // Fetch all rows from the result set as an associative array
        $orders = mysqli_fetch_all($result, MYSQLI_ASSOC);
    } else {
        // If there are no orders, set $orders to an empty array
        $orders = [];
    }

    // Close the database connection
    mysqli_close($link);
?>

<!DOCTYPE html>
<html lang="en">
    <?php include('header.php') ?>
    <?php include('menu.php') ?>

    <h4 class="center grey-text">Orders</h4>

    <div class="container">
        <div class="row">
            <?php foreach($orders as $order): ?>
                <div class="col s6 m4">
                    <div class="card z-depth-0">
                        <!-- Display order details -->
                        <div class="card-content center-align">
                            <h6>Order ID: <?php echo htmlspecialchars($order['order_id']); ?></h6>
                            <p>User ID: <?php echo htmlspecialchars($order['user_id']); ?></p>
                            <p>Brew ID: <?php echo htmlspecialchars($order['brew_id']); ?></p>
                            <p>Quantity: <?php echo htmlspecialchars($order['quantity']); ?></p>
                            <p>Order Date: <?php echo htmlspecialchars($order['order_date']); ?></p>
                            <p>Size: <?php echo htmlspecialchars($order['size']); ?></p>
                        </div>

                        <div class="card-action right-align">
                            <a class="brand-text" href="details.php?order_id=<?php echo $order['order_id']; ?>">More info</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <?php include('footer.php') ?>
</html>