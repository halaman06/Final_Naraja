<?php
include 'config.php';
check_login();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = (int)$_POST['id'];

    if ($_SESSION['role'] == 'admin') {
        $stmt = $conn->prepare("DELETE FROM items WHERE id = ?");
        $stmt->bind_param("i", $id);
    } else {
        $stmt = $conn->prepare("DELETE FROM items WHERE id = ? AND user_id = ?");
        $stmt->bind_param("ii", $id, $_SESSION['user_id']);
    }
    $stmt->execute();
}

header("Location: dashboard.php?msg=Item deleted");
exit();
?>
