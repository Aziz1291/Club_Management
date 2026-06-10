<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>

<aside class="sidebar-nav-wrapper">
    <div class="navbar-logo">
        <a href="index.php">
            <img src="../assets/images/logo/logo.svg" alt="Club Management" />
        </a>
    </div>

    <nav class="sidebar-nav">
        <ul>
            <li class="nav-item">
                <a href="index.php" >
                    <span class="icon"><i class="lni lni-home"></i></span>
                    <span class="text">Dashboard</span>
                </a>
            </li>

            <li class="nav-item">
                <a href="events.php" >
                    <span class="icon"><i class="lni lni-calendar"></i></span>
                    <span class="text">Events</span>
                </a>
            </li>
            <li class="nav-item">
                    <a href="messages.php" class="">
                        <span class="icon"><i class="lni lni-envelope"></i></span>
                        <span class="text">Messages</span>
                    </a>
                </li>

            <?php if ($_SESSION['role'] === "admin"): ?>
                <li class="nav-item">
                <a href="announcements.php">
                    <span class="icon"><i class="lni lni-bullhorn"></i></span>
                    <span class="text">Announcements</span>
                </a>
                </li>
                <li class="nav-item">
                    <a href="members.php" >
                        <span class="icon"><i class="lni lni-users"></i></span>
                        <span class="text">Manage Members</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="manage_events.php" >
                        <span class="icon"><i class="lni lni-folder"></i></span>
                        <span class="text">Manage Events</span>
                    </a>
                </li>

                
            <?php endif; ?>

            <?php if ($_SESSION['role'] === "member"): ?>
                <li class="nav-item">
                    <a href="my_registrations.php" >
                        <span class="icon"><i class="lni lni-checkmark-circle"></i></span>
                        <span class="text">My Registrations</span>
                    </a>
                </li>
            <?php endif; ?>

            <li class="nav-item">
                <a href="profile.php" >
                    <span class="icon"><i class="lni lni-user"></i></span>
                    <span class="text">Profile</span>
                </a>
            </li>

            <li class="nav-item">
                <a href="../actions/logout.php">
                    <span class="icon"><i class="lni lni-exit"></i></span>
                    <span class="text">Logout</span>
                </a>
            </li>
        </ul>
    </nav>
</aside>
<div class="overlay"></div>