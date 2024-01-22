<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>User Login</title>
    <!-- Add Bootstrap CSS link -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <style>
        .r-height{
            height: 36rem;
        }
        .form-control{
            width:40%;
            align-self: center;
            background-color: transparent;
        }
        .label-text{
            font-family: Cambria, Cochin, Georgia, Times, 'Times New Roman', serif;
            font-size: 1.3rem;
            color: white;
        }
        .form{
            padding: 3rem;
        }
        body{
            background-image:url('./images/bike.jpg') ;
            background-size: cover;
        }
        h2{
            color: white;
        }
        h5{
            color: white;
        }
    </style>
</head>
<body>
<?php include('navbar.php'); ?>
    <div class="container mt-5 r-height">
        <h2>Login</h2>

        <?php
        // Include database connection file
        include_once("database.php");

        // Define variables and initialize with empty values
        $username_or_email = $password = "";
        $username_or_email_err = $password_err = "";

        // Processing form data when form is submitted
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Validate username or email
            if (empty($_POST["username_or_email"])) {
                $username_or_email_err = "Please enter your username or email.";
            } else {
                $username_or_email = mysqli_real_escape_string($con, $_POST["username_or_email"]);
            }

            // Validate password
            if (empty($_POST["password"])) {
                $password_err = "Please enter your password.";
            } else {
                $password = mysqli_real_escape_string($con, $_POST["password"]);
            }

            // Check input errors before querying the database
            if (empty($username_or_email_err) && empty($password_err)) {
                // Attempt to select the user from the database
                $sql = "SELECT * FROM users WHERE username = '$username_or_email' OR email = '$username_or_email'";
                $result = mysqli_query($con, $sql);

                if ($result) {
                    if (mysqli_num_rows($result) == 1) {
                        $row = mysqli_fetch_assoc($result);

                        // Verify the password
                        if (password_verify($password, $row['password'])) {
                            // Password is correct, start a new session
                            session_start();

                            // Store data in session variables
                            $_SESSION["username"] = $row['username'];
                            $_SESSION["user_type"] = $row['user_type'];

                            // Redirect user to the home page or any other desired page
                            header("location: home.php");
                            exit();
                        } else {
                            // Display an error message if the password is not valid
                            echo '<div class="alert form-group alert-danger mt-3" role="alert">Invalid password.</div>';
                        }
                    } else {
                        // Display an error message if the username or email is not found
                        echo '<div class="alert form-group alert-danger mt-3" role="alert">Username or email not found.</div>';
                    }
                } else {
                    // Display an error message if there is an issue with the database query
                    echo '<div class="alert alert-danger form-group mt-3" role="alert">Error: ' . mysqli_error($con) . '</div>';
                }
            }
        }
        ?>

        <form class="form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group">
                <label class="label-text" for="username_or_email">Username or Email:</label>
                <input type="text" name="username_or_email" class="form-control" value="<?php echo $username_or_email; ?>" required>
                <span class="text-danger"><?php echo $username_or_email_err; ?></span>
            </div>

            <div class="form-group">
                <label class="label-text" for="password">Password:</label>
                <input type="password" name="password" class="form-control" required>
                <span class="text-danger"><?php echo $password_err; ?></span>
            </div></br>

            <input type="submit" value="Login" class="btn btn-primary form-control">
            </br></br>
            <h5>Create an account ? <a href="register.php">Register</a></h5>
        </form>
    </div>

    <!-- Add Bootstrap JS and Popper.js scripts (required for Bootstrap) -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <?php include('footer.php'); ?>
</body>
</html>
