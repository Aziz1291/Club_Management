<?php include("header.php"); ?>
<section class="section">
    <div class="container-fluid">
        <div class="title-wrapper pt-30">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <div class="title">
                        <h2>Manage Members</h2>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="breadcrumb-wrapper">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a href="index.php">Dashboard</a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    Members
                                </li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mb-4">
            <div class="col-12">
                <div class="add-member-btn-container">
                    <a href="addMember.php" class="btn-add-member">
                        <i class="lni lni-plus"></i>
                        Add New Member
                    </a>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="card-style mb-30">
                    <div class="members-table-container">
                        <table class="members-table">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Username</th>
                                    <th>Email</th>
                                    <th>Password</th>
                                    <th>Role</th>
                                    <th>Profile Picture</th>
                                    <?php if($_SESSION['role']=='admin'):?>
                                    <th>Actions</th>
                                    <?php endif; ?>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                include("../classes/user.php");
                                $us = new user();
                                $res = $us->list_user();
                                
                                
                                    foreach($res as $row) {
                                        $role_class = $row[4] == 'admin' ? 'role-admin' : 'role-member';
                                        $avatar = !empty($row[5]) ? htmlspecialchars($row[5]) : '../assets/images/profilee.jpg';
                                        echo "
                                        <tr>
                                            <td>{$row[0]}</td>
                                            <td>{$row[1]}</td>
                                            <td>{$row[2]}</td>
                                            <td>••••••••</td>
                                            <td><span class='role-badge $role_class'>{$row[4]}</span></td>
                                            <td><img src='$avatar' class='profile-img' alt='Profile' onerror=\"this.src='../assets/images/profilee.jpg'\"></td>
                                            <td>
                                                <div class='action-buttons'>
                                                    
                                                    <form action='editMemberProfile.php' method='POST'>
                                                    <input type='hidden' name='curid' value='{$row[0]}'>
                                                    <button type='submit' class='btn-edit' ><i class='lni lni-pencil'></i> Edit</button>
                                                    </form>
                                                    <form action='../actions/Del.php' method='POST'>
                                                    <input type='hidden' name='curid' value='{$row[0]}'>
                                                    <button type='submit' class='btn-delete' ><i class='lni lni-trash-can'></i> Delete</button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>";
                                    }
                                
                                ?>
                            </tbody>
                            
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<style>
<?php include '../assets/css/members.css'; ?>
</style>

<?php include("footer.php"); ?>