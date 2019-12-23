<?php
require_once("Autoloader.php");
if(isset($_POST['eventId']) && isset($_POST['typeEvent'])) {
    $eventId = $_POST['eventId'];
    $typeEvent = $_POST['typeEvent'];
    $amountType = $_POST['amountType'];
    $session = new Session;
    $amount = $session->RemoveFromCartFood($eventId, $typeEvent, $amountType);
    print $amount;
}
?>