<?php 
require_once __DIR__.'/../auth.php'; 
require_admin(); 
include("header.php");
require_once('../classes/User.php');
require_once('../classes/Event.php');

$ev = new Event();
$events = $ev->listEvent(); 
$ad = new User();
?>

<link rel="stylesheet" href="../assets/css/manage_events.css">

<section class="section">
    <div class="container-fluid">
        <div class="events-container">
            <div class="events-header">
                <div>
                    <span class="kicker">Admin</span>
                    <h2>Manage events</h2>
                    <p>Add, edit and delete the events of the club.</p>
                </div>
                <div>
                    <a href="addEvent.php" class="btn-add-event">
                        <i class="lni lni-plus"></i> Schedule New Event
                    </a>
                </div>
            </div>

            <div class="events-table-container">
                <table class="events-table">
                    <thead>
                        <tr>
                            <th scope="col">Event Title</th>
                            <th scope="col">Schedule Date</th>
                            <th scope="col">Location / Venue</th>
                            <th scope="col">Event Director</th>
                            <th scope="col">Description</th>
                            <th scope="col" style="text-align: right;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($events)): ?>
                            <tr>
                                <td colspan="6" class="text-center py-4 text-muted empty-row">No events currently scheduled.</td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($events as $event): ?>
                                <?php
                                $admin = $ad->getUser($event[5]);
                                $adminName = htmlspecialchars($admin[1] ?? 'Administrator');
                                $formattedDate = date('M j, Y', strtotime($event[3]));
                                $title = htmlspecialchars($event[1] ?? '');
                                $desc = htmlspecialchars($event[2] ?? '');
                                $loc = htmlspecialchars($event[4] ?? 'Campus Facility');
                                $id = htmlspecialchars((string)$event[0]);
                                ?>
                                <tr>
                                    <td data-label="Event"><strong><?= $title ?></strong></td>
                                    <td data-label="Date"><span class="table-date-badge"><i class="lni lni-calendar me-1"></i><?= $formattedDate ?></span></td>
                                    <td data-label="Location"><i class="lni lni-map-marker text-muted me-1"></i><?= $loc ?></td>
                                    <td data-label="Director"><?= $adminName ?></td>
                                    <td class="text-muted event-desc" data-label="Description"><?= $desc ?></td>
                                    <td class="cell-actions">
                                        <div class="table-actions justify-content-end">
                                            <form action="editEvent.php" method="POST" class="d-inline">
<?= csrf_field() ?>
                                                <input type="hidden" value="<?= $id ?>" name="ide">
                                                <button type="submit" class="btn-edit" aria-label="Edit <?= $title ?>">
                                                    <i class="lni lni-pencil"></i> Edit
                                                </button>
                                            </form>
                                            <form action="../actions/delEvent.php" method="POST" class="d-inline" onsubmit="return confirm('Delete this scheduled event?');">
<?= csrf_field() ?>
                                                <input type="hidden" value="<?= $id ?>" name="ide">
                                                <button type="submit" class="btn-delete" aria-label="Delete <?= $title ?>">
                                                    <i class="lni lni-trash-can"></i> Delete
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>

<?php include("footer.php"); ?>
