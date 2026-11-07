<?php 
include("header.php");
require_once('../classes/Event.php');
require_once('../classes/Registration.php');
require_once('../classes/User.php');

$ev = new Event();
$allEvents = $ev->listEvent();
$reg = new Registration();
$ad = new User();

$currentUserId = (int)($_SESSION['id'] ?? 0);
$isAdmin = ($_SESSION['role'] ?? '') === 'admin';
$myRegisteredEventIds = $currentUserId > 0 ? $reg->getRegisteredEventIds($currentUserId) : [];

// Handle search query
$q = trim($_GET['q'] ?? '');
$events = [];
foreach ($allEvents as $item) {
    if ($q !== '') {
        $haystack = strtolower(($item[1] ?? '') . ' ' . ($item[2] ?? '') . ' ' . ($item[4] ?? ''));
        if (strpos($haystack, strtolower($q)) === false) {
            continue;
        }
    }
    $events[] = $item;
}
// Upcoming events soonest first, then past events most recent first.
$today = date('Y-m-d');
$isPastEvent = fn($e) => substr((string) $e[3], 0, 10) < $today;
$events = array_merge(
    array_values(array_filter($events, fn($e) => !$isPastEvent($e))),
    array_reverse(array_values(array_filter($events, $isPastEvent)))
);
$notice = take_flash_code();
?>

<link rel="stylesheet" href="../assets/css/events.css">

<section class="section">
    <div class="container-fluid">
        <div class="events-page">
            <!-- Header bar -->
            <div class="events-header-bar">
                <div>
                    <span class="kicker">Events</span>
                    <h1 class="page-title">Club Events</h1>
                    <p class="page-subtitle">Register for the events of the club.</p>
                </div>
                <div<?= $isAdmin ? ' hidden' : '' ?>>
                    <a href="my_registrations.php" class="view-registrations-btn">
                        <i class="lni lni-ticket"></i> View My Registrations (<?= count($myRegisteredEventIds) ?>)
                    </a>
                </div>
            </div>

            <!-- Registration Success Alert Banner -->
            <?php if ($notice === 'registered'): ?>
                <div class="alert-registration-success" role="alert">
                    <div class="d-flex align-items-center gap-3">
                        <i class="lni lni-checkmark-circle icon-success"></i>
                        <div>
                            <strong>You are registered!</strong>
                            <p class="mb-0">You can see it in My registrations.</p>
                        </div>
                    </div>
                    <a href="my_registrations.php" class="btn-club btn-club-primary btn-club-sm">
                        <i class="lni lni-ticket"></i> My registrations &rarr;
                    </a>
                </div>
            <?php elseif ($notice === 'already_registered'): ?>
                <div class="alert-registration-success" style="border-left-color: var(--accent);" role="alert">
                    <div class="d-flex align-items-center gap-3">
                        <i class="lni lni-information icon-success" style="color: var(--accent);"></i>
                        <div>
                            <strong>Already Registered</strong>
                            <p class="mb-0">You are already registered for this event.</p>
                        </div>
                    </div>
                    <a href="my_registrations.php" class="btn-club btn-club-secondary btn-club-sm">
                        <i class="lni lni-ticket"></i> My registrations &rarr;
                    </a>
                </div>
            <?php endif; ?>

            <?php if ($q !== ''): ?>
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <p class="text-muted mb-0">Showing search results for &ldquo;<strong><?= htmlspecialchars($q) ?></strong>&rdquo; (<?= count($events) ?> matches)</p>
                    <a href="events.php" class="btn-club btn-club-secondary btn-club-sm">Clear Filter</a>
                </div>
            <?php endif; ?>

            <!-- Events Grid -->
            <div class="events-grid">
                <?php if (empty($events)): ?>
                    <div class="club-card text-center py-5 col-12">
                        <i class="lni lni-calendar" style="font-size: 2.5rem; color: var(--subtle);"></i>
                        <h3 class="mt-3">No Upcoming Events Found</h3>
                        <p class="text-muted">There are currently no events matching your filter.</p>
                        <?php if ($q !== ''): ?>
                            <a href="events.php" class="btn-club btn-club-primary mt-2">View All Events</a>
                        <?php endif; ?>
                    </div>
                <?php else: ?>
                    <?php foreach ($events as $event): ?>
                        <?php
                        $eventId = (int)$event[0];
                        $admin = $ad->getUser($event[5]);
                        $formattedDate = date('M j, Y', strtotime($event[3]));
                        $adminPic = get_avatar_url($admin[5] ?? '');
                        $adminName = htmlspecialchars($admin[1] ?? 'Admin');
                        $adminRole = htmlspecialchars($admin[4] ?? 'Admin');
                        $title = htmlspecialchars($event[1] ?? '');
                        $desc = htmlspecialchars($event[2] ?? '');
                        $location = htmlspecialchars($event[4] ?? 'Campus Facility');
                        $isRegistered = in_array($eventId, $myRegisteredEventIds, true);
                        $isPast = $isPastEvent($event);
                        ?>
                        <div<?= $isPast ? ' style="opacity:.7"' : '' ?> class="event-card" data-event-id="<?= $eventId ?>" data-registered="<?= $isRegistered ? '1' : '0' ?>">
                            <div class="event-header">
                                <div class="d-flex justify-content-between align-items-center mb-1">
                                    <span class="event-id-tag">#EVT-<?= str_pad((string)$eventId, 2, '0', STR_PAD_LEFT) ?></span>
                                    <span class="event-date">
                                        <i class="lni lni-calendar"></i> <?= $formattedDate ?><?= $isPast ? ' &middot; Ended' : '' ?>
                                    </span>
                                </div>
                                <h3 class="event-title"><?= $title ?></h3>
                            </div>
                            
                            <p class="event-description"><?= $desc ?></p>
                            
                            <div class="event-details">
                                <div class="event-detail">
                                    <i class="lni lni-map-marker"></i>
                                    <span><?= $location ?></span>
                                </div>
                            </div>
                            
                            <div class="event-admin">
                                <div class="admin-avatar">
                                    <img src="<?= $adminPic ?>" alt="<?= $adminName ?>" onerror="this.src='../assets/images/profilee.jpg'">
                                </div>
                                <div class="admin-info">
                                    <h4><?= $adminName ?></h4>
                                    <p><?= $adminRole ?></p>
                                </div>
                            </div>
                            
                            <div class="event-actions">
                                <?php if ($isRegistered): ?>
                                    <div class="registered-badge-box">
                                        <span class="registration-confirmed-badge">
                                            <i class="lni lni-checkmark-circle"></i> Registered
                                        </span>
                                        <a href="my_registrations.php" class="btn-view-pass" title="View my registrations">
                                            <i class="lni lni-ticket"></i> My registrations
                                        </a>
                                    </div>
                                <?php elseif ($isAdmin): ?>
                                    <span class="text-muted">Admins manage events from Manage Events.</span>
                                <?php elseif ($isPast): ?>
                                    <span class="text-muted"><i class="lni lni-lock"></i> Event ended &middot; registration closed</span>
                                <?php else: ?>
                                    <form action="../actions/register.php" method="POST">
<?= csrf_field() ?>
                                        <input type="hidden" value="<?= $eventId ?>" name="idEvent">
                                        <button type="submit" class="btn-attend">
                                            <i class="lni lni-checkmark-circle"></i> Register for Event
                                        </button>
                                    </form>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>

<?php include("footer.php"); ?>
