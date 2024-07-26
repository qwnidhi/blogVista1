<?php
require 'config/database.php';

if (isset($_POST['submit'])) {
    $author_id = $_SESSION['user-id'];
    $title = filter_var($_POST['title'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $body = filter_var($_POST['body'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $category_id = filter_var($_POST['category'], FILTER_SANITIZE_NUMBER_INT);
    $is_featured = filter_var($_POST['is_featured'], FILTER_SANITIZE_NUMBER_INT);
    $thumbnail = $_FILES['thumbnail'];

    // Set is__featured to 0 if unchecked
    $is_featured = $is_featured == 1 ? 1 : 0;

    // Validate form data
    if (!$title) {
        $_SESSION['add-post'] = "Enter Post title";
    } elseif (!$category_id) {
        $_SESSION['add-post'] = "Select Post Category";
    } elseif (!$body) {
        $_SESSION['add-post'] = "Enter Post Body";
    } elseif (!$thumbnail['name']) {
        $_SESSION['add-post'] = "Choose Post Thumbnail";
    } else {
        // Work on thumbnail
        // Rename the image
        $time = time(); // Make each image name unique
        $thumbnail_name = $time . '_' . $thumbnail['name']; // Add time to the image name
        $thumbnail_tmp_name = $thumbnail['tmp_name']; // Get the image from the temp folder
        $thumbnail_destination_path = '../images/' . $thumbnail_name; // Set the destination path

        // Make sure file is an image
        $allowed_files = ['png', 'jpg', 'jpeg'];
        $extension = pathinfo($thumbnail_name, PATHINFO_EXTENSION);

        if (in_array($extension, $allowed_files)) {
            // Make sure file is not too big
            if ($thumbnail['size'] < 2000000) {
                // Upload thumbnail
                move_uploaded_file($thumbnail_tmp_name, $thumbnail_destination_path);
            } else {
                $_SESSION['add-post'] = "File size is too large. Should be less than 2MB";
            }
        } else {
            $_SESSION['add-post'] = "File should be png, jpg, or jpeg";
        }
    }

    // Redirect back (with form data) to add-post if there is any problem
    if (isset($_SESSION['add-post'])) {
        $_SESSION['add-post-data'] = $_POST;
        header('Location: ' . ROOT__URL . 'admin/add-post.php');
        die();
    } else {
        // Set is__featured of all posts to 0 if is__featured for this post is 1
        if ($is_featured == 1) {
            $zero_all_is_featured_query = "UPDATE posts SET is_featured = 0";
            mysqli_query($connection, $zero_all_is_featured_query);
        }

        // Insert post into database
        $query = "INSERT INTO posts (title, body, thumbnail, category_id, author_id, is_featured)
                  VALUES ('$title', '$body', '$thumbnail_name', $category_id, $author_id, $is_featured)";
        $result = mysqli_query($connection, $query);

        if (!mysqli_errno($connection)) {
            $_SESSION['add-post-success'] = "New Post Added Successfully";
            header('Location: ' . ROOT__URL . 'admin/');
            die();
        }
    }
}

// Final redirect if script reaches here
header('Location: ' . ROOT__URL . 'admin/add-post.php');
die();
?>
