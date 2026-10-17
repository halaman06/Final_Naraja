<?php
include 'config.php';

$error = "";

if (isset($_POST['login'])) {
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if ($user && password_verify($password, $user['password'])) {
        session_regenerate_id(true);
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['name'] = $user['name'];
        $_SESSION['role'] = $user['role'];
        header("Location: dashboard.php");
        exit();
    } else {
        $error = "Wrong email or password.";
    }
}

include 'header.php';
?>

<div class="form-box">
    <h3>Login</h3>

    <?php if ($error != "") { ?>
        <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
    <?php } ?>

    <form method="post" id="loginForm">
        <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="email" name="email" id="email" class="form-control">
        </div>
        <div class="mb-3">
            <label class="form-label">Password</label>
            <input type="password" name="password" id="password" class="form-control">
        </div>
        <p id="formError" class="text-danger"></p>
        <button type="submit" name="login" class="btn btn-primary w-100">Login</button>
    </form>
    <p class="mt-3">No account yet? <a href="register.php">Register</a></p>
</div>

<?php include 'footer.php'; ?>
