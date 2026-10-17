<?php
include 'config.php';
check_login();

$id = (int)$_GET['id'];

if ($_SESSION['role'] == 'admin') {
    $stmt = $conn->prepare("SELECT * FROM items WHERE id = ?");
    $stmt->bind_param("i", $id);
} else {
    $stmt = $conn->prepare("SELECT * FROM items WHERE id = ? AND user_id = ?");
    $stmt->bind_param("ii", $id, $_SESSION['user_id']);
}
$stmt->execute();
$item = $stmt->get_result()->fetch_assoc();

if (!$item) {
    die("Item not found.");
}

$error = "";

if (isset($_POST['update'])) {
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
        $stmt = $conn->prepare("UPDATE items SET name = ?, category = ?, quantity = ?, price = ? WHERE id = ?");
        $stmt->bind_param("ssidi", $name, $category, $quantity, $price, $id);
        $stmt->execute();
        header("Location: dashboard.php?msg=Item updated");
        exit();
    }
}

include 'header.php';
?>

<div class="form-box">
    <h3>Edit Item</h3>

    <?php if ($error != "") { ?>
        <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
    <?php } ?>

    <form method="post" id="itemForm">
        <div class="mb-3">
            <label class="form-label">Item Name</label>
            <input type="text" name="name" id="name" class="form-control" value="<?php echo htmlspecialchars($item['name']); ?>">
        </div>
        <div class="mb-3">
            <label class="form-label">Category</label>
            <input type="text" name="category" id="category" class="form-control" value="<?php echo htmlspecialchars($item['category']); ?>">
        </div>
        <div class="mb-3">
            <label class="form-label">Quantity</label>
            <input type="number" name="quantity" id="quantity" class="form-control" value="<?php echo (int)$item['quantity']; ?>">
        </div>
        <div class="mb-3">
            <label class="form-label">Price</label>
            <input type="number" step="0.01" name="price" id="price" class="form-control" value="<?php echo $item['price']; ?>">
        </div>
        <p id="formError" class="text-danger"></p>
        <button type="submit" name="update" class="btn btn-primary">Update</button>
        <a href="dashboard.php" class="btn btn-secondary">Cancel</a>
    </form>
</div>

<?php include 'footer.php'; ?>
