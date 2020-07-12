<?php
require_once("Autoloader.php");

class JazzController 
{
	private $JazzModel;
	private $JazzView;
	private $Config;
	private $genres;
	private $artists;
	public $days;

	public function __construct($jazzModel){
		$this->JazzModel = $jazzModel;
		$this->JazzView = new JazzView;
		$this->Config = Config::getInstance();
		$this->JazzRepository = new JazzRepository;
		$this->SetEventDates();
	}
	
	//get config
	public function GetConfig(){
		return $this->Config;
	}

	//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	//////													CAROUSEL													//////
	//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

	//get filter for genre search
	public function MakeGenreAdvancedSearch(){
		$this->genres = $this->JazzRepository->GetGenresJazz();
		foreach ($this->genres as $genre) {
			//Create genre filters
			$artistsSearchlist .= $this->JazzView->FilterInputBox($genre->getGenre());
		}
		return $artistsSearchlist;
	}

	//Get Carousel
	public function MakeCarousel(){
		$isFirst = true;

		//Check if filter is set
		if(isset($_GET['GenreCheckbox']))
		{
			//Create SQL string		
		   	foreach ($_GET['GenreCheckbox'] as $genreCheckbox ) 
			{
		   		if(!$isFirst){
					//Add "OR" to the mysql parameter for combining the select results
		   			$searchStringGenre .= " OR ";
				}
		   		$searchStringGenre .= "n.Genre LIKE '%".$genreCheckbox."%'";
				$isFirst = false;
			}
		}
		return $this->GetArtistsCarousel($searchStringGenre);
	}

	//Get all artist cards
	private function GetArtistsCarousel($filter = null){
		//Get DB results based on the filter
		$this->artists = $this->JazzRepository->GetArtistsJazz($filter);
		return $this->JazzView->Carousel($this->artists);
	}

	//define genre
	public function DefineStyleGenre($genre){
		//Check which css class must be returned
		switch ($genre) {
			case "Blues":
				return "genre1";
				break;
			case "Ragtime":
				return "genre2";
				break;
			case "Classic":
				return "genre3";
				break;
			case "Jazz Rock":
				return "genre4";
				break;
			default:
				return "genre0";
		}
	}

	//check if image is set
	public function CheckImageIsSet($image){
		//If image is not set, set a default image
		if (empty($image)){
			return "http://hfteam3.infhaarlem.nl/cms/Images/Jazz/unset.gif";
		}
		else{
			return $image;
		}
	}

	//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	//////													PROGRAMME													//////
	//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

	//Make programme table
	public function GetProgramme(){
		//Get header (dates) of table
		$programme = $this->GetTableHeader();

		//get times (first column)
		$times = $this->JazzRepository->GetTimesJazz();

		//collect all times (start and end date) and convert to a time format
		foreach ($times as $time) {
			$timeBegin = date("H:i", strtotime($time->getStartDateTime()));
			$newTimeBegin[] = $timeBegin;
			
			$timeEnd = date("H:i", strtotime($time->getEndDateTime()));
			$newTimeEnd[] = $timeEnd;
		}

		//create rows
		$programme .= $this->JazzView->TimeTableRows($newTimeBegin, $newTimeEnd, $this->days);
		return $programme;
	}

	//Get dates for programme table
	private function GetTableHeader(){
		$dates = $this->JazzRepository->GetDatesJazz();
		$newdates = array();
		foreach ($dates as $date) {
			$tempdate = date("l - d F", strtotime($date->getStartDateTime()));
			$newdates[] = $tempdate;
		}
		
		return $this->JazzView->TimeTableHeader($newdates);
	}

	//Get artist/band name for programme table
	public function GetArtistForProgramme($datetime){
		$artistnames = $this->JazzRepository->GetArtistName($datetime);
		if (!empty($artistnames)){
			foreach ($artistnames as $artistname) {
				if ($counter >= 2){
					$output .= $this->JazzView->TimeTableSplit();
				}
				$output .= $artistname;
				$counter++;
			}
			return $output;
		}
		return null;
	}

	//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	//////													TICKETS 													//////
	//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

	//get tickets for event day
	public function FillTickets($date){
		$date .= "%";
		$tickets = $this->JazzRepository->GetTicketsJazz($date);
		foreach ($tickets as $ticket) {
			$starttime = strtotime($ticket["StartDateTime"]);
			$endtime = strtotime($ticket["EndDateTime"]);

			//Check if entry is free
			if ($ticket["Price"] == "0.00"){
				$ticketsTable .= "
				".date("H:i", $starttime)." - ".date("H:i", $endtime)."&nbsp;&nbsp;".$ticket["Name"]."<hr>
				";
			}
			//Check if ticket is an all access pass
			elseif (strpos($ticket["Name"], 'All Access') !== false){
				$ticketsTable .= "
				".$ticket["Name"]."&nbsp;&nbsp;&nbsp;&nbsp;<aside class='price' id='pricespec'>€".$ticket["Price"]."</aside><hr>
				";
			}
			//Else show a normal ticket
			else{
				$ticketsTable .= "
				".date("H:i", $starttime)." - ".date("H:i", $endtime)."&nbsp;&nbsp;".$ticket["Hall"]."&nbsp;&nbsp; <aside id='artistTicket'>".$ticket["Name"]."</aside><aside class='price'>€".$ticket["Price"]."</aside><hr>
				";
			}
		}
		return $ticketsTable;
	}

	//Get all tickets for jazz
	public function GetOrderForm($date){
		$date .= "%";
		$tickets = $this->JazzRepository->GetTicketsJazz($date);

		//Create input [Add/Remove/Input]
		foreach ($tickets as $ticket => $info) {
			$addtocart .= "
			<button onclick='ShoppingCartMinJazz(".$info["ID"].")'>-</button>
			<input type='text' value='0' id='".$info["ID"]."'>
			<button onclick='ShoppingCartPlusJazz(".$info["ID"].")'>+</button>
			<br>
			";
		}
		return $addtocart;
	}

	//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	//////													LOCATION													//////
	//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

	//Get event location of each day
	public function GetLocation($date){
		$date .= "%";
		$location = $this->JazzRepository->GetLocationsJazz($date);
		$output = "<h2>Location<h2>
		<p class='location'>".$location["Name"]."<br>".$location["Adress"]."<br>".$location["Zipcode"]." ".$location["City"]."<br>".$this->GetLocationInfo($location["InfoEnglish"],$location["InfoDutch"])."</p>
		<iframe class='googlemaps' src='".$location["GoogleMaps"]."' frameborder='0' style='border:0;' allowfullscreen=''></iframe>
		";
		return $output;
	}

	//Get extra info for location
	private function GetLocationInfo($infoE, $infoD){
		if (isset($_SESSION['Language'])){
			if (EncryptionHelper::Decrypt($_SESSION['Language']) == "Dutch"){
				return $infoD;
			}
			else {
				return $infoE;
			}
		}
		else{
			return $infoE;
		}
	}

	//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	//////													OTHERS	 													//////
	//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

	//Get Dates for JazzView
	public function SetEventDates(){
		$this->days = $this->JazzRepository->GetEventDates();
	}
}
?>
