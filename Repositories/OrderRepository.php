<?php
class DB_Helper
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

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//Select
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


	public function GetAllByOrderLine($id){
		//clean Id
		$tickets = array();
		$IdSQL = mysqli_real_escape_string($this->Conn, $id);
		//does a prepared query
		$stmt = $this->Conn->prepare("
		select t.Id from OrderLine
		join Tickets t on t.Id = OrderLine.TicketId
		where OrderLine.OrderId = ?");
		$stmt->bind_param("i", $IdSQL);
		$stmt->execute();
		$stmt->store_result();
		$stmt-> bind_result($Id);
		while ($stmt -> fetch()) { 
			$ticket = array("Id"=>$Id);
			array_push($tickets,$ticket);
		}
		return $tickets;
	}

	public function GetAllCustomerInfo($id){
		//clean Id
		$IdSQL = mysqli_real_escape_string($this->Conn, $id);
		//does a prepared query
		$stmt = $this->Conn->prepare("SELECT FirstName, LastName, Email, Address, PhoneNumber, OrderNumber FROM `Order` WHERE Id = ?");
		$stmt->bind_param("i", $IdSQL);
		$stmt->execute();
		$stmt->store_result();
		$stmt-> bind_result($FirstName, $LastName ,$Email, $Address, $PhoneNumber, $OrderNumber);
		$stmt->fetch();
		$info = array($FirstName." ".$LastName, $Email, $Address, $PhoneNumber, $OrderNumber);
		return $info;
	}

	public function GetAllTicketInfoDance($id){
		//clean Id
		$tickets = array();
		$IdSQL = mysqli_real_escape_string($this->Conn, $id);
		//does a prepared query
		$stmt = $this->Conn->prepare("
		select GROUP_CONCAT(a.Name) artist, e.Description, o.FirstName , o.LastName, v.Name, v.Location, e.StartDateTime, e.EndDateTime, t.Price, t.QRCode from `Order` o 
		JOIN OrderLine ol on ol.OrderId = o.Id
		JOIN Tickets t on t.Id = ol.TicketId
		JOIN DanceEvent e on e.Id = t.EventId
		JOIN performingact p on p.EventId = e.Id
		JOIN DanceArtist a on a.Id = p.ArtistId
		JOIN DanceVenue v on v.Id = e.VenueId
		where o.Id = ? && t.TypeEvent = 2
		GROUP by t.Id");
		$stmt->bind_param("i", $IdSQL);
		$stmt->execute();
		$stmt->store_result();
		$stmt-> bind_result($artist, $description, $firstName, $lastName, $location, $address, $startDate, $endDate, $price, $qrCode);
		while ($stmt -> fetch()) { 
			$startTime = date("H:i:s",strtotime($startDate));
			$endTime = date("H:i:s",strtotime($endDate));
			$date = date_format(date_create($startDate),"d/m/Y");
			$duration =$startTime ." - ".$endTime;
			if($startTime == "00:00:00"){
				$duration = "All Day";
			}
			if($artist == ","){
				$artist = "";
			}
			if($location == ""){
				$location = "Multiple Locations";
			}
			$ticket = array($artist." ".$description, $price, $firstName ." ". $lastName, $location, $address, $date,$duration, $qrCode );
			array_push($tickets,$ticket);
		}
		return $tickets;
	}

	public function GetAllTicketInfoFood($id){
		//clean Id
		$tickets = array();
		$IdSQL = mysqli_real_escape_string($this->Conn, $id);
		//does a prepared query
		$stmt = $this->Conn->prepare("
		select 'reservation', o.FirstName , o.LastName, r.Name, r.Location, f.SessionStartDateTime, f.SessionEndDateTime, t.Price, t.QRCode from `Order` o 
		JOIN OrderLine ol on ol.OrderId = o.Id
		JOIN Tickets t on t.Id = ol.TicketId
		JOIN FoodRestaurants f on f.Id = t.EventId
		JOIN Restaurants r on r.Id = f.RestaurantId
		where o.Id = ? && t.TypeEvent = 1
		GROUP by t.Id");
		$stmt->bind_param("i", $IdSQL);
		$stmt->execute();
		$stmt->store_result();
		$stmt-> bind_result($reservation, $firstName, $lastName, $location, $address, $startDate, $endDate, $price, $qrCode);
		while ($stmt -> fetch()) { 
			$startTime = date("H:i:s",strtotime($startDate));
			$endTime = date("H:i:s",strtotime($endDate));
			$date = date_format(date_create($startDate),"d/m/Y");
			$duration =$startTime ." - ".$endTime;
			if($startTime == "00:00:00"){
				$duration = "All Day";
			}
			$ticket = array($reservation, $price, $firstName ." ". $lastName, $location, $address, $date,$duration , $qrCode);
			array_push($tickets,$ticket);
		}
		return $tickets;
	}

	public function GetAllTicketInfoJazz($id){
		//clean Id
		$tickets = array();
		$IdSQL = mysqli_real_escape_string($this->Conn, $id);
		//does a prepared query
		$stmt = $this->Conn->prepare("
		SELECT j.ArtistName, o.FirstName, o.LastName, j.Location, j.Hall, jv.Adress, j.StartDateTime, j.EndDateTime, t.Price, t.QRCode FROM `Order` o
		Join OrderLine ol on ol.OrderId = o.Id
		JOIN Tickets t on t.Id = ol.TicketId
		Join Jazz j on j.Id = t.EventId
		JOIN JazzVenues jv on jv.Name = j.Location
		where o.Id = ? && t.TypeEvent = 4
		GROUP by t.Id");
		$stmt->bind_param("i", $IdSQL);
		$stmt->execute();
		$stmt->store_result();
		$stmt-> bind_result($artist, $firstName, $lastName, $location, $hall, $address, $startDate, $endDate, $price, $qrCode);
		while ($stmt -> fetch()) { 
			$startTime = date("H:i:s",strtotime($startDate));
			$endTime = date("H:i:s",strtotime($endDate));
			$date = date_format(date_create($startDate),"d/m/Y");
			$duration =$startTime ." - ".$endTime;
			if($startTime == "00:00:00"){
				$duration = "All Day";
			}
			$ticket = array($artist, $price, $firstName ." ". $lastName, $location." (".$hall.")", $address, $date,$duration, $qrCode );
			array_push($tickets,$ticket);
		}
		return $tickets;
	}

	public function GetAllTicketInfoTour($id){
		//clean Id
		$tickets = array();
		$IdSQL = mysqli_real_escape_string($this->Conn, $id);
		//does a prepared query
		$stmt = $this->Conn->prepare("
		SELECT h.Description, o.FirstName, o.LastName, 'Church of St. Bavo' location, h.Language, h.StartDateTime, h.EndDateTime, t.Price, t.QRCode FROM `Order` o
		Join OrderLine ol on ol.OrderId = o.Id
		JOIN Tickets t on t.Id = ol.TicketId
		Join HistoricTours h on h.Id = t.EventId
		WHERE o.Id = ? && t.TypeEvent = 3
		GROUP by t.Id");
		$stmt->bind_param("i", $IdSQL);
		$stmt->execute();
		$stmt->store_result();
		$stmt-> bind_result($description, $firstName, $lastName, $location, $language, $startDate, $endDate, $price, $qrCode);
		while ($stmt -> fetch()) { 
			$startTime = date("H:i:s",strtotime($startDate));
			$endTime = date("H:i:s",strtotime($endDate));
			$date = date_format(date_create($startDate),"d/m/Y");
			$duration =$startTime ." - ".$endTime;
			if($startTime == "00:00:00"){
				$duration = "All Day";
			}
			$ticket = array($description." (".$language.")", $price, $firstName ." ". $lastName, $location, "", $date,$duration, $qrCode );
			array_push($tickets,$ticket);
		}
		return $tickets;
	}


	public function GetTicketAmountDance($eventId)
	{
		//clean Id
		$IdSQL = mysqli_real_escape_string($this->Conn, $eventId);
		//does a prepared query
		$stmt = $this->Conn->prepare("SELECT Amount FROM DanceEvent WHERE Id = ?");
		$stmt->bind_param("i", $IdSQL);
		$stmt->execute();
		$stmt->store_result();
		$stmt-> bind_result($Amount);
		$stmt->fetch();
		$amount = $Amount;
		return $amount;
	}

	public function GetTicketAmountFood($eventId)
	{
		//clean Id
		$IdSQL = mysqli_real_escape_string($this->Conn, $eventId);
		//does a prepared query
		$stmt = $this->Conn->prepare("SELECT Amount FROM FoodRestaurants WHERE Id = ?");
		$stmt->bind_param("i", $IdSQL);
		$stmt->execute();
		$stmt->store_result();
		$stmt-> bind_result($Amount);
		$stmt->fetch();
		$amount = $Amount;
		return $amount;
	}

	public function GetAmountHistoric($id){
        //does a prepared query
        $stmt = $this->Conn->prepare("SELECT TypeTicket, ReferenceId FROM HistoricTours WHERE Id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $stmt->store_result();
        $stmt-> bind_result($Type, $ReferenceId);
        $stmt->fetch();
        $type = $Type;
        if ($type == 'Family') {
            $id = $ReferenceId;
        }
        //does a prepared query
        $stmt = $this->Conn->prepare("SELECT Amount FROM HistoricTours WHERE Id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $stmt->store_result();
        $stmt-> bind_result($Amount);
        $stmt->fetch();
        $amount = array('Amount' => $Amount, 'Type' => $Type, 'ReferenceId' => $ReferenceId);
        return $amount;
    }

	public function GetTicketAmountJazz($eventId)
	{
		//clean Id
		$IdSQL = mysqli_real_escape_string($this->Conn, $eventId);
		//does a prepared query
		$stmt = $this->Conn->prepare("SELECT Amount FROM Jazz WHERE Id = ?");
		$stmt->bind_param("i", $IdSQL);
		$stmt->execute();
		$stmt->store_result();
		$stmt-> bind_result($Amount);
		$stmt->fetch();
		$amount = $Amount;
		return $amount;
	}
	
	public function CheckMail($Email){
		//clean Id
		$EmailSQL = mysqli_real_escape_string($this->Conn, $Email);
		//does a prepared query
		$stmt = $this->Conn->prepare("SELECT OrderNumber FROM `Order` WHERE Email = ? limit 1");
		$stmt->bind_param("s", $EmailSQL);
		$stmt->execute();
		$stmt->store_result();
		$stmt-> bind_result($orderCode);
		$stmt->fetch();
		return $orderCode;
	}

	//get tickets
	public function GetOrderTicketsTour($orderId){
		//does a prepared query
		$stmt = $this->Conn->prepare("SELECT ht.Id, 'startpunt' Name, ht.StartDateTime, ht.EndDateTime, ht.Description, '' info
			FROM `Order` o
			join OrderLine ol on ol.OrderId = o.id
			join Tickets t on t.Id = ol.TicketId
			join HistoricTours ht on ht.Id = t.EventId
			WHERE o.OrderNumber = ? && t.TypeEvent = 3
			group by ol.id");
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
}
?>