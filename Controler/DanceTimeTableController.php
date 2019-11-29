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
	}
	
	//get config
	public function GetConfig(){
		return $this->Config;
	}

	public function AddEvent($date){
		$events = $this->DB_Helper->Get_AllDanceEventsByDate($date."%");

		$tableEvent= "";
		foreach ($events as $event) {
			$tableEvent .= $this->AddEventRow($event);
		}
		return $tableEvent;
	}

	public function AddEventRow($event){
		$emptyTime = $this->CalculateTimeSpan($event["StartDateTime"]);

		$datetime1 = date_create($event["StartDateTime"]);
		$datetime2 = date_create($event["endDateTime"]);
		$timeSpan = $datetime1->diff($datetime2);
		$durationEvent = (($timeSpan->h+($timeSpan->i/60))*2);

		$fullRow = "<TR><TD colspan='3'>".$event["Venue"]."</TD>";
		 
		for ($i=0; $i < $emptyTime; $i++) { 
			$fullRow .="<TD colspan='1' class=''></TD>";
		}
			$fullRow .="
	      <TD colspan='".$durationEvent."' class='Event'>
	        <div class='AddText'>".$event["artist"]."<br>€ ".$event["price"]."</div>
	        <div class='Add'><input class='AddButton' type='Button' onclick='ShowPopup();ShoppingCartPlus()' name='Add' value='+'></div>
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
		$artist =$this->DB_Helper->GetArtists();
		$artistsSearchlist = "";
		foreach ($artist as $artist) {
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

	public function GetDates($dates){
		$days = "";
		foreach ($dates as $date) {
			$SetDate = date('Y-m-d', strtotime($date["Date"]));
            $day = date('l', strtotime($SetDate));
			$days .= "<div onclick='SelectedDay(".date('d', strtotime($date["Date"])).")' class='Day'>".$day."</div>";
		}
		$days .= "</div>";
		return $days;
	}

	public function MakeTimeTables(){
		$dates =$this->DB_Helper->GetDates();

		$TimeTables = $this->GetDates($dates);

		$first = "";
		foreach ($dates as $date) {
			$TimeTables .= $this->MakeTimeTable($date["Date"], $first);
			$first = "Hide";
		}

		return $TimeTables;
	}

	public function MakeTimeTable($date, $first){
		return "<div id='".date('d', strtotime($date))."' class='".$first." HideTimeTable'>
	    	<TABLE class='ArtistTimeTable'> 
			  <THEAD>
			    <TR>
			      <TH colspan='3'></TH>
			      <TH>14:00</TH>
			      <TH>14:30</TH> 
			      <TH>15:00</TH>
			      <TH>15:30</TH>  
			      <TH>16:00</TH>
			      <TH>16:30</TH>
			      <TH>17:00</TH>
			      <TH>17:30</TH>
			      <TH>18:00</TH>
			      <TH>18:30</TH>
			      <TH>19:00</TH>
			      <TH>19:30</TH>
			      <TH>20:00</TH>
			      <TH>20:30</TH>
			      <TH>21:00</TH>
			      <TH>21:30</TH>
			      <TH>22:00</TH>
			      <TH>22:30</TH>
			      <TH>23:00</TH>
			      <TH>23:30</TH>
			      <TH>00:00</TH>
			      <TH>00:30</TH>
			      <TH>01:00</TH>
			      <TH>01:30</TH>
			      <TH>02:00</TH>
			    </TR>
			  </THEAD>
			  <TBODY>
			    ".$this->AddEvent($date)."
			   </TBODY>
			</TABLE>
			</div>";
	}
}
?>