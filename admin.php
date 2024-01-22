<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
    <!-- Add Bootstrap CSS link -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <style>
        body{
            flex:1;
            background-image:url('./images/adminBackground.jpg') ;
            background-size: cover;
        }
        td{
            color: black;
            background-color: #ffffff40;
            font-family: monospace;
        }
        h2{
            color: black;
            font-family: monospace;
        }
    </style>
</head>
<body>
    <?php include_once("header.php"); ?>
    <div class="container mt-5">
        <h2>Admin Dashboard</h2>

        <?php

        // Include database connection file
        include_once("database.php");

        // Check if the user is logged in as an admin
        if(isset($_SESSION["username"]) && $_SESSION["user_type"] === 'admin') {
            // Check if the delete button is clicked
            if(isset($_POST['delete_product'])) {
                $product_id_to_delete = $_POST['product_id_to_delete'];

                $result = mysqli_query($con, "SELECT * FROM product WHERE p_id = $product_id_to_delete");
                if ($row = mysqli_fetch_assoc($result)) {
                    // Delete the associated image file
                    $image_file = $row['p_id'] . '.jpg'; // Assuming the image has a .jpg extension, adjust as needed
                    $image_path = './images/' . $image_file; // Adjust the path accordingly
        
                    if (file_exists($image_path)) {
                        unlink($image_path); // Delete the image file
                    }
                // Delete the selected product
            $delete_sql = "DELETE FROM product WHERE p_id = $product_id_to_delete";
            if (mysqli_query($con, $delete_sql)) {
                echo '<div class="alert alert-success" role="alert">Product deleted successfully!</div>';
            } else {
                echo '<div class="alert alert-danger" role="alert">Error deleting product: ' . mysqli_error($con) . '</div>';
            }
        } else {
            echo '<div class="alert alert-warning" role="alert">Error: Product not found.</div>';
        }
    }

            // Retrieve all products
            $result = mysqli_query($con, "SELECT * FROM product");

            if (mysqli_num_rows($result) > 0) {
                echo '<table class="table table-bordered mt-3">';
                echo '<thead class="thead-dark">';
                echo '<tr><th>Product Name</th><th>Price</th><th>Link</th><th>Category</th><th>Details</th><th>Action</th></tr>';
                echo '</thead>';
                echo '<tbody>';

                while($row = mysqli_fetch_assoc($result)) {
                    echo '<tr>';
                    echo '<td>'.$row['p_name'].'</td>';
                    echo '<td>'.$row['p_price'].'</td>';
                    echo '<td>'.$row['p_link'].'</td>';
                    echo '<td>'.$row['p_category'].'</td>';
                    echo '<td>'.$row['p_details'].'</td>';
                    echo '<td>
                            <form method="post" action="'.htmlspecialchars($_SERVER["PHP_SELF"]).'">
                                <input type="hidden" name="product_id_to_delete" value="'.$row['p_id'].'">
                                <a href="update_product.php?id='.$row['p_id'].'" class="btn btn-primary btn-sm">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-down-up" viewBox="0 0 16 16">
                                    <path fill-rule="evenodd" d="M11.5 15a.5.5 0 0 0 .5-.5V2.707l3.146 3.147a.5.5 0 0 0 .708-.708l-4-4a.5.5 0 0 0-.708 0l-4 4a.5.5 0 1 0 .708.708L11 2.707V14.5a.5.5 0 0 0 .5.5m-7-14a.5.5 0 0 1 .5.5v11.793l3.146-3.147a.5.5 0 0 1 .708.708l-4 4a.5.5 0 0 1-.708 0l-4-4a.5.5 0 0 1 .708-.708L4 13.293V1.5a.5.5 0 0 1 .5-.5"/>
                                </svg> Update</a>

                                <button type="submit" name="delete_product" class="btn btn-danger btn-sm">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash-fill" viewBox="0 0 16 16">
                                <path d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5M8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5m3 .5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 1 0"/>
                                </svg> Delete</button>
                                
                            </form>
                          </td>';
                    echo '</tr>';
                }

                echo '</tbody>';
                echo '</table>';
            } else {
                echo '<div class="alert alert-info" role="alert">No products found.</div>';
            }
        } else {
            // Handle the case where the user is not authenticated as an admin
            echo '<div class="alert alert-warning" role="alert">Error: Access denied. You must be logged in as an admin.</div>';
        }

        // Close database connection
        mysqli_close($con);
        ?>
    </div>

    <!-- Add Bootstrap JS and Popper.js scripts (required for Bootstrap) -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</body>
</html>
