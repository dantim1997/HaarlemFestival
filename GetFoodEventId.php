<?php
require_once("Autoloader.php");
if(isset($_POST['startTime']) && isset($_POST['date']) && isset($_POST['name'])) {
    $startTime = $_POST['startTime'];
    $name = $_POST['name'];
    $date = date_create($_POST['date']);
    $date = date_format($date, "Y-m-d");
    $dateTime = $date.' '.$startTime.':00';
    $DB_Helper = new DB_Helper;
    $ids = $DB_Helper->GetEventIdFood($dateTime, $name);
    $kaa = 1;
    foreach ($ids as $id) {
        $kaa = $id;
    }
    print $id;
}
?>