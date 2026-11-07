<?php
include("header.php");
require_once('../classes/User.php');

$us = new User();
$currentUserId = $_SESSION['id'] ?? 0;
$totalMembers = $us->nbUser();
$upcomingEvents = $us->nbUpcomingEvent();
$regsPerEvent = $us->registrationsPerEvent();
$roleCounts = $us->countByRole();
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
                    <span class="kicker">Club</span>
                    <h2 class="mb-1">Dashboard</h2>
                    <p class="text-muted mb-0">Members, upcoming events, your messages and your registrations.</p>
                </div>
                <div class="col-md-5">
                    <div class="breadcrumb-wrapper">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="index.php">ClubManager</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>

        <!-- Summary cards -->
        <div class="row g-4 mb-4">
            <!-- Total Members -->
            <div class="col-xl-3 col-lg-6 col-sm-6">
                <div class="icon-card vitals-members">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <div class="icon">
                            <i class="lni lni-users"></i>
                        </div>
                        <span class="pill tone-sea">Members</span>
                    </div>
                    <div class="content">
                        <h6>Members</h6>
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
                        <span class="pill tone-olive">Events</span>
                    </div>
                    <div class="content">
                        <h6>Upcoming events</h6>
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
                        <span class="pill tone-clay">Messages</span>
                    </div>
                    <div class="content">
                        <h6>Unread messages</h6>
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
                        <span class="pill pill-admin">Registrations</span>
                    </div>
                    <div class="content">
                        <h6>My registrations</h6>
                        <h3 class="tabular-num"><?= htmlspecialchars((string)$eventRegistrations) ?></h3>
                    </div>
                </div>
            </div>
        </div>

        <!-- Charts Grid (real counts from the database) -->
        <div class="row g-4 mb-4">
            <div class="col-lg-8">
                <div class="card-style h-100 mb-0">
                    <div class="mb-3 pb-2 border-bottom">
                        <span class="kicker-subtle">Events</span>
                        <h3 class="mb-0">Registrations per event</h3>
                    </div>
                    <?php if (empty($regsPerEvent)): ?>
                        <p class="text-muted mb-0">No events yet.</p>
                    <?php else: ?>
                        <div class="chart" style="height: 300px;">
                            <canvas id="activityChart"></canvas>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card-style h-100 mb-0">
                    <div class="mb-3 pb-2 border-bottom">
                        <span class="kicker-subtle">Members</span>
                        <h3 class="mb-0">Members by role</h3>
                    </div>
                    <div class="chart d-flex align-items-center justify-content-center" style="height: 300px;">
                        <canvas id="memberChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Latest announcements -->
        <div class="row g-4">
            <div class="col-12">
                <div class="card-style mb-0">
                    <div class="d-flex flex-wrap justify-content-between align-items-center mb-3 pb-2 border-bottom">
                        <div>
                            <span class="kicker">Announcements</span>
                            <h3 class="mb-0">Latest announcements</h3>
                        </div>
                        <a href="announcements.php" class="btn-club btn-club-secondary btn-club-sm">
                            <i class="lni lni-bullhorn"></i> All announcements &rarr;
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
    const regs = <?= json_encode($regsPerEvent, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT) ?>;
    const roles = <?= json_encode($roleCounts, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT) ?>;
    const font = { family: "'Outfit', sans-serif", size: 12 };

    const bar = document.getElementById("activityChart");
    if (bar) {
        new Chart(bar.getContext("2d"), {
            type: "bar",
            data: {
                labels: regs.map(r => r.title),
                datasets: [{ label: "Registrations", data: regs.map(r => Number(r.total)), backgroundColor: "#1d4ed8", borderRadius: 4 }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                scales: {
                    y: { beginAtZero: true, ticks: { precision: 0, font: font } },
                    x: { grid: { display: false }, ticks: { font: font } }
                }
            }
        });
    }

    const names = { admin: "Admins", member: "Members" };
    new Chart(document.getElementById("memberChart").getContext("2d"), {
        type: "doughnut",
        data: {
            labels: Object.keys(roles).map(k => names[k] || k),
            datasets: [{ data: Object.values(roles).map(Number), backgroundColor: ["#1d4ed8", "#5d6b43", "#b4552d"], borderColor: "#ffffff", borderWidth: 2 }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { position: "bottom", labels: { font: font, padding: 16 } } },
            cutout: "62%"
        }
    });
});
</script>

<?php include("footer.php"); ?>
