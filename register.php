<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Registration</title>
    <!-- Add Bootstrap CSS link -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <!-- Add this to the head section of your HTML file -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

    <style>
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
            background-image:url('./images/bikebackground.jpg') ;
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
    <div class="container mt-5">
        <h2>User Registration</h2>

        <?php
        // Include database connection file
        include_once("database.php");

        // Define variables and initialize with empty values
        $username = $user_type = $email = $mobile_number = $address = $password = "";
        $username_err = $email_err = $mobile_number_err = $address_err = $password_err = "";

        // Processing form data when form is submitted
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Validate username
            if (empty($_POST["username"])) {
                $username_err = "Please enter a username.";
            } else {
                $username = mysqli_real_escape_string($con, $_POST["username"]);
            }

            // Validate email
            if (empty($_POST["email"])) {
                $email_err = "Please enter your email.";
            } else {
                $email = mysqli_real_escape_string($con, $_POST["email"]);
                if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    $email_err = "Invalid email format.";
                }
            }

            // Validate mobile number
            if (empty($_POST["mobile_number"])) {
                $mobile_number_err = "Please enter your mobile number.";
            } else {
                $mobile_number = mysqli_real_escape_string($con, $_POST["mobile_number"]);
                // You may want to add additional validation for mobile numbers
            }

            // Validate address
            if (empty($_POST["address"])) {
                $address_err = "Please enter your address.";
            } else {
                $address = mysqli_real_escape_string($con, $_POST["address"]);
            }

            // Validate password
            if (empty($_POST["password"])) {
                $password_err = "Please enter a password.";
            } else {
                $password = mysqli_real_escape_string($con, $_POST["password"]);
            }

            // Check input errors before inserting into the database
            if (empty($username_err) && empty($email_err) && empty($mobile_number_err) && empty($address_err) && empty($password_err)) {
                // Default user_type is 'customer'
                $user_type = 'customer';

                // Hash the password before storing it in the database
                $hashed_password = password_hash($password, PASSWORD_DEFAULT);

                // Insert data into the users table
                $insert_sql = "INSERT INTO users (username, user_type, email, mobile_number, address, password) 
                               VALUES ('$username', '$user_type', '$email', '$mobile_number', '$address', '$hashed_password')";

                if (mysqli_query($con, $insert_sql)) {
                    echo '<div class="alert alert-success mt-3" role="alert">Registration successful!</div>';
                    echo "<script>
                    setTimeout(function() {
                        window.location.href = 'login.php';
                    }, 2000);
                    </script>";
                } else {
                    echo '<div class="alert alert-danger mt-3" role="alert">Error: ' . mysqli_error($con) . '</div>';
                }
            }
        }
        ?>
        <form class="form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">

            <div class="form-group">
                <label class="label-text" for="username">Name:</label>
                <input type="text" name="username"  class="form-control" value="<?php echo $username; ?>" required>
                <span class="text-danger"><?php echo $username_err; ?></span>
            </div>

            <div class="form-group">
                <label class="label-text" for="email">Email:</label>
                <input type="email" name="email" class="form-control" value="<?php echo $email; ?>" required>
                <span class="text-danger"><?php echo $email_err; ?></span>
            </div>

            <div class="form-group">
                <label class="label-text" for="mobile_number">Mobile Number:</label>
                <input type="text" name="mobile_number" class="form-control" value="<?php echo $mobile_number; ?>" required>
                <span class="text-danger"><?php echo $mobile_number_err; ?></span>
            </div>

            <div class="form-group">
                <label class="label-text"  for="address">Address:</label>
                <input type="text" name="address" class="form-control" value="<?php echo $address; ?>" required>
                <span class="text-danger"><?php echo $address_err; ?></span>
            </div>

            <div class="form-group">
                <label class="label-text" for="password">Password:</label>
                <input type="password" name="password" class="form-control" required>
                <span class="text-danger"><?php echo $password_err; ?></span>
            </div></br>

            <input type="submit" value="Register" class="btn btn-primary form-control"></br></br>
            <h5>If you already have a account ? <a href="login.php">Login</a></h5>
        </form>
    </div>
    <?php include('footer.php'); ?>
    <!-- Add Bootstrap JS and Popper.js scripts (required for Bootstrap) -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</body>
</html>
