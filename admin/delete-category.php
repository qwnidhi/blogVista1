<?php
require 'config/database.php';

if (isset($_GET['id'])) {
    // Check if 'title' is set in the POST request
    if (isset($_POST['title'])) {
        $title = filter_var($_POST['title'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    } else {
        $title = "Category"; // Default title if not set
    }
    
    $id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);

    // Check if "Uncategorized" category exists
    $uncategorized_query = "SELECT id FROM categories WHERE title='Uncategorized' LIMIT 1";
    $uncategorized_result = mysqli_query($connection, $uncategorized_query);

    if (mysqli_num_rows($uncategorized_result) == 0) {
        // Create "Uncategorized" category if it doesn't exist
        $create_uncategorized_query = "INSERT INTO categories (title) VALUES ('Uncategorized')";
        mysqli_query($connection, $create_uncategorized_query);
        $uncategorized_id = mysqli_insert_id($connection);
    } else {
        // Get the id of the "Uncategorized" category
        $uncategorized = mysqli_fetch_assoc($uncategorized_result);
        $uncategorized_id = $uncategorized['id'];
    }

    // Update category_id of posts that belong to this category to the id of "Uncategorized" category
    $update_query = "UPDATE posts SET category_id=$uncategorized_id WHERE category_id=$id";
    $update_result = mysqli_query($connection, $update_query);

    if ($update_result && !mysqli_errno($connection)) {
        // Delete the category
        $delete_query = "DELETE FROM categories WHERE id=$id LIMIT 1";
        $delete_result = mysqli_query($connection, $delete_query);

        if ($delete_result) {
            $_SESSION['delete-category-success'] = "$title deleted successfully";
        } else {
            $_SESSION['delete-category-error'] = "Failed to delete category.";
        }
    } else {
        $_SESSION['delete-category-error'] = "Failed to update posts category.";
    }
}

header('Location: ' . ROOT__URL . 'admin/manage-categories.php');
die();
