<?php
require_once( "Autoloader.php");
class JazzController 
{
	private $JazzModel;
	private $Session;
	private $Config;

	public function __construct($jazzModel){
		$this->JazzModel = $jazzModel;
		$this->Config = Config::getInstance();
		$this->JazzRepository = new JazzRepository;
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
		$genres = $this->JazzRepository->GetGenresJazz();
		$artistsSearchlist = "";
		foreach ($genres as $genre) {
			//Create genre filters
			$artistsSearchlist .= "<input class='checkbox' type='checkbox' name='GenreCheckbox[]' value=".$genre["Genre"]."><label>".$genre["Genre"]."</label><br/>";
		}
		return $artistsSearchlist;
	}

	//Get Carousel
	public function MakeCarousel(){
		$first = true;

		//Check if filter is set
		if(isset($_GET['GenreCheckbox']))
		{
		   foreach ($_GET['GenreCheckbox'] as $genreCheckbox ) 
			{
		   		if(!$first){
					//Add "OR" to the mysql parameter for combining the select results
		   			$searchStringGenre .= " OR ";
				}
		   		$searchStringGenre .= "n.Genre LIKE '%".$genreCheckbox."%'";
				$first = false;
			}
		}
		$output = $this->GetArtistsCarousel($searchStringGenre);
		return $output;
	}

	//Get Artists
	private function GetArtistsCarousel($filter = null){
		//Get DB results based on the filter
		$artists = $this->JazzRepository->GetArtistsJazz($filter);
		$first = true;
		foreach ($artists as $artist) {
			$counter++;
			//If is first item add div header
			if ($first){
				$carousel .= "<div class='carousel-item active'><div class='artists'>";
			}
			//else add normal item
			else if ($counter == 1 && !$first){
				$carousel .= "<div class='carousel-item'><div class='artists'>";
			}
			$first = false;
			$carousel .= "<div class='artist'>
							<div class='artistname'>".$artist["Name"]."</div>
							<div class='artistcontainer'>
								<image class='artistimage' src='".$this->CheckImageIsSet($artist["Image"])."'>
								<div class='".$this->DefineGenre($artist["Genre"])."'>".$artist["Genre"]."</div>
								<div class='genre0'>0</div></div></div>";
			//Close artist section (1 row = 4 columns)
			if ($counter == 4){
				$counter = 0;
				$carousel .= "</div></div>";
			}
		}
		$check = $counter % 4;
		//Close div section if items are not 0 (prevents empty slide)
		if ($check != 0){
			$carousel .= "</div></div>";
		}
		return $carousel;
	}

	//define genre
	private function DefineGenre($genre){
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
	private function CheckImageIsSet($image){
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
		$output = $this->GetDates();

		//get times (first column)
		$time = $this->JazzRepository->GetTimesJazz();

		//collect all times (start and end date)
		foreach ($time as $time) {
			$timeBegin = date("H:i", strtotime($time["StartDateTime"]));
			$newTimeBegin[] = $timeBegin;
			
			$timeEnd = date("H:i", strtotime($time["EndDateTime"]));
			$newTimEend[] = $timeEnd;
		}
		
		//Get event days and set variables
		$days = $this->GetEventDates();

		//create rows
		for($i=0; $i < count($newTimeBegin); $i++) {
			$time = $newTimeBegin[$i];
			$output .= "<tr><td class='tg-6jhs'>".$newTimeBegin[$i]." - ".$newTimEend[$i]."</td>";
			//Add rows foreach day
			for ($counter=0; $counter < count($days); $counter++) { 
				$day = $days[$counter]["Dates"]; 
				$day = date('Y-m-d H:i:s', strtotime($day." $time"));
				$output .= "<td class='tg-m4n1'>".$this->GetArtistForProgramme($day)."</td>";
			}
			$output .= "<tr>";
		}
		return $output;
	}

	//Get dates for programme table
	private function GetDates(){
		$date = $this->JazzRepository->GetDatesJazz();
		$newdates = array();
		foreach ($date as $date) {
			$tempdate = date("l - d F", strtotime($date["StartDateTime"]));
			$newdates[] = $tempdate;
		}
		
		$output = "
		<tr>
		<th class='tg-lh0f'></th>";

		foreach ($newdates as $newdate) {
			$output .= "<th class='tg-qcxk'><span style='font-weight:700'>".$newdate."</span></th>";
		}

		$output .= "</tr>";
		return $output;
	}

	//Get artist/band name for programme table
	private function GetArtistForProgramme($datetime){
		$result = $this->JazzRepository->GetArtistName($datetime);
		$output = "";
		$count = 0;
		if (!empty($result)){
			foreach ($result as $result) {
				if ($count >= 2){
					$output .= "<hr id='bordertable'>";
				}
				$output .= $result;
				$count++;
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
		$ticket = $this->JazzRepository->GetTicketsJazz($date);
		$tickets = "";
		foreach ($ticket as $ticket) {
			$starttime = strtotime($ticket["StartDateTime"]);
			$endtime = strtotime($ticket["EndDateTime"]);

			//Check if entry is free
			if ($ticket["Price"] == "0.00"){
				$tickets .= "
				".date("H:i", $starttime)." - ".date("H:i", $endtime)."&nbsp;&nbsp;".$ticket["Name"]."<hr>
				";
			}
			//Check if ticket is an all access pass
			elseif (strpos($ticket["Name"], 'All Access') !== false){
				$tickets .= "
				".$ticket["Name"]."&nbsp;&nbsp;&nbsp;&nbsp;<aside class='price' id='pricespec'>€".$ticket["Price"]."</aside><hr>
				";
			}
			//Else show a normal ticket
			else{
				$tickets .= "
				".date("H:i", $starttime)." - ".date("H:i", $endtime)."&nbsp;&nbsp;".$ticket["Hall"]."&nbsp;&nbsp; <aside id='artistTicket'>".$ticket["Name"]."</aside><aside class='price'>€".$ticket["Price"]."</aside><hr>
				";
			}
		}
		return $tickets;
	}

	//Get all tickets for jazz
	public function GetOrderForm($date){
		$date .= "%";
		$tickets = $this->JazzRepository->GetTicketsJazz($date);
		
		$addtocart = "";
		$count = 1;
		$id = "ID";

		//Create input [Add/Remove/Input]
		foreach ($tickets as $ticket => $info) {
			$addtocart .= "
			<button onclick='ShoppingCartMinJazz(".$info["ID"].")'>-</button>
			<input type='text' value='0' id='".$info["ID"]."'>
			<button onclick='ShoppingCartPlusJazz(".$info["ID"].")'>+</button>
			<br>
			";
			$count++;
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
	public function GetEventDates(){
		return $this->JazzRepository->GetEventDates();
	}
}
?>
