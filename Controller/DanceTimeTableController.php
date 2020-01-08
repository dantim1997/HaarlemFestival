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
		$this->Session = new Session;
	}
	
	//get config
	public function GetConfig(){
		return $this->Config;
	}

	//makes each event in a row
	public function AddEvent($date){
		//get all events by date
		$events = $this->DB_Helper->Get_AllDanceEventsByDate($date."%");

		$tableEvent= "";
		//foreach event in the array make a row
		foreach ($events as $event) {
			$tableEvent .= $this->AddEventRow($event);
		}

		//return all rows
		return $tableEvent;
	}

	// takes special tickets and put them in a row
	public function GetSpecialTickets(){
		// get all events in the dancevent where special is 1 and the amount is higher then 0
		$specials = $this->DB_Helper->Get_AllSpecialEvents();

		$specialTickets="";
		// check if there is any special tickets
		if(count($specials) > 0){

			//foreach ticket make an row in the special table
			foreach ($specials as $special) {
				$specialTickets.= "
				<tr>
				<td>".$special["description"]."</td><td>&euro; ".$special["price"]."</td>
				<td><input type='Button' class='AddButton'
				onclick='AddToCart(".$special["ID"].",2,1)' name='' value='Add to cart'></td>
				</tr>";
			}
		}
		//if there are no tickets give an notification
		else{
			$specialTickets .= "<i style='color:red;'>There are no Sessions</i>";
		}
		// return the table rows or the notification
		return $specialTickets;
	}

	//for each event makes the row
	public function AddEventRow($event){
		//calculate the empty timespan start from 14:00
		$emptyTime = $this->CalculateTimeSpan($event["StartDateTime"]);
		//get the datetimes
		$startDateTime = date_create($event["StartDateTime"]);
		$endDateTime = date_create($event["endDateTime"]);
		//get the timespan of the event
		$timeSpan = $startDateTime->diff($endDateTime);
		//gets the timespan in half hours
		$durationEvent = (($timeSpan->h+($timeSpan->i/60))*2);

		//first row to give the location
		$fullRow = "<TR><TD colspan='3'>".$event["Venue"]."</TD>";
		 
		//foreach empty time till the event begins
		for ($i=0; $i < $emptyTime; $i++) { 
			$fullRow .="<TD colspan='1' class=''></TD>";
		}
		// the event itself
		$fullRow .="
			<TD colspan='".$durationEvent."' class='Event'>
			<div class='AddText'>".$event["artist"]."<br>€ ".$event["price"]."</div>
			<div class='Add'><input class='AddButton' type='Button' onclick='AddToCart(".$event["ID"].",2,1)' name='Add' value='+'></div>
			</TD>";

		//the after empty time to fillup the space (25 is all cells in the row)
	    for ($i=0; $i < (25-($emptyTime + $durationEvent)); $i++) { 
	    	$fullRow .= "<TD colspan='1' class=''></TD>";
	    }
		 
		//closes the row
	    $fullRow .="</TR>";

		//returns the row with spacing
	    return $fullRow;
	}

	//calculate the span from 14:00 till the starttime of the event
	//each cell is 30 minutes
	public function CalculateTimeSpan($Date){
		// get hours from the startdatetime
		$hour = intval((date("H",strtotime($Date))));
		//get all minuts from the startdatetime in hours(like 0.50 halfhour)
		$minute = doubleval((date("i",strtotime($Date)))) / 60;
		// hour plus minute, min the start of the table and times 2 to set span in halfhours from hours
		$Span = (($hour + $minute) - 14) * 2;
		//return amount cells that need to be empty
		return $Span;
	}

	// get all artists and set them in the checkboxlist for advanced search
	public function MakeArtistAdvancedSearch(){
		//get all artists
		$artist =$this->DB_Helper->GetArtists();
		$artistsSearchlist = "";
		// foreach artist make a checkbox 
		foreach ($artist as $artist) {
			$artistsSearchlist .= "<input type='checkbox' name='ArtistCheckbox[]' value=".$artist["Id"]."><label>".$artist["Name"]."</label><br/>";
		}
		//return all artists checkboxes
		return $artistsSearchlist;
	}

	// get all locations and set them in the checkboxlist for advanced search
	public function MakeLocationAdvancedSearch(){
		//get all locations
		$locations =$this->DB_Helper->GetLocations();
		$locationSearchlist = "";
		// foreach location make a checkbox
		foreach ($locations as $location) {
			$locationSearchlist .= "<input type='checkbox' name='LocationCheckbox[]' value=".$location["Id"]."><label>".$location["Name"]."</label><br/>";
		}
		// return all locations checkboxes
		return $locationSearchlist;
	}

	//get all the dates that an dance event is playing
	public function GetDates($dates){
		$days = "";
		// foreach date make a button to show the events of that day 
		foreach ($dates as $date) {
			$SetDate = date('Y-m-d', strtotime($date["Date"]));
			//gets the day name of the day (like monday)
			$day = date('l', strtotime($SetDate));
			//make a button from the day to switch days
			$days .= "<div onclick='SelectedDay(".date('d', strtotime($date["Date"])).")' class='Day'>".$day."</div>";
		}
		$days .= "</div>";
		//returns all day buttons
		return $days;
	}

	//makes the head of the timetable
	public function MakeTimeTables(){
		//get all dates of the events
		$dates =$this->DB_Helper->GetDates();

		// get all buttons of the timetables
		$TimeTables = $this->GetDates($dates);

		$hide = "";
		//foreach date make an timetable with the events
		foreach ($dates as $date) {
			//makes the timetable but when $hide is "hide", to hide the timetable 
			$TimeTables .= $this->MakeTimeTable($date["Date"], $hide);
			//after the first one hide the rest(on page load)
			$hide = "Hide";
		}
		//return all buttons and timetables
		return $TimeTables;
	}

	//makes the timetable for all events
	public function MakeTimeTable($date, $hide){
		// return the timetable with all rows and time for one timetable
		return "<div id='".date('d', strtotime($date))."' class='".$hide." HideTimeTable'>
	    	<TABLE class='ArtistTimeTable'> 
			  <THEAD>
			    <TR>
				  <TH colspan='3'></TH>
				  ".$this->MakeHalfHours()."
			    </TR>
			  </THEAD>
			  <TBODY>
			    ".$this->AddEvent($date)."
			   </TBODY>
			</TABLE>
			</div>";
	}

	public function MakeHalfHours()
	{
		$times = "";
		//start time of the timetable
		$time = '14:00';
		//for each cell(is 25 cells) set the time in the header of the table 
		for($i =0; $i < 25; $i++){
			$times .="<TH>".$time."</TH>";
			$time = date('H:i',strtotime('+30 minutes',strtotime($time)));
		}
		//return all the TH times
		return $times;
	}
}
?>