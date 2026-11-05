<?php 
include('header.php'); 
require_once('../classes/Announcement.php');
require_once('../classes/User.php');

$a = new Announcement();
$u = new User();
$as = $a->displayAnn();
?>

<link rel="stylesheet" href="../assets/css/announcements.css">

<section class="section">
    <div class="container-fluid">
        <div class="announcements-page">
            <div class="page-header">
                <div>
                    <span class="kicker">Club Dispatches</span>
                    <h1 class="page-title">Official Announcements</h1>
                    <p class="page-subtitle">Official directives, schedule updates, and club announcements from administration.</p>
                </div>
                <?php if (($_SESSION['role'] ?? '') === 'admin'): ?>
                    <a href="addAnn.php" class="add-announcement-btn">
                        <i class="lni lni-plus"></i> Post Announcement
                    </a>
                <?php endif; ?>
            </div>

            <div class="announcements-grid">
                <?php if (empty($as)): ?>
                    <div class="no-announcements">
                        <i class="lni lni-bullhorn"></i>
                        <h3>No Announcements Yet</h3>
                        <p>Be the first to publish a collegiate announcement for the club.</p>
                    </div>
                <?php else: ?>
                    <?php foreach ($as as $an): ?>
                        <?php 
                        $ad = $u->getUser($an[3]); 
                        $authorPic = get_avatar_url($ad[5] ?? '');
                        $authorName = htmlspecialchars($ad[1] ?? 'Administrator');
                        $authorRole = htmlspecialchars($ad[4] ?? 'Admin');
                        $title = htmlspecialchars($an[1] ?? '');
                        $content = nl2br(htmlspecialchars($an[2] ?? ''));
                        $id = htmlspecialchars((string)$an[0]);
                        ?>
                        <div class="announcement-card">
                            <span class="announcement-id">#ANN-<?= $id ?></span>
                            <div class="announcement-header">
                                <h3 class="announcement-title"><?= $title ?></h3>
                            </div>
                            
                            <p class="announcement-content"><?= $content ?></p>
                            
                            <div class="announcement-admin">
                                <div class="admin-avatar">
                                    <img src="<?= $authorPic ?>" alt="<?= $authorName ?>" onerror="this.src='../assets/images/profilee.jpg'">
                                </div>
                                <div class="admin-info">
                                    <h4><?= $authorName ?></h4>
                                    <p><?= $authorRole ?></p>
                                </div>
                            </div>
                            
                            <?php if (($_SESSION['role'] ?? '') === 'admin'): ?>
                                <div class="announcement-actions">
                                    <form action="editAnn.php" method="POST" class="d-inline">
                                        <input type="hidden" value="<?= $id ?>" name="id">
                                        <button type="submit" class="btn-edit">
                                            <i class="lni lni-pencil"></i> Edit
                                        </button>
                                    </form>
                                    <form action="../actions/deleteAnn.php" method="POST" class="d-inline" onsubmit="return confirm('Delete this bulletin?');">
                                        <input type="hidden" value="<?= $id ?>" name="id">
                                        <button type="submit" class="btn-delete">
                                            <i class="lni lni-trash-can"></i> Delete
                                        </button>
                                    </form>
                                </div>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>

<?php include('footer.php'); ?>
