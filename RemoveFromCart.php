<?php
require_once("Autoloader.php");
if(isset($_POST['eventId']) && isset($_POST['typeEvent'])) {
    $eventId = $_POST['eventId'];
    $TypeEvent = $_POST['typeEvent'];
    $session = new Session;
    $lol = $session->RemoveFromCart($eventId,$TypeEvent);
    print $lol;
}
?>