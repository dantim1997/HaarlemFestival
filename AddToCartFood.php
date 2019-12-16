<?php
require_once("Autoloader.php");
if(isset($_POST['eventId']) && isset($_POST['childAmount']) || isset($_POST['eventId']) && isset($_POST['typeEvent']) && isset($_POST['adultAmount'])) {
    $eventId = $_POST['eventId'];
    $childAmount = $_POST['childAmount'];
    $adultAmount = $_POST['adultAmount'];
    $special = $_POST['special'];
    $startTime = $_POST['startTime'];
    $date = $_POST['date'];
    $extraInfo = $_POST['extraInfo'];
    $session = new Session;
    $session->AddToCartFood($eventId, $childAmount, $adultAmount, $startTime, $date, $extraInfo);
}
?>