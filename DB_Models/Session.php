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

	function AddToCart($eventId, $typeEvent){
		if(!isset($_SESSION['Tickets'])){
			$_SESSION['Tickets'] = array();
		}
		$allCartItems = $_SESSION['Tickets'];
		$newCartItems = array();
		$added = false;
		foreach ($allCartItems as $cartItem) {
			if($eventId == $cartItem['EventId'] && $typeEvent == $cartItem['TypeEvent']){
				$cartItem['Amount']++;
				$newCartItems[] = $cartItem;
				$added = true;
			}
			else{
				$newCartItems[] = $cartItem;
			}
		}
		if(!$added){
			$cartItem = array("EventId"=>$eventId,"TypeEvent"=>$typeEvent,"Amount"=>1);
			$newCartItems[] = $cartItem;
		}

		$_SESSION['Tickets'] = null;
		$_SESSION['Tickets'] = $newCartItems;
	}
}


?>