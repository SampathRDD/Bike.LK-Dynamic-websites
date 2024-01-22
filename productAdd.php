<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Product</title>
    <!-- Add Bootstrap CSS link -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <!-- Add Bootstrap JS and Popper.js scripts (required for Bootstrap) -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <style>
        body{
            flex:1;
            background-image:url('./images/adminBackground.jpg') ;
            background-size: cover;
        }
        td{
            color: black;
            background-color: #ffffff90;
        }
        h2{
            color: black;
            font-family: monospace;
        }
        label{
            color: black;
            font-family: monospace;
            font-weight: 600;
        }
        button{
            color: white;
            font-family: monospace;
            font-weight: 700;
        }
    </style>
</head>
<body class="bg-light">
    <?php include_once("header.php"); ?>
    <div class="container mt-5">
        <h2 class="mb-4">Add Bike</h2>

        <?php
        // Include database connection file
        include_once("database.php");

        // Check if the form is submitted
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Collect form data
            $p_name = $_POST['p_name'];
            $p_price = $_POST['p_price'];
            $p_category = $_POST['p_category'];
            $p_details = $_POST['p_details'];

            // File upload handling
            $uploadDir = "uploads/";
            $uploadFile = $uploadDir . basename($_FILES['image']['name']);
            $imageFileType = strtolower(pathinfo($uploadFile, PATHINFO_EXTENSION));

            // Check if the file is an actual image
            $check = getimagesize($_FILES['image']['tmp_name']);
            if ($check === false) {
                echo '<div class="alert alert-danger" role="alert">File is not an image.</div>';
                exit();
            }

            // Check if file already exists
            if (file_exists($uploadFile)) {
                echo '<div class="alert alert-warning" role="alert">File already exists. Please choose a different file.</div>';
                exit();
            }

            // Check file size
            if ($_FILES['image']['size'] > 500000) {
                echo '<div class="alert alert-warning" role="alert">File is too large. Maximum size is 500KB.</div>';
                exit();
            }

            // Allow only certain file formats
            $allowedFormats = ['jpg', 'jpeg', 'png', 'gif'];
            if (!in_array($imageFileType, $allowedFormats)) {
                echo '<div class="alert alert-warning" role="alert">Only JPG, JPEG, PNG, and GIF files are allowed.</div>';
                exit();
            }

            // Upload the file
            if (move_uploaded_file($_FILES['image']['tmp_name'], $uploadFile)) {
                // File uploaded successfully, save the file path in the database
                $p_link = $uploadFile;

                // Get username from session
                if(isset($_SESSION["username"])) {
                    $username = $_SESSION["username"];

                    // Insert data into the database
                    $sql = "INSERT INTO product (p_name, p_price, p_category, p_details, username, p_link) 
                            VALUES ('$p_name', $p_price, '$p_category', '$p_details', '$username', '$p_link')";

                    if (mysqli_query($con, $sql)) {
                        echo '<div class="alert alert-success" role="alert">Product added successfully!</div>';
                        echo "<script>
                        setTimeout(function() {
                            window.location.href = 'product.php';
                        }, 2000);
                        </script>";
                    } else {
                        echo '<div class="alert alert-danger" role="alert">Error: ' . mysqli_error($con) . '</div>';
                    }
                } else {
                    // Handle the case where username is not set in session
                    echo '<div class="alert alert-danger" role="alert">Error: User not authenticated.</div>';
                }
            } else {
                echo '<div class="alert alert-danger" role="alert">Error uploading the file.</div>';
            }
        }
        ?>

        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label for="p_name">Bike Name:</label>
                <input type="text" name="p_name" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="p_price">Bike Price:</label>
                <input type="text" name="p_price" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="p_category">Bike Category:</label>
                <select name="p_category" class="form-control" required>
                    <option value="scooter">Scooter</option>
                    <option value="cruiser">Cruiser</option>
                    <option value="sport">Sport</option>
                    <option value="enduro">Enduro</option>
                    <option value="adventure">Adventure</option>
                </select>
            </div>

            <div class="form-group">
                <label for="p_details">Bike About:</label>
                <textarea name="p_details" class="form-control"></textarea>
            </div>

            <div class="form-group">
                <label for="image">Bike Image:</label>
                <input type="file" name="image" class="form-control-file" accept="image/*" required>
            </div>

            <button type="submit" class="btn btn-primary">Add Product</button><br><br>
        </form>
    </div>
    <?php include_once("footer.php"); ?>
</body>
</html>
