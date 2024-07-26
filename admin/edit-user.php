<?php 
    include 'partials/header.php';

    if(isset($_GET['id'])){
        $id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);
        $query = "SELECT * FROM users WHERE Id = $id";
        $result = mysqli_query($connection, $query);
        $user = mysqli_fetch_assoc($result);
    } else {
        header('location: ' . ROOT__URL . 'admin/manage-users.php');
        die();
    }
?>

<section class="form__section">
    <div class="container form__section-container">
        <h2>Edit User</h2>
        <form action="<?= ROOT__URL ?>admin/edit-user-logic.php" method="POST">
            <input type="hidden" value="<?= htmlspecialchars($user['Id']) ?>" name="Id">
            <input type="text" name="firstname" value="<?= htmlspecialchars($user['firstname']) ?>" placeholder="First name">
            <input type="text" name="lastname" value="<?= htmlspecialchars($user['lastname']) ?>" placeholder="Last name">
            <select name="userrole">
                <option value="0" <?= $user['is_admin'] == 0 ? 'selected' : '' ?>>Author</option>
                <option value="1" <?= $user['is_admin'] == 1 ? 'selected' : '' ?>>Admin</option>
            </select>
            <button type="submit" name="submit" class="btn">Update User</button>
        </form>
    </div>
</section>

<?php 
    include '../partials/footer.php';
?>
