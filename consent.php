<?php
// This file runs before application PHP scripts through Apache configuration.
if (basename($_SERVER['SCRIPT_FILENAME'] ?? '') === 'privacy.php') { return; }
$secure = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') || strtolower($_SERVER['HTTP_X_FORWARDED_PROTO'] ?? '') === 'https';
if (($_SERVER['REQUEST_METHOD'] ?? '') === 'POST' && isset($_POST['club_notice_accept']) && $_POST['club_notice_accept'] === '1' && ($_POST['privacy_acknowledged'] ?? '') === '1') {
    setcookie('club_notice', '1', ['expires' => time() + 180 * 86400, 'path' => '/', 'secure' => $secure, 'httponly' => true, 'samesite' => 'Lax']);
    header('Location: /public/login.php', true, 303);
    exit;
}
if (($_COOKIE['club_notice'] ?? '') === '1') { return; }
http_response_code(200);
header('Content-Type: text/html; charset=utf-8');
header('Cache-Control: no-store');
?>
<!doctype html><html lang="en"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1"><meta name="description" content="ClubManager is an academic club management demo for members, events and messages.">
    <meta name="robots" content="noindex, nofollow">
    <meta property="og:type" content="website">
    <meta property="og:title" content="ClubManager | Academic project">
    <meta property="og:description" content="Explore an academic club management demo for members, events and messages.">
    <meta property="og:image" content="https://www.azizkouki.com/projects/club/assets/social-preview.png">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="ClubManager | Academic project">
    <meta name="twitter:description" content="An academic club management demo for members, events and messages.">
    <meta name="twitter:image" content="https://www.azizkouki.com/projects/club/assets/social-preview.png"><title>Before using ClubManager</title><style>*{box-sizing:border-box}body{margin:0;min-height:100vh;background:#64748b;color:#17233a;font:16px/1.5 system-ui,sans-serif;display:grid;place-items:center;padding:24px 18px 130px}.card{width:min(100%,480px);background:#fff;border:1px solid #d9e1ec;border-radius:16px;padding:28px;box-shadow:0 16px 48px #17233a33}.eyebrow{color:#526783;font-size:.75rem;font-weight:700;letter-spacing:.1em;text-transform:uppercase}h1{font-size:1.4rem;margin:8px 0}p{color:#47566c}a{color:#2563eb}label{display:flex;align-items:flex-start;gap:10px;margin:22px 0}input{margin-top:.35em;accent-color:#2563eb}button{background:#2563eb;color:white;border:0;border-radius:7px;padding:11px 18px;font:inherit;font-weight:650;cursor:pointer}.leave{margin-left:16px}.cookie-bar{position:fixed;bottom:0;left:0;right:0;background:white;border-top:1px solid #d9e1ec;box-shadow:0 -4px 20px #17233a12;padding:12px 20px;display:flex;gap:16px;align-items:center;justify-content:center}.cookie-bar p{margin:0;font-size:.875rem}.cookie-bar button{background:#eef2f7;color:#243b5c;padding:7px 12px;white-space:nowrap}.cookie-bar[hidden]{display:none}@media(max-width:520px){.cookie-bar{align-items:flex-start}.card{padding:22px}body{padding-bottom:160px}}:focus-visible{outline:3px solid #f1af38;outline-offset:3px}</style></head><body><main class="card" role="dialog" aria-modal="true" aria-labelledby="notice-title"><span class="eyebrow">ClubManager demo</span><h1 id="notice-title">Before you continue</h1><p>This demo stores information you enter. Please use sample data.</p><form method="post"><label><input type="checkbox" name="privacy_acknowledged" value="1" required><span>I have read and agree to the <a href="/public/privacy.php">privacy and cookie notice</a>.</span></label><button type="submit" name="club_notice_accept" value="1">Continue to demo</button><a class="leave" href="https://www.azizkouki.com/">Leave</a></form></main><aside class="cookie-bar" id="cookie-bar" aria-label="Cookie information"><p>Necessary cookies support sign-in and remember this notice. The app loads fonts from Google. <a href="/public/privacy.php">Learn more</a></p><button type="button" onclick="document.getElementById('cookie-bar').hidden=true">Accept necessary cookies</button></aside></body></html>
<?php exit;