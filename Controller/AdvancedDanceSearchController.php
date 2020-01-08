<?php
	require_once( "Autoloader.php");
class AdvancedDanceSearchController 
{
	private $AdvancedDanceSearchModel;
	private $Session;
	private $Config;
	private $PageContentHelper;

	public function __construct($advancedDanceSearchModel){
		$this->AdvancedDanceSearchModel = $advancedDanceSearchModel;
		$this->DanceRepository = new DanceRepository;
		$this->Config = Config::getInstance();
		$this->PageContentHelper = new PageContentHelper();
	}
	
	//get config
	public function GetConfig(){
		return $this->Config;
	}

	public function MakeArtistAdvancedSearch(){
		$artists =$this->DanceRepository->GetArtists();
		$artistsSearchlist = "";
		foreach ($artists as $artist) {
			$artistsSearchlist .= "<input type='checkbox' name='ArtistCheckbox[]' value=".$artist["Id"]."><label>".$artist["Name"]."</label><br/>";
		}
		return $artistsSearchlist;
	}

	public function MakeLocationAdvancedSearch(){
		$locations =$this->DanceRepository->GetLocations();
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
		   $first = true;
		   foreach ($_GET['LocationCheckbox'] as $venueCheckbox ) {
		   		if(!$first){
		   			$searchStringLocation .= " OR ";
		   		}
		   		$searchStringLocation .= "e.VenueId LIKE '%".$venueCheckbox."%'";


		   		$first = false;
		   }
		}
		if(isset($_GET['ArtistCheckbox']) || isset($_GET['LocationCheckbox'])){
			$tickets = $this->CreateTickets($this->DanceRepository->GetSearch($searchStringArtist,$searchStringLocation));
			return $tickets;
		}
		return null;
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
		if($dates != null){
			$pageTexts = $this->PageContentHelper->GetPageText("DanceAdvancedSearch");
			$days = "<div class='Tickets'>".current($pageTexts)."</h2>";
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
		else{
			return "<h2>Could not found tickets with the critiria:</h2>";
		}
	}
}
?>