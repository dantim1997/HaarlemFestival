<?php
require_once("Autoloader.php");
if(isset($_POST['eventId']) && isset($_POST['typeEvent']) && isset($_POST['amount']) && isset($_POST['childAmount']) && isset($_POST['adultAmount']) && isset($_POST['startTime']) && isset($_POST['date']) && isset($_POST['extraInfo'])) {
    $eventId = $_POST['eventId'];
    $TypeEvent = $_POST['typeEvent'];

    $session = new Session;
    $OrderRepository = new OrderRepository();
    $HistoricRepository = new HistoricRepository();
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

        foreach(EncryptionHelper::Decrypt($_SESSION["Tickets"]) as $item){
            if ($item["EventId"] == $eventId) {
                $existingChildAmount = $item["ChildAmount"];
                $existingAdultAmount = $item["AdultAmount"];
            }
        }
    } else {
        // normal ticket is being added
        $existingamount = 0;
        
        foreach(EncryptionHelper::Decrypt($_SESSION["Tickets"]) as $item){
            if($item["EventId"] == $eventId){
                $existingamount = $item["Amount"];
            }
        }
    }

    switch ($TypeEvent) {
        case 1:
            $maxamount = $OrderRepository->GetTicketAmountFood($eventId);
            break;
        case 2:
            $maxamount = $OrderRepository->GetTicketAmountDance($eventId);
            break;
        case 3:
            $historic = $OrderRepository->GetTicketAmountHistoric($eventId);
            $maxamount =  $historic['Amount'];

            $familyTourByReferenceId = $HistoricRepository->GetToursByReferenceId($eventId);

            if ($historic['Type'] == 'Family') {
                $amount = $amount * 4;
            }    
            foreach(EncryptionHelper::Decrypt($_SESSION["Tickets"]) as $item) {
                if ($familyTourByReferenceId == $item["EventId"]) {
                    $existingamount += $item['Amount']; 
                }
                if ($historic['ReferenceId']  != 0 && $item["EventId"] == $historic['ReferenceId']) {
                    $existingamount += $item["Amount"];
                }
            }
            break;
        case 4:
            $maxamount = $OrderRepository->GetTicketAmountJazz($eventId);
            break;
    }

    if ($isFoodReservation) {
        // we're adding a foodreservation, call different method ...
        if ($childAmount + $adultAmount + $existingChildAmount + $existingAdultAmount <= $maxamount) {
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