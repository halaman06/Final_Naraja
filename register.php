<?php
include 'config.php';

$error = "";
$success = "";

if (isset($_POST['register'])) {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $confirm = $_POST['confirm'];

    // server side validation
    if ($name == "" || $email == "" || $password == "") {
        $error = "Please fill in all fields.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Invalid email address.";
    } elseif (strlen($password) < 6) {
        $error = "Password must be at least 6 characters.";
    } elseif ($password != $confirm) {
        $error = "Passwords do not match.";
    } else {
        // check if email is already used
        $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $error = "Email is already registered.";
        } else {
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $conn->prepare("INSERT INTO users (name, email, password, role) VALUES (?, ?, ?, 'user')");
            $stmt->bind_param("sss", $name, $email, $hash);
            $stmt->execute();
            $success = "Account created! You can login now.";
        }
    }
}

include 'header.php';
?>

<div class="form-box">
    <h3>Register</h3>

    <?php if ($error != "") { ?>
        <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
    <?php } ?>
    <?php if ($success != "") { ?>
        <div class="alert alert-success"><?php echo htmlspecialchars($success); ?></div>
    <?php } ?>

    <form method="post" id="registerForm">
        <div class="mb-3">
            <label class="form-label">Name</label>
            <input type="text" name="name" id="name" class="form-control">
        </div>
        <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="email" name="email" id="email" class="form-control">
        </div>
        <div class="mb-3">
            <label class="form-label">Password</label>
            <input type="password" name="password" id="password" class="form-control">
        </div>
        <div class="mb-3">
            <label class="form-label">Confirm Password</label>
            <input type="password" name="confirm" id="confirm" class="form-control">
        </div>
        <p id="formError" class="text-danger"></p>
        <button type="submit" name="register" class="btn btn-primary w-100">Register</button>
    </form>
    <p class="mt-3">Already have an account? <a href="login.php">Login</a></p>
</div>

<?php include 'footer.php'; ?>
