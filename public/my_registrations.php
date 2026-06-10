<?php include('header.php'); ?>
<style>
    <?php include('../assets/css/register.css'); ?>
</style>

<div class='registrations-page'>
    <div class='page-header'>
        <h1 class='page-title'>My Event Registrations</h1>
        <p class='page-subtitle'>Manage your event registrations. View your upcoming events and cancel if needed.</p>
    </div>

    <div class='registrations-grid'>
        <?php 
        require_once('../classes/Registration.php');
        require_once('../classes/User.php');
        $e=new Registration();
        $a=new User();
        $events=$e->getRegistrations($_SESSION['id']);
        if($events->rowCount()==0){
            echo "
            <div class='no-registrations'>
            <i class='fas fa-calendar-times'></i>
            <h3>No Registrations Yet</h3>
            <p>You havent registered for any events yet.</p>
            <a href='events.php' class='browse-events-btn'>
                <i class='fas fa-calendar-plus'></i>
                Browse Events
            </a>
        </div>";
        } else{
        foreach($events as $ev){
        $formattedDate = date('F j, Y', strtotime($ev[3]));
        $ad=$a->getUser($ev[5]);
        echo "
        <div class='registration-card'>
            <div class='registration-header'>
                <h3 class='registration-title'>$ev[1]</h3>
                <span class='registration-date'>
                    <i class='fas fa-calendar-alt'></i>
                    {$formattedDate}
                </span>
            </div>
            
            <p class='registration-description'>$ev[2]</p>
            
            <div class='registration-details'>
                <div class='registration-detail'>
                    <i class='fas fa-map-marker-alt'></i>
                    <span>$ev[4]</span>
                </div>
                
                <div class='event-admin'>
                    <div class='admin-avatar'><img class='profile-img' src='{$ad[5]} '></div>
                    <div class='admin-info'>
                        <h4>{$ad[1]}</h4>
                        <p>{$ad[4]}</p>
                    </div>
                </div>
            </div>
            
            <div class='registration-actions'>
                <form action='../actions/cancel_registration.php' method='POST' style='flex: 1;'>
                    <input type='hidden' name='registration_id' value='$ev[6]'>
                    <button type='submit' class='btn-cancel-reg'>
                        <i class='fas fa-times'></i>
                        Cancel Registration
                    </button>
                </form>
            </div>
        </div>";
        };}
        
        ?>
        </div>

        <!-- No Registrations State -->
        
    </div>
</div>

<?php include('footer.php'); ?>