<?php
include 'config.php';
check_login();

$q = "%" . $_GET['q'] . "%";

if ($_SESSION['role'] == 'admin') {
    $stmt = $conn->prepare("SELECT * FROM items WHERE name LIKE ? ORDER BY id DESC");
    $stmt->bind_param("s", $q);
} else {
    $stmt = $conn->prepare("SELECT * FROM items WHERE name LIKE ? AND user_id = ? ORDER BY id DESC");
    $stmt->bind_param("si", $q, $_SESSION['user_id']);
}
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    echo "<tr><td colspan='5' class='text-center'>No items found.</td></tr>";
}

while ($row = $result->fetch_assoc()) {
    $low = ($row['quantity'] <= 5) ? "low-stock" : "";
    echo "<tr>";
    echo "<td>" . htmlspecialchars($row['name']) . "</td>";
    echo "<td>" . htmlspecialchars($row['category']) . "</td>";
    echo "<td class='$low'>" . $row['quantity'] . "</td>";
    echo "<td>" . number_format($row['price'], 2) . "</td>";
    echo "<td>
            <a href='edit.php?id=" . $row['id'] . "' class='btn btn-sm btn-primary'>Edit</a>
            <form method='post' action='delete.php' class='d-inline' onsubmit='return confirm(\"Delete this item?\");'>
                <input type='hidden' name='id' value='" . $row['id'] . "'>
                <button type='submit' class='btn btn-sm btn-danger'>Delete</button>
            </form>
          </td>";
    echo "</tr>";
}
?>
