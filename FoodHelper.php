<?php
require_once("Autoloader.php");
if(isset($_POST['id']) && isset($_POST['date'])) {
    $DB_Helper = new DB_Helper();
    $date = date_create($_POST['date']);
    $date = date_format($date, "Y-m-d");
    $date .= '%';
    $id = $_POST['id'];
    $time = $DB_Helper->GetFoodTimeByDate($date, $id);
    $cleanTime = json_encode($time);
    print $cleanTime;
}
?>