<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Club Management Dashboard</title>

    <link rel="stylesheet" href="../assets/css/bootstrap.min.css" />
    <link rel="stylesheet" href="../assets/css/lineicons.css" />
    <link rel="stylesheet" href="../assets/css/main.css" />
    
    <style>
        .icon-card {
            border-radius: 10px;
            padding: 25px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }
        
        .icon-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        }
        
        .icon-card .icon {
            width: 60px;
            height: 60px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 15px;
        }
        
        .icon-card .icon i {
            font-size: 24px;
            color: white;
        }
        
        .icon-card .icon.purple {
            background-color: #9b51e0;
        }
        
        .icon-card .icon.success {
            background-color: #27ae60;
        }
        
        .icon-card .icon.primary {
            background-color: #2d9cdb;
        }
        
        .icon-card .icon.orange {
            background-color: #f2994a;
        }
        
        .icon-card h6 {
            font-size: 14px;
            color: #8F92A1;
            margin-bottom: 10px;
        }
        
        .icon-card h3 {
            font-size: 24px;
            font-weight: 700;
            margin-bottom: 5px;
        }
        
        .card-style {
            border-radius: 10px;
            padding: 25px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
            background-color: white;
            margin-bottom: 30px;
        }
        
        .header-search form {
            position: relative;
        }
        
        .header-search input {
            border-radius: 20px;
            padding: 8px 15px;
            border: 1px solid #e2e8f0;
            background-color: #f8fafc;
            width: 250px;
        }
        
        .header-search button {
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: #8F92A1;
        }
        
        .notification-box, .header-message-box {
            position: relative;
        }
        
        .notification-box button, .header-message-box button {
            background: none;
            border: none;
            position: relative;
            color: #64748b;
        }
        
        .notification-box span, .header-message-box span {
            position: absolute;
            top: -5px;
            right: -5px;
            background-color: #ef4444;
            color: white;
            border-radius: 50%;
            width: 18px;
            height: 18px;
            font-size: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .profile-box .profile-info .image {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            overflow: hidden;
            margin-right: 10px;
        }
        
        .profile-box .profile-info .image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        
        .profile-box .dropdown-menu {
            border: none;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
            padding: 10px 0;
        }
        
        .profile-box .dropdown-menu .dropdown-item {
            padding: 8px 20px;
            color: #64748b;
        }
        
        .profile-box .dropdown-menu .dropdown-item:hover {
            background-color: #f1f5f9;
            color: #1e293b;
        }
        
        .profile-box .dropdown-menu .divider {
            margin: 10px 0;
            border-top: 1px solid #e2e8f0;
        }
        
        .main-btn {
            border-radius: 6px;
            padding: 8px 20px;
            font-weight: 500;
            transition: all 0.3s ease;
        }
        
        .primary-btn {
            background-color: #3b82f6;
            color: white;
            border: none;
        }
        
        .primary-btn:hover {
            background-color: #2563eb;
            color: white;
        }
        
        .btn-hover:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>

<body>

    <!-- ========== SIDEBAR START ========== -->
    <aside class="sidebar-nav-wrapper">
        <div class="navbar-logo">
            <a href="#">
                <img src="../assets/images/logo/logo.svg" alt="logo" />
            </a>
        </div>

        <nav class="sidebar-nav">
            <ul>

                <!-- ===== DASHBOARD ===== -->
                <li class="nav-item">
                    <a href="index.php" class="active">
                        <span class="icon"><i class="lni lni-home"></i></span>
                        <span class="text">Dashboard</span>
                    </a>
                </li>

                <!-- ===== COMMON SECTIONS (Both Roles) ===== -->
                <li class="nav-item">
                    <a href="events.php">
                        <span class="icon"><i class="lni lni-calendar"></i></span>
                        <span class="text">Events</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="messages.php">
                        <span class="icon"><i class="lni lni-envelope"></i></span>
                        <span class="text">Messages</span>
                    </a>
                </li>
                <!-- ===== ADMIN ONLY ===== -->
                <?php if ($_SESSION['role'] === 'admin'): ?>
                <li class="nav-item">
                    <a href="announcements.php">
                        <span class="icon"><i class="lni lni-bullhorn"></i></span>
                        <span class="text">Announcements</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="members.php">
                        <span class="icon"><i class="lni lni-users"></i></span>
                        <span class="text">Manage Members</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="manage_events.php">
                        <span class="icon"><i class="lni lni-folder"></i></span>
                        <span class="text">Manage Events</span>
                    </a>
                </li>
                <?php endif; ?>

                <!-- ===== MEMBER ONLY ===== -->
                <?php if ($_SESSION['role'] === 'member'): ?>

                <li class="nav-item">
                    <a href="my_registrations.php">
                        <span class="icon"><i class="lni lni-checkmark-circle"></i></span>
                        <span class="text">My Registrations</span>
                    </a>
                </li>
                <?php endif; ?>
                <!-- ===== PROFILE ===== -->
                <li class="nav-item">
                    <a href="profile.php">
                        <span class="icon"><i class="lni lni-user"></i></span>
                        <span class="text">Profile</span>
                    </a>
                </li>
                <!-- ===== LOGOUT ===== -->
                <li class="nav-item">
                    <a href="../actions/logout.php">
                        <span class="icon"><i class="lni lni-exit"></i></span>
                        <span class="text">Logout</span>
                    </a>
                </li>

            </ul>
        </nav>
    </aside>
    <!-- ========== SIDEBAR END ========== -->


    <!-- ========== MAIN CONTENT START ========== -->
    <main class="main-wrapper">

        <!-- HEADER -->
        <header class="header">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-5 col-md-5 col-6">
                        <div class="header-left d-flex align-items-center">
                            <div class="menu-toggle-btn mr-15">
                                <button id="menu-toggle" class="main-btn primary-btn btn-hover">
                                    <i class="lni lni-chevron-left me-2"></i> Menu
                                </button>
                            </div>
                            <div class="header-search d-none d-md-flex">
                                <form action="#">
                                    <input type="text" placeholder="Search..." />
                                    <button><i class="lni lni-search-alt"></i></button>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-7 col-md-7 col-6">
                        <div class="header-right">
                            <!-- notification start -->
                            <div class="notification-box ml-15 d-none d-md-flex">
                                <a href="announcements.php" class="notification-link">
                                    <button class="dropdown-toggle" type="button" id="notification" data-bs-toggle="dropdown"
                                        aria-expanded="false">
                                        <svg width="22" height="22" viewBox="0 0 22 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M11 20.1667C9.88317 20.1667 8.88718 19.63 8.23901 18.7917H13.761C13.113 19.63 12.1169 20.1667 11 20.1667Z"
                                                fill="currentColor" />
                                            <path
                                                d="M10.1157 2.74999C10.1157 2.24374 10.5117 1.83333 11 1.83333C11.4883 1.83333 11.8842 2.24374 11.8842 2.74999V2.82604C14.3932 3.26245 16.3051 5.52474 16.3051 8.24999V14.287C16.3051 14.5301 16.3982 14.7633 16.564 14.9352L18.2029 16.6342C18.4814 16.9229 18.2842 17.4167 17.8903 17.4167H4.10961C3.71574 17.4167 3.5185 16.9229 3.797 16.6342L5.43589 14.9352C5.6017 14.7633 5.69485 14.5301 5.69485 14.287V8.24999C5.69485 5.52474 7.60672 3.26245 10.1157 2.82604V2.74999Z"
                                                fill="currentColor" />
                                        </svg>
                                        <span>3</span>
                                    </button>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="notification">
                                    <li>
                                        <a href="announcements.php" class="dropdown-item">
                                            <div class="image">
                                                <img src="../assets/images/lead/lead-6.png" alt="" />
                                            </div>
                                            <div class="content">
                                                <h6>
                                                    New Announcement
                                                    <span class="text-regular">
                                                        from Admin
                                                    </span>
                                                </h6>
                                                <p>
                                                    Annual Club Meeting scheduled for next week.
                                                </p>
                                                <span>10 mins ago</span>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="announcements.php" class="dropdown-item">
                                            <div class="image">
                                                <img src="../assets/images/lead/lead-1.png" alt="" />
                                            </div>
                                            <div class="content">
                                                <h6>
                                                    Event Reminder
                                                    <span class="text-regular">
                                                        Workshop tomorrow
                                                    </span>
                                                </h6>
                                                <p>
                                                    Don't forget about the photography workshop.
                                                </p>
                                                <span>25 mins ago</span>
                                            </div>
                                        </a>
                                    </li>
                                    <li class="dropdown-footer">
                                        <a href="announcements.php" class="text-center d-block py-2 text-primary">
                                            <i class="lni lni-bullhorn me-1"></i> View All Announcements
                                        </a>
                                    </li>
                                </ul>
                            </div>

                            <div class="header-message-box ml-15 d-none d-md-flex">
                                <?php if ($_SESSION['role'] === 'admin'): ?>
                                    <a href="messages.php" class="message-link">
                                <?php else: ?>
                                    <a href="messages.php" class="message-link">
                                <?php endif; ?>
                                    <button class="dropdown-toggle" type="button" id="message" data-bs-toggle="dropdown"
                                        aria-expanded="false">
                                        <svg width="22" height="22" viewBox="0 0 22 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M7.74866 5.97421C7.91444 5.96367 8.08162 5.95833 8.25005 5.95833C12.5532 5.95833 16.0417 9.4468 16.0417 13.75C16.0417 13.9184 16.0364 14.0856 16.0259 14.2514C16.3246 14.138 16.6127 14.003 16.8883 13.8482L19.2306 14.629C19.7858 14.8141 20.3141 14.2858 20.129 13.7306L19.3482 11.3882C19.8694 10.4604 20.1667 9.38996 20.1667 8.25C20.1667 4.70617 17.2939 1.83333 13.75 1.83333C11.0077 1.83333 8.66702 3.55376 7.74866 5.97421Z"
                                                fill="currentColor" />
                                            <path
                                                d="M14.6667 13.75C14.6667 17.2938 11.7939 20.1667 8.25004 20.1667C7.11011 20.1667 6.03962 19.8694 5.11182 19.3482L2.76946 20.129C2.21421 20.3141 1.68597 19.7858 1.87105 19.2306L2.65184 16.8882C2.13062 15.9604 1.83338 14.89 1.83338 13.75C1.83338 10.2062 4.70622 7.33333 8.25004 7.33333C11.7939 7.33333 14.6667 10.2062 14.6667 13.75ZM5.95838 13.75C5.95838 13.2437 5.54797 12.8333 5.04171 12.8333C4.53545 12.8333 4.12504 13.2437 4.12504 13.75C4.12504 14.2563 4.53545 14.6667 5.04171 14.6667C5.54797 14.6667 5.95838 14.2563 5.95838 13.75ZM9.16671 13.75C9.16671 13.2437 8.7563 12.8333 8.25004 12.8333C7.74379 12.8333 7.33338 13.2437 7.33338 13.75C7.33338 14.2563 7.74379 14.6667 8.25004 14.6667C8.7563 14.6667 9.16671 14.2563 9.16671 13.75ZM11.4584 14.6667C11.9647 14.6667 12.375 14.2563 12.375 13.75C12.375 13.2437 11.9647 12.8333 11.4584 12.8333C10.9521 12.8333 10.5417 13.2437 10.5417 13.75C10.5417 14.2563 10.9521 14.6667 11.4584 14.6667Z"
                                                fill="currentColor" />
                                        </svg>
                                        <span>2</span>
                                    </button>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="message">
                                    <li>
                                        <a href="<?= $_SESSION['role'] === 'admin' ? 'messages.php' : 'messages.php' ?>" class="dropdown-item">
                                            <div class="image">
                                                <img src="../assets/images/lead/lead-5.png" alt="" />
                                            </div>
                                            <div class="content">
                                                <h6>Michael Brown</h6>
                                                <p>Can you provide more details about the workshop?</p>
                                                <span>10 mins ago</span>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="<?= $_SESSION['role'] === 'admin' ? 'messages.php' : 'messages.php' ?>" class="dropdown-item">
                                            <div class="image">
                                                <img src="../assets/images/lead/lead-3.png" alt="" />
                                            </div>
                                            <div class="content">
                                                <h6>Emily Davis</h6>
                                                <p>I have a suggestion for the next club event</p>
                                                <span>45 mins ago</span>
                                            </div>
                                        </a>
                                    </li>
                                    <li class="dropdown-footer">
                                        <?php if ($_SESSION['role'] === 'admin'): ?>
                                            <a href="messages.php" class="text-center d-block py-2 text-primary">
                                                <i class="lni lni-envelope me-1"></i> View All Messages
                                            </a>
                                        <?php else: ?>
                                            <a href="messages.php" class="text-center d-block py-2 text-primary">
                                                <i class="lni lni-envelope me-1"></i> Contact Admin
                                            </a>
                                        <?php endif; ?>
                                    </li>
                                </ul>
                            </div>
                            <!-- message end -->
                            
                           <!-- profile start -->
<div class="profile-box ml-15">
    <button class="dropdown-toggle bg-transparent border-0" type="button" id="profile"
        data-bs-toggle="dropdown" aria-expanded="false">
        <div class="profile-info">
            <div class="info d-flex align-items-center">
                <div class="image">
                    <?php $pp_idx = !empty($_SESSION['profile_picture']) ? htmlspecialchars($_SESSION['profile_picture']) : '../assets/images/profilee.jpg'; ?>
                    <img src="<?= $pp_idx ?>" alt="profile" />
                </div>
                <div>
                    <h6 class="fw-500"><?= htmlspecialchars($_SESSION['username']); ?></h6>
                    <p><?= ucfirst($_SESSION['role']); ?></p>
                </div>
            </div>
        </div>
    </button>
    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="profile">
        <li>
            <div class="author-info flex items-center !p-1">
                <div class="image">
                    <img src="<?= $pp_idx ?>" alt="image">
                </div>
                <div class="content">
                    <h4 class="text-sm"><?= htmlspecialchars($_SESSION['username']); ?></h4>
                    <a class="text-black/40 dark:text-white/40 hover:text-black dark:hover:text-white text-xs" href="#">
                        <?= $_SESSION['email'] ?? 'user@example.com' ?>
                    </a>
                </div>
            </div>
        </li>
        <li class="divider"></li>
        <li>
            <a href="profile.php" class="dropdown-item">
                <i class="lni lni-user"></i> View Profile
            </a>
        </li>
        <li>
            <a href="announcements.php" class="dropdown-item">
                <i class="lni lni-alarm"></i> Notifications
            </a>
        </li>
        <li>
            <?php if ($_SESSION['role'] === 'admin'): ?>
                <a href="messages.php" class="dropdown-item">
            <?php else: ?>
                <a href="messages.php" class="dropdown-item">
            <?php endif; ?>
                <i class="lni lni-inbox"></i> Messages
            </a>
        </li>
        <li>
            <a href="#0" class="dropdown-item"> 
                <i class="lni lni-cog"></i> Settings 
            </a>
        </li>
        <li class="divider"></li>
        <li>
            <a href="../actions/logout.php" class="dropdown-item"> 
                <i class="lni lni-exit"></i> Sign Out 
            </a>
        </li>
    </ul>
</div>
<!-- profile end -->
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <!-- MAIN DASHBOARD SECTION -->
        <section class="section">
            <div class="container-fluid">
                <!-- ========== title-wrapper start ========== -->
                <div class="title-wrapper pt-30">
                    <div class="row align-items-center">
                        <div class="col-md-6">
                            <div class="title">
                                <h2>Club Management Dashboard</h2>
                            </div>
                        </div>
                        <!-- end col -->
                        <div class="col-md-6">
                            <div class="breadcrumb-wrapper">
                                <nav aria-label="breadcrumb">
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item">
                                            <a href="#0">Dashboard</a>
                                        </li>
                                        <li class="breadcrumb-item active" aria-current="page">
                                            Overview
                                        </li>
                                    </ol>
                                </nav>
                            </div>
                        </div>
                        <!-- end col -->
                    </div>
                    <!-- end row -->
                </div>
                <!-- ========== title-wrapper end ========== -->
                
                <div class="row">
                    <div class="col-xl-3 col-lg-4 col-sm-6">
                        <div class="icon-card mb-30">
                            <div class="icon purple">
                                <i class="lni lni-users"></i>
                            </div>
                            <div class="content">
                                <h6 class="mb-10">Total Members</h6>
                                <h3 class="text-bold mb-10"><?php require_once('../classes/User.php');$us=new User();$nb=$us->nbUser();echo($nb)?></h3>
                                
                            </div>
                        </div>
                        <!-- End Icon Cart -->
                    </div>
                    <!-- End Col -->
                    <div class="col-xl-3 col-lg-4 col-sm-6">
                        <div class="icon-card mb-30">
                            <div class="icon success">
                                <i class="lni lni-calendar"></i>
                            </div>
                            <div class="content">
                                <h6 class="mb-10">Upcoming Events</h6>
                                <h3 class="text-bold mb-10"><?php require_once('../classes/User.php');$us=new User();$nb=$us->nbEvent();echo($nb)?></h3>
                                
                            </div>
                        </div>
                        <!-- End Icon Cart -->
                    </div>
                    <!-- End Col -->
                    <div class="col-xl-3 col-lg-4 col-sm-6">
                        <div class="icon-card mb-30">
                            <div class="icon primary">
                                <i class="lni lni-envelope"></i>
                            </div>
                            <div class="content">
                                <h6 class="mb-10">Unread Messages</h6>
                                <h3 class="text-bold mb-10"><?php require_once('../classes/User.php');$us=new User();$nb=$us->nbMsg($_SESSION['id']);echo($nb)?></h3>
                                
                            </div>
                        </div>
                        <!-- End Icon Cart -->
                    </div>
                    <!-- End Col -->
                    <div class="col-xl-3 col-lg-4 col-sm-6">
                        <div class="icon-card mb-30">
                            <div class="icon orange">
                                <i class="lni lni-checkmark-circle"></i>
                            </div>
                            <div class="content">
                                <h6 class="mb-10">Event Registrations</h6>
                                <h3 class="text-bold mb-10"><?php require_once('../classes/User.php');$us=new User();$nb=$us->nbReg($_SESSION['id']);echo($nb)?></h3>
                                
                            </div>
                        </div>
                        <!-- End Icon Cart -->
                    </div>
                    <!-- End Col -->
                </div>
                <!-- End Row -->

                <div class="row">
                    <div class="col-lg-8">
                        <div class="card-style mb-30">
                            <div class="title d-flex flex-wrap justify-content-between">
                                <div class="left">
                                    <h6 class="text-medium mb-10">Club Activity Overview</h6>
                                    <h3 class="text-bold">Monthly Performance</h3>
                                </div>
                                <div class="right">
                                    <div class="select-style-1">
                                        <div class="select-position select-sm">
                                            <select class="light-bg">
                                                <option value="">Monthly</option>
                                                <option value="">Weekly</option>
                                                <option value="">Yearly</option>
                                            </select>
                                        </div>
                                    </div>
                                    <!-- end select -->
                                </div>
                            </div>
                            <!-- End Title -->
                            <div class="chart">
                                <canvas id="activityChart" style="width: 100%; height: 400px;"></canvas>
                            </div>
                            <!-- End Chart -->
                        </div>
                    </div>
                    <!-- End Col -->
                    <div class="col-lg-4">
                        <div class="card-style mb-30">
                            <div class="title d-flex flex-wrap align-items-center justify-content-between">
                                <div class="left">
                                    <h6 class="text-medium mb-30">Member Distribution</h6>
                                </div>
                            </div>
                            <!-- End Title -->
                            <div class="chart">
                                <canvas id="memberChart" style="width: 100%; height: 400px;"></canvas>
                            </div>
                            <!-- End Chart -->
                        </div>
                    </div>
                    <!-- End Col -->
                </div>
                <!-- End Row -->

                <!-- Recent Activities Section Removed -->

            </div>
            <!-- end container -->
        </section>
            <?php include('ann-div.php')?>
        <!-- FOOTER -->
        <footer class="footer">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-6 order-last order-md-first">
                        <div class="copyright text-center text-md-start">
                            <p class="text-sm">
                                Club Management System © 2025
                            </p>
                        </div>
                    </div>
                    <!-- end col-->
                    <div class="col-md-6">
                        <div class="terms d-flex justify-content-center justify-content-md-end">
                            <a href="#0" class="text-sm">Term & Conditions</a>
                            <a href="#0" class="text-sm ml-15">Privacy & Policy</a>
                        </div>
                    </div>
                </div>
                <!-- end row -->
            </div>
            <!-- end container -->
        </footer>
    </main>
    <!-- ========== MAIN CONTENT END ========== -->

    <!-- JS -->
    <script src="../assets/js/bootstrap.bundle.min.js"></script>
    <script src="../assets/js/Chart.min.js"></script>
    <script src="../assets/js/main.js"></script>

    <script>
        // =========== activity chart start
        const ctx1 = document.getElementById("activityChart").getContext("2d");
        const activityChart = new Chart(ctx1, {
            type: "line",
            data: {
                labels: [
                    "Jan", "Feb", "Mar", "Apr", "May", "Jun", 
                    "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"
                ],
                datasets: [
                    {
                        label: "Event Registrations",
                        backgroundColor: "transparent",
                        borderColor: "#365CF5",
                        data: [30, 45, 35, 50, 49, 60, 70, 91, 125, 100, 95, 120],
                        pointBackgroundColor: "transparent",
                        pointHoverBackgroundColor: "#365CF5",
                        pointBorderColor: "transparent",
                        pointHoverBorderColor: "#fff",
                        pointHoverBorderWidth: 5,
                        borderWidth: 5,
                        pointRadius: 8,
                        pointHoverRadius: 8,
                    },
                    {
                        label: "New Members",
                        backgroundColor: "transparent",
                        borderColor: "#9b51e0",
                        data: [10, 15, 8, 12, 20, 18, 25, 30, 22, 28, 25, 35],
                        pointBackgroundColor: "transparent",
                        pointHoverBackgroundColor: "#9b51e0",
                        pointBorderColor: "transparent",
                        pointHoverBorderColor: "#fff",
                        pointHoverBorderWidth: 5,
                        borderWidth: 5,
                        pointRadius: 8,
                        pointHoverRadius: 8,
                    }
                ],
            },
            options: {
                plugins: {
                    tooltip: {
                        callbacks: {
                            labelColor: function (context) {
                                return {
                                    backgroundColor: "#ffffff",
                                    color: "#171717"
                                };
                            },
                        },
                        intersect: false,
                        backgroundColor: "#f9f9f9",
                        title: {
                            fontFamily: "Plus Jakarta Sans",
                            color: "#8F92A1",
                            fontSize: 12,
                        },
                        body: {
                            fontFamily: "Plus Jakarta Sans",
                            color: "#171717",
                            fontStyle: "bold",
                            fontSize: 16,
                        },
                        multiKeyBackground: "transparent",
                        displayColors: false,
                        padding: {
                            x: 30,
                            y: 10,
                        },
                        bodyAlign: "center",
                        titleAlign: "center",
                        titleColor: "#8F92A1",
                        bodyColor: "#171717",
                        bodyFont: {
                            family: "Plus Jakarta Sans",
                            size: "16",
                            weight: "bold",
                        },
                    },
                    legend: {
                        display: true,
                        position: 'top',
                    },
                },
                responsive: true,
                maintainAspectRatio: false,
                title: {
                    display: false,
                },
                scales: {
                    y: {
                        grid: {
                            display: false,
                            drawTicks: false,
                            drawBorder: false,
                        },
                        ticks: {
                            padding: 35,
                            max: 140,
                            min: 0,
                        },
                    },
                    x: {
                        grid: {
                            drawBorder: false,
                            color: "rgba(143, 146, 161, .1)",
                            zeroLineColor: "rgba(143, 146, 161, .1)",
                        },
                        ticks: {
                            padding: 20,
                        },
                    },
                },
            },
        });

        // =========== member chart start
        const ctx2 = document.getElementById("memberChart").getContext("2d");
        const memberChart = new Chart(ctx2, {
            type: "doughnut",
            data: {
                labels: ["Active", "Inactive", "New"],
                datasets: [{
                    data: [65, 15, 20],
                    backgroundColor: [
                        "#365CF5",
                        "#9b51e0",
                        "#f2994a"
                    ],
                    borderWidth: 0,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                    },
                },
            },
        });
    </script>

</body>
</html>