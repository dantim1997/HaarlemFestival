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
        $PaymentService = new PaymentService;
        $OrderRepository = new OrderRepository;
        $tickets = $OrderRepository->GetAllByOrderLine($orderId);
        foreach($tickets as $ticket){
            $PaymentService->UpdateTickets($ticket['Id']);
        }

        $customerInfo = $OrderRepository->GetAllCustomerInfo($orderId);
        $PayedTicketsDance = $OrderRepository->GetAllTicketInfoDance($orderId);
        $PayedTicketsFood = $OrderRepository->GetAllTicketInfoFood($orderId);
        $PayedTicketsJazz = $OrderRepository->GetAllTicketInfoJazz($orderId);
        $PayedTicketsTour = $OrderRepository->GetAllTicketInfoTour($orderId);
        $AllTickets = array_merge($PayedTicketsDance, $PayedTicketsJazz);
        $AllTickets = array_merge($AllTickets, $PayedTicketsFood);
        $AllTickets = array_merge($AllTickets, $PayedTicketsTour);
        $sendMail = new SendMail();
        $sendMail->SendCustomerMail($customerInfo, $AllTickets);
        
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