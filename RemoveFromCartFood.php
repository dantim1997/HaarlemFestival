<?php
require_once("Autoloader.php");
if(isset($_POST['eventId']) && isset($_POST['typeEvent'])) {
    $eventId = $_POST['eventId'];
    $typeEvent = $_POST['typeEvent'];
    $session = new Session;
    $amount = $session->RemoveFromCartFood($eventId, $typeEvent);
    print $amount;
}
?>