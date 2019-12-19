<?php
require_once("Autoloader.php");
if(isset($_POST['eventId']) && isset($_POST['ChildAmount'])) {
    $amount = $_POST['ChildAmount'];
} else if (isset($_POST['eventId']) && isset($_POST['AdultAmount'])) {
    $amount = $_POST['AdultAmount'];
}

$eventId = $_POST['eventId'];
$typeEvent = 1;
$session = new Session;
$amount = $session->RemoveFromCartFood($eventId, $typeEvent, $amount);
print $amount;

?>