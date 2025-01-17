<?php 
require 'config/database.php';

// Fetch current user from database
$avatar = null;
if (isset($_SESSION['user-id'])) { 
    $id = filter_var($_SESSION['user-id'], FILTER_SANITIZE_NUMBER_INT);
    $query = "SELECT avatar FROM users WHERE id = $id";
    $result = mysqli_query($connection, $query);

    if ($result) {
        $avatar = mysqli_fetch_assoc($result);
        // Clean up the avatar path
        if ($avatar) {
            $avatar['avatar'] = str_replace('images.', 'images/', $avatar['avatar']);
        }
    } else {
        // Query failed
        echo "Database query failed: " . mysqli_error($connection);
    }
} else {
    echo "User is not logged in.";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blogvista PHP & MYSQL</title>
    <!-- Custom stylesheet -->
    <link rel="stylesheet" href="<?php echo ROOT__URL ?>css/style.css">
    <!-- Iconscout CDN -->
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.8/css/line.css">
    <!-- Google font Montserrat -->
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@100..900&display=swap" rel="stylesheet">
</head>
<body>
    <nav>
        <div class="container nav__container">
            <a href="<?php echo ROOT__URL ?>index.php" class="nav__logo">NIDHI</a>
            <ul class="nav__items">
                <li><a href="<?php echo ROOT__URL ?>blog.php">Blog</a></li>
                <li><a href="<?php echo ROOT__URL ?>about.php">About</a></li>
                <li><a href="<?php echo ROOT__URL ?>services.php">Services</a></li>
                <li><a href="<?php echo ROOT__URL ?>contact.php">Contact</a></li>
                <?php if (isset($_SESSION['user-id']) && $avatar): ?>
                <li class="nav__profile">
                    <div class="avatar">
                        <img src="<?= ROOT__URL . htmlspecialchars($avatar['avatar']) ?>" alt="User Avatar">
                    </div>
                    <ul>
                        <li><a href="<?php echo ROOT__URL ?>admin/index.php">Dashboard</a></li>
                        <li><a href="<?php echo ROOT__URL ?>logout.php">Logout</a></li>
                    </ul>
                </li>
                <?php else: ?>
                <li><a href="<?php echo ROOT__URL ?>signin.php">Signin</a></li>   
                <?php endif ?>
            </ul>
            <button id="open__nav-btn"><i class="uil uil-bars"></i></button>
            <button id="close__nav-btn"><i class="uil uil-multiply"></i></button>
        </div>
    </nav>
    <!------------------end of nav bar---------------->
</body>
</html>
