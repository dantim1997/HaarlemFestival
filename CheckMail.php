<?php
require_once("Autoloader.php");
if (isset($_POST['Email'])) {
    $DB_Helper = new DB_Helper();
    
    $OrderCode = $DB_Helper->CheckMail($_POST["Email"]);
    if ($OrderCode != "") {
        print $OrderCode;
    }
    else {
        print false;
    }
}
?>