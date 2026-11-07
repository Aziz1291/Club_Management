<?php 
require_once __DIR__.'/../auth.php'; 
require_admin(); 
include("header.php");
require_once('../classes/Admin.php');

$ad = new Admin();
$admins = $ad->listAdmin();
?>

<link rel="stylesheet" href="../assets/css/addEvent.css">

<section class="section">
    <div class="container-fluid">
        <div class="event-form-container">
            <div class="form-card">
                <span class="kicker">Admin</span>
                <h2 class="form-title">New event</h2>
                
                <?php form_error_box(); ?>
                <form class="event-form" id="addEventForm" method="POST" action="../actions/addEvent.php">
<?= csrf_field() ?>
                    <div class="form-group">
                        <label for="eventTitle" class="form-label">Event title</label>
                        <input type="text" id="eventTitle" name="title" class="form-control" placeholder="e.g. Spring training day" maxlength="150" value="<?= htmlspecialchars(form_old('title')) ?>" required autofocus>
                    </div>

                    <div class="form-group">
                        <label for="eventDescription" class="form-label">Description</label>
                        <textarea id="eventDescription" name="description" class="form-control" rows="4" placeholder="What is the event about? Who can join?" maxlength="2000" required><?= htmlspecialchars(form_old('description')) ?></textarea>
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <div class="form-group mb-0">
                                <label for="eventDate" class="form-label">Event Date</label>
                                <input type="date" id="eventDate" name="date" class="form-control" min="<?= date('Y-m-d') ?>" value="<?= htmlspecialchars(form_old('date')) ?>" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mb-0">
                                <label for="eventLocation" class="form-label">Location</label>
                                <input type="text" id="eventLocation" name="location" class="form-control" placeholder="e.g. Main hall" maxlength="150" value="<?= htmlspecialchars(form_old('location')) ?>" required>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="eventAdmin" class="form-label">Organizer</label>
                        <select id="eventAdmin" name="admin_id" class="form-control" required>
                            <option value="">Select an admin...</option>
                            <?php foreach ($admins as $admin): ?>
                                <option value="<?= htmlspecialchars((string)$admin[0]) ?>"<?= form_old('admin_id') === (string)$admin[0] ? ' selected' : '' ?>>
                                    <?= htmlspecialchars($admin[1]) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="form-actions">
                        <a href="manage_events.php" class="btn-cancel">Cancel</a>
                        <button type="submit" class="btn-save">
                            <i class="lni lni-checkmark me-1"></i> Create Event
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

<?php include("footer.php"); ?>
