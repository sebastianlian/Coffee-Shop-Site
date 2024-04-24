<?php
    # initialize the session
    session_start();

    # check of user is already logged in. If yes, then redirect to welcome page
    if(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
        header('location: index.php');
        exit;
    }

    # include the config file
    require_once "connectDB.php";

    # define variables and initialize them with empty values
    $username = $password = "";
    $username_err = $password_err = "";

    # processing form data after form is submitted
    if($_SERVER['REQUEST_METHOD'] == 'POST') {
        # check if username is empty
        if(empty(trim($_POST['username'])))
            $username_err = "Please enter username";
        else
            $username = trim($_POST['username']);

        # check if password is empty
        if(empty(trim($_POST['password'])))
            $password_err = "Please enter password";
        else
            $password = trim($_POST['password']);

        # validate credentials
        if(empty($username_err) && empty($password_err)) {
            // proceed to validate credentials

            # prepare SQL statement
            $sql = "SELECT id, username, password FROM users WHERE username = ?";

            if($stmt = mysqli_prepare($link, $sql)) {
                # bind variables to the prepared statement as parameters
                # parameter 's' for string, 'i' for integer, and 'b' for blob
                # ensure that we use the same number of variables as question marks in the SQL statement
                mysqli_stmt_bind_param($stmt, 's', $param_username);

                # set parameters
                $param_username = $username;

                # attempt to execute the prepared statement
                if(mysqli_stmt_execute($stmt)) {
                    # store result
                    mysqli_stmt_store_result($stmt);

                    # check if username exists. If yes, then verify password
                    if(mysqli_stmt_num_rows($stmt) == 1) {
                        # bind result variables
                        mysqli_stmt_bind_result($stmt, $id, $username, $hashed_password);
                        if(mysqli_stmt_fetch($stmt)) {
                            if(password_verify($password, $hashed_password)) {
                                # password is correct, start a new session
                                session_start();

                                # store data in session variables
                                $_SESSION['loggedin'] = true;
                                $_SESSION['id'] = $id;
                                $_SESSION['username'] = $username;

                                # redirect user to welcome page
                                header('location: index.php');
                            } else # display error msg if pw is not valid
                                $password_err = "The password you entered is invalid";
                        }
                    } else # display error msg as user does not exist
                        $username_err = "No account found with that username.";
                } else # unable to execute SQL query
                    echo "Oops! Something went wrong. Please try again later.";
            }
            # close statement
            mysqli_stmt_close($stmt);
        }

        # close connection
        mysqli_close($link);
    }
?>

<!DOCTYPE html>
<html lang="en">

    <?php include('header.php') ?>

    <div class="container">
        <h4 class="center-align grey-text">Login</h4>
        <p class="center-align">Please fill in your credentials to login</p>
        <div class="row">
            <form class="col s12" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">
                <div class="row">
                    <div class="input-field col s12">
                        <input id="username" type="text" class="validate" name="username" value="<?php echo $username; ?>">
                        <label for="username">Username</label>
                        <span class="red-text"><?php echo $username_err; ?></span>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s12">
                        <input id="password" type="password" class="validate" name="password">
                        <label for="password">Password</label>
                        <span class="red-text"><?php echo $password_err; ?></span>
                    </div>
                </div>
                <div class="row">
                    <div class="col s12">
                        <button class="btn waves-effect waves-light brand" type="submit" name="action">Login</button>
                    </div>
                </div>
                <p class="center-align">Don't have an account? <a href="register.php">Sign up now!</a></p>
<!--                <p class="center-align">Forgot your password? <a href="reset.php">Click Here</a></p>-->
            </form>
        </div>
    </div>

    <!-- Materialize JavaScript -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            M.updateTextFields();
        });
    </script>

    <?php include('footer.php') ?>
</html>