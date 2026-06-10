<?php 
require_once('../classes/Event.php');
$e=new Event();
$event=$e->getEvent($_POST['ide']);
;?>
<div class="event-form-container">
    <div class="form-card">
        <h2 class="form-title">Add New Event</h2>
        
        <form class="event-form" id="addEventForm" method="POST" action="../actions/editEvent.php">
            <div class="form-group">
                <label for="eventTitle" class="form-label">Event Title</label>
                <input type="text" value="<?php echo $event[1] ?>" id="eventTitle" name="title" class="form-control" placeholder="Enter event title" required>
            </div>

            <div class="form-group">
                <label for="eventDescription" class="form-label">Description</label>
                <textarea id="eventDescription"  name="description" class="form-control" rows="4" placeholder="Enter event description" required><?php echo $event[2] ?></textarea>
            </div>
            <input type="hidden" name="ide" value="<?php echo $event[0] ?>" >
            <div class="form-group">
                <label for="eventDate" class="form-label">Event Date</label>
                <input type="date" value="<?php echo $event[3] ?>" id="eventDate" name="date" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="eventLocation" class="form-label">Location</label>
                <input type="text" value="<?php echo $event[4] ?>" id="eventLocation" name="location" class="form-control" placeholder="Enter event location" required>
            </div>

            <div class="form-group">
                <label for="eventAdmin" class="form-label">Select Admin</label>
                <select id="eventAdmin"  name="admin_id" class="form-control" required>

                    <option value="">Choose an admin...</option>
                    
                    <?php
                    require_once('../classes/Admin.php');
                    $ad=new Admin();
                    $admins=$ad->listAdmin();
                    foreach ($admins as $admin) {
                        echo "<option value='$admin[0]'>$admin[1]</option>";
                    }
                    ?>
                </select>
            </div>

            <div class="form-actions">
                <a href="manage_events.php"><button type="button" class="btn-cancel">Cancel</button></a>
                <button type="submit" class="btn-save">Save Event</button>
            </div>
        </form>
    </div>
</div>

<style>
    <?php include('../assets/css/addEvent.css');?>
</style>

