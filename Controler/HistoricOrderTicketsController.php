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
			$normalTickets = $this->DB_Helper->GetToursByFilters($_POST['language'], $_POST['day'], "Normal");
			$familyTickets = $this->DB_Helper->GetToursByFilters($_POST['language'], $_POST['day'], "Family");
			
			$normalTours = array();
			foreach ($normalTickets as $tour) {
				array_push($normalTours, new HistoricTours($tour['Id'], $tour['Language'], $tour['Description'], $tour['StartDateTime'], $tour['EndDateTime'], $tour['Price'], $tour['TypeTicket']));
			}

			$familyTours = array();
			foreach ($familyTickets as $tour) {
				array_push($familyTours, new HistoricTours($tour['Id'], $tour['Language'], $tour['Description'], $tour['StartDateTime'], $tour['EndDateTime'], $tour['Price'], $tour['TypeTicket']));
			}

			//send all output to be created into html code.normalTours
			$ticketInformation = array('normalTickets' => $this->BuildNormalTickets($normalTours), 'familyTickets' => $this->BuildFamilyTickets($familyTours), 'day' => date("l jS F, Y", strtotime($_POST['day'])));
			return $ticketInformation;					
		}
	}

	public function BuildNormalTickets($tours){
		$normalTickets = "<div class='normalTicketsLabels'>";

		//Add the text of each ticket.
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
								<button class='addToCartBTN' type='button' onclick='ShowPopup();ShoppingCartPlus()'></button>
							</div>";
		}

		$normalTickets .= "</div>";
		return $normalTickets;
	}

	public function BuildFamilyTickets($tours){
		$familyTickets = "<div class='familyTicketsLabels'>";

		//Add the text of each ticket
		foreach ($tours as $tour) {
			$familyTickets .= "<h5 class=ticket>".$tour->Description."</h5>";
		}

		$familyTickets .= "</div>";

		$familyTickets .= "<div class='familyTicketButtons'>";

		//Add buttons for each ticket
		foreach ($tours as $tour) {
			$familyTickets .= "<div class='ticketButtons'>	
								<button class='removeBTN' type='button' >-</button>
								<input class='ticketTxt' type='text' value='0'>
								<button class='addBTN' type='button'>+</button>
								<button class='addToCartBTN' type='button' onclick='ShowPopup();ShoppingCartPlus()'></button>
							</div>";
		}

		$familyTickets .= "</div>";
		return $familyTickets;
	}
}

?>