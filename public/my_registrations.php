<?php 
include('header.php'); 
require_once('../classes/Registration.php');
require_once('../classes/User.php');

$e = new Registration();
$a = new User();
$currentUserId = (int)($_SESSION['id'] ?? 0);
$events = $e->getRegistrations($currentUserId);
$regList = $events->fetchAll(PDO::FETCH_ASSOC);
$totalPasses = count($regList);
?>

<link rel="stylesheet" href="../assets/css/register.css">

<section class="section">
    <div class="container-fluid">
        <div class="registrations-page">
            <div class="registrations-header-bar">
                <div>
                    <span class="kicker">Athlete Commitments</span>
                    <h1 class="page-title">My Tournament Registrations</h1>
                    <p class="page-subtitle">Confirmed event entries, scheduled meets, and active tournament passes.</p>
                </div>
                <div>
                    <a href="events.php" class="btn-club btn-club-secondary">
                        <i class="lni lni-plus"></i> Browse More Events
                    </a>
                </div>
            </div>

            <?php if (isset($_GET['cancelled'])): ?>
                <div class="alert-cancellation-success" role="alert">
                    <i class="lni lni-checkmark-circle"></i>
                    <div>
                        <strong>Registration Cancelled</strong>
                        <p class="mb-0 text-muted">Your tournament pass has been withdrawn. You can re-register anytime from the events calendar.</p>
                    </div>
                </div>
            <?php endif; ?>

            <div class="registrations-grid">
                <?php if ($totalPasses === 0): ?>
                    <div class="no-registrations">
                        <i class="lni lni-ticket-alt"></i>
                        <h3>No Active Tournament Passes</h3>
                        <p>You haven't registered for any upcoming club meets or tournaments yet.</p>
                        <a href="events.php" class="browse-events-btn">
                            <i class="lni lni-calendar"></i> Discover &amp; Join Events
                        </a>
                    </div>
                <?php else: ?>
                    <?php foreach ($regList as $ev): ?>
                        <?php
                        $eventId = (int)$ev['event_id'];
                        $regId = (int)$ev['registration_id'];
                        $formattedDate = date('M j, Y', strtotime($ev['date']));
                        $ad = $a->getUser($ev['admin_Id']);
                        $adminName = htmlspecialchars($ad[1] ?? 'Athletics Director');
                        $adminRole = htmlspecialchars($ad[4] ?? 'Admin');
                        $adminPic = get_avatar_url($ad[5] ?? '');
                        $title = htmlspecialchars($ev['title'] ?? '');
                        $desc = htmlspecialchars($ev['description'] ?? '');
                        $loc = htmlspecialchars($ev['location'] ?? 'Campus Facility');
                        ?>
                        <div class="registration-card" data-registration-id="<?= $regId ?>" data-event-id="<?= $eventId ?>">
                            <div class="registration-header">
                                <div class="d-flex justify-content-between align-items-center mb-1">
                                    <div class="d-flex align-items-center gap-2">
                                        <span class="pass-id-tag">#PASS-<?= str_pad((string)$regId, 3, '0', STR_PAD_LEFT) ?></span>
                                        <span class="event-id-chip"><i class="lni lni-tag"></i> #EVT-<?= str_pad((string)$eventId, 2, '0', STR_PAD_LEFT) ?></span>
                                    </div>
                                    <span class="pill tone-olive"><i class="lni lni-checkmark-circle"></i> Confirmed Entry</span>
                                </div>
                                <h3 class="registration-title"><?= $title ?></h3>
                                <span class="registration-date">
                                    <i class="lni lni-calendar"></i> <?= $formattedDate ?>
                                </span>
                            </div>
                            
                            <p class="registration-description"><?= $desc ?></p>
                            
                            <div class="registration-details mb-3">
                                <div class="venue-chip">
                                    <i class="lni lni-map-marker"></i>
                                    <span><?= $loc ?></span>
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
                            
                            <div class="registration-actions">
                                <form action="../actions/cancel_registration.php" method="POST" onsubmit="return confirm('Withdraw your registration for &ldquo;<?= addslashes($title) ?>
<?= csrf_field() ?>&rdquo;?');">
                                    <input type="hidden" name="registration_id" value="<?= $regId ?>">
                                    <button type="submit" class="btn-cancel-reg">
                                        <i class="lni lni-close"></i> Cancel Registration
                                    </button>
                                </form>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>

<?php include('footer.php'); ?>
