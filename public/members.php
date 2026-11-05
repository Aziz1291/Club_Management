<?php 
require_once __DIR__.'/../auth.php'; 
require_admin(); 
include("header.php"); 
include("../classes/User.php");

$us = new User();
$res = $us->list_user();
?>

<link rel="stylesheet" href="../assets/css/members.css">

<section class="section">
    <div class="container-fluid">
        <div class="title-wrapper">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <span class="kicker">Athletic Governance</span>
                    <h2 class="mb-1">Collegiate Member Roster</h2>
                    <p class="text-muted mb-0">Active athletes, verified members, and athletic department directors.</p>
                </div>
                <div class="col-md-6 text-md-end mt-3 mt-md-0">
                    <a href="addMember.php" class="btn-add-member">
                        <i class="lni lni-plus"></i> Enroll New Athlete
                    </a>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="members-table-container">
                    <table class="members-table">
                        <thead>
                            <tr>
                                <th scope="col">ID</th>
                                <th scope="col">Athlete / Profile</th>
                                <th scope="col">Collegiate Email</th>
                                <th scope="col">Division Role</th>
                                <th scope="col">Account Status</th>
                                <th scope="col" style="text-align: right;">Administrative Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($res)): ?>
                                <tr>
                                    <td colspan="6" class="text-center py-4 text-muted">No members enrolled in the club roster.</td>
                                </tr>
                            <?php else: ?>
                                <?php foreach ($res as $row): ?>
                                    <?php
                                    $id = htmlspecialchars((string)$row[0]);
                                    $name = htmlspecialchars($row[1] ?? 'User');
                                    $email = htmlspecialchars($row[2] ?? '');
                                    $role = htmlspecialchars($row[4] ?? 'member');
                                    $avatar = !empty($row[5]) ? htmlspecialchars($row[5]) : '../assets/images/profilee.jpg';
                                    $rolePillClass = $role === 'admin' ? 'pill-admin' : 'pill-member';
                                    $roleLabel = $role === 'admin' ? 'Athletic Director' : 'Varsity Athlete';
                                    ?>
                                    <tr>
                                        <td>
                                            <span class="member-id-badge">#ATH-<?= $id ?></span>
                                        </td>
                                        <td>
                                            <div class="member-athlete-cell">
                                                <img src="<?= $avatar ?>" class="member-avatar" alt="<?= $name ?>" onerror="this.src='../assets/images/profilee.jpg'">
                                                <div class="member-info">
                                                    <h4><?= $name ?></h4>
                                                    <span>@<?= strtolower($name) ?></span>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <a href="mailto:<?= $email ?>" class="text-muted"><i class="lni lni-envelope me-1"></i><?= $email ?></a>
                                        </td>
                                        <td>
                                            <span class="pill <?= $rolePillClass ?>"><?= $roleLabel ?></span>
                                        </td>
                                        <td>
                                            <span class="pill tone-sea"><i class="lni lni-checkmark me-1"></i>Active</span>
                                        </td>
                                        <td>
                                            <div class="action-buttons justify-content-end">
                                                <form action="editMemberProfile.php" method="POST" class="d-inline">
                                                    <input type="hidden" name="curid" value="<?= $id ?>">
                                                    <button type="submit" class="btn-edit" aria-label="Edit <?= $name ?>">
                                                        <i class="lni lni-pencil"></i> Edit
                                                    </button>
                                                </form>
                                                <form action="../actions/Del.php" method="POST" class="d-inline" onsubmit="return confirm('Remove athlete from roster?');">
                                                    <input type="hidden" name="curid" value="<?= $id ?>">
                                                    <button type="submit" class="btn-delete" aria-label="Delete <?= $name ?>">
                                                        <i class="lni lni-trash-can"></i> Remove
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
    </div>
</section>

<?php include("footer.php"); ?>
