<?php 
include("header.php"); 
require_once('../classes/User.php');

$us = new User();
$currentUserId = (int)($_SESSION['id'] ?? 0);
$row = $us->getUser($currentUserId);
$currentPic = get_avatar_url($row[5] ?? '');
$role = htmlspecialchars($row[4] ?? 'member');
$name = htmlspecialchars($row[1] ?? 'Athlete');
$email = htmlspecialchars($row[2] ?? '');
$id = htmlspecialchars((string)$row[0]);
?>

<link rel="stylesheet" href="../assets/css/profile.css">

<section class="section">
    <div class="container-fluid">
        <div class="profile-card">
            <?php if (!empty($_GET['success'])): ?>
                <div class="flash-success">
                    <i class="lni lni-checkmark-circle"></i> Profile dossier updated successfully!
                </div>
            <?php endif; ?>
            <?php if (!empty($_GET['error'])): ?>
                <div class="flash-error">
                    <i class="lni lni-warning"></i>
                    <?= $_GET['error'] === 'invalid_type' ? 'Invalid file format. Please upload JPG, PNG, GIF, or WebP.' : 'File exceeds maximum size threshold (5 MB).' ?>
                </div>
            <?php endif; ?>

            <div class="profile-header">
                <div class="profile-image-container">
                    <img src="<?= $currentPic ?>" alt="Profile photo" class="profile-image" id="profile-image" onerror="this.src='../assets/images/profilee.jpg'">
                    <label class="profile-image-overlay" for="profile-image-input" id="profile-image-trigger" title="Change athlete photo">
                        <i class="lni lni-camera"></i>
                        <span>Change Photo</span>
                    </label>
                </div>
                <div>
                    <label for="profile-image-input" class="btn-change-photo-badge" id="btn-browse-photo">
                        <i class="lni lni-camera"></i> Update Photo
                    </label>
                </div>
                <h1 class="profile-name mt-2"><?= $name ?></h1>
                <p class="profile-role">
                    <span class="pill <?= $role === 'admin' ? 'pill-admin' : 'pill-member' ?>">
                        <?= $role === 'admin' ? 'Athletic Director' : 'Varsity Athlete' ?>
                    </span>
                </p>
            </div>

            <?php form_error_box(); ?>
            <form class="profile-form" id="profile-form" method="post" action="../actions/modifyProfile.php" enctype="multipart/form-data">
<?= csrf_field() ?>
                <!-- Hidden inputs -->
                <input type="hidden" name="id" value="<?= $id ?>">
                <input type="hidden" name="old_img" value="<?= htmlspecialchars($row[5] ?? '') ?>">
                <input type="hidden" name="role" value="<?= $role ?>">

                <!-- Profile picture file input (triggered by label overlay or button) -->
                <input type="file" id="profile-image-input" name="profile_image" accept="image/jpeg,image/png,image/gif,image/webp">

                <div class="row g-3 mb-3">
                    <div class="col-md-4">
                        <div class="form-group mb-0">
                            <label for="user-id" class="form-label">Member Roster ID</label>
                            <input type="text" id="user-id" class="form-control tabular-num" value="#ATH-<?= str_pad((string)$id, 2, '0', STR_PAD_LEFT) ?>" disabled>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="form-group mb-0">
                            <label for="user-name" class="form-label">Full Name</label>
                            <input type="text" id="user-name" name="name" class="form-control" value="<?= htmlspecialchars(form_old('name', html_entity_decode($name))) ?>" minlength="3" maxlength="50" required>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="user-email" class="form-label">Collegiate Email Address</label>
                    <input type="email" id="user-email" name="email" class="form-control" value="<?= htmlspecialchars(form_old('email', html_entity_decode($email))) ?>" maxlength="100" required>
                </div>

                <div class="form-group">
                    <label for="user-password" class="form-label">Password</label>
                    <input type="password" id="user-password" name="pwd" class="form-control" minlength="6" placeholder="Leave blank to maintain current credentials">
                    <small class="text-muted">Enter a new password only if you wish to change it.</small>
                </div>

                <div class="form-group">
                    <label for="user-role" class="form-label">Division Role</label>
                    <input type="text" id="user-role" class="form-control" value="<?= $role === 'admin' ? 'Athletic Administrator' : 'Varsity Member' ?>" disabled>
                </div>

                <div class="form-actions">
                    <a href="index.php" class="btn-cancel">Return to Dashboard</a>
                    <button type="submit" class="btn-save" id="btn-save-profile">
                        <i class="lni lni-checkmark me-1"></i> Save Dossier
                    </button>
                </div>
            </form>
        </div>
    </div>
</section>

<script>
// Instant local preview for avatar replacement using FileReader
document.getElementById('profile-image-input').addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(ev) {
            const previewImg = document.getElementById('profile-image');
            if (previewImg) {
                previewImg.src = ev.target.result;
            }
        };
        reader.readAsDataURL(file);
    }
});
</script>

<?php include("footer.php"); ?>
