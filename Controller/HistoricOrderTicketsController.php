
<?php
	require_once( "Autoloader.php");
class HistoricOrderTicketsController 
{
	private $HistoricOrderTicketsModel;
	private $Session;
	private $Config;
	private $NotAvailable = "";

	public function __construct($historicOrderTicketsModel){
		$this->HistoricOrderTicketsModel = $historicOrderTicketsModel;
		$this->Config = Config::getInstance();
		$this->HistoricRepository = new HistoricRepository;
		$this->OrderRepository = new OrderRepository;
	}
	
	//get config
	public function GetConfig(){
		return $this->Config;
	}
	public function GetTickets(){
		if (isset($_POST['day']) && isset($_POST['language'])) {
			//Get all the session from the database matching the given filters
			$normalTickets = $this->HistoricRepository->GetToursByFilters($_POST['language'], $_POST['day'], "Normal");
			$familyTickets = $this->HistoricRepository->GetToursByFilters($_POST['language'], $_POST['day'], "Family");
			
			//Filling the arays with objects with database data
			$normalTours = array();
			foreach ($normalTickets as $tour) {
				array_push($normalTours, new HistoricTours($tour['Id'], $tour['Language'], $tour['Description'], $tour['StartDateTime'], $tour['EndDateTime'], $tour['Price'], $tour['TypeTicket'], $tour['ReferenceId'], $tour['Amount']));
			}

			$familyTours = array();
			foreach ($familyTickets as $tour) {
				array_push($familyTours, new HistoricTours($tour['Id'], $tour['Language'], $tour['Description'], $tour['StartDateTime'], $tour['EndDateTime'], $tour['Price'], $tour['TypeTicket'], $tour['ReferenceId'], $tour['Amount']));
			}

			//send all output to be created into html code.normalTours
			$ticketInformation = array('normalTickets' => $this->BuildNormalTickets($normalTours), 'familyTickets' => $this->BuildFamilyTickets($familyTours), 'day' => date("l jS F, Y", strtotime($_POST['day'])), 'NotAvailable' => $this->UnavailableTickets());
			return $ticketInformation;					
		}
	}

	public function BuildNormalTickets($tours){
		$normalTickets = "<div class='normalTicketsLabels'>";
		//Add the text of each ticket.
		foreach ($tours as $tour) {
			if ($this->OrderRepository->GetTicketAmountHistoric($tour->Id)['Amount'] >= 1) {
				$normalTickets .= "<h5 class=ticket>".$tour->Language." Tour, ".date('H', $tour->StartDateTime)." - ".$tour->EndDateTime."</h5>";
			}
			else{
				$this->NotAvailable .= "<br> - ".$tour->Description."</li>";
			}
		}
		$normalTickets .= "</div>";
		$normalTickets .= "<div class='normalTicketButtons'>";

		//create a count so each amount box can be uniquely identified by the javascript.
		$count = 1;
		//Add buttons for each ticket
		foreach ($tours as $tour) {
			//Check for available tickets
			if ($this->OrderRepository->GetTicketAmountHistoric($tour->Id)['Amount'] >= 1) {
				$normalTickets .= "<div class='ticketButtons'>
					<button class='removeBTN' type='button' onclick='cartAmountMinus(".$count.")'>-</button>
					<input class='ticketTxt' type='text' value='1' id='amountNumber".$count."'>
					<button class='addBTN' type='button' onclick='cartAmountPlus(".$count.")'>+</button>
					<button class='addToCartBTN' type='button' onclick='AddToCart(".$tour->Id.", 3, GetTicketAmount(".$count."))'></button>
				</div>";
				$count++;
			}
		}
		$normalTickets .= "</div>";
		return $normalTickets;
	}
	public function BuildFamilyTickets($tours){
		$familyTickets = "<div class='familyTicketsLabels'>";

		//create a count so each amount box can be uniquely identified by the javascript.
		$count = 4;
		//Add the text of each ticket
		foreach ($tours as $tour) {
			if ($this->OrderRepository->GetTicketAmountHistoric($tour->Id)['Amount'] >= 4) {
				$familyTickets .= "<h5 class=ticket>".$tour->Description."</h5>";
			}
			else{
				$this->NotAvailable .= "<br> - ".$tour->Description."<br>";
			}
		}
		$familyTickets .= "</div>";
		$familyTickets .= "<div class='familyTicketButtons'>";


		//Add buttons for each ticket
		foreach ($tours as $tour) {
			if ($this->OrderRepository->GetTicketAmountHistoric($tour->Id)['Amount'] >= 4) {
				$familyTickets .= "<div class='ticketButtons'>	
									<button class='removeBTN' type='button' onclick='cartAmountMinus(".$count.")'>-</button>
									<input class='ticketTxt' type='text' value='1' id='amountNumber".$count."'>
									<button class='addBTN' type='button' onclick='cartAmountPlus(".$count.")'>+</button>
									<button class='addToCartBTN' type='button' onclick='AddToCart(".$tour->Id.", 3, GetTicketAmount(".$count."))'></button>
								</div>";
				$count++;
			}
		}
		$familyTickets .= "</div>";
		return $familyTickets;
	}

	public function UnavailableTickets(){
		if (!empty($this->NotAvailable)) {
			$temp = "The following tickets are sold out:" . $this->NotAvailable;
			$this->NotAvailable = $temp;
		}
		return $this->NotAvailable;
	}
}
?>

