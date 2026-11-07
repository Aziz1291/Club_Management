<?php 
require_once __DIR__.'/../auth.php'; 
require_admin(); 
include("header.php");
require_once('../classes/Announcement.php');
require_once('../classes/Admin.php');

$annId = $_POST['id'] ?? $_GET['id'] ?? 0;
$a = new Announcement();
$an = $a->getAnn($annId);

if (!$an) {
    echo "<div class='container py-5'><div class='club-alert club-alert-danger'>Announcement not found. <a href='announcements.php'>Return to announcements</a>.</div></div>";
    include("footer.php");
    exit;
}

$u = new Admin();
$admins = $u->listAdmin();
$title = htmlspecialchars($an[1] ?? '');
$desc = htmlspecialchars($an[2] ?? '');
$authorId = $an[3] ?? 0;
?>

<link rel="stylesheet" href="../assets/css/editAnn.css">

<section class="section">
    <div class="container-fluid">
        <div class="ann-form-container">
            <div class="ann-form-card">
                <div class="form-header">
                    <span class="kicker">Club Dispatches</span>
                    <h2>Edit Announcement #ANN-<?= htmlspecialchars((string)$an[0]) ?></h2>
                </div>

                <?php form_error_box(); ?>
                <form action="../actions/editAnn.php" method="POST">
                    <input type="hidden" name="id" value="<?= htmlspecialchars((string)$an[0]) ?>">

                    <div class="form-group">
                        <label for="ann-title" class="form-label">Announcement Headline</label>
                        <input type="text" id="ann-title" name="title" class="form-control" value="<?= htmlspecialchars(form_old('title', $an[1] ?? '')) ?>" maxlength="150" required autofocus>
                    </div>

                    <div class="form-group">
                        <label for="ann-content" class="form-label">Dispatch Brief / Content</label>
                        <textarea id="ann-content" name="desc" class="form-control" rows="5" maxlength="5000" required><?= htmlspecialchars(form_old('desc', $an[2] ?? '')) ?></textarea>
                    </div>

                    <div class="form-group">
                        <label for="admin_id" class="form-label">Publishing Authority / Director</label>
                        <select id="admin_id" name="idA" class="form-control" required>
                            <option value="">Select an administrator...</option>
                            <?php foreach ($admins as $user): ?>
                                <option value="<?= htmlspecialchars((string)$user[0]) ?>" <?= $user[0] == $authorId ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($user[1]) ?> (<?= ucfirst(htmlspecialchars($user[4])) ?>)
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="form-actions">
                        <a href="announcements.php" class="btn-cancel">Cancel</a>
                        <button type="submit" class="btn-save">
                            <i class="lni lni-checkmark me-1"></i> Save Changes
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

<?php include("footer.php"); ?>
