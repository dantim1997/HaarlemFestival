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

	function AddToCart($eventId, $typeEvent, $amount, $special){
		if(!isset($_SESSION['Tickets'])){
			$_SESSION['Tickets'] = array();
		}
		$allCartItems = $_SESSION['Tickets'];
		$newCartItems = array();
		$added = false;
		foreach ($allCartItems as $cartItem) {
			if($eventId == $cartItem['EventId'] && $typeEvent == $cartItem['TypeEvent']){
				$cartItem['Amount'] = intval($cartItem['Amount']) + intval($amount);
				$cartItem['Special'] = $special;
				$newCartItems[] = $cartItem;
				$added = true;
			}
			else{
				$newCartItems[] = $cartItem;
			}
		}
		if(!$added){
			$cartItem = array("EventId"=>$eventId,"TypeEvent"=>$typeEvent,"Amount"=>$amount, "Special"=>$special);
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