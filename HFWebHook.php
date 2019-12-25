<?php
require_once( "Autoloader.php");
require_once ("mollie/vendor/autoload.php");
require_once ("mollie/examples/functions.php");


$Config = Config::getInstance();
$mollie = new \Mollie\Api\MollieApiClient();
$mollie->setApiKey($Config->GetMollieKey());

    $payment = $mollie->payments->get($_POST["id"]);
    $orderId = $payment->metadata;
    /*
    * Update the order in the database.
    */
    //database_write($orderId, $payment->status);
    if ($payment->isPaid() && !$payment->hasRefunds() && !$payment->hasChargebacks()) {
        /*
        * The payment is paid and isn't refunded or charged back.
        * At this point you'd probably want to start the process of delivering the product to the customer.
        */
		$Session = new Session;
        $DB_Helper = new DB_Helper;
        $tickets = $DB_Helper->GetAllByOrderLine($orderId);
        foreach($tickets as $ticket){
            $DB_Helper->UpdateTickets($ticket['Id']);
        }

        $customerInfo = $DB_Helper->GetAllCustomerInfo($orderId);
        $PayedTicketsDance = $DB_Helper->GetAllTicketInfoDance($orderId);
        $PayedTicketsFood = $DB_Helper->GetAllTicketInfoFood($orderId);
        $PayedTicketsJazz = $DB_Helper->GetAllTicketInfoJazz($orderId);
        $PayedTicketsTour = $DB_Helper->GetAllTicketInfoTour($orderId);
        $AllTickets = array_merge($PayedTicketsDance, $PayedTicketsJazz);
        $AllTickets = array_merge($AllTickets, $PayedTicketsFood);
        $AllTickets = array_merge($AllTickets, $PayedTicketsTour);
        $sendMail = new SendMail();
        $sendMail->SendCustomerMail($customerInfo, $AllTickets);
        $Session->CleanCart();
    } elseif ($payment->isOpen()) {
        /*
         * The payment is open.
         */
    } elseif ($payment->isPending()) {
        /*
         * The payment is pending.
         */
    } elseif ($payment->isFailed()) {
        /*
         * The payment has failed.
         */
    } elseif ($payment->isExpired()) {
        /*
         * The payment is expired.
         */
    } elseif ($payment->isCanceled()) {
        /*
         * The payment has been canceled.
         */
    } elseif ($payment->hasRefunds()) {
        /*
         * The payment has been (partially) refunded.
         * The status of the payment is still "paid"
         */
    } elseif ($payment->hasChargebacks()) {
        /*
         * The payment has been (partially) charged back.
         * The status of the payment is still "paid"
         */
    }