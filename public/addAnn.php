<style><?php include('../assets/css/editAnn.css');?></style>
<form action='../actions/addAnn.php' method='POST'>
    <input type='hidden' name='id' value='$an[0]'>
    
    <div class='form-group'>
        <label for='title' class='form-label'>Announcement Title</label>
        <input type='text' id='title' name='title' class='form-control'  required>
    </div>
    
    <div class='form-group'>
        <label for='content' class='form-label'>Announcement Content</label>
        <textarea id='content' name='desc' class='form-control' rows='5' required></textarea>
    </div>
    
    <div class='form-group'>
        <label for='admin_id' class='form-label'>Posted By</label>
        <select id='admin_id' name='idA' class='form-control' required>
            <option value=''>Select User</option>";
            <?php 
            require_once('../classes/Admin.php');
            $a=new Admin();
            $us=$a->listAdmin();
            foreach($us as $user) {echo "<option value='$user[0]' $selected>$user[1] ($user[4])</option>";}
                ?>
              </select>
    </div>
    
    <div class='form-actions'>
        <a href='announcements.php'><button type='button' class='btn-cancel' >Cancel</button></a>
        <button type='submit' class='btn-save'>Save Changes</button>
    </div>
</form>