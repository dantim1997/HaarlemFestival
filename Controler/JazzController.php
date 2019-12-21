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
		$counter = 0;
		$first = true;
		foreach ($artist as $artist) {
			$counter++;
			if ($first){
				$artists .= "
				<div class='carousel-item active'>
				<div class='artists'>";
			}
			else if ($counter == 1 && !$first){
				$artists .= "
				<div class='carousel-item'>
				<div class='artists'>";
			}
			$first = false;
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
			if ($counter == 4){
				$counter = 0;
				$artists .= "
				</div></div>";
			}
		}
		$check = $counter % 4;
		if ($check != 0){
			$artists .= "</div></div>";
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
		elseif ($genre == "Classic"){
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
			return "Images/Jazz/unset.gif";
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
			elseif (strpos($ticket["Name"], 'All Access') !== false){
				$tickets .= "
				".$ticket["Name"]."&nbsp;&nbsp;&nbsp;&nbsp;<aside class='price' id='pricespec'>€".$ticket["Price"]."</aside><hr>
				";
			}
			else{
				$tickets .= "
				".date("H:i", $starttime)." - ".date("H:i", $endtime)."&nbsp;&nbsp;".$ticket["Hall"]."&nbsp;&nbsp; <aside id='artistTicket'>".$ticket["Name"]."</aside><aside class='price'>€".$ticket["Price"]."</aside><hr>
				";
			}
		}
		return $tickets;
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

	public function GetTable(){
		//Get header (dates) of table
		$output = $this->GetDates();

		//get times
		$time = $this->DB_Helper->GetTimesJazz();


		//convert time
		foreach ($time as $time) {
			$timebegin = date("H:i", strtotime($time["StartDateTime"]));
			$newtimebegin[] = $timebegin;
			$timeend = date("H:i", strtotime($time["EndDateTime"]));
			$newtimeend[] = $timeend;
		}
		
		//create rows
		for($i=0; $i<count($newtimebegin); $i++) {
			$time = $newtimebegin[$i];
			$date1 = "2020-07-26"; $date1 = date('Y-m-d H:i:s', strtotime("$date1 $time"));
			$date2 = "2020-07-27"; $date2 = date('Y-m-d H:i:s', strtotime("$date2 $time"));
			$date3 = "2020-07-28"; $date3 = date('Y-m-d H:i:s', strtotime("$date3 $time"));
			$date4 = "2020-07-29"; $date4 = date('Y-m-d H:i:s', strtotime("$date4 $time"));

			$output .= "
			<tr>
			<td class='tg-6jhs'>".$newtimebegin[$i]." - ".$newtimeend[$i]."</td>
			<td class='tg-m4n1'>".$this->GetArtistTable($date1)."</td>
			<td class='tg-m4n1'>".$this->GetArtistTable($date2)."</td>
			<td class='tg-m4n1'>".$this->GetArtistTable($date3)."</td>
			<td class='tg-m4n1'>".$this->GetArtistTable($date4)."</td>
			<tr>";
		}
		return $output;
	}

	public function GetDates(){
		$date = $this->DB_Helper->GetDatesJazz();
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

	public function GetArtistTable($datetime){
		$result = $this->DB_Helper->GetArtistTableJazz($datetime);
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
		else{
			return null;
		}
	}

	public function FromDateTimeToTime($date){
		//convert datetime to time
		$hour = date("H",strtotime($date));
		$minute = date("i",strtotime($date));
		return $hour .":". $minute;
	}

	public function GetTickets($date){
		$tickets = $this->DB_Helper->GetTicketsJazz($date);
		
		$addtocart = "";
		$count = 1;
		$id = "ID";

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

	public function GetLocation($date){
		$location = $this->DB_Helper->GetLocationsJazz($date);
		$output = "<h2>Location<h2>
		<p class='location'>".$location["Name"]."<br>".$location["Adress"]."<br>".$location["Zipcode"]." ".$location["City"]."<br>".$location["Info"]."</p>
		<iframe class='googlemaps' src='".$location["GoogleMaps"]."' frameborder='0' style='border:0;' allowfullscreen=''></iframe>
		";
		return $output;
	}
}
?>