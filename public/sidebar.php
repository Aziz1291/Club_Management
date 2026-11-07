<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$currentPage = basename($_SERVER['PHP_SELF'] ?? '');
?>

<aside class="sidebar-nav-wrapper">
    <div class="navbar-logo">
        <a href="index.php">
            <img src="../assets/images/logo/logo.svg" alt="Club Crest" />
            <div class="logo-text">
                <span class="logo-kicker">Collegiate Athletics</span>
                <span>ClubManager</span>
            </div>
        </a>
    </div>

    <nav class="sidebar-nav">
        <ul>
            <li class="nav-category">General Navigation</li>

            <li class="nav-item">
                <a href="index.php" class="<?= $currentPage === 'index.php' ? 'active' : '' ?>">
                    <span class="icon"><i class="lni lni-grid-alt"></i></span>
                    <span class="text">Dashboard</span>
                </a>
            </li>

            <li class="nav-item">
                <a href="events.php" class="<?= in_array($currentPage, ['events.php', 'addEvent.php', 'editEvent.php']) ? 'active' : '' ?>">
                    <span class="icon"><i class="lni lni-calendar"></i></span>
                    <span class="text">Events Calendar</span>
                </a>
            </li>

            <li class="nav-item">
                <a href="messages.php" class="<?= $currentPage === 'messages.php' ? 'active' : '' ?>">
                    <span class="icon"><i class="lni lni-envelope"></i></span>
                    <span class="text">Communications</span>
                </a>
            </li>

            <?php if (($_SESSION['role'] ?? '') === "admin"): ?>
                <li class="nav-category">Athletic Governance</li>

                <li class="nav-item">
                    <a href="announcements.php" class="<?= in_array($currentPage, ['announcements.php', 'addAnn.php', 'editAnn.php']) ? 'active' : '' ?>">
                        <span class="icon"><i class="lni lni-bullhorn"></i></span>
                        <span class="text">Announcements</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="members.php" class="<?= in_array($currentPage, ['members.php', 'addMember.php', 'editMemberProfile.php']) ? 'active' : '' ?>">
                        <span class="icon"><i class="lni lni-users"></i></span>
                        <span class="text">Member Roster</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="manage_events.php" class="<?= $currentPage === 'manage_events.php' ? 'active' : '' ?>">
                        <span class="icon"><i class="lni lni-folder"></i></span>
                        <span class="text">Manage Events</span>
                    </a>
                </li>
            <?php endif; ?>

            <?php if (($_SESSION['role'] ?? '') === "member"): ?>
                <li class="nav-category">Athlete Portal</li>

                <li class="nav-item">
                    <a href="my_registrations.php" class="<?= $currentPage === 'my_registrations.php' ? 'active' : '' ?>">
                        <span class="icon"><i class="lni lni-checkmark-circle"></i></span>
                        <span class="text">My Registrations</span>
                    </a>
                </li>
            <?php endif; ?>

            <li class="nav-category">Account</li>

            <li class="nav-item">
                <a href="profile.php" class="<?= $currentPage === 'profile.php' ? 'active' : '' ?>">
                    <span class="icon"><i class="lni lni-user"></i></span>
                    <span class="text">My Profile</span>
                </a>
            </li>

            <li class="nav-item">
                <a href="../actions/logout.php" onclick="this.nextElementSibling.submit(); return false;">
                    <span class="icon"><i class="lni lni-exit"></i></span>
                    <span class="text">Sign Out</span>
                </a><form method="post" action="../actions/logout.php" hidden><?= csrf_field() ?></form>
            </li>
        </ul>
    </nav>
</aside>
<div class="overlay" id="sidebar-overlay"></div>
