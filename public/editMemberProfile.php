<?php 
require_once __DIR__.'/../auth.php'; 
require_admin(); 
include("header.php");
require_once('../classes/Admin.php');

$targetId = $_POST['curid'] ?? $_GET['curid'] ?? $_GET['id'] ?? 0;
$us  = new Admin();
$row = $us->getUser($targetId);

if (!$row) {
    echo "<div class='container py-5'><div class='club-alert club-alert-danger'>Member not found. <a href='members.php'>Back to members</a>.</div></div>";
    include("footer.php");
    exit;
}

$currentPic = htmlspecialchars(get_avatar_url($row[5] ?? ''));
$role = htmlspecialchars($row[4] ?? 'member');
$name = htmlspecialchars($row[1] ?? 'Member');
$email = htmlspecialchars($row[2] ?? '');
$id = htmlspecialchars((string)$row[0]);
?>

<link rel="stylesheet" href="../assets/css/profile.css">

<section class="section">
    <div class="container-fluid">
        <div class="profile-card">
            <div class="profile-header">
                <span class="kicker">Edit member</span>
                <div class="profile-image-container mt-3">
                    <img src="<?= $currentPic ?>" alt="Profile photo" class="profile-image" id="profile-image" onerror="this.src='../assets/images/profilee.jpg'">
                    <label class="profile-image-overlay" for="profile-image-input" title="Change photo">
                        <i class="lni lni-camera"></i>
                        <span>Replace Photo</span>
                    </label>
                </div>
                <h1 class="profile-name"><?= $name ?></h1>
                <p class="profile-role">
                    <span class="pill <?= $role === 'admin' ? 'pill-admin' : 'pill-member' ?>">
                        <?= $role === 'admin' ? 'Admin' : 'Member' ?>
                    </span>
                </p>
            </div>

            <?php form_error_box(); ?>
            <form class="profile-form" id="profile-form" method="post" action="../actions/editMemberProfile.php" enctype="multipart/form-data">
<?= csrf_field() ?>
                <!-- Hidden inputs -->
                <input type="hidden" name="id" value="<?= $id ?>">
                <input type="hidden" name="old_img" value="<?= htmlspecialchars($row[5] ?? '') ?>">

                <!-- Profile picture file input -->
                <input type="file" id="profile-image-input" name="profile_image" accept="image/jpeg,image/png,image/gif,image/webp">

                <div class="row g-3 mb-3">
                    <div class="col-md-4">
                        <div class="form-group mb-0">
                            <label for="user-id" class="form-label">Member ID</label>
                            <input type="text" id="user-id" class="form-control tabular-num" value="#ATH-<?= $id ?>" disabled>
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
                    <label for="user-email" class="form-label">Email address</label>
                    <input type="email" id="user-email" name="email" class="form-control" value="<?= htmlspecialchars(form_old('email', html_entity_decode($email))) ?>" maxlength="100" required>
                </div>

                <div class="form-group">
                    <label for="user-password" class="form-label">Password Override</label>
                    <input type="password" id="user-password" name="pwd" class="form-control" minlength="6" placeholder="Leave blank to maintain current credentials">
                    <small class="text-muted">Enter a new password only if you want to change it.</small>
                </div>

                <div class="form-group">
                    <label for="user-role" class="form-label">Division &amp; Permissions Role</label>
                    <div class="select-style-1">
                        <select name="role" id="user-role" class="form-control" required>
                            <option value="member" <?= $role === 'member' ? 'selected' : '' ?>>Member</option>
                            <option value="admin"  <?= $role === 'admin'  ? 'selected' : '' ?>>Admin</option>
                        </select>
                    </div>
                </div>

                <div class="form-actions">
                    <a href="members.php" class="btn-cancel">Back to members</a>
                    <button type="submit" class="btn-save">
                        <i class="lni lni-checkmark me-1"></i> Save Changes
                    </button>
                </div>
            </form>
        </div>
    </div>
</section>

<script>
document.getElementById('profile-image-input').addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(ev) {
            document.getElementById('profile-image').src = ev.target.result;
        };
        reader.readAsDataURL(file);
    }
});
</script>

<?php include("footer.php"); ?>
