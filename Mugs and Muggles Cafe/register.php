<?php
    // include config file
    require_once "connectDB.php";

    # define variables and initialize with empty values
    $username = $password = $confirm_password = "";
    $username_err = $password_err = $confirm_password_err = "";

    # process form data after the form is submitted
    if($_SERVER["REQUEST_METHOD"] == "POST") {
        // validate username
        if(empty(trim($_POST["username"])))
            $username_err = "Please enter username";
        else {
            # prepare a select statement
            $sql = "SELECT id FROM users WHERE username = ?";

            if($stmt = mysqli_prepare($link, $sql)) {
                # bind variables to the prepared statement as parameters
                mysqli_stmt_bind_param($stmt, "s", $param_username);

                # set parameter
                $param_username = trim($_POST['username']);

                #attempt to execute the prepared statement
                if(mysqli_stmt_execute($stmt)) {
                    # store result
                    mysqli_stmt_store_result($stmt);

                    # check if user already exists
                    if(mysqli_stmt_num_rows($stmt) == 1)
                        $username_err = "This username is already taken.";
                    else
                        $username = trim($_POST['username']);
                }
                else
                    echo "Something went wrong. Please try again later.";
            }

            # close statement
            mysqli_stmt_close($stmt);
        }

        # validate password
        if(empty(trim($_POST["password"])))
            $password_err = "Please enter a password";
        elseif(strlen(trim($_POST['password'])) < 6)
            $password_err = "Password must have at least 6 characters";
        else
            $password = trim($_POST['password']);

        # validate confirm password
        if(empty(trim($_POST['confirm_password'])))
            $confirm_password_err = "Please confirm password";
        else {
            $confirm_password = trim($_POST['confirm_password']);
            if(empty($password_err) && ($password != $confirm_password))
                $confirm_password_err = "Password did not match confirmation";
        }

        # check for input errors before inserting to database
        if(empty($username_err) && empty($password_err) && empty($confirm_password_err)) {
            # prepare an insert SQL statment
            $sql = "INSERT INTO users (username, password) VALUES (?, ?)";

            if($stmt = mysqli_prepare($link, $sql)) {
                # bind variables to the prepared statement as parameters
                mysqli_stmt_bind_param($stmt, 'ss', $param_username, $param_password);

                # set parameters
                $param_username = $username;
                # create a password hash (encrypted pw)
                $param_password = password_hash($password, PASSWORD_DEFAULT);

                # attempt to execute the prepared statement
                if(mysqli_stmt_execute($stmt))
                    # redirect login page
                    header("location: login.php");
                else
                    echo "Something went wrong. Please try again later.<br>";
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

    <body>
    <div class="container">
        <h4 class="center grey-text">Sign up</h4>
        <p class="center-align account">Please fill out this form to create an account</p>
        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">
            <div class="row">
                <div class="input-field col s12">
                    <input id="username" type="text" class="validate" name="username" value="<?php echo $username; ?>">
                    <label for="username">Username</label>
                    <span class="helper-text red-text"><?php echo $username_err; ?></span>
                </div>
            </div>
            <div class="row">
                <div class="input-field col s12">
                    <input id="password" type="password" class="validate" name="password">
                    <label for="password">Password</label>
                    <span class="helper-text red-text"><?php echo $password_err; ?></span>
                </div>
            </div>
            <div class="row">
                <div class="input-field col s12">
                    <input id="confirm_password" type="password" class="validate" name="confirm_password">
                    <label for="confirm_password">Confirm Password</label>
                    <span class="helper-text red-text"><?php echo $confirm_password_err; ?></span>
                </div>
            </div>
            <div class="row">
                <button class="btn waves-effect waves-light brand" type="submit" name="action">Submit
                    <i class="material-icons right">send</i>
                </button>
                <button class="btn waves-effect waves-light brand" type="reset" name="action">Reset
                    <i class="material-icons right">clear</i>
                </button>
            </div>
            <p class="center-align">Already have an account? <a href="login.php">Login here</a></p>
        </form>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>

    <?php include('footer.php') ?>
</html>
