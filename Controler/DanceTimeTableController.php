<?php
	require_once( "Autoloader.php");
class DanceTimeTableController 
{
	private $DanceModel;
	private $Session;
	private $Config;

	public function __construct($danceModel){
		$this->Dancemodel = $danceModel;
		$this->Config = Config::getInstance();
		$this->DB_Helper = new DB_Helper;

		$this->Get_AllDanceEvents();
	}
	
	//get config
	public function GetConfig(){
		return $this->Config;
	}

	public function Get_AllDanceEvents(){
		$this->DB_Helper->Get_AllDanceEvents();

	}

	public function AddEvent(){
		$events = $this->DB_Helper->Get_AllDanceEventsByDate("2019-11-11%");

		$tableEvent= "";
		foreach ($events as $event) {
			$tableEvent .= $this->AddEventRow($event);
		}

		return $tableEvent;
	}

	public function AddEventRow($event){
		$emptyTime = $this->CalculateTimeSpan($event["StartDateTime"]);
		$emptyTime = $this->CalculateTimeSpan($event["StartDateTime"]);

		$datetime1 = date_create($event["StartDateTime"]);
		$datetime2 = date_create($event["endDateTime"]);
		$timeSpan = $datetime1->diff($datetime2);
		$durationEvent = (($timeSpan->h+($timeSpan->i/60))*2);

		$fullRow = "<TR><TD>".$event["Venue"]."</TD>";
		 
		for ($i=0; $i < $emptyTime; $i++) { 
			$fullRow .="<TD colspan='1' class=''></TD>";
		}
			$fullRow .="
	      <TD colspan='".$durationEvent."' class='Event'>
	        <div class='AddText'>".$event["artist"]."<br>€ ".$event["price"]."</div>
	        <div class='Add'><input class='AddButton' type='Button' name='Add' value='+'></div>
	      </TD>";

	    for ($i=0; $i < (25-($emptyTime + $durationEvent)); $i++) { 
	    	$fullRow .= "<TD colspan='1' class=''></TD>";
	    }
	     
	    $fullRow .="</TR>";

	    return $fullRow;
	}

	public function CalculateTimeSpan($Date){
		$hour = intval((date("H",strtotime($Date))));
		$minute = doubleval((date("i",strtotime($Date)))) / 60;
		$Span = (($hour + $minute) - 14) * 2;

		return $Span;
	}

	public function MakeArtistAdvancedSearch(){
		$this->Locations =$this->DB_Helper->GetArtists();
		$artistsSearchlist = "";
		foreach ($this->Locations as $location) {
			$artistsSearchlist .= "<input type='checkbox' name='ArtistCheckbox[]' value=".$location["Id"]."><label>".$location["Name"]."</label><br/>";
		}
		return $artistsSearchlist;
	}

	public function MakeLocationAdvancedSearch(){
		$this->locations =$this->DB_Helper->GetLocations();
		$locationSearchlist = "";
		foreach ($this->locations as $location) {
			$locationSearchlist .= "<input type='checkbox' name='LocationCheckbox[]' value=".$location["Id"]."><label>".$location["Name"]."</label><br/>";
		}
		return $locationSearchlist;
	}
}
?>