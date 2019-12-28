<?php
require_once("Autoloader.php");
if(isset($_POST['eventId']) && isset($_POST['typeEvent']) && isset($_POST['amount'])) {
    $eventId = $_POST['eventId'];
    $TypeEvent = $_POST['typeEvent'];

    $session = new Session;
    $DB_Helper = new DB_Helper();
    $existingamount = 0;
    $maxamount = 0;
    foreach($_SESSION["Tickets"] as $item){
        if($item["EventId"] == $eventId){
            $existingamount = $item["Amount"];
        }
    }
    switch ($TypeEvent) {
        case 1:
            $maxamount= $DB_Helper->GetTicketAmountFood($eventId);
            break;
        case 2:
            $maxamount= $DB_Helper->GetTicketAmountDance($eventId);
            break;
        case 3:
                $maxamount =  $DB_Helper->GetAmountHistoric($eventId);
            break;
        case 4:
            $maxamount = $DB_Helper->GetTicketAmountJazz($eventId);
            break;
    }
    if($_POST['amount'] + $existingamount <= $maxamount){
        $amount = $_POST['amount'];
        $session->AddToCart($eventId,$TypeEvent,$amount);
        print 1;
    }
    else{
        print 0;
    }
}
?>