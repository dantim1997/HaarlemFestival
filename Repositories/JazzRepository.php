<?php
class JazzRepository
{
	private $Conn;
	
	function __construct()
	{
		$DBConnection = DBConnection::getInstance();	
		$this->Conn = $DBConnection->getConnection();

		if($this->Conn->connect_error){
			die("Connection failed:" . $this->Conn->connect_error);
		}

		/* Switch off auto commit to allow transactions*/
		$this->Conn->autocommit(FALSE);
	}

	public function GetConn(){
		return $this->Conn;
	}

	//get Artists for Jazz carousel filter
	public function GetArtistsJazz($genreFilter){
		if (empty($genreFilter)){
			$sql = "SELECT n.ArtistName, e.Image, n.Genre 
			FROM Jazz n
			INNER JOIN EventImage e
			ON e.Id = n.ImageRef
			WHERE n.Genre IS NOT NULL GROUP BY n.ArtistName";
		}
		else{
			$sql = "SELECT n.ArtistName, e.Image, n.Genre 
			FROM Jazz n
			INNER JOIN EventImage e
			ON e.Id = n.ImageRef
			WHERE ".$genreFilter." AND n.Genre IS NOT NULL GROUP BY n.ArtistName";
		}
		//does a prepared query
		$stmt = $this->Conn->prepare($sql);
		$stmt->execute();
		$stmt->store_result();
		$stmt-> bind_result($Name, $Image, $Genre); 
		$artists = array();
		while ($stmt -> fetch()) { 
			$artist = new JazzModel();
			$artist->setArtistName($Name);
			$artist->setImage("http://hfteam3.infhaarlem.nl/cms/".$Image);
			$artist->setGenre($Genre);
			$artists[] = $artist;
		}
		return $artists;
	}

	//get Tickets for Jazz
	public function GetTicketsJazz($date){
		//does a prepared query
		$stmt = $this->Conn->prepare("SELECT ID, ArtistName, StartDateTime, EndDateTime, Price, Hall 
		FROM Jazz 
		WHERE StartDateTime LIKE ? AND Amount > 0 
		ORDER BY EndDateTime, Hall 
		ASC");
		$stmt->bind_param("s", $date);
		$stmt->execute();
		$stmt->store_result();
		$stmt-> bind_result($Id, $Name, $StartDateTime, $EndDateTime, $Price, $Hall); 
		$tickets = array();
		while ($stmt -> fetch()) { 
			$ticket = array("ID"=>$Id, "Name"=>$Name, "StartDateTime"=>$StartDateTime, "EndDateTime"=>$EndDateTime, "Price"=>$Price, "Hall"=>$Hall);
			$tickets[] = $ticket;
		}
		return $tickets;
	}

	//get Programme for Jazz
	public function GetArtistName($datetime){
		//does a prepared query
		$stmt = $this->Conn->prepare("SELECT ArtistName 
		FROM Jazz 
		WHERE StartDateTime LIKE ? AND Genre IS NOT NULL");
		$stmt->bind_param("s", $datetime);
		$stmt->execute();
		$stmt->store_result();
		$stmt-> bind_result($Name); 
		$artists[] = "";
		while ($stmt -> fetch()) { 
			$artists[] = $Name;
		}
		return $artists;
	}

	//get Genres for Jazz carousel
	public function GetGenresJazz(){
		//does a prepared query
		$stmt = $this->Conn->prepare("SELECT Genre 
		FROM Jazz 
		WHERE Genre IS NOT NULL 
		GROUP BY Genre");
		$stmt->execute();
		$stmt->store_result();
		$stmt-> bind_result($Genre);
		while ($stmt -> fetch()) { 
			$genre = new JazzModel();
			$genre->setGenre($Genre);
			$genres[] = $genre;
		}
		return $genres;
	}

	//Get dates for jazz
	public function GetDatesJazz(){
		//does a prepared query
		$stmt = $this->Conn->prepare("SELECT StartDateTime, EndDateTime 
		FROM Jazz 
		GROUP BY DATE(StartDateTime) 
		ASC");
		$stmt->execute();
		$stmt->store_result();
		$stmt-> bind_result($StartDateTime, $EndDateTime); 
		$dates = array();
		while ($stmt -> fetch()) { 
			$date = new JazzModel();
			$date->setStartDateTime($StartDateTime);
			$date->setEndDateTime($EndDateTime);
			$dates[] = $date;
		}
		return $dates;
	}

	//Get times for jazz programme
	public function GetTimesJazz(){
		//does a prepared query
		$stmt = $this->Conn->prepare("SELECT StartDateTime, EndDateTime 
		FROM Jazz 
		WHERE Genre IS NOT NULL 
		GROUP BY TIME(StartDateTime) 
		ASC");
		$stmt->execute();
		$stmt->store_result();
		$stmt-> bind_result($StartDateTime, $EndDateTime); 
		$times = array();
		while ($stmt -> fetch()) {
			$time = new JazzModel();
			$time->setStartDateTime($StartDateTime);
			$time->setEndDateTime($EndDateTime);
			$times[] = $time;
		}
		return $times;
	}

	//Get jazz location
	public function GetLocationsJazz($date){
		//does a prepared query
		$stmt = $this->Conn->prepare("SELECT v.Name, v.Adress, v.Zipcode, v.City, v.ExtraInfoEnglish, v.ExtraInfoDutch, v.GoogleMaps
		FROM Jazz j
		INNER JOIN JazzVenues v
		ON v.Name = j.Location
		WHERE j.StartDateTime LIKE ?
		GROUP BY DATE_FORMAT(j.StartDateTime, '%Y-%m')");
		$stmt->bind_param("s", $date);
		$stmt->execute();
		$stmt->store_result();
		$stmt-> bind_result($Name, $Adress, $Zipcode, $City, $ExtraInfoEnglish, $ExtraInfoDutch, $GoogleMaps);
		$stmt->fetch();
		$location = array("Name"=>$Name, "Adress"=>$Adress, "Zipcode"=>$Zipcode, "City"=>$City, "InfoEnglish"=>$ExtraInfoEnglish, "InfoDutch"=>$ExtraInfoDutch, "GoogleMaps"=>$GoogleMaps);
		return $location;
	}

	//Get checkout info
	public function GetEventInfoJazz($id){
		//clean Id
		$IdSQL = mysqli_real_escape_string($this->Conn, $id);
		//does a prepared query
		$stmt = $this->Conn->prepare("SELECT Id, ArtistName, Hall, Location, Price, StartDateTime, EndDateTime 
		FROM Jazz 
		WHERE Id = ?");
		$stmt->bind_param("i", $IdSQL);
		$stmt->execute();
		$stmt->store_result();
		$stmt-> bind_result($Id, $ArtistName, $Hall, $Location, $Price, $StartDateTime, $EndDateTime);
		$stmt->fetch();
		$ticket = array("ID"=>$Id, "About"=>"<br><strong>".$ArtistName."</strong>", "Description"=>null, "Venue"=>$Location.", ".$Hall, "StartDateTime"=>$StartDateTime, "EndDateTime"=>$EndDateTime, "Price"=>$Price);
		return $ticket;
	}

	//Get event dates for view
	public function GetEventDates(){
		//does a prepared query
		$stmt = $this->Conn->prepare("SELECT StartDateTime 
		From Jazz 
		GROUP BY DATE(StartDateTime)");
		$stmt->execute();
		$stmt->store_result();
		$stmt-> bind_result($Dates); 
		$date = array();
		while ($stmt -> fetch()) { 
			$date = array("Dates"=>substr($Dates, 0, -9));
			$dates[] = $date;
		}
		return $dates;
	}

}
?>