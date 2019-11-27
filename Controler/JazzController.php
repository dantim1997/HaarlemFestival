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
	public function MakeArtistCarousel(){
		$artist = $this->DB_Helper->GetArtistsJazz("");
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
		//$array = array('' =>  );
		foreach($artist as $artist){
			if(!empty($array)){
					$array2 .= $artist["StartDateTime"];
			}
			$artist .= $artist["Name"];
		}
	}

	//get artists for filter
	public function MakeGenreAdvancedSearch(){
		$artist =$this->DB_Helper->GetGenresJazz();
		$artistsSearchlist = "";
		foreach ($artist as $artist) {
			$artistsSearchlist .= "<input type='checkbox' name='GenreCheckbox[]' value=".$artist["Genre"]."><label>".$artist["Genre"]."</label><br/>";
		}
		return $artistsSearchlist;
	}

	//GetFilterResult
	public function GetFilterResults(){
		$searchStringGenre = "";
		$first = true;

		if(isset($_GET['GenreCheckbox']))
		{
		   foreach ($_GET['GenreCheckbox'] as $genreCheckbox ) {
		   		if(!$first){
		   			$searchStringGenre .= " OR ";
				   }
				   
		   		$searchStringGenre .= "Genre LIKE '%".$genreCheckbox."%'";
		   		$first = false;
		   }
		}

		$artists = $this->DB_Helper->GetArtistsJazz($searchStringGenre);
		return $artists;
	}
}
?>