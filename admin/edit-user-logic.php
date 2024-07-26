<?php 
require 'config/database.php';

if(isset($_POST['submit'])) {
    // Get updated form data
    $id = filter_var($_POST['Id'], FILTER_SANITIZE_NUMBER_INT);
    $firstname = filter_var($_POST['firstname'], FILTER_SANITIZE_STRING);
    $lastname = filter_var($_POST['lastname'], FILTER_SANITIZE_STRING);
    $is_admin = filter_var($_POST['userrole'], FILTER_SANITIZE_NUMBER_INT);

    // Check for valid input
    if(!$firstname || !$lastname){
        $_SESSION['edit-user'] = "Invalid Form Input On Edit Page.";
    } else {
        // Update user in database
        $query = "UPDATE users SET firstname = '$firstname', lastname = '$lastname', is_admin = $is_admin WHERE Id = $id LIMIT 1";
        $result = mysqli_query($connection, $query);

        if(mysqli_errno($connection)){
            $_SESSION['edit-user'] = "Failed to Update User";
        } else {
            $_SESSION['edit-user-success'] = "User $firstname $lastname updated successfully";
        }
    }

    header('location: ' . ROOT__URL . 'admin/manage-users.php');
    die();
}
?>
