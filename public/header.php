<?php 
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}
require_once __DIR__ . '/../auth.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
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
    <title>ClubManager – Collegiate Athletics</title>
    <link rel="icon" type="image/png" href="../assets/favicon.png">

    <!-- Fonts: Outfit (Brand & Headings) + JetBrains Mono (Data & Tabs) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700&family=JetBrains+Mono:wght@400;500;600&display=swap" rel="stylesheet">
    
    <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/css/lineicons.css">
    <link rel="stylesheet" href="../assets/css/club-tokens.css">
    <link rel="stylesheet" href="../assets/css/main.css">
</head>

<body>

<?php include("sidebar.php"); ?>

<main class="main-wrapper">

<header class="header">
    <div class="container-fluid">
        <div class="row align-items-center">
            <div class="col-lg-5 col-md-5 col-6">
                <div class="header-left d-flex align-items-center">
                    <div class="menu-toggle-btn">
                        <button id="menu-toggle" class="main-btn" aria-label="Toggle Navigation Rail">
                            <i class="lni lni-menu"></i>
                            <span class="d-none d-sm-inline">Menu</span>
                        </button>
                    </div>
                    <div class="header-search d-none d-md-flex">
                        <?php if (($_SESSION['role'] ?? '') === 'admin'): ?>
                            <form action="members.php" method="GET">
                                <input type="text" name="q" aria-label="Search members" placeholder="Search members..." />
                                <button type="submit" aria-label="Search"><i class="lni lni-search-alt"></i></button>
                            </form>
                        <?php else: ?>
                            <form action="events.php" method="GET">
                                <input type="text" name="q" aria-label="Search events" placeholder="Search events, meets..." />
                                <button type="submit" aria-label="Search"><i class="lni lni-search-alt"></i></button>
                            </form>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <div class="col-lg-7 col-md-7 col-6">
                <div class="header-right">
                    <!-- Notification Bell -->
                    <div class="notification-box d-none d-md-flex">
                        <button class="dropdown-toggle" type="button" id="notificationDropdown" data-bs-toggle="dropdown" aria-expanded="false" aria-label="Announcements & Alerts">
                            <i class="lni lni-alarm"></i>
                            <span>3</span>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="notificationDropdown">
                            <li>
                                <a href="announcements.php" class="dropdown-item">
                                    <div class="image">
                                        <img src="../assets/images/lead/lead-6.png" alt="" />
                                    </div>
                                    <div class="content">
                                        <h6>New Announcement <span class="text-regular">from Admin</span></h6>
                                        <p>Annual Club Meeting scheduled for next week.</p>
                                        <span class="tabular-num">10 mins ago</span>
                                    </div>
                                </a>
                            </li>
                            <li>
                                <a href="announcements.php" class="dropdown-item">
                                    <div class="image">
                                        <img src="../assets/images/lead/lead-1.png" alt="" />
                                    </div>
                                    <div class="content">
                                        <h6>Event Reminder <span class="text-regular">Track Meet</span></h6>
                                        <p>Track Invitational roster check tomorrow at 9 AM.</p>
                                        <span class="tabular-num">25 mins ago</span>
                                    </div>
                                </a>
                            </li>
                            <li class="dropdown-footer">
                                <a href="announcements.php" class="text-center d-block py-2">
                                    <i class="lni lni-bullhorn me-1"></i> View All Announcements
                                </a>
                            </li>
                        </ul>
                    </div>

                    <!-- Communications / Direct Mail -->
                    <div class="header-message-box d-none d-md-flex">
                        <button class="dropdown-toggle" type="button" id="messageDropdown" data-bs-toggle="dropdown" aria-expanded="false" aria-label="Direct Messages">
                            <i class="lni lni-envelope"></i>
                            <span>2</span>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="messageDropdown">
                            <li>
                                <a href="messages.php" class="dropdown-item">
                                    <div class="image">
                                        <img src="../assets/images/lead/lead-5.png" alt="" />
                                    </div>
                                    <div class="content">
                                        <h6>Michael Brown <span class="pill pill-member ms-1">Athlete</span></h6>
                                        <p>Can you confirm my 400m heat assignment?</p>
                                        <span class="tabular-num">10 mins ago</span>
                                    </div>
                                </a>
                            </li>
                            <li>
                                <a href="messages.php" class="dropdown-item">
                                    <div class="image">
                                        <img src="../assets/images/lead/lead-3.png" alt="" />
                                    </div>
                                    <div class="content">
                                        <h6>Emily Davis <span class="pill pill-admin ms-1">Director</span></h6>
                                        <p>Updated rules sheet published for Spring season.</p>
                                        <span class="tabular-num">45 mins ago</span>
                                    </div>
                                </a>
                            </li>
                            <li class="dropdown-footer">
                                <a href="messages.php" class="text-center d-block py-2">
                                    <i class="lni lni-inbox me-1"></i> Open Communications Desk
                                </a>
                            </li>
                        </ul>
                    </div>

                    <!-- Profile Dropdown -->
                    <div class="profile-box">
                        <button class="dropdown-toggle" type="button" id="profileDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                            <div class="profile-info">
                                <div class="info d-flex align-items-center">
                                    <div class="image">
                                        <?php 
                                        $pp = get_avatar_url($_SESSION['profile_picture'] ?? ''); 
                                        ?>
                                        <img src="<?= $pp ?>" alt="Profile avatar" onerror="this.src='../assets/images/profilee.jpg'" />
                                    </div>
                                    <div class="d-none d-sm-block text-start">
                                        <h6 class="fw-500"><?= htmlspecialchars($_SESSION['username'] ?? 'User'); ?></h6>
                                        <p><?= htmlspecialchars($_SESSION['role'] ?? 'Member'); ?></p>
                                    </div>
                                </div>
                            </div>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="profileDropdown">
                            <li>
                                <div class="author-info">
                                    <div class="image">
                                        <img src="<?= $pp ?>" alt="Profile" onerror="this.src='../assets/images/profilee.jpg'">
                                    </div>
                                    <div class="content">
                                        <h4><?= htmlspecialchars($_SESSION['username'] ?? ''); ?></h4>
                                        <span class="kicker-subtle"><?= strtoupper($_SESSION['role'] ?? 'MEMBER'); ?></span>
                                    </div>
                                </div>
                            </li>
                            <li>
                                <a href="profile.php" class="dropdown-item">
                                    <i class="lni lni-user"></i> My Athletic Dossier
                                </a>
                            </li>
                            <li>
                                <a href="announcements.php" class="dropdown-item">
                                    <i class="lni lni-alarm"></i> Club Announcements
                                </a>
                            </li>
                            <li>
                                <a href="messages.php" class="dropdown-item">
                                    <i class="lni lni-envelope"></i> Communications
                                </a>
                            </li>
                            <li class="divider"></li>
                            <li>
                                <a href="../actions/logout.php" class="dropdown-item text-danger" onclick="this.nextElementSibling.submit(); return false;"> 
                                    <i class="lni lni-exit"></i> Sign Out 
                                </a><form method="post" action="../actions/logout.php" hidden><?= csrf_field() ?></form>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
<?php flash_notice_box(); ?>
