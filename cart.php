<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Cart</title>
    <!-- Add Bootstrap CSS link -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <style>
        .r-height{
            height: 36rem;
        }
        body{
            flex:1;
            background-image:url('./images/leaveBack.jpg') ;
            background-size: cover;
        }
        td{
            color: black;
            background-color: #ffffff90;
        }
        .tot{
            color: white;
            background-color: #ffffff01;
            width: 38%;
            padding: 1rem;
            border-radius: 2px;
            text-align: center;
            float: right;
            border: 3px solid #ff0000;
        }
        .bb{
            color: yellow;
        }
    </style>
</head>
<body>
    <?php include_once("header.php"); ?>
    <div class="container mt-5 r-height">
        <h2>Your Cart</h2>

        <?php
        // Include database connection file
        include_once("database.php");

        // Get username from session
        if(isset($_SESSION["username"])) {
            $username = $_SESSION["username"];

            // Check if the remove from cart button is clicked
            if(isset($_POST['remove_from_cart'])) {
                $product_id_to_remove = $_POST['product_id_to_remove'];

                // Remove the selected product from the cart table
                $remove_cart_sql = "DELETE FROM cart WHERE p_id = $product_id_to_remove AND username='$username'";
                if (mysqli_query($con, $remove_cart_sql)) {
                    echo '<div class="alert alert-success mt-3" role="alert">Product removed from cart successfully!</div>';
                } else {
                    echo '<div class="alert alert-danger mt-3" role="alert">Error removing product from cart: ' . mysqli_error($con) . '</div>';
                }
            }

            // Retrieve items in the cart for the logged-in user
            $cart_result = mysqli_query($con, "SELECT cart.p_id, product.p_name, product.p_price, cart.quantity FROM cart JOIN product ON cart.p_id = product.p_id WHERE cart.username='$username'");

            if (mysqli_num_rows($cart_result) > 0) {
                echo '<table class="table table-bordered mt-3">';
                echo '<thead class="thead-dark">';
                echo '<tr><th>Product Name</th><th>Price</th><th>Quantity</th><th>Total Price</th><th>Action</th></tr>';
                echo '</thead>';
                echo '<tbody>';

                $overall_total = 0;

                while($cart_row = mysqli_fetch_assoc($cart_result)) {
                    $total_price = $cart_row['p_price'] * $cart_row['quantity'];
                    $overall_total += $total_price;

                    echo '<tr>';
                    echo '<td>'.$cart_row['p_name'].'</td>';
                    echo '<td>Rs.'.$cart_row['p_price'].' /=</td>';
                    echo '<td>'.$cart_row['quantity'].'</td>';
                    echo '<td>Rs.'.$total_price.' /=</td>';
                    echo '<td>
                            <form method="post" action="'.htmlspecialchars($_SERVER["PHP_SELF"]).'">
                                <input type="hidden" name="product_id_to_remove" value="'.$cart_row['p_id'].'">
                                <button type="submit" name="remove_from_cart" class="btn btn-danger btn-sm">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-bag-dash-fill" viewBox="0 0 16 16">
                                    <path fill-rule="evenodd" d="M10.5 3.5a2.5 2.5 0 0 0-5 0V4h5zm1 0V4H15v10a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V4h3.5v-.5A3.5 3.5 0 1 1 7 0a3.5 3.5 0 0 1 7 0zM6 9.5a.5.5 0 0 0 0 1h4a.5.5 0 0 0 0-1z"/>
                                </svg> Remove</button>
                                <button class="btn btn-success btn-sm">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-bag-fill" viewBox="0 0 16 16">
                                    <path d="M8 1a2.5 2.5 0 0 1 2.5 2.5V4h-5v-.5A2.5 2.5 0 0 1 8 1m3.5 3v-.5a3.5 3.5 0 1 0-7 0V4H1v10a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V4z"/>
                                </svg> Buy Now</button>
                            </form>
                          </td>';
                    echo '</tr>';
                }

                echo '</tbody>';
                echo '</table>';

                // Display overall cart total
                echo '<div class="mt-3 tot">Overall Cart Total: <b class="bb">Rs.'.$overall_total.' /=</b></div>';
            } else {
                echo '<div class="alert alert-info mt-3" role="alert">Your cart is empty.</div>';
            }
        } else {
            // Handle the case where username is not set in session
            echo '<div class="alert alert-warning mt-3" role="alert">Error: User not authenticated.</div>';
        }

        // Close database connection
        mysqli_close($con);
        ?>
    </div>
    <?php include_once("footer.php"); ?>

    <!-- Add Bootstrap JS and Popper.js scripts (required for Bootstrap) -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</body>
</html>
