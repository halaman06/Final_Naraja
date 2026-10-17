<?php
include 'config.php';
check_admin();

if (isset($_POST['delete_user'])) {
    $id = (int)$_POST['id'];
    if ($id != $_SESSION['user_id']) {
        $stmt = $conn->prepare("DELETE FROM users WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
    }
    header("Location: users.php");
    exit();
}

$result = $conn->query("SELECT id, name, email, role, created_at FROM users ORDER BY id");

include 'header.php';
?>

<h3>Manage Users</h3>

<div class="table-responsive">
    <table class="table table-bordered table-striped bg-white mt-3">
        <thead class="table-dark">
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Role</th>
                <th>Registered</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()) { ?>
            <tr>
                <td><?php echo htmlspecialchars($row['name']); ?></td>
                <td><?php echo htmlspecialchars($row['email']); ?></td>
                <td><?php echo $row['role']; ?></td>
                <td><?php echo $row['created_at']; ?></td>
                <td>
                    <?php if ($row['id'] != $_SESSION['user_id']) { ?>
                    <form method="post" onsubmit="return confirm('Delete this user and all their items?');">
                        <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                        <button type="submit" name="delete_user" class="btn btn-sm btn-danger">Delete</button>
                    </form>
                    <?php } ?>
                </td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
</div>

<?php include 'footer.php'; ?>
