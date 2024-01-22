<?php
// Include database connection file
include_once("database.php");

// Initialize the search query
$search_query = '';

// Check if the search form is submitted
if(isset($_POST['search'])) {
    $search_query = mysqli_real_escape_string($con, $_POST['search_query']);
}

// Retrieve products based on the search query
$sql = "SELECT * FROM product WHERE p_name LIKE '%$search_query%' OR p_category LIKE '%$search_query%'";
$result = mysqli_query($con, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Product View</title>
    <!-- Add Bootstrap CSS link -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <style>
        #details {
            height: 50px;
            overflow: hidden;
        }
        .img-size{
            height: 250px;
        }
        .s_width{
            width: 90%;
        }
        .s-direction{
            display: flex;
            flex-direction: row;
        }
        .s-btn{
            width: 8%;
            margin-left: 2%;
        }
        body{
            flex:1;
            background-image:url('./images/leaveBack.jpg') ;
            background-size: cover;
        }
        h2{
            color: white;
            font-family: monospace;
        }
    </style>
</head>
<body>
    <?php include_once("header.php"); ?>
    <div class="container mt-5">
        <h2>Add your desired bikes</h2><br>

        <!-- Search Form -->
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <div class="form-group s-direction">
                <input type="text" class="form-control" placeholder="Search..." name="search_query" id="search_query" value="<?php echo $search_query; ?>">
                <button type="submit" class="btn s-btn" name="search">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                    <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001q.044.06.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1 1 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0"/>
                </svg>
                    </svg>
                </button>
            </div><br>
            
        </form>

        <?php
        if (mysqli_num_rows($result) > 0) {
            echo '<div class="row">';

            while($row = mysqli_fetch_assoc($result)) {
                echo '<div class="col-md-4 mb-4">';
                echo '<div class="card">';
                echo '<img src="'.$row['p_link'].'" class="card-img-top img-size" alt="'.$row['p_name'].'">';
                echo '<div class="card-body">';
                echo '<h5 class="card-title">'.$row['p_name'].'</h5>';
                echo '<p class="card-text">Price: $'.$row['p_price'].'</p>';
                echo '<p class="card-text">Category: '.$row['p_category'].'</p>';
                echo '<p class="card-text" id="details">'.$row['p_details'].'</p>';

                // Add a form for quantity input and add to cart button
                echo '<form method="post" action="'.htmlspecialchars($_SERVER["PHP_SELF"]).'">';
                echo '<div class="form-group">';
                echo '<label for="quantity">Quantity:</label>';
                echo '<input type="number" class="form-control" name="quantity" id="quantity" value="1" min="1">';
                echo '</div>';
                echo '<input type="hidden" name="product_id_to_add" value="'.$row['p_id'].'">';
                echo '<button type="submit" name="add_to_cart" class="btn btn-primary">Add to Cart</button>';
                echo '</form>';

                echo '</div>';
                echo '</div>';
                echo '</div>';
            }

            echo '</div>';
        } else {
            echo '<div class="alert alert-info" role="alert">No products found.</div>';
        }

        // Check if the add to cart button is clicked
        if(isset($_POST['add_to_cart'])) {
            $product_id_to_add = $_POST['product_id_to_add'];
            $quantity = isset($_POST['quantity']) ? intval($_POST['quantity']) : 1;

            // Insert the selected product into the cart table with specified quantity
            $insert_cart_sql = "INSERT INTO cart (p_id, username, quantity) VALUES ($product_id_to_add, '$username', $quantity)";
            if (mysqli_query($con, $insert_cart_sql)) {
                echo '<div class="alert alert-success mt-3" role="alert">Product added to cart successfully!</div>';
            } else {
                echo '<div class="alert alert-danger mt-3" role="alert">Error adding product to cart: ' . mysqli_error($con) . '</div>';
            }
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
