<?php
require_once('../auth.php');
auth_start();

// Signing out needs a POST with the session token, so a link on another site cannot sign people out.
if ($_SERVER['REQUEST_METHOD'] === 'POST' && csrf_valid()) {
    session_destroy();
    header('Location: ../public/login.php');
    exit;
}
if (empty($_SESSION['id'])) {
    header('Location: ../public/login.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign out</title>
    <style>
        body { font-family: system-ui, sans-serif; background: #f6f6f4; color: #1f2329; display: grid; place-items: center; min-height: 100vh; margin: 0; }
        main { background: #fff; border: 1px solid #e3e3df; border-radius: 12px; padding: 32px; max-width: 360px; text-align: center; }
        button { font: inherit; padding: 10px 20px; border-radius: 8px; border: 0; background: #1f2329; color: #fff; cursor: pointer; }
        a { color: #555; display: inline-block; margin-top: 14px; }
    </style>
    <link rel="icon" href="../assets/favicon.ico" sizes="any">
    <link rel="icon" type="image/svg+xml" href="../assets/favicon.svg">
    <link rel="icon" type="image/png" sizes="48x48" href="../assets/favicon-48.png">
    <link rel="apple-touch-icon" href="../assets/apple-touch-icon.png">
</head>
<body>
<main>
    <h1 style="font-size:1.3rem; margin-top:0;">Sign out?</h1>
    <form method="post" action="logout.php">
        <?= csrf_field() ?>
        <button type="submit">Sign out</button>
    </form>
    <a href="../public/index.php">Stay signed in</a>
</main>
</body>
</html>
