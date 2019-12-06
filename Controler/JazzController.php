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
		$this->DB_Helper = new DB_Helper;
	}
	
	//get config
	public function GetConfig(){
		return $this->Config;
	}

	//Get Artists
	public function MakeArtistCarousel($filter = null){
		$artist = $this->DB_Helper->GetArtistsJazz($filter);
		$artists = "";
		foreach ($artist as $artist) {
			$artists .= "
			<div class='artist'>
				<div class='artistname'>".$artist["Name"]."</div>
					<div class='artistcontainer'>
						<image class='artistimage' src='".$this->CheckImageIsSet($artist["Image"])."'>
						<div class='".$this->BepaalGenre($artist["Genre"])."'>".$artist["Genre"]."</div>
						<div class='genre0'>0</div> 
					</div>
			</div>
			";
		}
		return $artists;
	}

	//define genre
	public function BepaalGenre($genre){
		if ($genre == "Blues"){
			return "genre1";
		}
		elseif ($genre == "Ragtime"){
			return "genre2";
		}
		elseif ($genre == "Classic Soul"){
			return "genre3";
		}
		elseif ($genre == "Classic"){
			return "genre4";
		}
		elseif ($genre == "Jazz Rock"){
			return "genre5";
		}
		else {
			return "genre0";
		}
	}

	//check if image is set
	public function CheckImageIsSet($image){
		if (empty($image)){
			return "Images/unset.gif";
		}
		else{
			return $image;
		}
	}

	//get tickets for event day
	public function FillTickets($date){
		$ticket = $this->DB_Helper->GetTicketsJazz($date);
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
			else{
				$tickets .= "
				".date("H:i", $starttime)." - ".date("H:i", $endtime)."&nbsp;&nbsp;".$ticket["Hall"]."&nbsp;&nbsp; ".$ticket["Name"]."&nbsp;&nbsp;&nbsp;&nbsp;<aside class='price'>€".$ticket["Price"]."</aside><hr>
				";
			}
		}
		return $tickets;
	}

	//Fill Time Table
	public function FillTable(){
		$artist = $this->DB_Helper->GetTimeTableJazz();
		$artists = "";
		$array = array();
		foreach($artist as $artist){
			if(!empty($array)){
					$array2 .= $artist["StartDateTime"];
			}
			$artist .= $artist["Name"];
			$output = "<tr>
						<td class='tg-6jhs'>".$artist["Name"]."</td>
						<td class='tg-m4n1'>".$artist["Name"]."</td>
						<td class='tg-m4n1'>".$artist["Name"]."</td>
						<td class='tg-m4n1'>".$artist["Name"]."</td>
						<td class='tg-m4n1'>".$artist["Name"]."</td>
						</tr>";
		}
		return $output;
	}
	
	//get genre for filter
	public function MakeGenreAdvancedSearch(){
		$artist =$this->DB_Helper->GetGenresJazz();
		$artistsSearchlist = "";
		foreach ($artist as $artist) {
			$artistsSearchlist .= "<input class='checkbox' type='checkbox' name='GenreCheckbox[]' value=".$artist["Genre"]."><label>".$artist["Genre"]."</label><br/>";
		}
		return $artistsSearchlist;
	}

	//GetFilterResult
	public function GetFilterResults(){
		$searchStringGenre = "";
		$output = "";
		$first = true;

		if(isset($_GET['GenreCheckbox']))
		{
		   foreach ($_GET['GenreCheckbox'] as $genreCheckbox ) 
			{
		   		if(!$first){
		   			$searchStringGenre .= " OR ";
				}
		   		$searchStringGenre .= "Genre LIKE '%".$genreCheckbox."%'";
				$first = false;
			}
		}
		$output = $this->MakeArtistCarousel($searchStringGenre);
		return $output;
	}

	public function CreateTable(){
		$searchResults = $this->DB_Helper->GetTimeTableJazz();
		$date = array();
		foreach ($searchResults as $searchResult) {
			$eventDate = date('Y-m-d', strtotime($searchResult["StartDateTime"]));
			if(!array_key_exists($eventDate ,$date)){
				$date[$eventDate] = "";
			}
			$startTime = $this->FromDateTimeToTime($searchResult["StartDateTime"]);
			$endTime = $this->FromDateTimeToTime($searchResult["EndDateTime"]);
			
			$tickets = "<tr>
			<td class='tg-6jhs'>".$startTime." - ".$endTime."</td>
			<td class='tg-m4n1'>".$searchResult["Name"]."</td>
			<td class='tg-m4n1'>".$searchResult["Name"]."</td>
			<td class='tg-m4n1'>".$searchResult["Name"]."</td>
			<td class='tg-m4n1'>".$searchResult["Name"]."</td>
			</tr>";
			$date[$eventDate] .=$tickets;
		}
		return $tickets;
	}

	public function CreateTable2(){
		//Get all dates
		$date = $this->DB_Helper->GetDatesJazz();


		//Get all times
	}

	public function GetDates(){
		$date = $this->DB_Helper->GetDatesJazz();
		$newdates = array();
		foreach ($date as $date) {
			$tempdate = date("l - d F", strtotime($date["StartDateTime"]));
			$newdates[] = $tempdate;
		}
		
		$output = "<tr>
						<th class='tg-lh0f'></th>";
						foreach ($newdates as $newdate) {
							$output .= "<th class='tg-qcxk'><span style='font-weight:700'>".$newdate."</span></th>";
						}
					$output .= "</tr>";
					return $output;
	}

	public function GetTimes(){
		$time = $this->DB_Helper->GetTimesJazz();
		$newtimebegin = array();
		$newtimeend = array();
		foreach ($time as $time) {
			$temptime = date("H:i", strtotime($time["StartDateTime"]));
			$newtimebegin[] = $temptime;
			$temptime = date("H:i", strtotime($time["EndDateTime"]));
			$newtimeend[] = $temptime;
		}
		
		$output = "<tr>";
						foreach ($newtimebegin as $startTime) {
							foreach ($newtimeend as $endTime)
							$output .= "<td class='tg-6jhs'>".$startTime." - ".$endTime."</td>";
						}
					$output .= "</tr>";
					return $output;
	}

	public function FromDateTimeToTime($date){
		$hour = date("H",strtotime($date));
		$minute = date("i",strtotime($date));
		return $hour .":". $minute;
	}
}
?>