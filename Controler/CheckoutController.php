<?php
	require_once( "Autoloader.php");
class CheckoutController 
{
	private $CheckoutModel;
	private $Session;
	private $Config;

	public function __construct($checkoutModel){
		$this->CheckoutModel = $checkoutModel;
		$this->Config = Config::getInstance();
		$this->DB_Helper = new DB_Helper;
	}
	
	//get config
	public function GetConfig(){
		return $this->Config;
	}

	public function GetAllItems(){
		$this->Session = new Session;

		$ticketRows = "";

		if (isset($_SESSION["Tickets"])) {
			$items = $_SESSION["Tickets"];
			foreach ($items as $item) {
				$ticketRows .=$this->GetItems($item["EventId"],$item["TypeEvent"],$item["Amount"]);
			}
		}
		return $ticketRows;
	}

	public function GetItems($eventId, $typeEvent,$amount){
		switch ($typeEvent) {
			case 1:
				$eventInfo = $this->DB_Helper->GetEventInfoFood($eventId);
				break;
			case 2:
				$eventInfo = $this->DB_Helper->GetEventInfoDance($eventId);
				break;
			case 3:
				$eventInfo = $this->DB_Helper->GetEventInfoHistoric($eventId);
				break;
			case 4:
				$eventInfo = $this->DB_Helper->GetEventInfoJazz($eventId);
				break;
		}
		$startTime = date("H:i",strtotime($eventInfo["StartDateTime"]));
		$endTime = date("H:i",strtotime($eventInfo["EndDateTime"]));
		return "<div class=ticket>
			<p class=amountTickets>".$amount." x</p>
			<p class='ticketText'>".$eventInfo["Venue"]." ".$eventInfo["About"]." ".$eventInfo["Description"]." ".$this->IsTimeEmtpy($startTime,$endTime)."  € ".$eventInfo["Price"].",-</p>
					<input class='removeCheckoutItem' onclick='RemoveFromCart(this,".$eventId.",".$typeEvent.")' type='submit' value='&#10006' name='??????'>
		</div>";
	}

	public function IsTimeEmtpy($startTime,$endTime){
		if($startTime == "00:00"){
			return "";
		}
		else{
			return "(".$startTime." - ".$endTime.")";
		}
	}
}

?>