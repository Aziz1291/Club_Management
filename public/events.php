<?php include("header.php"); ?>
<style>
    <?php include("../assets/css/events.css"); ?>
</style>
<div style="text-align: center; margin-bottom: 30px;">
    <a href="my_registrations.php" class="view-registrations-btn">
        <i class="fas fa-list-check"></i>
        View My Registrations
    </a>
</div>

<div class="events-page">
    <div class="page-header">
        <h1 class="page-title">Upcoming Events</h1>
        <p class="page-subtitle">Join our exciting events and connect with the community. Discover upcoming activities and register your participation.</p>
    </div>

    <div class="events-grid">
        <?php
        require_once('../classes/Event.php');
        require_once('../classes/User.php');
        $ev=new Event();
        $events = $ev->listEvent();
        $ad=new User();
        foreach ($events as $event) {
            $admin=$ad->getUser($event[5]);
            $formattedDate = date('F j, Y', strtotime($event[3]));
            $idUser=$_SESSION['id'];
            echo "
            <div class='event-card'>
                <div class='event-header'>
                    <h3 class='event-title'>{$event[1]}</h3>
                    <span class='event-date'>
                        <i class='fas fa-calendar-alt'></i>
                        {$formattedDate}
                    </span>
                </div>
                
                <p class='event-description'>{$event[2]}</p>
                
                <div class='event-details'>
                    <div class='event-detail'>
                        <i class='fas fa-map-marker-alt'></i>
                        <span>{$event[4]}</span>
                    </div>
                    
                </div>
                
                <div class='event-admin'>
                    <div class='admin-avatar'><img class='profile-img' src='{$admin[5]} '></div>
                    <div class='admin-info'>
                        <h4>{$admin[1]}</h4>
                        <p>{$admin[4]}</p>
                    </div>
                </div>
                <form action='../actions/register.php' method='POST'>
                <input type='hidden' value='$event[0]' name='idEvent'>
                <input type='hidden' value='$idUser' name='idUser'>
                <div class='event-actions'>
                    <button type='submit' class='btn-attend'>
                        <i class='fas fa-check-circle'></i>
                        Register Now
                    </button>
                </div>
                </form>
            </div>
            ";
        }
        
        
        ?>
    </div>
</div>



<?php include("footer.php"); ?>