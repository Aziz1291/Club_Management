<?php include("header.php"); ?>
<style>
    <?php include('../assets/css/manage_events.css');?>
</style>

<div class="events-container">
    <div class="events-header">
        <h2>Events Management</h2>
        <a href="addEvent.php">
        <button class="btn-add-event" >
            <i class="fas fa-plus"></i> Add New Event
        </button>
        </a>
    </div>

    <div class="events-table-container">
        <table class="events-table">
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Description</th>
                    <th>Date</th>
                    <th>Location</th>
                    <th>Admin</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                require_once('../classes/User.php');
                require_once('../classes/Event.php');
                $ev=new Event();
                $events=$ev->listEvent(); 
                $ad=new User();
                foreach ($events as $event) {
                    $admin=$ad->getUser($event[5]);
                    echo "
                    <tr>
                        <td>{$event[1]}</td>
                        <td>{$event[2]}</td>
                        <td>{$event[3]}</td>
                        <td>{$event[4]}</td>
                        <td>{$admin[1]}</td>
                        <td>
                            <form action='editEvent.php' method='POST'>
                            <input type='hidden' value='$event[0]' name='ide'>
                            <button class='btn-edit' >
                                <i class='fas fa-edit'></i> Edit
                            </button>
                            </form>
                            <form action='../actions/delEvent.php' method='POST'>
                            <input type='hidden' value='$event[0]' name='ide'>
                            <button class='btn-delete' >
                                <i class='fas fa-trash'></i> Delete
                            </button>
                            </form>
                        </td>
                    </tr>
                    ";
                }
                ?>
            </tbody>
        </table>
    </div>
</div>


<style>
    <?php include('../assets/manage_events.css');?>
</style>



<?php include("footer.php"); ?>