<?php
	require_once( "Autoloader.php");
class AdvancedDanceSearchController 
{
	private $AdvancedDanceSearchModel;
	private $Session;
	private $Config;

	public function __construct($advancedDanceSearchModel){
		$this->AdvancedDanceSearchModel = $advancedDanceSearchModel;
		$this->DB_Helper = new DB_Helper;
		$this->Config = Config::getInstance();
	}
	
	//get config
	public function GetConfig(){
		return $this->Config;
	}

	public function MakeArtistAdvancedSearch(){
		$artists =$this->DB_Helper->GetArtists();
		$artistsSearchlist = "";
		foreach ($artists as $artist) {
			$artistsSearchlist .= "<input type='checkbox' name='ArtistCheckbox[]' value=".$artist["Id"]."><label>".$artist["Name"]."</label><br/>";
		}
		return $artistsSearchlist;
	}

	public function MakeLocationAdvancedSearch(){
		$locations =$this->DB_Helper->GetLocations();
		$locationSearchlist = "";
		foreach ($locations as $location) {
			$locationSearchlist .= "<input type='checkbox' name='LocationCheckbox[]' value=".$location["Id"]."><label>".$location["Name"]."</label><br/>";
		}
		return $locationSearchlist;
	}

	public function GetSearchResults(){
		$searchStringArtist = "";
		$searchStringLocation = "";

		   $first = true;
		if(isset($_GET['ArtistCheckbox']))
		{
		   foreach ($_GET['ArtistCheckbox'] as $artistCheckbox ) {
		   		if(!$first){
		   			$searchStringArtist .= " OR ";
		   		}
		   		$searchStringArtist .= "p.ArtistId LIKE '%".$artistCheckbox."%'";


		   		$first = false;
		   }
		}

		if(isset($_GET['LocationCheckbox']))
		{
		   //$first = true;
		   foreach ($_GET['LocationCheckbox'] as $venueCheckbox ) {
		   		if(!$first){
		   			$searchStringLocation .= " OR ";
		   		}
		   		$searchStringLocation .= "e.VenueId LIKE '%".$venueCheckbox."%'";


		   		$first = false;
		   }
		}

		$tickets = $this->CreateTickets($this->DB_Helper->GetSearch($searchStringArtist,$searchStringLocation));
		return $tickets;
	}

	public function CreateTickets($searchResults){
		$date = array();
		foreach ($searchResults as $searchResult) {
			$eventDate = date('Y-m-d', strtotime($searchResult["StartDateTime"]));
			if(!array_key_exists($eventDate ,$date)){
				$date[$eventDate] = "";
			}
			$startTime = $this->FromDateTimeToTime($searchResult["StartDateTime"]);
			$endTime = $this->FromDateTimeToTime($searchResult["EndDateTime"]);
			
			$tickets = "<div class='SessionFound'>
							<p class='SessionInfo'>Haarlem Dance ".$startTime." - ".$endTime.", ".$searchResult["artist"]." ,".$searchResult["Venue"]."     € ".$searchResult["Price"].",-</p>
							<input onclick='AddToCart(".$searchResult["ID"].",2,1)' class='SessionAdd' type='button' value='+'>
							</div>";
			$date[$eventDate] .=$tickets;
		}
		return $date;
	}

	public function FromDateTimeToTime($date){
			$hour = date("H",strtotime($date));
			$minute = date("i",strtotime($date));
			return $hour .":". $minute;
	}

	public function CreateDays($dates){
		$days = "<div class='Tickets'><h2>Tickets found with the critiria:</h2>";
		foreach($dates as $key=>$date){
            $eventdate = new DateTime($key);
            $SetDate = $eventdate->format('Y-m-d');
            $Day = date('l', strtotime($SetDate));
			$days .="<div class='Days'><h3>".$Day."</h3>
			<hr>
			<div class='SessionFound'>";
				$days .= $date;
			$days .="</div></div>";
		}
		$days .= "</div>";
		return $days;			
	}
}
?>