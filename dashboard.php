<?php
include 'config.php';
check_login();
include 'header.php';
?>

<div class="d-flex justify-content-between align-items-center mb-3">
    <h3>Inventory Items</h3>
    <a href="add.php" class="btn btn-success">+ Add Item</a>
</div>

<?php if (isset($_GET['msg'])) { ?>
    <div class="alert alert-info"><?php echo htmlspecialchars($_GET['msg']); ?></div>
<?php } ?>

<input type="text" id="search" class="form-control mb-3" placeholder="Search item name...">

<div class="table-responsive">
    <table class="table table-bordered table-striped bg-white">
        <thead class="table-dark">
            <tr>
                <th>Name</th>
                <th>Category</th>
                <th>Quantity</th>
                <th>Price</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody id="results">
        </tbody>
    </table>
</div>

<?php include 'footer.php'; ?>
