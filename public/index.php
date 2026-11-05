<?php
include("header.php");
require_once('../classes/User.php');

$us = new User();
$currentUserId = $_SESSION['id'] ?? 0;
$totalMembers = $us->nbUser();
$upcomingEvents = $us->nbEvent();
$unreadMessages = $us->nbMsg($currentUserId);
$eventRegistrations = $us->nbReg($currentUserId);
?>

<link rel="stylesheet" href="../assets/css/announcements.css">

<section class="section">
    <div class="container-fluid">
        <!-- Title & Breadcrumb -->
        <div class="title-wrapper">
            <div class="row align-items-center">
                <div class="col-md-7">
                    <span class="kicker">Season Performance &bull; Division League</span>
                    <h2 class="mb-1">Athletic Club Executive Dashboard</h2>
                    <p class="text-muted mb-0">Live roster vitals, tournament registrations, and official dispatches.</p>
                </div>
                <div class="col-md-5">
                    <div class="breadcrumb-wrapper">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="index.php">ClubManager</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Executive Overview</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>

        <!-- Athletic Vitals Ribbon -->
        <div class="row g-4 mb-4">
            <!-- Total Members -->
            <div class="col-xl-3 col-lg-6 col-sm-6">
                <div class="icon-card vitals-members">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <div class="icon">
                            <i class="lni lni-users"></i>
                        </div>
                        <span class="pill tone-sea">Roster Vitals</span>
                    </div>
                    <div class="content">
                        <h6>Total Active Members</h6>
                        <h3 class="tabular-num"><?= htmlspecialchars((string)$totalMembers) ?></h3>
                    </div>
                </div>
            </div>

            <!-- Upcoming Events -->
            <div class="col-xl-3 col-lg-6 col-sm-6">
                <div class="icon-card vitals-events">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <div class="icon">
                            <i class="lni lni-calendar"></i>
                        </div>
                        <span class="pill tone-olive">Schedule</span>
                    </div>
                    <div class="content">
                        <h6>Upcoming Meets &amp; Events</h6>
                        <h3 class="tabular-num"><?= htmlspecialchars((string)$upcomingEvents) ?></h3>
                    </div>
                </div>
            </div>

            <!-- Unread Messages -->
            <div class="col-xl-3 col-lg-6 col-sm-6">
                <div class="icon-card vitals-messages">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <div class="icon">
                            <i class="lni lni-envelope"></i>
                        </div>
                        <span class="pill tone-clay">Inbox</span>
                    </div>
                    <div class="content">
                        <h6>Unread Dispatches</h6>
                        <h3 class="tabular-num"><?= htmlspecialchars((string)$unreadMessages) ?></h3>
                    </div>
                </div>
            </div>

            <!-- Event Registrations -->
            <div class="col-xl-3 col-lg-6 col-sm-6">
                <div class="icon-card vitals-passes">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <div class="icon">
                            <i class="lni lni-checkmark-circle"></i>
                        </div>
                        <span class="pill pill-admin">Active Passes</span>
                    </div>
                    <div class="content">
                        <h6>My Tournament Registrations</h6>
                        <h3 class="tabular-num"><?= htmlspecialchars((string)$eventRegistrations) ?></h3>
                    </div>
                </div>
            </div>
        </div>

        <!-- Charts Grid -->
        <div class="row g-4 mb-4">
            <div class="col-lg-8">
                <div class="card-style h-100 mb-0">
                    <div class="d-flex flex-wrap justify-content-between align-items-center mb-3 pb-2 border-bottom">
                        <div>
                            <span class="kicker-subtle">Participation Velocity</span>
                            <h3 class="mb-0">Registration &amp; Roster Growth</h3>
                        </div>
                        <div class="select-style-1">
                            <select aria-label="Chart Period Filter">
                                <option value="monthly">2026 Season (Monthly)</option>
                                <option value="quarterly">Quarterly Breakdown</option>
                            </select>
                        </div>
                    </div>
                    <div class="chart" style="height: 340px;">
                        <canvas id="activityChart"></canvas>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card-style h-100 mb-0">
                    <div class="d-flex justify-content-between align-items-center mb-3 pb-2 border-bottom">
                        <div>
                            <span class="kicker-subtle">Demographics</span>
                            <h3 class="mb-0">Roster Status</h3>
                        </div>
                    </div>
                    <div class="chart d-flex align-items-center justify-content-center" style="height: 340px;">
                        <canvas id="memberChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Official Bulletins Stream -->
        <div class="row g-4">
            <div class="col-12">
                <div class="card-style mb-0">
                    <div class="d-flex flex-wrap justify-content-between align-items-center mb-3 pb-2 border-bottom">
                        <div>
                            <span class="kicker">Official Announcements</span>
                            <h3 class="mb-0">Club Administration Bulletins</h3>
                        </div>
                        <a href="announcements.php" class="btn-club btn-club-secondary btn-club-sm">
                            <i class="lni lni-bullhorn"></i> View All Bulletins &rarr;
                        </a>
                    </div>
                    <?php include('ann-div.php'); ?>
                </div>
            </div>
        </div>

    </div>
</section>

<!-- Chart.js Vendor Script -->
<script src="../assets/js/Chart.min.js"></script>

<script>
document.addEventListener("DOMContentLoaded", function () {
    // 1. Club Activity & Growth (Line Chart)
    const ctx1 = document.getElementById("activityChart").getContext("2d");
    new Chart(ctx1, {
        type: "line",
        data: {
            labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
            datasets: [
                {
                    label: "Event Registrations",
                    backgroundColor: "transparent",
                    borderColor: "#1d4ed8", // Royal Ultramarine
                    pointBackgroundColor: "#1d4ed8",
                    pointHoverBackgroundColor: "#1e3a8a",
                    borderWidth: 3,
                    pointRadius: 4,
                    pointHoverRadius: 6,
                    tension: 0.25,
                    data: [28, 42, 35, 52, 48, 64, 72, 88, 120, 95, 90, 115]
                },
                {
                    label: "New Athlete Recruits",
                    backgroundColor: "transparent",
                    borderColor: "#5d6b43", // Turf Olive
                    pointBackgroundColor: "#5d6b43",
                    pointHoverBackgroundColor: "#465133",
                    borderWidth: 2,
                    borderDash: [5, 5],
                    pointRadius: 4,
                    pointHoverRadius: 6,
                    tension: 0.25,
                    data: [12, 16, 9, 14, 22, 19, 26, 31, 24, 29, 26, 36]
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'top',
                    labels: {
                        font: { family: "'Outfit', sans-serif", size: 12, weight: '600' },
                        color: "#1c1917"
                    }
                },
                tooltip: {
                    backgroundColor: "#ffffff",
                    titleColor: "#1c1917",
                    bodyColor: "#57534e",
                    borderColor: "#e2e2df",
                    borderWidth: 1,
                    padding: 12,
                    boxPadding: 6,
                    usePointStyle: true,
                    titleFont: { family: "'Outfit', sans-serif", weight: '700' },
                    bodyFont: { family: "'JetBrains Mono', monospace", size: 13 }
                }
            },
            scales: {
                y: {
                    grid: { color: "rgba(226, 226, 223, 0.6)" },
                    ticks: {
                        color: "#57534e",
                        font: { family: "'JetBrains Mono', monospace", size: 11 }
                    }
                },
                x: {
                    grid: { display: false },
                    ticks: {
                        color: "#57534e",
                        font: { family: "'Outfit', sans-serif", size: 12 }
                    }
                }
            }
        }
    });

    // 2. Member Demographics (Doughnut Chart)
    const ctx2 = document.getElementById("memberChart").getContext("2d");
    new Chart(ctx2, {
        type: "doughnut",
        data: {
            labels: ["Active Varsity", "In Review", "Alumni / Reserve"],
            datasets: [{
                data: [68, 18, 14],
                backgroundColor: [
                    "#1d4ed8", // Ultramarine
                    "#d7dcbd", // Olive
                    "#eccdb4"  // Clay
                ],
                borderColor: "#ffffff",
                borderWidth: 2
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: "bottom",
                    labels: {
                        font: { family: "'Outfit', sans-serif", size: 12, weight: '500' },
                        color: "#1c1917",
                        padding: 16
                    }
                }
            },
            cutout: "68%"
        }
    });
});
</script>

<?php include("footer.php"); ?>
