<?php 
require_once __DIR__.'/../auth.php'; 
require_admin(); 
include("header.php"); 
?>

<link rel="stylesheet" href="../assets/css/addMember.css">

<section class="section">
    <div class="container-fluid">
        <div class="title-wrapper">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <span class="kicker">Athletic Governance</span>
                    <h2 class="mb-1">Enroll New Member</h2>
                    <p class="text-muted mb-0">Directly add an athlete or director to the collegiate roster.</p>
                </div>
                <div class="col-md-6 text-md-end mt-3 mt-md-0">
                    <a href="members.php" class="btn-club btn-club-secondary">
                        &larr; Back to Member Roster
                    </a>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="add-member-form-container">
                    <?php form_error_box(); ?>
                    <form action="../actions/addMember.php" method="POST" class="add-member-form" enctype="multipart/form-data">
                        <div class="form-grid">
                            <div class="form-group">
                                <label for="username" class="form-label">Athlete Username</label>
                                <input type="text" id="username" name="username" class="form-control" placeholder="e.g. j_miller" minlength="3" maxlength="50" value="<?= htmlspecialchars(form_old('username')) ?>" required autofocus>
                            </div>

                            <div class="form-group">
                                <label for="email" class="form-label">Collegiate Email Address</label>
                                <input type="email" id="email" name="email" class="form-control" placeholder="athlete@university.edu" maxlength="100" value="<?= htmlspecialchars(form_old('email')) ?>" required>
                            </div>

                            <div class="form-group">
                                <label for="password" class="form-label">Temporary Password</label>
                                <input type="password" id="password" name="password" class="form-control" placeholder="Minimum 6 characters" minlength="6" required>
                            </div>

                            <div class="form-group">
                                <label for="role" class="form-label">Division &amp; Permissions Role</label>
                                <div class="select-style-1">
                                    <select id="role" name="role" class="form-control" required>
                                        <option value="member">Varsity Member / Athlete</option>
                                        <option value="admin">Athletic Director (Administrator)</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group full-width">
                                <label for="profile_picture" class="form-label">Athlete Portrait Photo (Optional)</label>
                                <input type="file" id="profile_picture" name="profile_picture" class="form-control" accept="image/jpeg,image/png,image/gif,image/webp">
                                <small class="text-muted">Recommended: square JPG, PNG, or WebP up to 5 MB.</small>
                            </div>
                        </div>

                        <div class="form-actions">
                            <a href="members.php" class="btn-cancel">Cancel</a>
                            <button type="submit" class="btn-submit">
                                <i class="lni lni-plus me-1"></i> Enroll Athlete
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include("footer.php"); ?>
