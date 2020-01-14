<?php
require_once("Autoloader.php");
if(isset($_POST['eventId']) && isset($_POST['typeEvent']) && isset($_POST['amount']) && isset($_POST['childAmount']) && isset($_POST['adultAmount']) && isset($_POST['startTime']) && isset($_POST['date']) && isset($_POST['extraInfo'])) {
    // assign vars
    $session = new Session;
    $OrderRepository = new OrderRepository();
    $HistoricRepository = new HistoricRepository();
    
    // assign vars from post data
    $eventId = $_POST['eventId'];
    $TypeEvent = $_POST['typeEvent'];
    $amount = $_POST['amount'];
    $childAmount = $_POST['childAmount'];
    $adultAmount = $_POST['adultAmount'];

    $isFoodReservation = false;

    // create vars to be used
    $maxAmount = 0;
    $existingamount = 0;
    $existingChildAmount = 0;
    $existingAdultAmount = 0;

    if (($childAmount != 0 || $adultAmount != 0) && $amount == 0) {
        // food reservation is being added
        $isFoodReservation = true;
    }
    
    if(isset($_SESSION["Tickets"])){
        if ($isFoodReservation) {
            // calculate existing food amounts in session (in 'cart')
            foreach(EncryptionHelper::Decrypt($_SESSION["Tickets"]) as $item){
                if ($item["EventId"] == $eventId) {
                    $existingChildAmount = $item["childAmount"];
                    $existingAdultAmount = $item["adultAmount"];
                }
            }
        } else {
            // calculate existing amounts in session (in 'cart')
            foreach(EncryptionHelper::Decrypt($_SESSION["Tickets"]) as $item){
                if($item["EventId"] == $eventId){
                    $existingamount = $item["Amount"];
                }
            }
        }
    }

    // grab the 'max' amount allowed to be added (tickets left)
    switch ($TypeEvent) {
        case 1:
            $maxAmount = $OrderRepository->GetTicketAmountFood($eventId);
            break;
        case 2:
            $maxAmount = $OrderRepository->GetTicketAmountDance($eventId);
            break;
        case 3:
            $historic = $OrderRepository->GetTicketAmountHistoric($eventId);
            $maxAmount =  $historic['Amount'];

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
            $maxAmount = $OrderRepository->GetTicketAmountJazz($eventId);
            break;
    }

    // calculate if the tickets being added + the tickets already in cart don't exceed or are equal to the remaining tickets. Act accordingly
    if ($isFoodReservation) {
        // we're adding a food reservation, call different method ...
        if ($childAmount + $adultAmount + $existingChildAmount + $existingAdultAmount <= $maxAmount) {
            // not exceeding or equal to, add reservation to cart
            $session->AddToCartFood($eventId, $childAmount, $adultAmount, $_POST['startTime'], $_POST['date'], $_POST['extraInfo']);
            print 1;
        }
        else {
            print 0;
        }
    } else {
        // adding normal tickets ...
        if ($amount + $existingamount <= $maxAmount) {
            // not exceeding or equal to, add tickets to cart
            $session->AddToCart($eventId, $TypeEvent, $amount);
            print 1;
        }
        else {
            print 0;
        }
    }
}
?>