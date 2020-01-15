<?php
class FoodRepository
{
	private $conn;
	
	function __construct()
	{
		$DBConnection = DBConnection::getInstance();	
		$this->conn = $DBConnection->getConnection();

		if($this->conn->connect_error){
			die("Connection failed:" . $this->conn->connect_error);
		}

		// switch off auto commit to allow transactions
		$this->conn->autocommit(FALSE);
	}

	public function GetConn(){
		return $this->conn;
	}

	////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	// MAIN PAGE
	////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

	public function GetRestaurantInfo() {
		$stmt = $this->conn->prepare("SELECT r.Name, ei.Image, r.Cuisines FROM Restaurants r JOIN EventImage ei ON r.ImageRef = ei.Id");
		$stmt->execute();
		$stmt->store_result();
		$stmt->bind_result($Name, $Image, $Cuisines);
		$restaurantImages = array();
		while ($stmt -> fetch()) {
			$restaurantImage = array("Name" => $Name, "Image" => "http://hfteam3.infhaarlem.nl/cms/".$Image, "Cuisines" => $Cuisines);
			$restaurantImages[] = $restaurantImage;
		}
		return $restaurantImages;
	}
		
	// grab the food description in English
	public function GetFoodDescriptionEnglish($name) {
		$stmt = $this->conn->prepare("SELECT ep.ParagraphTextEnglish FROM Restaurants r JOIN EventParagraph ep ON r.Description = ep.Id WHERE r.Name LIKE ?");
		$stmt->bind_param("s", $name);
		$stmt->execute();
		$stmt->store_result();
		$stmt->bind_result($descriptionText);
		$pageTextContent = array();
		while ($stmt -> fetch()) {
			$pageText = $descriptionText;
			$pageTextContent[] = $pageText;
		}
		return $pageTextContent;
	}

	// grab the food description in Dutch
	public function GetFoodDescriptionDutch($name) {
		$stmt = $this->conn->prepare("SELECT ep.ParagraphTextDutch FROM Restaurants r JOIN EventParagraph ep ON r.Description = ep.Id WHERE r.Name LIKE ?");
		$stmt->bind_param("s", $name);
		$stmt->execute();
		$stmt->store_result();
		$stmt->bind_result($descriptionText);
		$pageTextContent = array();
		while ($stmt -> fetch()) {
			$pageText = $descriptionText;
			$pageTextContent[] = $pageText;
		}
		return $pageTextContent;
	}

	////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	// TIMES_TICKETS PAGE
	////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

	public function GetFoodSections($queryStringTimes, $queryStringCuisine, $queryStringRestaurants) {
		$query = "SELECT r.Id, r.Name, r.Cuisines, r.Location, r.Rating, r.NormalPrice, r.ChildPrice, r.LocationLink, ei.Image, fr.SessionStartDateTime, fr.SessionEndDateTime, SUM(fr.Amount) 
					FROM FoodRestaurants fr 
					JOIN Restaurants r ON fr.RestaurantId = r.Id
					JOIN EventImage ei ON r.ImageRef = ei.Id";
		if ($queryStringTimes != "" || $queryStringCuisine != "" || $queryStringRestaurants != "") {
			$query .= " WHERE ".$queryStringTimes." ".$queryStringCuisine. " ".$queryStringRestaurants;
		}
		$query .= " GROUP BY r.Id";
		$stmt = $this->conn->prepare($query);
		$stmt->execute();
		$stmt->store_result();
		$stmt->bind_result($Id, $Name, $Cuisines, $Location, $Rating, $NormalPrice, $ChildPrice, $LocationLink, $Logo, $SessionStartDateTime, $SessionEndDateTime, $Amount);
		$foodSections = array();
		while ($stmt -> fetch()) {
			$foodSection = array("Id" => $Id, "Name" => $Name, "Cuisines" => $Cuisines, "Location" => $Location, "Rating" => $Rating, "NormalPrice" => $NormalPrice, "ChildPrice" => $ChildPrice, "LocationLink" => $LocationLink, "Logo" => '<img src="http://hfteam3.infhaarlem.nl/cms/'.$Logo.'" class="restaurantInfoImages"/>', "SessionStartDateTime" => $SessionStartDateTime, "SessionEndDateTime" => $SessionEndDateTime, "Amount" => $Amount);
			$foodSections[] = $foodSection;
		}
		return $foodSections;
	}


	public function GetAllFoodSessions($side) {
		if ($side == "left") {
			$query = "SELECT SessionStartDateTime FROM FoodRestaurants GROUP BY SessionStartDateTime ORDER BY SessionStartDateTime LIMIT 5";
		} else if ("right") {
			$query = "SELECT SessionStartDateTime FROM FoodRestaurants GROUP BY SessionStartDateTime ORDER BY SessionStartDateTime LIMIT 5 OFFSET 5";
		}
		$stmt = $this->conn->prepare($query);
		$stmt->execute();
		$stmt->store_result();
		$stmt->bind_result($SessionStartDateTime);
		$foodSessions = array();
		while ($stmt -> fetch()) {
			$foodSession = array("SessionStartDateTime" => $SessionStartDateTime);
			$foodSessions[] = $foodSession;
		}
		return $foodSessions;
	}

	// get all food cuisines
	public function GetAllCuisines() {
		$stmt = $this->conn->prepare("SELECT Cuisines FROM Restaurants GROUP BY Cuisines");
		$stmt->execute();
		$stmt->store_result();
		$stmt->bind_result($Cuisines);
		$foodCuisines = array();
		while ($stmt -> fetch()) {
			$foodCuisine = array("Cuisines" => $Cuisines);
			$foodCuisines[] = $foodCuisine;
		}
		return $foodCuisines;
	}

	// grab all dates from food
	public function GetFoodDates() {
		$stmt = $this->conn->prepare("SELECT DATE(SessionStartDateTime) FROM FoodRestaurants GROUP BY DATE(SessionStartDateTime)");
		$stmt->execute();
		$stmt->store_result();
		$stmt->bind_result($SessionDate);
		$foodDates = array();
		while ($stmt -> fetch()) {
			$foodDate = array("SessionDate" => $SessionDate);
			$foodDates[] = $foodDate;
		}
		return $foodDates;
    }


	// get needed information from food event
	public function GetEventInfoFood($Id) {
		// cleans Id
		$IdSQL = mysqli_real_escape_string($this->conn, $Id);
		// does a prepared query
		$stmt = $this->conn->prepare("SELECT r.Name, fr.SessionStartDateTime, fr.SessionEndDateTime, r.ChildPrice, r.NormalPrice from FoodRestaurants fr JOIN Restaurants r ON r.Id = fr.RestaurantId WHERE fr.Id = ? limit 1");
		$stmt->bind_param("i", $IdSQL);
		$stmt->execute();
		$stmt->store_result();
		$stmt->bind_result($Name, $SessionStartDateTime, $SessionEndDateTime, $ChildPrice, $AdultPrice);
		$Ticket = array();
		while ($stmt -> fetch()) { 
			$ticket = array("Venue"=>$Name, "StartDateTime"=>$SessionStartDateTime, "EndDateTime"=>$SessionEndDateTime, "ChildPrice"=>$ChildPrice, "AdultPrice"=>$AdultPrice, "About"=>"", "Description" =>"");
			$Ticket = $ticket;
		}
		return $Ticket;
	}
	
	// we have the food Date and need its correspding time(s), grab them from DB
	public function GetFoodTimeByDate($date, $id) {
		// we know the date and restaurant Id, allowing us to pick up the exact corresponding times for the date selected by the user
		$stmt = $this->conn->prepare("SELECT DATE_FORMAT(SessionStartDateTime, '%H:%i'), Id FROM FoodRestaurants WHERE RestaurantId = ? AND SessionStartDateTime LIKE ? GROUP BY TIME(SessionStartDateTime)");
		$stmt->bind_param("is", $id, $date);
		$stmt->execute();
		$stmt->store_result();
		$stmt->bind_result($SessionStartTime, $Id);
		$foodTimes = array();
		while ($stmt -> fetch()) {
			$foodTime = array("SessionStartTime" => $SessionStartTime, "Id" => $Id);
			$foodTimes[] = $foodTime;
		}
		return $foodTimes;
	}
}
?>