<?php
include 'config.php';
check_login();

$error = "";

if (isset($_POST['save'])) {
    $name = trim($_POST['name']);
    $category = trim($_POST['category']);
    $quantity = $_POST['quantity'];
    $price = $_POST['price'];

    if ($name == "" || $category == "") {
        $error = "Name and category are required.";
    } elseif (!is_numeric($quantity) || $quantity < 0) {
        $error = "Quantity must be 0 or more.";
    } elseif (!is_numeric($price) || $price < 0) {
        $error = "Price must be 0 or more.";
    } else {
        $stmt = $conn->prepare("INSERT INTO items (name, category, quantity, price, user_id) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("ssidi", $name, $category, $quantity, $price, $_SESSION['user_id']);
        $stmt->execute();
        header("Location: dashboard.php?msg=Item added");
        exit();
    }
}

include 'header.php';
?>

<div class="form-box">
    <h3>Add Item</h3>

    <?php if ($error != "") { ?>
        <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
    <?php } ?>

    <form method="post" id="itemForm">
        <div class="mb-3">
            <label class="form-label">Item Name</label>
            <input type="text" name="name" id="name" class="form-control">
        </div>
        <div class="mb-3">
            <label class="form-label">Category</label>
            <input type="text" name="category" id="category" class="form-control">
        </div>
        <div class="mb-3">
            <label class="form-label">Quantity</label>
            <input type="number" name="quantity" id="quantity" class="form-control" value="0">
        </div>
        <div class="mb-3">
            <label class="form-label">Price</label>
            <input type="number" step="0.01" name="price" id="price" class="form-control" value="0">
        </div>
        <p id="formError" class="text-danger"></p>
        <button type="submit" name="save" class="btn btn-success">Save</button>
        <a href="dashboard.php" class="btn btn-secondary">Cancel</a>
    </form>
</div>

<?php include 'footer.php'; ?>
