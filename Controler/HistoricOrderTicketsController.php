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
			$toursArray = $this->DB_Helper->GetToursByFilters($_POST['language'], $_POST['day']);
			
			$tours = array();
			foreach ($toursArray as $tour) {
				array_push($tours, new HistoricTours($tour['Id'], $tour['Language'], $tour['Description'], $tour['StartDateTime'], $tour['EndDateTime'], $tour['Price']));
			}

			//send all output to be created into html code.
			$ticketInformation = array('normalTickets' => $this->BuildNormalTickets($tours), 'familyTickets' => $this->BuildFamilyTickets($tours), 'day' => date("l jS F, Y", strtotime($_POST['day'])));
			return $ticketInformation;					
		}
	}

	public function BuildNormalTickets($tours){
		$normalTickets = "<div class='normalTicketsLabels'>";

		//Add the text of each ticket
		foreach ($tours as $tour) {
			$normalTickets .= "<h5 class=ticket>".$tour->Description."</h5>";
		}

		$normalTickets .= "</div>";

		$normalTickets .= "<div class='normalTicketButtons'>";

		//Add buttons for each ticket
		foreach ($tours as $tour) {
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

	public function BuildFamilyTickets($tours){
		$normalTickets = "<div class='familyTicketsLabels'>";

		//Add the text of each ticket
		foreach ($tours as $tour) {
			$normalTickets .= "<h5 class=ticket>".str_replace("Tour", "Family ticket", $tour->Description)."</h5>";
		}

		$normalTickets .= "</div>";

		$normalTickets .= "<div class='familyTicketButtons'>";

		//Add buttons for each ticket
		foreach ($tours as $tour) {
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