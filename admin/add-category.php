<?php 
    include 'partials/header.php';

    //get back form data if invalid

    $title =$_SESSION['add-category-data']['title'] ?? null;
    $description =$_SESSION['add-category-data']['description'] ?? null;

    unset($_SESSION['add-category-data']);
?>

<section class="form__section">
    <div class="container form__section-container">
        <h2>Add Category</h2>
        <?php if(isset($_SESSION['add-category'])): ?>
            <div class="alert__message error">
                <p><?= $_SESSION['add-category'] ?></p>
            </div>
            <?php unset($_SESSION['add-category']); ?>
        <?php endif; ?>
        <form action="<?= ROOT__URL ?>admin/add-category-logic.php" method="POST">
            <input type="text" value="<?= $title ?>" name="title"  placeholder="Title" value="<?= $_SESSION['add-category-data']['title'] ?? '' ?>">
            <textarea rows="4" value="<?= $description?>" name="description" placeholder="Description"><?= $_SESSION['add-category-data']['description'] ?? '' ?></textarea>
            <button type="submit" name="submit" class="btn">Add Category</button>
        </form>
        <?php unset($_SESSION['add-category-data']); ?>
    </div>
</section>

<?php 
include '../partials/footer.php';
?>
