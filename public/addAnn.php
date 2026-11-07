<?php 
require_once __DIR__.'/../auth.php'; 
require_admin(); 
include("header.php");
require_once('../classes/Admin.php');

$a = new Admin();
$admins = $a->listAdmin();
$currentUserId = $_SESSION['id'] ?? 0;
?>

<link rel="stylesheet" href="../assets/css/editAnn.css">

<section class="section">
    <div class="container-fluid">
        <div class="ann-form-container">
            <div class="ann-form-card">
                <div class="form-header">
                    <span class="kicker">Announcements</span>
                    <h2>New announcement</h2>
                </div>

                <?php form_error_box(); ?>
                <form action="../actions/addAnn.php" method="POST">
<?= csrf_field() ?>
                    <div class="form-group">
                        <label for="ann-title" class="form-label">Title</label>
                        <input type="text" id="ann-title" name="title" class="form-control" placeholder="e.g. New training schedule" maxlength="150" value="<?= htmlspecialchars(form_old('title')) ?>" required autofocus>
                    </div>

                    <div class="form-group">
                        <label for="ann-content" class="form-label">Content</label>
                        <textarea id="ann-content" name="desc" class="form-control" rows="5" placeholder="Write the complete announcement text..." maxlength="5000" required><?= htmlspecialchars(form_old('desc')) ?></textarea>
                    </div>

                    <div class="form-group">
                        <label for="admin_id" class="form-label">Published by</label>
                        <select id="admin_id" name="idA" class="form-control" required>
                            <option value="">Select an administrator...</option>
                            <?php foreach ($admins as $user): ?>
                                <option value="<?= htmlspecialchars((string)$user[0]) ?>" <?= $user[0] == $currentUserId ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($user[1]) ?> (<?= ucfirst(htmlspecialchars($user[4])) ?>)
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="form-actions">
                        <a href="announcements.php" class="btn-cancel">Cancel</a>
                        <button type="submit" class="btn-save">
                            <i class="lni lni-bullhorn me-1"></i> Publish Announcement
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

<?php include("footer.php"); ?>
