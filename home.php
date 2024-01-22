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
$sql = "SELECT * FROM product WHERE p_name LIKE '%$search_query%' OR p_category LIKE '%$search_query%' LIMIT 6";
$result = mysqli_query($con, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Welcome to Bike.LK</title>
    <!-- Add Bootstrap CSS link -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <style>
        .product-card {
            margin-bottom: 20px;
            cursor: pointer;
        }
        #details {
            height: 50px;
            overflow: hidden;
        }
        .r-height{
            flex: 1;
        }
        body{
            flex:1;
            background-image:url('./images/leaveBack.jpg') ;
            background-size: cover;
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
        h2{
            color: white;
            font-family: monospace;
        }
    </style>
</head>
<body>
    <?php include_once("header.php"); ?>
    <div class="container mt-5 r-height">
        <h2>Welcome, <?php echo $username; ?>!</h2><br>

        <!-- Search Form -->
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <div class="form-group s-direction">
                <input type="text" class="form-control s_width" placeholder="Search..." id="search_query" name="search_query" value="<?php echo $search_query; ?>">
                <button type="submit" class="btn s-btn" name="search">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                    <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001q.044.06.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1 1 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0"/>
                </svg>
                </button>
            </div>
            
        </form>

        <h3>All Products:</h3>

        <?php
        if (mysqli_num_rows($result) > 0) {
            echo '<div class="row">';

            while($row = mysqli_fetch_assoc($result)) {
                echo '<div class="col-md-4 mb-4 product-card" onclick="goToProductPage(' . $row['p_id'] . ')">';
                echo '<div class="card">';
                echo '<img src="'.$row['p_link'].'" class="card-img-top img-size" alt="'.$row['p_name'].'">';
                echo '<div class="card-body">';
                echo '<h5 class="card-title">'.$row['p_name'].'</h5>';
                echo '<p class="card-text">Price: $'.$row['p_price'].'</p>';
                echo '<p class="card-text">Category: '.$row['p_category'].'</p>';
                echo '<p class="card-text" id="details">'.$row['p_details'].'</p>';
                echo '</div>';
                echo '</div>';
                echo '</div>';
            }

            echo '</div>';
        } else {
            echo '<div class="alert alert-info" role="alert">No products found.</div>';
        }
        ?>
    </div>
    <?php include_once("footer.php"); ?>

    <!-- Add Bootstrap JS and Popper.js scripts (required for Bootstrap) -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>

    <script>
        function goToProductPage(productId) {
            window.location.href = 'product.php?product_id=' + productId;
        }
    </script>
</body>
</html>
