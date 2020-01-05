<?php
require_once("Autoloader.php");
if(isset($_POST['eventId']) && isset($_POST['typeEvent']) && isset($_POST['amount']) && isset($_POST['childAmount']) && isset($_POST['adultAmount']) && isset($_POST['startTime']) && isset($_POST['date']) && isset($_POST['extraInfo'])) {
    $eventId = $_POST['eventId'];
    $TypeEvent = $_POST['typeEvent'];

    $session = new Session;
    $DB_Helper = new DB_Helper();
    $maxamount = 0;

    $isFoodReservation = false;

    $amount = $_POST['amount'];
    $childAmount = $_POST['childAmount'];
    $adultAmount = $_POST['adultAmount'];
    
    if (($childAmount != 0 || $adultAmount != 0) && $amount == 0) {
        // food reservation is being added
        $isFoodReservation = true;

        $existingChildAmount = 0;
        $existingAdultAmount = 0;

        foreach ($_SESSION["Tickets"] as $item) {
            if ($item["EventId"] == $eventId) {
                $existingChildAmount = $item["ChildAmount"];
                $existingAdultAmount = $item["AdultAmount"];
            }
        }
    } else {
        // normal ticket is being added
        $existingamount = 0;
        
        foreach ($_SESSION["Tickets"] as $item) {
            if ($item["EventId"] == $eventId) {
                $existingamount = $item["Amount"];
            }
        }
    }

    switch ($TypeEvent) {
        case 1:
            $maxamount = $DB_Helper->GetTicketAmountFood($eventId);
            break;
        case 2:
            $maxamount = $DB_Helper->GetTicketAmountDance($eventId);
            break;
        case 3:
            $historic = $DB_Helper->GetAmountHistoric($eventId);
            $maxamount =  $historic['Amount'];

            $familyTourByReferenceId = $DB_Helper->GetToursByReferenceId($eventId);

            if ($historic['Type'] == 'Family') {
                $amount = $amount * 4;
            }
            
            foreach($_SESSION["Tickets"] as $item) {
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

    if ($isFoodReservation) {
        // we're adding a foodreservation, call different method ...
        if ($childAmount + $adultAmount <= $maxamount) {
            $session->AddToCartFood($eventId, $childAmount, $adultAmount, $_POST['startTime'], $_POST['date'], $_POST['extraInfo']);
            print 1;
        }
        else {
            print 0;
        }
    } else {
        // adding normal reservation ...
        if ($amount + $existingamount <= $maxamount) {
            $session->AddToCart($eventId, $TypeEvent, $amount);
            print 1;
        }
        else {
            print 0;
        }
    }
}
?>