<?php

require_once("Autoloader.php");
/**
 * 
 */
class Session
{
	function __construct()
	{
		if(!isset($_SESSION)){
			session_start();
		}
	}

	function AddToCart($eventId, $typeEvent, $amount){
		if(!isset($_SESSION['Tickets'])){
			$_SESSION['Tickets'] = array();
		}
		$allCartItems = $_SESSION['Tickets'];
		$newCartItems = array();
		$added = false;
		foreach ($allCartItems as $cartItem) {
			// check if ticket already exists in cart
			if ($eventId == $cartItem['EventId'] && $typeEvent == $cartItem['TypeEvent']) {
				$cartItem['Amount'] = intval($cartItem['Amount']) + intval($amount);
				$newCartItems[] = $cartItem;
				$added = true;
			}
			else {
				$newCartItems[] = $cartItem;
			}
		}
		if(!$added){
			$cartItem = array("EventId"=>$eventId,"TypeEvent"=>$typeEvent,"Amount"=>$amount);
			$newCartItems[] = $cartItem;
		}

		$_SESSION['Tickets'] = null;
		$_SESSION['Tickets'] = $newCartItems;
	}

	function AddToCartFood($eventId, $childAmount, $adultAmount, $startTime, $date, $extraInfo) {
		$typeEvent = 1;
		if(!isset($_SESSION['Tickets'])){
			$_SESSION['Tickets'] = array();
		}
		$allCartItems = $_SESSION['Tickets'];
		$newCartItems = array();
		$added = false;
		foreach ($allCartItems as $cartItem) {
			// check if reservation already exists in cart (eventId, startTime and date define if the cartItem already exists in current session)
			if ($eventId == $cartItem['EventId'] && $startTime == $cartItem['StartTime'] && $date == $cartItem['Date']) {
				// reservation already exists in session
				$cartItem['ChildAmount'] = intval($cartItem['ChildAmount']) + intval($childAmount);
				$cartItem['AdultAmount'] = intval($cartItem['AdultAmount']) + intval($adultAmount);
				$cartItem['StartTime'] = $startTime;
				$cartItem['Date'] = $date;
				$cartItem['ExtraInfo'] = $extraInfo;
				$newCartItems[] = $cartItem;
				$added = true;
			}
			else {
				$newCartItems[] = $cartItem;
			}
		}
		if(!$added){
			$cartItem = array("EventId"=>$eventId, "TypeEvent"=>$typeEvent, "ChildAmount"=>$childAmount, "AdultAmount"=>$adultAmount, "Special"=>$special, "StartTime"=>$startTime, "Date"=>$date, "ExtraInfo"=>$extraInfo);
			$newCartItems[] = $cartItem;
		}

		$_SESSION['Tickets'] = null;
		$_SESSION['Tickets'] = $newCartItems;
	}

	function RemoveFromCart($eventId, $typeEvent){
		if(!isset($_SESSION['Tickets'])){
			$_SESSION['Tickets'] = array();
		}
		$allCartItems = $_SESSION['Tickets'];
		$newCartItems = array();
		$removedAmount = 0;

		foreach ($allCartItems as $cartItem) {
			if($eventId == $cartItem['EventId'] && $typeEvent == $cartItem['TypeEvent']){
				$removedAmount = $removedAmount + intval($cartItem['Amount']);
			}
			else{
				$newCartItems[] = $cartItem;

			}
		}
		$_SESSION['Tickets'] = null;
		$_SESSION['Tickets'] = $newCartItems;

		return $removedAmount;
	}
}
?>