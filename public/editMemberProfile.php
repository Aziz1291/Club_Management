<?php include("header.php"); ?>
<style><?php include('../assets/css/profile.css')?> </style>
<?php
require_once('../classes/Admin.php');
$us  = new Admin();
$row = $us->getUser($_POST['curid']);
$currentPic = !empty($row[5]) ? htmlspecialchars($row[5]) : '../assets/images/profilee.jpg';
?>

<div class="profile-card">
    <div class="profile-header">
        <div class="profile-image-container">
            <img src="<?= $currentPic ?>" alt="Profile Image" class="profile-image" id="profile-image">
            <label class="profile-image-overlay" for="profile-image-input">
                <i class="lni lni-camera"></i>
                <span>Change Photo</span>
            </label>
        </div>
        <h1 class="profile-name"><?= htmlspecialchars($row[1]) ?></h1>
        <p class="profile-role"><?= htmlspecialchars($row[4]) ?></p>
    </div>

    <form class="profile-form" id="profile-form" method="post"
          action="../actions/editMemberProfile.php"
          enctype="multipart/form-data">

        <!-- Hidden fields -->
        <input type="hidden" name="id"      value="<?= $row[0] ?>">
        <input type="hidden" name="old_img" value="<?= $row[5] ?>">

        <!-- Profile picture upload -->
        <div class="form-group">
            <label for="profile-image-input" class="form-label">Profile Picture</label>
            <input type="file" id="profile-image-input" name="profile_image"
                   accept="image/jpeg,image/png,image/gif,image/webp"
                   class="form-control">
            <small class="text-muted">Leave empty to keep current photo. Max 5 MB.</small>
        </div>

        <div class="form-group">
            <label for="user-id" class="form-label">User ID</label>
            <input type="text" id="user-id" class="form-control"
                   value="<?= $row[0] ?>" disabled>
        </div>

        <div class="form-group">
            <label for="user-name" class="form-label">Full Name</label>
            <input type="text" id="user-name" name="name" class="form-control"
                   value="<?= htmlspecialchars($row[1]) ?>">
        </div>

        <div class="form-group">
            <label for="user-email" class="form-label">Email Address</label>
            <input type="email" id="user-email" name="email" class="form-control"
                   value="<?= htmlspecialchars($row[2]) ?>">
        </div>

        <div class="form-group">
            <label for="user-password" class="form-label">Password</label>
            <input type="password" id="user-password" name="pwd" class="form-control"
                   placeholder="Leave blank to keep unchanged"
                   value="<?= htmlspecialchars($row[3]) ?>">
        </div>

        <div class="form-group">
            <label for="user-role" class="form-label">Role</label>
            <select name="role" id="user-role" class="form-control">
                <option value="admin"  <?= $row[4] === 'admin'  ? 'selected' : '' ?>>Admin</option>
                <option value="member" <?= $row[4] === 'member' ? 'selected' : '' ?>>Member</option>
            </select>
        </div>

        <div class="form-actions">
            <a href="members.php"><button type="button" class="btn-cancel">Cancel</button></a>
            <input type="submit" class="btn-save" value="Save Changes">
        </div>
    </form>
</div>

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
