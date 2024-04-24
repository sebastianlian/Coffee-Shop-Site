<?php
//    # initialize session
//    session_start();
//
//    // check if user is not logged in, otherwise redirect to login.php
//    if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
//        header("location: login.php");
//        exit;
//    }
//
//    # include config file
//    require_once "config.php";
//
//    # define variables and initialize with empty values
//    $new_password = $confirm_password = "";
//    $new_password_err = $confirm_password_err = "";
//
//    # process form data when form is submitted
//    if($_SERVER['REQUEST_METHOD'] == "POST") {
//        #validate new password
//        if(empty(trim($_POST['new_password'])))
//            $new_password_err = "Please enter the new password";
//        elseif(strlen(trim($_POST['new_password'])) < 6)
//            $new_password_err = "Password must have at least 6 characters";
//        else
//            $new_password = trim($_POST['new_password']);
//
//        # validate confirm password
//        if(empty(trim($_POST['confirm_password'])))
//            $confirm_password_err = "Please confirm password";
//        else {
//            $confirm_password = trim($_POST["confirm_password"]);
//            if(empty($new_password_err) && ($new_password != $confirm_password))
//                $confirm_password_err = "Passwords did not match";
//        }
//
//        # check input errors before updating the database
//        if(empty($new_password_err) && empty($confirm_password_err)) {
//            # prepare an update statement
//            $sql = "UPDATE users SET password = ? WHERE id = ?";
//
//            if($stmt = mysqli_prepare($link, $sql)) {
//                # bind variables to the prep statement as parameters
//                mysqli_stmt_bind_param($stmt, "si", $param_password, $param_id);
//
//                # set parameters
//                $param_password = password_hash($new_password, PASSWORD_DEFAULT); // encryption method to create hash
//                $param_id = $_SESSION['id'];
//
//                ## attempt to execute the prep statement
//                if(mysqli_stmt_execute($stmt)) {
//                    # password updated successfully, destroy the session, and redirect to login page
//                    session_destroy();
//                    header("location: login.php");
//                    exit;
//                }
//                echo "Something went wrong. Please try again later.<br>";
//            }
//
//            # close statement
//            mysqli_stmt_close($stmt);
//        }
//
//        # close the connection
//        mysqli_close($link);
//    }
//?>
<!---->
<!--<html>-->
<!--    --><?php //include('header.php') ?>
<!---->
<!--    <body class="grey lighten-4">-->
<!--    <div class="container">-->
<!--        <h2 class="center">Reset Password</h2>-->
<!--        <p class="center">Please fill out this form to reset your password.</p>-->
<!--        <form action="--><?php //echo htmlspecialchars($_SERVER['PHP_SELF']); ?><!--" method="POST">-->
<!--            <div class="input-field">-->
<!--                <input id="new_password" type="password" name="new_password" class="--><?php //echo (!empty($new_password_err)) ? 'invalid' : ''; ?><!--" value="--><?php //echo $new_password; ?><!--">-->
<!--                <label for="new_password">New Password</label>-->
<!--                <span class="helper-text red-text">--><?php //echo $new_password_err; ?><!--</span>-->
<!--            </div>-->
<!---->
<!--            <div class="input-field">-->
<!--                <input id="confirm_password" type="password" name="confirm_password" class="--><?php //echo (!empty($confirm_password_err)) ? 'invalid' : ''; ?><!--">-->
<!--                <label for="confirm_password">Confirm Password</label>-->
<!--                <span class="helper-text red-text">--><?php //echo $confirm_password_err; ?><!--</span>-->
<!--            </div>-->
<!---->
<!--            <div class="center">-->
<!--                <button class="btn waves-effect waves-light" type="submit" name="action">Submit-->
<!--                    <i class="material-icons right">send</i>-->
<!--                </button>-->
<!--                <a href="index.php" class="btn waves-effect waves-light">Cancel</a>-->
<!--            </div>-->
<!--        </form>-->
<!--    </div>-->
<!--    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>-->
<!---->
<!--    --><?php //include('footer.php') ?>
<!--</html>-->