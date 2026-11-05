<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include_once('../classes/User.php');

$error = '';
$username = '';
$password = '';
$role = 'member';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = trim($_POST['password'] ?? '');
    $role     = $_POST['role'] ?? 'member';

    $user = new User();
    $result = $user->login($username, $password, $role);

    if ($result === "success") {
        header("Location: index.php");
        exit;
    } elseif ($result === "wrong_password") {
        $error = "Incorrect password. Please verify credentials.";
    } elseif ($result === "no_user") {
        $error = "No " . ($role === 'admin' ? 'administrator' : 'member') . " account found with that username.";
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
    <title>Sign In – ClubManager</title>
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
            <span class="kicker">Collegiate Athletics</span>
            <h3>Portal Sign In</h3>
            <p class="login-subtitle">Access your roster, events, and communications</p>
        </div>

        <?php if ($error): ?>
            <div class="alert alert-danger" role="alert">
                <i class="lni lni-warning"></i>
                <span><?= htmlspecialchars($error) ?></span>
            </div>
        <?php endif; ?>

        <form method="POST">
            <!-- USERNAME -->
            <div class="form-group">
                <label class="form-label" for="username-field">Username</label>
                <input type="text" id="username-field" name="username" class="form-control" placeholder="Enter your username" value="<?= htmlspecialchars($username) ?>" required autofocus>
            </div>

            <!-- PASSWORD -->
            <div class="form-group">
                <label class="form-label" for="password-field">Password</label>
                <div class="password-wrapper">
                    <input type="password" name="password" id="password-field" class="form-control" placeholder="Enter your password" required>
                    <button type="button" class="password-toggle" id="togglePassword" aria-label="Toggle password visibility">
                        <i class="lni lni-eye"></i>
                    </button>
                </div>
            </div>

            <!-- ROLE -->
            <div class="form-group">
                <label class="form-label" for="role-select">Collegiate Role</label>
                <div class="select-style-1">
                    <select name="role" id="role-select" class="form-control" required>
                        <option value="member" <?= $role === 'member' ? 'selected' : '' ?>>Varsity Member / Athlete</option>
                        <option value="admin" <?= $role === 'admin' ? 'selected' : '' ?>>Athletic Director (Admin)</option>
                    </select>
                </div>
            </div>

            <!-- LOGIN BUTTON -->
            <button type="submit" class="btn btn-login">
                <i class="lni lni-enter"></i> Sign In to Portal
            </button>

            <!-- DEMO CREDENTIALS -->
            <div class="demo-accounts">
                <div class="demo-accounts__header">
                    <span class="demo-accounts__kicker">Quick Demo Accounts</span>
                    <span style="font-size:0.75rem; color:var(--muted);">Click to fill</span>
                </div>
                <div class="demo-accounts__grid">
                    <div class="demo-account-pill">
                        <div class="demo-account-pill__info">
                            <span class="demo-account-pill__role role-admin"><i class="lni lni-shield"></i> Athletic Director</span>
                            <span class="demo-account-pill__name">Admin Officer (<code>admin</code>)</span>
                        </div>
                        <button type="button" class="demo-account-pill__btn" onclick="fillClubDemo('admin', 'admin123', 'admin')">Use</button>
                    </div>
                    <div class="demo-account-pill">
                        <div class="demo-account-pill__info">
                            <span class="demo-account-pill__role role-member"><i class="lni lni-user"></i> Varsity Athlete</span>
                            <span class="demo-account-pill__name">Karim Athlete (<code>member1</code>)</span>
                        </div>
                        <button type="button" class="demo-account-pill__btn" onclick="fillClubDemo('member1', 'member123', 'member')">Use</button>
                    </div>
                </div>
            </div>
        </form>

        <div class="login-footer">
            <p>Not registered with the athletic club yet?</p>
            <a href="join_request.php">
                <i class="lni lni-user"></i> Submit Membership Application
            </a>
        </div>
    </div>
</div>

<script src="../assets/js/bootstrap.bundle.min.js"></script>

<script>
    const passwordField = document.getElementById("password-field");
    const togglePassword = document.getElementById("togglePassword");
    const toggleIcon = togglePassword.querySelector('i');

    togglePassword.addEventListener("click", function() {
        const type = passwordField.getAttribute("type") === "password" ? "text" : "password";
        passwordField.setAttribute("type", type);
        
        if (type === "password") {
            toggleIcon.classList.remove("lni-eye-off");
            toggleIcon.classList.add("lni-eye");
        } else {
            toggleIcon.classList.remove("lni-eye");
            toggleIcon.classList.add("lni-eye-off");
        }
        passwordField.focus();
    });

    function fillClubDemo(username, password, role) {
        const uField = document.getElementById("username-field");
        const pField = document.getElementById("password-field");
        const rSelect = document.getElementById("role-select");
        if (uField && pField) {
            uField.value = username;
            pField.value = password;
            if (rSelect) rSelect.value = role;
            uField.dispatchEvent(new Event('input', { bubbles: true }));
            pField.dispatchEvent(new Event('input', { bubbles: true }));
            pField.focus();
        }
    }
</script>

<p style="text-align:center"><a href="/public/privacy.php">Privacy &amp; cookies</a></p>
</body>
</html>
