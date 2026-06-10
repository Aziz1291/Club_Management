<?php include("header.php"); ?>

<div class="container-fluid mt-4">
    <h2>Welcome to the Club Dashboard</h2>

    <div class="row mt-4">
        <div class="col-md-4"><div class="card p-3">Total Members: <?php require_once('../classes/user.php');$us=new User();$us->nbUser();?></div></div>
        <div class="col-md-4"><div class="card p-3">Upcoming Events: 0</div></div>
        <div class="col-md-4"><div class="card p-3">Unread Messages: 0</div></div>
    </div>
</div>

<?php include("footer.php"); ?>
