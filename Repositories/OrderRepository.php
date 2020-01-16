<?php
class OrderRepository
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
			$startTime = date("H:i",strtotime($startDate));
			$endTime = date("H:i",strtotime($endDate));
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
			$ticket = array($artist." ".$description, $price, $location, $address, $date,$duration, $qrCode );
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
			$startTime = date("H:i",strtotime($startDate));
			$endTime = date("H:i",strtotime($endDate));
			$date = date_format(date_create($startDate),"d/m/Y");
			$duration =$startTime ." - ".$endTime;
			if($startTime == "00:00:00"){
				$duration = "All Day";
			}
			$ticket = array($reservation, $price, $location, $address, $date,$duration , $qrCode);
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
			$startTime = date("H:i",strtotime($startDate));
			$endTime = date("H:i",strtotime($endDate));
			$date = date_format(date_create($startDate),"d/m/Y");
			$duration =$startTime ." - ".$endTime;
			if($startTime == "00:00:00"){
				$duration = "All Day";
			}
			$ticket = array($artist, $price, $location." (".$hall.")", $address, $date,$duration, $qrCode );
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
			$startTime = date("H:i",strtotime($startDate));
			$endTime = date("H:i",strtotime($endDate));
			$date = date_format(date_create($startDate),"d/m/Y");
			$duration =$startTime ." - ".$endTime;
			if($startTime == "00:00:00"){
				$duration = "All Day";
			}
			$ticket = array($description,$price, $location, "", $date,$duration, $qrCode );
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
		// clean Id
		$IdSQL = mysqli_real_escape_string($this->Conn, $eventId);
		// does a prepared query
		$stmt = $this->Conn->prepare("SELECT Amount FROM FoodRestaurants WHERE Id = ?");
		$stmt->bind_param("i", $IdSQL);
		$stmt->execute();
		$stmt->store_result();
		$stmt-> bind_result($Amount);
		$stmt->fetch();
		$amount = $Amount;
		return $amount;
	}

	public function GetTicketAmountHistoric($id){
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
	public function GetOrderTicketsDance($orderId){
		//does a prepared query
		$stmt = $this->Conn->prepare("SELECT e.Id, v.Name, e.startdatetime, e.EndDateTime, GROUP_CONCAT(a.Name) description, Description info FROM `Order` as o
			join OrderLine ol on ol.OrderId = o.Id 
			join Tickets t on t.Id = ol.TicketId
			join DanceEvent e on e.id = t.eventid
			join DanceVenue as v on v.Id = e.VenueId
			join performingact as p on p.EventId = e.Id 
			join DanceArtist a on a.Id = p.ArtistId
			WHERE o.OrderNumber = ? && t.TypeEvent = 2
			GROUP by ol.id");
		$stmt->bind_param("i", $orderId);
		$stmt->execute();
		$stmt->store_result();
		$stmt-> bind_result($id, $venue, $startDateTime, $endDateTime, $description, $info); 
		$events = array();
		while ($stmt -> fetch()) { 
			if($description == ","){
				$description = "";
			}
			$event = array("ID"=>$id, "Name" =>$venue, "description"=>$description, "StartDateTime"=>$startDateTime, "EndDateTime"=>$endDateTime, "info"=>$info);
			$events[] = $event;
		}
		//return $array;
		return $events;
	}

	
	public function GetOrderTicketsFood($orderId){
		//does a prepared query
		$stmt = $this->Conn->prepare("SELECT fr.id, r.Location, fr.SessionStartDateTime, fr.SessionEndDateTime, r.Name, '' info, count(fr.id) amount
		FROM `Order` o
		join OrderLine ol on ol.OrderId = o.id
		join Tickets t on t.Id = ol.TicketId
		join FoodRestaurants fr on fr.Id = t.EventId
		join Restaurants r on r.Id = fr.RestaurantId
		WHERE o.OrderNumber = ? && t.TypeEvent = 1
		GROUP by fr.Id");
		$stmt->bind_param("i", $orderId);
		$stmt->execute();
		$stmt->store_result();
		$stmt-> bind_result($id, $venue, $startDateTime, $endDateTime, $description, $info, $amount); 
		$events = array();
		while ($stmt -> fetch()) { 
			$event = array("ID"=>$id, "Name" =>$venue, "description"=>$description. " (".$amount.")", "StartDateTime"=>$startDateTime, "EndDateTime"=>$endDateTime, "info"=>$info);
			$events[] = $event;
		}
		//return $array
		return $events;
	}

	//get tickets
	public function GetOrderTicketsJazz($orderId){
		//does a prepared query
		$stmt = $this->Conn->prepare("SELECT j.id, j.Location, j.StartDateTime, j.EndDateTime, j.ArtistName, '' info , count(j.id) amount
			FROM `Order` o
			join OrderLine ol on ol.OrderId = o.id
			join Tickets t on t.Id = ol.TicketId
			join Jazz j on j.Id = t.EventId
			WHERE o.OrderNumber = ? && t.TypeEvent = 4
			group by j.Id");
		$stmt->bind_param("i", $orderId);
		$stmt->execute();
		$stmt->store_result();
		$stmt-> bind_result($id, $venue, $startDateTime, $endDateTime, $description, $info, $amount); 
		$events = array();
		while ($stmt -> fetch()) { 
			$event = array("ID"=>$id, "Name" =>$venue, "description"=>$description. " (".$amount.")", "StartDateTime"=>$startDateTime, "EndDateTime"=>$endDateTime, "info"=>$info);
			$events[] = $event;
		}
		//return $array
		return $events;
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
			if($description == ","){
				$description = "";
			}
			$event = array("ID"=>$id, "Name" =>$venue, "description"=>$description, "StartDateTime"=>$startDateTime, "EndDateTime"=>$endDateTime, "info"=>$info);
			$events[] = $event;
		}
		//return $array;
		return $events;
	}

	public function GetInvoiceTicketsDanceArtist($eventId){
		//does a prepared query
		$stmt = $this->Conn->prepare("select a.Name from DanceArtist a
		join performingact p on p.ArtistId = a.Id
		join DanceEvent e on e.Id = p.EventId
		where e.Id= ?");
		$stmt->bind_param("i", $eventId);
		$stmt->execute();
		$stmt->store_result();
		$stmt-> bind_result($name); 
		$names = "";
		while ($stmt -> fetch()) { 
			$names .= $name ." ";
		}
		//return $array;
		return $names;
	}

	public function GetInvoiceTicketsDance($orderId)
	{
		//clean Id
		$IdSQL = mysqli_real_escape_string($this->Conn, $orderId);
		//does a prepared query
		$stmt = $this->Conn->prepare("select e.Id, e.Description, e.StartDateTime, e.EndDateTime, count(t.id) amount, t.Price, '9%' vat, e.Special from `Order` o 
		JOIN OrderLine ol on ol.OrderId = o.Id
		JOIN Tickets t on t.Id = ol.TicketId
		JOIN DanceEvent e on e.Id = t.EventId
		where o.Id = ? && t.TypeEvent = 2
		GROUP BY t.Id");
		$stmt->bind_param("i", $IdSQL);
		$stmt->execute();
		$stmt->store_result();
		$stmt-> bind_result($id, $description, $startdate, $enddate, $amount, $price, $vat, $special);
		$invoiceTickets = array();
		while ($stmt -> fetch()) { 
			$artists = "";
			if($special != "1"){
				$name = $this->GetInvoiceTicketsDanceArtist($id);
				$artists = $name;
			}
			$invoiceTicket = array($artists, $description, $startdate, $enddate, $amount, $price , $vat);
			$invoiceTickets[] = $invoiceTicket;
		}
		//return $array;
		return $invoiceTickets;
	}

	public function GetInvoiceTicketsFood($orderId)
	{
		//clean Id
		$IdSQL = mysqli_real_escape_string($this->Conn, $orderId);
		//does a prepared query
		$stmt = $this->Conn->prepare("select  r.Name, '' description, fr.SessionStartDateTime, fr.SessionEndDateTime, count(fr.id) amount, t.Price, '9%' vat from `Order` o 
		JOIN OrderLine ol on ol.OrderId = o.Id
		JOIN Tickets t on t.Id = ol.TicketId
		JOIN FoodRestaurants fr on fr.Id = t.EventId
		JOIN Restaurants r on r.Id = fr.RestaurantId
		where o.Id = ? && t.TypeEvent = 1
		GROUP by fr.Id");
		$stmt->bind_param("i", $IdSQL);
		$stmt->execute();
		$stmt->store_result();
		$stmt-> bind_result($artist, $description, $startdate, $enddate, $amount, $price, $vat);
		$invoiceTickets = array();
		while ($stmt -> fetch()) { 
			if($description == ","){
				$description = "";
			}
			$invoiceTicket = array($artist, $description, $startdate, $enddate, $amount, $price , $vat);
			$invoiceTickets[] = $invoiceTicket;
		}
		//return $array;
		return $invoiceTickets;
	}

	public function GetInvoiceTicketsJazz($orderId)
	{
		//clean Id
		$IdSQL = mysqli_real_escape_string($this->Conn, $orderId);
		//does a prepared query
		$stmt = $this->Conn->prepare("select  j.ArtistName, '' description, j.StartDateTime, j.EndDateTime, count(j.id) amount, t.Price, '9%' vat from `Order` o 
		JOIN OrderLine ol on ol.OrderId = o.Id
		JOIN Tickets t on t.Id = ol.TicketId
		JOIN Jazz j on j.Id = t.EventId
		where o.Id = ? && t.TypeEvent = 4
		GROUP by j.Id");
		$stmt->bind_param("i", $IdSQL);
		$stmt->execute();
		$stmt->store_result();
		$stmt-> bind_result($artist, $description, $startdate, $enddate, $amount, $price, $vat);
		$invoiceTickets = array();
		while ($stmt -> fetch()) { 
			if($description == ","){
				$description = "";
			}
			$invoiceTicket = array($artist, $description, $startdate, $enddate, $amount, $price , $vat);
			$invoiceTickets[] = $invoiceTicket;
		}
		//return $array;
		return $invoiceTickets;
	}

	public function GetInvoiceTicketsTour($orderId)
	{
		//clean Id
		$IdSQL = mysqli_real_escape_string($this->Conn, $orderId);
		//does a prepared query
		$stmt = $this->Conn->prepare("select  h.Description, '' description, h.StartDateTime, h.EndDateTime, count(h.id) amount, t.Price, '9%' vat from `Order` o 
		JOIN OrderLine ol on ol.OrderId = o.Id
		JOIN Tickets t on t.Id = ol.TicketId
		JOIN HistoricTours h on h.Id = t.EventId
		where o.Id = ? && t.TypeEvent = 3
		GROUP by h.Id");
		$stmt->bind_param("i", $IdSQL);
		$stmt->execute();
		$stmt->store_result();
		$stmt-> bind_result($artist, $description, $startdate, $enddate, $amount, $price, $vat);
		$invoiceTickets = array();
		while ($stmt -> fetch()) { 
			if($description == ","){
				$description = "";
			}
			$invoiceTicket = array($artist, $description, $startdate, $enddate, $amount, $price , $vat);
			$invoiceTickets[] = $invoiceTicket;
		}
		//return $array;
		return $invoiceTickets;
	}

	public function GetInvoiceOrder($orderId)
	{
		//clean Id
		$IdSQL = mysqli_real_escape_string($this->Conn, $orderId);
		//does a prepared query
		$stmt = $this->Conn->prepare("select  o.FirstName, o.LastName, o.OrderNumber, o.Address, o.PhoneNumber, o.Email from `Order` o 
		where o.Id = ?");
		$stmt->bind_param("i", $IdSQL);
		$stmt->execute();
		$stmt->store_result();
		$stmt-> bind_result($firstname, $lastName, $OrderNumber, $address, $PhoneNumber, $Email);
		$stmt->fetch();
			$invoiceOrder = array($firstname, $lastName, $OrderNumber, $address, $PhoneNumber, $Email , Date("d-m-Y"));
		//return $array;
		return $invoiceOrder;
	}
}
?>