<?php include("header.php"); ?>
<section class="section">
    <div class="container-fluid">
        <div class="title-wrapper pt-30">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <div class="title">
                        <h2>Add New Member</h2>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="breadcrumb-wrapper">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a href="index.php">Dashboard</a>
                                </li>
                                <li class="breadcrumb-item">
                                    <a href="members.php">Members</a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    Add Member
                                </li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="card-style mb-30">
                    <div class="add-member-form-container">
                        <form action="../actions/addMember.php" method="POST" class="add-member-form" enctype="multipart/form-data">
                            <div class="form-grid">
                                <div class="form-group">
                                    <label for="username" class="form-label">Username</label>
                                    <input type="text" id="username" name="username" class="form-control" required>
                                </div>

                                <div class="form-group">
                                    <label for="email" class="form-label">Email Address</label>
                                    <input type="email" id="email" name="email" class="form-control" required>
                                </div>

                                <div class="form-group">
                                    <label for="password" class="form-label">Password</label>
                                    <input type="password" id="password" name="password" class="form-control" required>
                                </div>

                                <div class="form-group">
                                    <label for="role" class="form-label">Role</label>
                                    <select id="role" name="role" class="form-control" required>
                                        <option value="">Select Role</option>
                                        <option value="member">Member</option>
                                        <option value="admin">Admin</option>
                                    </select>
                                </div>

                                <div class="form-group full-width">
                                    <label for="profile_picture" class="form-label">Profile Picture</label>
                                    <div class="file-upload-container">
                                        <input type="file" id="profile_picture" name="profile_picture" class="file-input" accept="image/*">
                                        <label for="profile_picture" class="file-upload-label">
                                            <i class="lni lni-cloud-upload"></i>
                                            <span>Choose profile picture</span>
                                        </label>
                                        <div class="file-preview" id="filePreview"></div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-actions">
                                <a href="members.php" class="btn-cancel">Cancel</a>
                                <button type="submit" class="btn-submit">
                                    <i class="lni lni-plus"></i>
                                    Add Member
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<style>
    <?php include '../assets/css/addMember.css'; ?>
</style>
<?php include("footer.php"); ?>