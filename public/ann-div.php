<div class="announcements-grid">
    <?php
    require_once('../classes/Announcement.php');
    require_once('../classes/User.php');
    
    $a = new Announcement();
    $u = new User();
    $as = $a->displayAnn();
    
    if (empty($as)) {
        echo "
        <div class='no-announcements'>
            <i class='lni lni-bullhorn'></i>
            <h3>No Active Announcements</h3>
            <p>Official dispatches and tournament bulletins will appear here.</p>
        </div>";
    } else {
        foreach ($as as $an) {
            $ad = $u->getUser($an[3]);
            $authorPic = get_avatar_url($ad[5] ?? '');
            $authorName = htmlspecialchars($ad[1] ?? 'Administrator');
            $authorRole = htmlspecialchars($ad[4] ?? 'Admin');
            $title = htmlspecialchars($an[1] ?? '');
            $content = nl2br(htmlspecialchars($an[2] ?? ''));
            $id = htmlspecialchars((string)$an[0]);

            echo "
            <div class='announcement-card'>
                <span class='announcement-id'>#ANN-$id</span>
                <div class='announcement-header'>
                    <h3 class='announcement-title'>$title</h3>
                </div>
                
                <p class='announcement-content'>$content</p>
                
                <div class='announcement-admin'>
                    <div class='admin-avatar'>
                        <img src='$authorPic' alt='$authorName' onerror=\"this.src='../assets/images/profilee.jpg'\">
                    </div>
                    <div class='admin-info'>
                        <h4>$authorName</h4>
                        <p>$authorRole</p>
                    </div>
                </div>
            </div>";
        }
    }
    ?>
</div>
