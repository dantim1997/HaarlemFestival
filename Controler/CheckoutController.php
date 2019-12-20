<?php
	require_once( "Autoloader.php");
class CheckoutController 
{
	private $CheckoutModel;
	private $Session;
	private $Config;

	public $SortedDays = array();

	public function __construct($checkoutModel){
		$this->CheckoutModel = $checkoutModel;
		$this->Config = Config::getInstance();
		$this->DB_Helper = new DB_Helper;
		$this->Session = new Session;
		$this->ProceedToPayment();
	}

	public function ProceedToPayment()
	{
		$errorList = array(
			"FirstName" => "",
			"LastName" => "",
			"Email" => "",
			"Adress" => "",
			"Date" => "",
		);
		if(isset($_POST['proceedToPaymentBTN'])){
			
			$errorList["FirstName"] = $this->IsRequired("FirstName", "text");
			$errorList["LastName"] = $this->IsRequired("LastName", "text");
			$errorList["Email"] = $this->IsRequired("Email", "text");
			$errorList["PostCode"] = $this->IsRequired("PostCode", "postalCode");
			$errorList["Number"] = $this->IsRequired("HouseNumber", "number");
			$errorList["Street"] = $this->IsRequired("Street", "text");
			$makeOrder = new MakeOrder();
			$makeOrder->Order($_POST, $_SESSION["Tickets"]);
		}
	}

	public function IsRequired($name, $Type)
	{
		if( $_POST[$name] == Null || $_POST[$name] == ""){
			return "Field is required";
		}
		if($Type == "Email"){

		}
		if($Type == "postalCode"){
			
		}
		return "";
	}
	
	//get config
	public function GetConfig(){
		return $this->Config;
	}

	public function GetAllItems(){
		
		$ticketRows = "";

		if (isset($_SESSION["Tickets"])) {
			$items = $_SESSION["Tickets"];
			foreach ($items as $item) {
				$this->GetItems($item["EventId"], $item["TypeEvent"], $item["Amount"], '', $item["ExtraInfo"] = "");
			}
			foreach ($this->CheckoutModel->GetSortedDays() as $key => $day) {
				$SetDate = date('Y-m-d', strtotime($key));
				$daynumber = date('d', strtotime($key));
				$dayname = date('l', strtotime($SetDate));
				$ticketRows .= "
				<div class='".$key."'>
				<h3 id='daylbl'>".$dayname." Juli ".$daynumber."th (".$SetDate.")</h3>
					<div class='blackBar'></div>
					<div class='tickets'>". $day."</div>
				</div>";
			}
		}
		if($ticketRows == ""){
			$ticketRows = "<div class='Empty'><h3>You dont have any items in your shopping cart</h3></div>";
		}

		return $ticketRows;
	}

	public function GetItems($eventId, $typeEvent, $amount, $special, $extraInfo){
		$sortedDays = $this->CheckoutModel->GetSortedDays();
		switch ($typeEvent) {
			case 1:
				if ($special == 0) {
					$eventInfo = $this->DB_Helper->GetEventInfoFood($eventId, "ChildPrice");
				} else {
					$eventInfo = $this->DB_Helper->GetEventInfoFood($eventId, "NormalPrice");
				}
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

		$eventDate = date('Y-m-d', strtotime($eventInfo["StartDateTime"]));
		if(!array_key_exists($eventDate ,$sortedDays)){
			$sortedDays[$eventDate] = "";
		}

		$this->CheckoutModel->AddTotal(intval($eventInfo["Price"]) * intval( $amount));
		$sortedDays[$eventDate] .= "<div class=ticket>
			<p class=amountTickets>".$amount." x</p>
			<p class='ticketText'>".$eventInfo["Venue"]." ".$eventInfo["About"]." ".$eventInfo["Description"]." ".$this->IsTimeEmtpy($startTime,$endTime)."  € ".Number_format($eventInfo["Price"], 2, ',', ' ')."</p>
					<input class='removeCheckoutItem' onclick='RemoveFromCart(this,".$eventId.",".$typeEvent.",".$eventInfo["Price"].")' type='submit' value='&#10006' name='??????'>
		</div>";

		// show allergies/special needs when given
		if (!empty($extraInfo)) {
			$sortedDays[$eventDate] .= "<p>Given allergies and/or special needs: ".$extraInfo."</p>";
		}
		$this->CheckoutModel->SetSortedDays($sortedDays);
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