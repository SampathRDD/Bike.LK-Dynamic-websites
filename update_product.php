<?php
include_once("header.php");
include_once("database.php");

if(isset($_GET['id']) && is_numeric($_GET['id'])) {
    $product_id = $_GET['id'];

    $result = mysqli_query($con, "SELECT * FROM product WHERE p_id = $product_id");

    if(mysqli_num_rows($result) > 0) {
        $product = mysqli_fetch_assoc($result);
    } else {
        echo '<div class="alert alert-danger" role="alert">Error: Product not found.</div>';
        // Redirect to admin_dashboard.php or handle the error as needed
    }
} else {
    echo '<div class="alert alert-danger" role="alert">Error: Invalid product ID.</div>';
    // Redirect to admin_dashboard.php or handle the error as needed
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_product'])) {
    $updated_name = mysqli_real_escape_string($con, $_POST["updated_name"]);
    $updated_price = mysqli_real_escape_string($con, $_POST["updated_price"]);
    $updated_link = mysqli_real_escape_string($con, $_POST["updated_link"]);
    $updated_category = mysqli_real_escape_string($con, $_POST["updated_category"]);
    $updated_details = mysqli_real_escape_string($con, $_POST["updated_details"]);

    $update_sql = "UPDATE product SET p_name = '$updated_name', p_price = '$updated_price', p_link = '$updated_link', 
                    p_category = '$updated_category', p_details = '$updated_details' WHERE p_id = $product_id";

    if (mysqli_query($con, $update_sql)) {
        echo '<div class="alert alert-success" role="alert">Product updated successfully!</div>';
        echo "<script>
                        setTimeout(function() {
                            window.location.href = 'admin.php';
                        }, 2000);
                        </script>";
    } else {
        echo '<div class="alert alert-danger" role="alert">Error updating product: ' . mysqli_error($con) . '</div>';
    }
}

mysqli_close($con);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Update Product - Admin Dashboard</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
</head>
<body>

<div class="container mt-5">
    <h2>Update Product</h2>

    <form action="<?= htmlspecialchars($_SERVER["PHP_SELF"]) . '?id=' . $product_id ?>" method="post">
        <div class="form-group">
            <label for="updated_name">Product Name:</label>
            <input type="text" class="form-control" id="updated_name" name="updated_name" value="<?= $product['p_name'] ?>" required>
        </div>

        <div class="form-group">
            <label for="updated_price">Price:</label>
            <input type="text" class="form-control" id="updated_price" name="updated_price" value="<?= $product['p_price'] ?>" required>
        </div>

        <div class="form-group">
            <label for="updated_link">Link:</label>
            <input type="text" class="form-control" id="updated_link" name="updated_link" value="<?= $product['p_link'] ?>" required>
        </div>

        <div class="form-group">
            <label for="updated_category">Category:</label>
            <input type="text" class="form-control" id="updated_category" name="updated_category" value="<?= $product['p_category'] ?>" required>
        </div>

        <div class="form-group">
            <label for="updated_details">Details:</label>
            <textarea class="form-control" id="updated_details" name="updated_details" rows="3" required><?= $product['p_details'] ?></textarea>
        </div>

        <button type="submit" class="btn btn-primary" name="update_product">Update Product</button>
    </form>
</div>

<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>

</body>
</html>
