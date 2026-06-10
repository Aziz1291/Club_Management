<style>
<?php include('../assets/css/announcements.css');?>
</style>
<div class='announcements-grid'>
        <?php
        require_once('../classes/Announcement.php');
        require_once('../classes/User.php');
        
        $a = new Announcement();
        $u = new User();
        $as = $a->displayAnn();
        
        if(empty($as)) {
            echo "
            <div class='no-announcements'>
                <i class='fas fa-bullhorn'></i>
                <h3>No Announcements Yet</h3>
                <p>Be the first to create an announcement for the club.</p>
            </div>";
        } else {
            foreach($as as $an) {
                $ad = $u->getUser($an[3]);
                echo "
                <div class='announcement-card'>
                    <span class='announcement-id'>#$an[0]</span>
                    <div class='announcement-header'>
                        <div>
                            <h3 class='announcement-title'>$an[1]</h3>
                        </div>
                    </div>
                    
                    <p class='announcement-content'>$an[2]</p>
                    
                    <div class='announcement-admin'>
                        <div class='admin-avatar'>
                            <img src='$ad[5]' class='profile-img' alt='Admin Avatar'>
                        </div>
                        <div class='admin-info'>
                            <h4>$ad[1]</h4>
                            <p>$ad[4]</p>
                        </div>
                    </div>
                </div>";}
        }
        ?>
    </div>
</div>