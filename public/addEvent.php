<div class="event-form-container">
    <div class="form-card">
        <h2 class="form-title">Add New Event</h2>
        
        <form class="event-form" id="addEventForm" method="POST" action="../actions/addEvent.php">
            <div class="form-group">
                <label for="eventTitle" class="form-label">Event Title</label>
                <input type="text" id="eventTitle" name="title" class="form-control" placeholder="Enter event title" required>
            </div>

            <div class="form-group">
                <label for="eventDescription" class="form-label">Description</label>
                <textarea id="eventDescription" name="description" class="form-control" rows="4" placeholder="Enter event description" required></textarea>
            </div>

            <div class="form-group">
                <label for="eventDate" class="form-label">Event Date</label>
                <input type="date" id="eventDate" name="date" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="eventLocation" class="form-label">Location</label>
                <input type="text" id="eventLocation" name="location" class="form-control" placeholder="Enter event location" required>
            </div>

            <div class="form-group">
                <label for="eventAdmin" class="form-label">Select Admin</label>
                <select id="eventAdmin" name="admin_id" class="form-control" required>
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
                <button type="submit" class="btn-save">Create Event</button>
            </div>
        </form>
    </div>
</div>

<style>
    <?php include('../assets/css/addEvent.css');?>
</style>

