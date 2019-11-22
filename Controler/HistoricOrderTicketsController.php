<?php
	require_once( "Autoloader.php");
class HistoricOrderTicketsController 
{
	private $HistoricOrderTicketsModel;
	private $Session;
	private $Config;

	public function __construct($historicOrderTicketsModel){
		$this->HistoricOrderTicketsModel = $historicOrderTicketsModel;
		$this->Config = Config::getInstance();
		$this->DB_Helper = new DB_Helper;
	}
	
	//get config
	public function GetConfig(){
		return $this->Config;
	}

	public function GetTickets(){
		if (isset($_POST['day'])) {
			//Get all the session from the database matching the given filters
			$sessions = $this->DB_Helper->GetSessionsByFilters($_POST['language'], $_POST['day']);

			//send all output to be created into html code.
			$ticketInformation = array('normalTickets' => $this->BuildNormalTickets($sessions), 'familyTickets' => $this->BuildFamilyTickets($sessions), 'day' => date("l jS F, Y", strtotime($_POST['day'])));
			return $ticketInformation;
		}
	}

	public function BuildNormalTickets($sessions){
		$normalTickets = "<div class='normalTicketsLabels'>";

		//Add the text of each ticket
		foreach ($sessions as $session) {
			$normalTickets .= "<h5 class=ticket>".$session['Description']."</h5>";
		}

		$normalTickets .= "</div>";

		$normalTickets .= "<div class='normalTicketButtons'>";

		//Add buttons for each ticket
		foreach ($sessions as $session) {
			$normalTickets .= "<div class='ticketButtons'>	
								<button class='removeBTN' type='button' >-</button>
								<input class='ticketTxt' type='text' value='0'>
								<button class='addBTN' type='button'>+</button>
								<button class='addToCartBTN' type='button' onclick='ShowPopup()'></button>
							</div>";
		}

		$normalTickets .= "</div>";
		return $normalTickets;
	}

	public function BuildFamilyTickets($sessions){
		$normalTickets = "<div class='familyTicketsLabels'>";

		//Add the text of each ticket
		foreach ($sessions as $session) {
			$normalTickets .= "<h5 class=ticket>".str_replace("Tour", "Family ticket", $session['Description'])."</h5>";
		}

		$normalTickets .= "</div>";

		$normalTickets .= "<div class='familyTicketButtons'>";

		//Add buttons for each ticket
		foreach ($sessions as $session) {
			$normalTickets .= "<div class='ticketButtons'>	
								<button class='removeBTN' type='button' >-</button>
								<input class='ticketTxt' type='text' value='0'>
								<button class='addBTN' type='button'>+</button>
								<button class='addToCartBTN' type='button' onclick='ShowPopup()'></button>
							</div>";
		}

		$normalTickets .= "</div>";
		return $normalTickets;
	}
}

?>