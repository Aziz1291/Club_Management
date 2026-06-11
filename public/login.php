<?php
session_start();
include_once('../classes/User.php');

$error = '';
$username = '';
$password = '';
$role = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    $role     = $_POST['role'];

    $user = new User();
    $result = $user->login($username, $password, $role);

    if ($result === "success") {
        $_SESSION['username'] = $username;
        $_SESSION['role'] = $role;
        header("Location: index.php");
        exit;
    } elseif ($result === "wrong_password") {
        $error = "Incorrect password. Please try again.";
    } elseif ($result === "no_user") {
        $error = "No " . ($role === 'admin' ? 'admin' : 'member') . " account found with that username.";
    } else {
        $error = "Invalid login credentials.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login – Club Management</title>
    <link rel="icon" type="image/png" href="../assets/favicon.png">

    <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/css/lineicons.css">
    <link rel="stylesheet" href="../assets/css/main.css">
    
    <style>
        <?php include('../assets/css/login.css');?>
    </style>
</head>

<body>

<div class="login-container">
    <div class="login-card">
        <div class="login-header">
            <div class="logo">
                <img src="../assets/images/logo/logo.svg" alt="Club Management">
            </div>
            <h3>Welcome Back</h3>
            <p class="login-subtitle">Sign in to your account</p>
        </div>

        <?php if ($error): ?>
            <div class="alert alert-danger text-center">
                <i class="lni lni-warning"></i> <?= $error ?>
            </div>
        <?php endif; ?>

        <form method="POST">
            <!-- USERNAME -->
            <div class="form-group">
                <label class="form-label">Username</label>
                <input type="text" name="username" class="form-control" placeholder="Enter your username" value="<?= htmlspecialchars($username) ?>" required>
            </div>

            <!-- PASSWORD -->
            <div class="form-group">
                <label class="form-label">Password</label>
                <div class="password-wrapper">
                    <input type="password" name="password" id="password-field" class="form-control" placeholder="Enter your password" required>
                    <button type="button" class="password-toggle" id="togglePassword">
                        <i class="lni lni-eye"></i>
                    </button>
                </div>
            </div>

            <!-- ROLE -->
            <div class="form-group">
                <label class="form-label">Role</label>
                <div class="select-style-1">
                    <select name="role" class="form-control" required>
                        <option value="admin" <?= $role === 'admin' ? 'selected' : '' ?>>Administrator</option>
                        <option value="member" <?= $role === 'member' ? 'selected' : '' ?>>Member</option>
                    </select>
                </div>
            </div>

            <!-- LOGIN BUTTON -->
            <button type="submit" class="btn btn-primary btn-login">
                <i class="lni lni-enter me-2"></i> Sign In
            </button>
        </form>

        <div class="login-footer">
            <p>Not a member yet?</p>
            <a href="join_request.php">
                <i class="lni lni-user me-1"></i> Request to join the club
            </a>
        </div>
    </div>
</div>

<script src="../assets/js/bootstrap.bundle.min.js"></script>

<script>
    // Enhanced Password Toggle
    const passwordField = document.getElementById("password-field");
    const togglePassword = document.getElementById("togglePassword");
    const toggleIcon = togglePassword.querySelector('i');

    togglePassword.addEventListener("click", function() {
        const type = passwordField.getAttribute("type") === "password" ? "text" : "password";
        passwordField.setAttribute("type", type);
        
        // Toggle eye icons
        if (type === "password") {
            toggleIcon.classList.remove("lni-eye-off");
            toggleIcon.classList.add("lni-eye");
        } else {
            toggleIcon.classList.remove("lni-eye");
            toggleIcon.classList.add("lni-eye-off");
        }
        
        // Add focus to password field for better UX
        passwordField.focus();
    });

    // Add animation to form elements
    document.addEventListener('DOMContentLoaded', function() {
        const formElements = document.querySelectorAll('.form-control, .btn-login');
        formElements.forEach((element, index) => {
            element.style.animationDelay = `${index * 0.1}s`;
        });
    });
</script>

</body>
</html>