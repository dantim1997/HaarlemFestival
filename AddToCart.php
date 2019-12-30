<?php
require_once("Autoloader.php");
if(isset($_POST['eventId']) && isset($_POST['typeEvent']) && isset($_POST['amount'])) {
    $eventId = $_POST['eventId'];
    $TypeEvent = $_POST['typeEvent'];

    $session = new Session;
    $DB_Helper = new DB_Helper();
    $existingamount = 0;
    $maxamount = 0;
    $amount = $_POST['amount'];
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
            $historic = $DB_Helper->GetAmountHistoric($eventId);
            $maxamount =  $historic['Amount'];

            $familyTourByReferenceId = $DB_Helper->GetToursByReferenceId($eventId);

            if ($historic['Type'] == 'Family') {
                $amount = $amount * 4;
            }    
            foreach($_SESSION["Tickets"] as $item){
                if ($familyTourByReferenceId == $item["EventId"]) {
                    $existingamount += $item['Amount']; 
                }
                if ($historic['ReferenceId']  != 0 && $item["EventId"] == $historic['ReferenceId']) {
                    $existingamount += $item["Amount"];
                }
            }
            break;
        case 4:
            $maxamount = $DB_Helper->GetTicketAmountJazz($eventId);
            break;
    }
    if($amount + $existingamount <= $maxamount){
        $session->AddToCart($eventId,$TypeEvent,$amount);
        print 1;
    }
    else{
        print 0;
    }
}
?>