<?php

require_once("Autoloader.php");
/**
 * 
 */
class Session
{
	function __construct()
	{
		if(!isset($_SESSION)) {
			session_start();
		}
	}

	// add 'normal' tickets to cart
	function AddToCart($eventId, $typeEvent, $amount) {
		if(!isset($_SESSION['Tickets'])) {
			$_SESSION['Tickets'] = array();
		}
		$allCartItems = EncryptionHelper::Decrypt($_SESSION['Tickets']);
		$newCartItems = array();
		$added = false;

		foreach ($allCartItems as $cartItem) {
			// check if ticket already exists in cart
			if ($eventId == $cartItem['EventId'] && $typeEvent == $cartItem['TypeEvent']) {
				// if so, update the amount of the ticket and add it back to array
				$cartItem['Amount'] = intval($cartItem['Amount']) + intval($amount);
				$newCartItems[] = $cartItem;
				$added = true;
			}
			else {
				$newCartItems[] = $cartItem;
			}
		}
		if(!$added){
			// if ticket wasn't added previously because it didn't exist yet, add it now
			$cartItem = array("EventId"=>$eventId,"TypeEvent"=>$typeEvent,"Amount"=>$amount);
			$newCartItems[] = $cartItem;
		}

		// clear and update tickets session
		$_SESSION['Tickets'] = null;
		$_SESSION['Tickets'] = EncryptionHelper::Encrypt($newCartItems);
	}

	function AddToCartFood($eventId, $childAmount, $adultAmount, $startTime, $date, $extraInfo) {
		$typeEvent = 1;
		if (!isset($_SESSION['Tickets'])) {
			$_SESSION['Tickets'] = array();
		}
		$allCartItems = EncryptionHelper::Decrypt($_SESSION['Tickets']);
		$newCartItems = array();
		$added = false;

		foreach ($allCartItems as $cartItem) {
			// check if reservation already exists in cart (eventId, startTime and date define if the cartItem already exists in current session)
			if ($eventId == $cartItem['EventId'] && $startTime == $cartItem['startTime'] && $date == $cartItem['Date']) {
				// reservation already exists in session, update the amount
				$cartItem['ChildAmount'] = intval($cartItem['ChildAmount']) + intval($childAmount);
				$cartItem['AdultAmount'] = intval($cartItem['AdultAmount']) + intval($adultAmount);
				$newCartItems[] = $cartItem;
				$added = true;
			}
			else {
				// if this cartItem does not equal the ticket being added, ignore it
				$newCartItems[] = $cartItem;
			}
		}
		if (!$added) {
			// if reservation wasn't added previously because it didn't exist yet, add it now
			$cartItem = array("EventId"=>$eventId, "TypeEvent"=>$typeEvent, "ChildAmount"=>$childAmount, "AdultAmount"=>$adultAmount, "StartTime"=>$startTime, "Date"=>$date, "ExtraInfo"=>$extraInfo);
			$newCartItems[] = $cartItem;
		}

		// clear and update tickets session
		$_SESSION['Tickets'] = null;
		$_SESSION['Tickets'] = EncryptionHelper::Encrypt($newCartItems);
	}

	function RemoveFromCart($eventId, $typeEvent){
		if(!isset($_SESSION['Tickets'])) {
			$_SESSION['Tickets'] = array();
		}
		$allCartItems = EncryptionHelper::Decrypt($_SESSION['Tickets']);
		$newCartItems = array();
		$removedAmount = 0;

		foreach ($allCartItems as $cartItem) {
			if ($eventId == $cartItem['EventId'] && $typeEvent == $cartItem['TypeEvent']){
				$removedAmount = $removedAmount + intval($cartItem['Amount']);
			}
			else {
				$newCartItems[] = $cartItem;
			}
		}

		$_SESSION['Tickets'] = null;
		$_SESSION['Tickets'] = EncryptionHelper::Encrypt($newCartItems);

		return $removedAmount;
	}

	function RemoveFromCartFood($eventId, $typeEvent, $amountType) {
		if (!isset($_SESSION['Tickets'])) {
			$_SESSION['Tickets'] = array();
		}
		$allCartItems = EncryptionHelper::Decrypt($_SESSION['Tickets']);
		$newCartItems = array();
		$removedAmount = 0;

		foreach ($allCartItems as $cartItem) {
			if ($eventId == $cartItem['EventId']) {
				// check what reservation type we're dealing with (child or normal) ...
				if ($cartItem["ChildAmount"] != '0') {
					// it's a childPrice reservation
					if ($amountType == 0) {
						$removedAmount = $removedAmount + intval($cartItem['ChildAmount']);
						$cartItem["ChildAmount"] = '0';
					}
				} 

				if ($cartItem["AdultAmount"] != '0') {
					// it's an adultPrice reservation
					if ($amountType == 1) {
						$removedAmount = $removedAmount + intval($cartItem['AdultAmount']);
						$cartItem["AdultAmount"] = '0';
					}
				}

				// check if both amounts are NULL, if so don't bother adding ticket back to session
				if ($cartItem['ChildAmount'] != '0' || $cartItem['AdultAmount'] != '0') {
					$newCartItems[] = $cartItem;
				}
			}
			else {
				$newCartItems[] = $cartItem;
			}
		}

		$_SESSION['Tickets'] = null;
		$_SESSION['Tickets'] = EncryptionHelper::Encrypt($newCartItems);

		return $removedAmount;
	}

	function CleanCart(){
		$_SESSION['Tickets'] = array();
	}
}
?>