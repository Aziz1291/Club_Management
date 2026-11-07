<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

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
            $error = 'That username or email is already registered. Please choose another or sign in.';
        } else {
            $user->addUser($username, $email, $password, 'member');
            $success = 'Your membership account has been established. You may now sign in.';
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
    <meta name="description" content="ClubManager is an academic club management demo for members, events and messages.">
    <meta name="robots" content="noindex, nofollow">
    <meta property="og:type" content="website">
    <meta property="og:title" content="ClubManager | Academic project">
    <meta property="og:description" content="Explore an academic club management demo for members, events and messages.">
    <meta property="og:image" content="https://www.azizkouki.com/projects/club/assets/social-preview.png">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="ClubManager | Academic project">
    <meta name="twitter:description" content="An academic club management demo for members, events and messages.">
    <meta name="twitter:image" content="https://www.azizkouki.com/projects/club/assets/social-preview.png">
    <title>Membership Application – ClubManager</title>
    <link rel="icon" type="image/png" href="../assets/favicon.png">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700&family=JetBrains+Mono:wght@400;500;600&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/css/lineicons.css">
    <link rel="stylesheet" href="../assets/css/club-tokens.css">
    <link rel="stylesheet" href="../assets/css/login.css">
</head>

<body>

<div class="login-container">
    <div class="login-card">
        <div class="login-header">
            <div class="logo">
                <img src="../assets/images/logo/logo.svg" alt="Club Crest">
            </div>
            <span class="kicker">Join the club</span>
            <h1 class="h3">Join the club</h1>
            <p class="login-subtitle">This is an academic demo. Use sample information to create a member account.</p>
        </div>

        <?php if ($error): ?>
            <div class="alert alert-danger" role="alert">
                <i class="lni lni-warning"></i>
                <span><?= htmlspecialchars($error) ?></span>
            </div>
        <?php endif; ?>

        <?php if ($success): ?>
            <div class="alert alert-success" role="alert">
                <i class="lni lni-checkmark-circle"></i>
                <div>
                    <p class="mb-2"><strong>Application Approved!</strong> <?= htmlspecialchars($success) ?></p>
                    <a href="login.php" class="btn btn-login" style="display:inline-flex; width:auto; padding:8px 24px;">
                        Proceed to Sign In &rarr;
                    </a>
                </div>
            </div>
        <?php else: ?>

        <form method="POST">
            <!-- USERNAME -->
            <div class="form-group">
                <label class="form-label" for="username-input">Username</label>
                <input type="text" id="username-input" name="username" class="form-control"
                       placeholder="e.g. j_miller"
                       value="<?= htmlspecialchars($username) ?>" required autofocus>
            </div>

            <!-- EMAIL -->
            <div class="form-group">
                <label class="form-label" for="email-input">Email address</label>
                <input type="email" id="email-input" name="email" class="form-control"
                       placeholder="name@example.com"
                       value="<?= htmlspecialchars($email) ?>" required>
            </div>

            <!-- PASSWORD -->
            <div class="form-group">
                <label class="form-label" for="password-field">Password</label>
                <div class="password-wrapper">
                    <input type="password" name="password" id="password-field" class="form-control"
                           placeholder="At least 6 characters" required>
                    <button type="button" class="password-toggle" id="togglePassword" aria-label="Toggle password visibility">
                        <i class="lni lni-eye"></i>
                    </button>
                </div>
                <p class="form-text">Minimum 6 characters &bull; alphanumeric recommended</p>
            </div>

            <!-- CONFIRM PASSWORD -->
            <div class="form-group">
                <label class="form-label" for="confirm-field">Confirm Password</label>
                <div class="password-wrapper">
                    <input type="password" name="confirm" id="confirm-field" class="form-control"
                           placeholder="Re-enter password" required>
                    <button type="button" class="password-toggle" id="toggleConfirm" aria-label="Toggle confirm password visibility">
                        <i class="lni lni-eye"></i>
                    </button>
                </div>
            </div>

            <!-- SUBMIT -->
            <button type="submit" class="btn btn-login">
                <i class="lni lni-checkmark"></i> Submit Application
            </button>
        </form>

        <?php endif; ?>

        <div class="login-footer">
            <p>Already an enrolled club member?</p>
            <a href="login.php">
                <i class="lni lni-enter"></i> Sign in with existing credentials
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

<p style="text-align:center"><a href="/public/privacy.php">Privacy &amp; cookies</a></p>
</body>
</html>
