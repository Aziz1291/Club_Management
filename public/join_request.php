<?php
if (session_status() === PHP_SESSION_NONE) session_start();

// If already logged in, redirect to dashboard
if (isset($_SESSION['username'])) {
    header("Location: index.php");
    exit;
}

include_once('../classes/User.php');

$error   = '';
$success = '';
$username = '';
$email    = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $email    = trim($_POST['email']    ?? '');
    $password = trim($_POST['password'] ?? '');
    $confirm  = trim($_POST['confirm']  ?? '');

    if (empty($username) || empty($email) || empty($password) || empty($confirm)) {
        $error = 'All fields are required.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'Please enter a valid email address.';
    } elseif (strlen($password) < 6) {
        $error = 'Password must be at least 6 characters.';
    } elseif ($password !== $confirm) {
        $error = 'Passwords do not match.';
    } else {
        $user = new User();

        // Check for duplicate username or email
        $checkUser = $user->pdo->prepare("SELECT id FROM users WHERE username = ? OR email = ?");
        $checkUser->execute([$username, $email]);
        if ($checkUser->fetch()) {
            $error = 'That username or email is already taken. Please choose another.';
        } else {
            $user->addUser($username, $email, $password, 'member');
            $success = 'Your account has been created! You can now sign in as a member.';
            $username = '';
            $email    = '';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Join the Club – Club Management</title>
    <link rel="icon" type="image/png" href="../assets/favicon.png">
    <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/css/lineicons.css">
    <link rel="stylesheet" href="../assets/css/main.css">
    <style>
        <?php include('../assets/css/login.css'); ?>

        .alert-success {
            background: #f0fdf4;
            color: #16a34a;
            border: 1px solid #bbf7d0;
            border-radius: 12px;
            padding: 12px 16px;
            margin-bottom: 20px;
        }
        .form-text {
            font-size: 12px;
            color: #94a3b8;
            margin-top: 4px;
        }
    </style>
</head>

<body>

<div class="login-container">
    <div class="login-card">
        <div class="login-header">
            <div class="logo">
                <img src="../assets/images/logo/logo.svg" alt="Club Management">
            </div>
            <h3>Join the Club</h3>
            <p class="login-subtitle">Create your member account</p>
        </div>

        <?php if ($error): ?>
            <div class="alert alert-danger text-center">
                <i class="lni lni-warning"></i> <?= htmlspecialchars($error) ?>
            </div>
        <?php endif; ?>

        <?php if ($success): ?>
            <div class="alert-success text-center">
                <i class="lni lni-checkmark-circle"></i> <?= htmlspecialchars($success) ?>
                <div style="margin-top:12px;">
                    <a href="login.php" class="btn btn-primary btn-login" style="display:inline-block;width:auto;padding:10px 30px;text-decoration:none;">
                        Sign In Now
                    </a>
                </div>
            </div>
        <?php else: ?>

        <form method="POST">
            <!-- USERNAME -->
            <div class="form-group">
                <label class="form-label">Username</label>
                <input type="text" name="username" class="form-control"
                       placeholder="Choose a username"
                       value="<?= htmlspecialchars($username) ?>" required>
            </div>

            <!-- EMAIL -->
            <div class="form-group">
                <label class="form-label">Email Address</label>
                <input type="email" name="email" class="form-control"
                       placeholder="your@email.com"
                       value="<?= htmlspecialchars($email) ?>" required>
            </div>

            <!-- PASSWORD -->
            <div class="form-group">
                <label class="form-label">Password</label>
                <div class="password-wrapper">
                    <input type="password" name="password" id="password-field" class="form-control"
                           placeholder="At least 6 characters" required>
                    <button type="button" class="password-toggle" id="togglePassword">
                        <i class="lni lni-eye"></i>
                    </button>
                </div>
                <p class="form-text">Minimum 6 characters</p>
            </div>

            <!-- CONFIRM PASSWORD -->
            <div class="form-group">
                <label class="form-label">Confirm Password</label>
                <div class="password-wrapper">
                    <input type="password" name="confirm" id="confirm-field" class="form-control"
                           placeholder="Repeat your password" required>
                    <button type="button" class="password-toggle" id="toggleConfirm">
                        <i class="lni lni-eye"></i>
                    </button>
                </div>
            </div>

            <!-- SUBMIT -->
            <button type="submit" class="btn btn-primary btn-login">
                <i class="lni lni-user me-2"></i> Create Account
            </button>
        </form>

        <?php endif; ?>

        <div class="login-footer">
            <p>Already have an account?</p>
            <a href="login.php">
                <i class="lni lni-enter me-1"></i> Sign in here
            </a>
        </div>
    </div>
</div>

<script src="../assets/js/bootstrap.bundle.min.js"></script>
<script>
    function setupToggle(fieldId, btnId) {
        const field = document.getElementById(fieldId);
        const btn   = document.getElementById(btnId);
        if (!field || !btn) return;
        const icon  = btn.querySelector('i');
        btn.addEventListener('click', function () {
            const isPassword = field.getAttribute('type') === 'password';
            field.setAttribute('type', isPassword ? 'text' : 'password');
            icon.classList.toggle('lni-eye',     !isPassword);
            icon.classList.toggle('lni-eye-off',  isPassword);
            field.focus();
        });
    }
    setupToggle('password-field', 'togglePassword');
    setupToggle('confirm-field',  'toggleConfirm');
</script>

</body>
</html>
