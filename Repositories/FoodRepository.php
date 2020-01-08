<?php
class FoodRepository
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

	public function GetOrderTicketsFood($orderId){
		//does a prepared query
		$stmt = $this->Conn->prepare("SELECT fr.id, r.Location, fr.SessionStartDateTime, fr.SessionEndDateTime, r.Name, '' info
		FROM `Order` o
		join OrderLine ol on ol.OrderId = o.id
		join Tickets t on t.Id = ol.TicketId
		join FoodRestaurants fr on fr.Id = t.EventId
		join Restaurants r on r.Id = fr.RestaurantId
		WHERE o.OrderNumber = ? && t.TypeEvent = 1");
		$stmt->bind_param("i", $orderId);
		$stmt->execute();
		$stmt->store_result();
		$stmt-> bind_result($id, $venue, $startDateTime, $endDateTime, $description, $info); 
		$events = array();
		while ($stmt -> fetch()) { 
			$event = array("ID"=>$id, "Name" =>$venue, "description"=>$description, "StartDateTime"=>$startDateTime, "EndDateTime"=>$endDateTime, "info"=>$info);
			$events[] = $event;
		}
		//return $array
		return $events;
	}

	public function GetRestaurantInfo() {
		$stmt = $this->Conn->prepare("SELECT r.Name, ei.Image, r.Cuisines FROM Restaurants r JOIN EventImage ei ON r.ImageRef = ei.Id");
		$stmt->execute();
		$stmt->store_result();
		$stmt->bind_result($Name, $Image, $Cuisines);
		$restaurantImages = array();
		while ($stmt -> fetch()) {
			$restaurantImage = array("Name" => $Name, "Image" => $Image, "Cuisines" => $Cuisines);
			$restaurantImages[] = $restaurantImage;
		}
		return $restaurantImages;
	}

	public function GetFoodSections($queryStringTimes, $queryStringCuisine, $queryStringRestaurants) {
		$query = "SELECT r.Id, r.Name, r.Cuisines, r.Location, r.Rating, r.NormalPrice, r.ChildPrice, r.LocationLink, ei.Image, fr.SessionStartDateTime, fr.SessionEndDateTime, fr.Amount 
					FROM FoodRestaurants fr 
					JOIN Restaurants r ON fr.RestaurantId = r.Id
					JOIN EventImage ei ON r.ImageRef = ei.Id";
		if ($queryStringTimes != "" || $queryStringCuisine != "" || $queryStringRestaurants != "") {
			$query .= " WHERE ".$queryStringTimes." ".$queryStringCuisine. " ".$queryStringRestaurants;
		}
		$query .= " GROUP BY r.Id";
		$stmt = $this->Conn->prepare($query);
		$stmt->execute();
		$stmt->store_result();
		$stmt->bind_result($Id, $Name, $Cuisines, $Location, $Rating, $NormalPrice, $ChildPrice, $LocationLink, $Logo, $SessionStartDateTime, $SessionEndDateTime, $Amount);
		$foodSections = array();
		while ($stmt -> fetch()) {
			$foodSection = array("Id" => $Id, "Name" => $Name, "Cuisines" => $Cuisines, "Location" => $Location, "Rating" => $Rating, "NormalPrice" => $NormalPrice, "ChildPrice" => $ChildPrice, "LocationLink" => $LocationLink, "Logo" => '<img src="'.$Logo.'" class="restaurantInfoImages"/>', "SessionStartDateTime" => $SessionStartDateTime, "SessionEndDateTime" => $SessionEndDateTime, "Amount" => $Amount);
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
		$stmt = $this->Conn->prepare($query);
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

	public function GetAllCuisines() {
		$stmt = $this->Conn->prepare("SELECT Cuisines FROM Restaurants GROUP BY Cuisines");
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

	public function GetFoodTimes() {
		$stmt = $this->Conn->prepare("SELECT TIME(SessionStartDateTime) FROM FoodRestaurants WHERE RestaurantId = ? GROUP BY TIME(SessionStartDateTime)");
		$stmt->bind_param("i", $id);
		$stmt->execute();
		$stmt->store_result();
		$stmt->bind_result($SessionStartTime);
		$foodTimes = array();
		while ($stmt -> fetch()) {
			$foodTime = array("SessionStartTime" => $SessionStartTime);
			$foodTimes[] = $foodTime;
		}
		return $foodTimes;
	}

	public function GetFoodDates() {
		$stmt = $this->Conn->prepare("SELECT DATE(SessionStartDateTime) FROM FoodRestaurants GROUP BY DATE(SessionStartDateTime)");
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
    
	public function GetFoodDescriptionEnglish($name) {
		$stmt = $this->Conn->prepare("SELECT ep.ParagraphTextEnglish FROM Restaurants r JOIN EventParagraph ep ON r.Description = ep.Id WHERE r.Name LIKE ?");
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

	public function GetFoodDescriptionDutch($name) {
		$stmt = $this->Conn->prepare("SELECT ep.ParagraphTextDutch FROM Restaurants r JOIN EventParagraph ep ON r.Description = ep.Id WHERE r.Name LIKE ?");
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

	//get all tickets by customer
	public function GetEventInfoFood($Id) {
		//clean Id
		$IdSQL = mysqli_real_escape_string($this->Conn, $Id);
		//does a prepared query
		$stmt = $this->Conn->prepare("SELECT r.Name, fr.SessionStartDateTime, fr.SessionEndDateTime, r.ChildPrice, r.NormalPrice from FoodRestaurants fr JOIN Restaurants r ON r.Id = fr.RestaurantId WHERE fr.Id = ? limit 1");
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
	
	public function GetFoodTimeByDate($date, $id) {
		$stmt = $this->Conn->prepare("SELECT DATE_FORMAT(SessionStartDateTime, '%H:%i'), Id FROM FoodRestaurants WHERE RestaurantId = ? AND SessionStartDateTime LIKE ? GROUP BY TIME(SessionStartDateTime)");
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