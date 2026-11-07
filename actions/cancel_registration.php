<?php
require_once('../auth.php');
require_login();
require_post();
require_once('../classes/Registration.php');

$regId  = (int) ($_POST['registration_id'] ?? 0);
$userId = (int) ($_SESSION['id'] ?? 0);

if ($regId > 0 && $userId > 0) {
    $r = new Registration();
    $r->cancelRegistration($regId, $userId);
    flash_code('cancelled');
    header("Location: ../public/my_registrations.php");
    exit;
}
header("Location: ../public/my_registrations.php");
exit;
?>
