<?php
// Include database connection file
include('database.php');

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
    $name = mysqli_real_escape_string($con, $_POST["name"]);
    $email = mysqli_real_escape_string($con, $_POST["email"]);
    $message = mysqli_real_escape_string($con, $_POST["message"]);

    // Insert the data into the database
    $sql = "INSERT INTO contacts (name, email, message) VALUES ('$name', '$email', '$message')";

    if (mysqli_query($con, $sql)) {
        echo '<div class="alert alert-success mt-3" role="alert">Thank you for reaching out, ' . $name . '! We have received your message.</div>';
        echo '<script>
            setTimeout(function() {
                window.location.href = "home.php";
            }, 2000);
        </script>';
    } else {
        echo '<div class="alert alert-danger mt-3" role="alert">Error: ' . mysqli_error($con) . '</div>';
        echo '<script>
            setTimeout(function() {
                window.location.href = "contact.php";
            }, 3000);
        </script>';
    }
}
?>
