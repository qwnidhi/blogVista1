<?php
require 'config/database.php';


if(isset($_POST['submit'])){
    // Get form data
    $title = filter_var($_POST['title'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $description = filter_var($_POST['description'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    if(!$title){
        $_SESSION['add-category'] = "Enter Title";
    } elseif(!$description){
        $_SESSION['add-category'] = "Enter Description";
    }

    // Redirect back to add category page with form data if there was invalid input
    if(isset($_SESSION['add-category'])){
        $_SESSION['add-category-data'] = $_POST;
        header('Location: ' . ROOT__URL . 'admin/add-category.php');
        die();
    } else {
        // Insert category into database
        $query = "INSERT INTO categories (title, description) VALUES ('$title', '$description')";
        $result = mysqli_query($connection, $query);

        if(mysqli_errno($connection)){
            $_SESSION['add-category'] = "Couldn't add Category";
            header('Location: ' . ROOT__URL . 'admin/add-category.php');
            die();
        } else {
            $_SESSION['add-category-success'] = "$title category added successfully";
            header('Location: ' . ROOT__URL . 'admin/manage-categories.php');
            die();
        }
    }
}
?>
