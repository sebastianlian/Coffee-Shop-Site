<?php
    include('connectDB.php');

    $order = null; // initialize $order variable

    if(isset($_POST['delete'])) {
        $id_to_delete = mysqli_real_escape_string($link, $_POST['id_to_delete']);

        # deletes the selected order
        $sql = "DELETE FROM orders WHERE order_id = $id_to_delete";

        if(mysqli_query($link, $sql)) {
            # success
            header('location: index.php');
        } else {
            # failure
            echo 'query error: ' . mysqli_error($link);
        }
    }


    # check get request id param
    if(isset($_GET['order_id'])) {
        $id = mysqli_real_escape_string($link, $_GET['order_id']);

        # make sql
        $sql = "SELECT * FROM orders WHERE order_id = $id";

        # get query results
        $result = mysqli_query($link, $sql);

        # fetch results in array format
        $order = mysqli_fetch_assoc($result);

        # gets single result
        mysqli_free_result($result);

        # close connection
        mysqli_close($link);

    //        print_r($order);
    }
?>

<!DOCTYPE html>
<html>

    <?php include('header.php') ?>
    <?php include('menu.php') ?>

    <div class="container center grey-text">
        <?php if($order): ?>

            <h4><?php echo htmlspecialchars($order['order_id']); ?></h4>
            <p>Created by: <?php echo htmlspecialchars($order['user_id']); ?></p>
            <p><?php echo date($order['order_date']); ?></p>
            <h5>Brew</h5>
            <p><?php echo htmlspecialchars($order['brew_id']); ?></p>

            <!-- DELETE FORM -->
            <form action="details.php" method="POST">
                <input type="hidden" name="id_to_delete" value="<?php echo $order['order_id'] ?>">
                <input type="submit" name="delete" value="delete" class="btn brand z-depth-0">
            </form>

        <?php else: ?>

            <h5>Order does not exist.</h5>

        <?php endif; ?>
    </div>

    <?php include('footer.php') ?>
</html>