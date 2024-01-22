<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us - Bike.LK</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
    <style>
        .form-control{
            width:40%;
            align-self: center;
            background-color: transparent;
        }
        label{
            font-family: Cambria, Cochin, Georgia, Times, 'Times New Roman', serif;
            font-size: 1.3rem;
            color: white;
        }
        .form{
            padding: 3rem;
        }
        body{
            flex:1;
            background-image:url('./images/bikebackground.jpg') ;
            background-size: cover;
        }
        h2,p{
            color: white;
        }
    </style>
</head>
<body>
<?php include('header.php'); ?>
<div class="container mt-4">
    <h2>Contact Us</h2>
    <p>If you have any questions or inquiries, feel free to reach out to us.</p>

    <?php include('process_contact.php'); ?>

    <form action="" method="post">
        <div class="form-group">
            <label for="name">Your Name:</label>
            <input type="text" class="form-control" id="name" name="name" required>
        </div>

        <div class="form-group">
            <label for="email">Your Email:</label>
            <input type="email" class="form-control" id="email" name="email" required>
        </div>

        <div class="form-group">
            <label for="message">Your Message:</label>
            <textarea class="form-control" id="message" name="message" rows="5" required></textarea>
        </div><br>

        <button type="submit" class="btn btn-primary form-control" name="submit">Send</button>
    </form><br><br>
    <p>Connect with us on social media:</p><br>
    <ul class="list-inline">
        <li class="list-inline-item">
            <a href="https://www.facebook.com/yourpage" target="_blank" class="social-icon"><i class="fab fa-facebook fa-3x"></i></a>
        </li>
        <li class="list-inline-item">
            <a href="https://www.linkedin.com/in/yourprofile" target="_blank" class="social-icon"><i class="fab fa-linkedin fa-3x"></i></a>
        </li>
        <li class="list-inline-item">
            <a href="https://www.linkedin.com/in/yourprofile" target="_blank" class="social-icon"><i class="fab fa-twitter fa-3x"></i></a>
        </li>
        <li class="list-inline-item">
            <a href="https://www.linkedin.com/in/yourprofile" target="_blank" class="social-icon"><i class="fab fa-instagram fa-3x"></i></a>
        </li>
    </ul>
</div>

<?php include('footer.php'); ?>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    </div>
</body>
</html>
