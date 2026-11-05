<?php
// This file runs before application PHP scripts through Apache configuration.
if (basename($_SERVER['SCRIPT_FILENAME'] ?? '') === 'privacy.php') { return; }
$secure = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') || strtolower($_SERVER['HTTP_X_FORWARDED_PROTO'] ?? '') === 'https';
if (($_SERVER['REQUEST_METHOD'] ?? '') === 'POST' && isset($_POST['club_notice_accept']) && $_POST['club_notice_accept'] === '1') {
    setcookie('club_notice', '1', ['expires' => time() + 180 * 86400, 'path' => '/', 'secure' => $secure, 'httponly' => true, 'samesite' => 'Lax']);
    header('Location: ' . strtok($_SERVER['REQUEST_URI'], '?'), true, 303);
    exit;
}
if (($_COOKIE['club_notice'] ?? '') === '1') { return; }
http_response_code(200);
header('Content-Type: text/html; charset=utf-8');
header('Cache-Control: no-store');
?>
<!doctype html><html lang="en"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1"><meta name="robots" content="noindex, nofollow"><title>Before using ClubManager</title><style>body{margin:0;background:#101b2e;color:#ecf2ff;font:16px/1.6 system-ui,sans-serif;display:grid;min-height:100vh;place-items:center}.card{max-width:36rem;padding:2rem;margin:1rem;background:#1b2a42;border-radius:1rem}a{color:#acd0ff}button,.leave{display:inline-block;padding:.7rem 1rem;border-radius:.5rem;font:inherit;cursor:pointer}button{background:#b6d4ff;border:0;color:#102039;font-weight:700}.leave{color:#fff;margin-left:.5rem}</style></head><body><main class="card"><h1>Before using this demo</h1><p>ClubManager stores account details and activity you submit. It uses a session cookie for sign-in and a cookie to remember that you accepted this notice. The interface also loads fonts from Google.</p><p>Read the <a href="/public/privacy.php">privacy and cookie notice</a> before continuing. Please use sample information when testing.</p><form method="post"><button type="submit" name="club_notice_accept" value="1">I understand and agree to continue</button><a class="leave" href="https://www.azizkouki.com/">Leave demo</a></form></main></body></html>
<?php exit;
