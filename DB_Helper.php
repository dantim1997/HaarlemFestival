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

	//gets all users for DB by role
	public function Get_AllDanceEvents(){
		//does a prepared query
		$stmt = $this->Conn->prepare("SELECT e.Id, v.Name venue, v.Location location, e.Description, e.StartDateTime, e.EndDateTime, e.Price, GROUP_CONCAT(a.Name) artist FROM DanceEvent as e join Dancevenue as v on v.Id = e.VenueId join performingact p on p.EventId = e.Id join DanceArtist a on a.Id = p.ArtistId GROUP by e.Id ");
		//$stmt->bind_param();
		$stmt->execute();
		$stmt->store_result();
		$stmt-> bind_result($Id, $venue, $location, $description, $startDateTime, $endDateTime, $price, $artist); 
		$events = array();
		while ($stmt -> fetch()) { 
			$event = array("ID"=>$Id, "Venue"=>$venue, "location"=>$location, "description"=>$description, "StartDateTime"=>$startDateTime, "endDateTime"=>$endDateTime, "price"=>$price, "artist"=>$artist);
			$events[] = $event;
		}
		//return $array;
		return $events;
	}

	//gets all users for DB by role
	public function Get_AllSpecialEvents(){
		//does a prepared query
		$stmt = $this->Conn->prepare("SELECT e.Id, e.Description, e.Price FROM DanceEvent as e WHERE Special = 1");
		//$stmt->bind_param();
		$stmt->execute();
		$stmt->store_result();
		$stmt-> bind_result($Id, $description, $price); 
		$events = array();
		while ($stmt -> fetch()) { 
			$event = array("ID"=>$Id, "description"=>$description, "price"=>$price);
			$events[] = $event;
		}
		//return $array;
		return $events;
	}

	//gets all users for DB by role
	public function Get_AllDanceEventsByDate($date){
		//does a prepared query
		$stmt = $this->Conn->prepare("SELECT e.Id, v.Name as venue, v.Location as location, e.Description, e.StartDateTime, e.EndDateTime, e.Price, GROUP_CONCAT(a.Name) artist FROM DanceEvent as e join Dancevenue as v on v.Id = e.VenueId join performingact p on p.EventId = e.Id join DanceArtist a on a.Id = p.ArtistId where StartDateTime LIKE ? GROUP by e.Id");
		$stmt->bind_param("s", $date);
		$stmt->execute();
		$stmt->store_result();
		$stmt-> bind_result($Id, $venue, $location, $description, $startDateTime, $endDateTime, $price, $artist); 
		$events = array();
		while ($stmt -> fetch()) { 
			$event = array("ID"=>$Id, "Venue"=>$venue, "location"=>$location, "description"=>$description, "StartDateTime"=>$startDateTime, "endDateTime"=>$endDateTime, "price"=>$price, "artist"=>$artist);
			$events[] = $event;
		}
		//return $array;
		return $events;
	}

	//get user by Id from DB by Id
	public function GetArtists(){
		//does a prepared query
		$stmt = $this->Conn->prepare("SELECT Id, Name, Types, About, KnownFor from DanceArtist where Id != 0");
		//$stmt->bind_param();
		$stmt->execute();
		$stmt->store_result();
		$stmt-> bind_result($Id, $Name, $Types, $About, $KnownFor); 
		$artists = array();
		while ($stmt -> fetch()) { 
			$artist = array("Id"=>$Id, "Name"=>$Name, "Types"=>$Types, "About"=>$About, "KnownFor"=>$KnownFor);
			$artists[] = $artist;
		}
		return $artists;
	}

	//get user by Id from DB by Id
	public function GetDates(){
		//does a prepared query
		$stmt = $this->Conn->prepare("SELECT DISTINCT DATE(StartDateTime) as Date FROM DanceEvent ");
		//$stmt->bind_param();
		$stmt->execute();
		$stmt->store_result();
		$stmt-> bind_result($Date); 
		$dates = array();
		while ($stmt -> fetch()) { 
			$date = array("Date"=>$Date);
			$dates[] = $date;
		}
		return $dates;
	}

	//get user by Id from DB by Id
	public function GetEventsByArtist($id){
		//does a prepared query
		$stmt = $this->Conn->prepare("SELECT e.Id, v.Name, e.Description, StartDateTime, EndDateTime, Price, a.Name Artist 
			FROM DanceEvent as e 
			join Dancevenue as v on v.Id = e.VenueId
			join performingact as p on p.EventId = e.Id
			join DanceArtist a on a.Id = p.ArtistId
			where p.ArtistId = ?");
		$stmt->bind_param("i", $id);
		$stmt->execute();
		$stmt->store_result();
		$stmt-> bind_result($Id, $venue, $description, $startDateTime, $endDateTime, $price, $artist); 
		$events = array();
		while ($stmt -> fetch()) { 
			$event = array("ID"=>$Id, "Venue"=>$venue, "description"=>$description, "StartDateTime"=>$startDateTime, "endDateTime"=>$endDateTime, "Price"=>$price, "artist"=>$artist);
			$events[] = $event;
		}
		//return $array;
		return $events;
	}

	//get user by Id from DB by Id
	public function GetLocations(){
		//does a prepared query
		$stmt = $this->Conn->prepare("SELECT Id, Name, Location from DanceVenue where Id != 0");
		$stmt->execute();
		$stmt->store_result();
		$stmt-> bind_result($Id, $Name, $Location); 
		$venues = array();
		while ($stmt -> fetch()) { 
			$venue = array("Id"=>$Id, "Name"=>$Name, "Location"=>$Location);
			$venues[] = $venue;
		}
		return $venues;
	}

	//get tickets
	public function GetOrderTicketsDance($orderId){
		//does a prepared query
		$stmt = $this->Conn->prepare("SELECT e.Id, v.Name, e.startdatetime, e.EndDateTime, GROUP_CONCAT(a.Name) description FROM `order` as o
			join orderline ol on ol.OrderId = o.Id 
			join tickets t on t.Id = ol.TicketId
			join danceevent e on e.id = t.eventid
			join DanceVenue as v on v.Id = e.VenueId
			join performingact as p on p.EventId = e.Id 
			join DanceArtist a on a.Id = p.ArtistId
			WHERE o.id = ? && t.TypeTicket = 2
			GROUP by ol.id");
		$stmt->bind_param("i", $orderId);
		$stmt->execute();
		$stmt->store_result();
		$stmt-> bind_result($id, $venue, $startDateTime, $endDateTime, $description); 
		$events = array();
		while ($stmt -> fetch()) { 
			$event = array("ID"=>$id, "Name" =>$venue, "description"=>$description, "StartDateTime"=>$startDateTime, "EndDateTime"=>$endDateTime);
			$events[] = $event;
		}
		//return $array;
		return $events;
	}

	//get tickets
	public function GetOrderTicketsTour($orderId){
		//does a prepared query
		$stmt = $this->Conn->prepare("SELECT ht.Id, 'startpunt' Name, ht.StartDateTime, ht.EndDateTime, ht.Description 
			FROM `order` o
			join orderline ol on ol.OrderId = o.id
			join tickets t on t.Id = ol.TicketId
			join historictours ht on ht.Id = t.EventId
			WHERE o.id = ? && t.TypeTicket = 2
			group by ol.id");
		$stmt->bind_param("i", $orderId);
		$stmt->execute();
		$stmt->store_result();
		$stmt-> bind_result($id, $Name, $startDateTime, $endDateTime, $description); 
		$events = array();
		while ($stmt -> fetch()) { 
			$event = array("ID"=>$id, "Name" =>$Name, "description"=>$description, "StartDateTime"=>$startDateTime, "EndDateTime"=>$endDateTime);
			$events[] = $event;
		}
		//return $array
		return $events;
	}

	//get tickets
	public function GetOrderTicketsJazz($orderId){
		//does a prepared query
		$stmt = $this->Conn->prepare("SELECT j.id, j.Location, j.StartDateTime, j.EndDateTime, j.ArtistName
			FROM `order` o
			join orderline ol on ol.OrderId = o.id
			join tickets t on t.Id = ol.TicketId
			join Jazz j on j.Id = t.EventId
			WHERE o.id = ? && t.TypeTicket = 3");
		$stmt->bind_param("i", $orderId);
		$stmt->execute();
		$stmt->store_result();
		$stmt-> bind_result($id, $Name, $startDateTime, $endDateTime, $description); 
		$events = array();
		while ($stmt -> fetch()) { 
			$event = array("ID"=>$id, "Name" =>$Name, "description"=>$description, "StartDateTime"=>$startDateTime, "EndDateTime"=>$endDateTime);
			$events[] = $event;
		}
		//return $array
		return $events;
	}

	public function GetOrderTicketsFood($orderId){
		//does a prepared query
		$stmt = $this->Conn->prepare("SELECT f.id, f.Location, f.SessionStartDateTime, f.SessionEndDateTime, f.Description
			FROM `order` o
			join orderline ol on ol.OrderId = o.id
			join tickets t on t.Id = ol.TicketId
			join foodrestaurants f on f.Id = t.EventId
			WHERE o.id = ? && t.TypeTicket = 1");
		$stmt->bind_param("i", $orderId);
		$stmt->execute();
		$stmt->store_result();
		$stmt-> bind_result($id, $Name, $startDateTime, $endDateTime, $description); 
		$events = array();
		while ($stmt -> fetch()) { 
			$event = array("ID"=>$id, "Name" =>$Name, "description"=>$description, "StartDateTime"=>$startDateTime, "EndDateTime"=>$endDateTime);
			$events[] = $event;
		}
		//return $array
		return $events;
	}


	//Get the sessions for historic
	public function GetToursByFilters($language, $day, $type){
		//does a prepared query
		$stmt = $this->Conn->prepare("SELECT Id, Description, StartDateTime, EndDateTime, Price, Language, TypeTicket from HistoricTours WHERE Language LIKE ? AND StartDateTime LIKE ? AND TypeTicket LIKE ? ORDER BY StartDateTime ASC");
		$day = "%".$day."%"; 
		$stmt->bind_param("sss", $language, $day, $type);
		$stmt->execute();
		$stmt->store_result();
		$stmt-> bind_result($Id, $Description, $StartDateTime, $EndDateTime, $Price, $Language, $TypeTicket); 
		$tours = array();
		while ($stmt -> fetch()) { 
			$tour = array("Id"=>$Id, "Description"=>$Description, "StartDateTime"=>$StartDateTime, "EndDateTime"=>$EndDateTime, "Price"=>$Price, "Language"=>$Language, "TypeTicket"=>$TypeTicket);
			$tours[] = $tour;
		}
		return $tours;
	
	}

	public function GetFoodSections($queryStringTimes, $queryStringCuisine) {
		$query = "SELECT Id, Name, Cuisines, Location, Rating, NormalPrice, ChildPrice, LocationLink, Logo FROM foodrestaurants";
		if ($queryStringTimes != "" || $queryStringCuisine != "") {
			$query .= " WHERE ".$queryStringTimes." ".$queryStringCuisine;
		}
		$query .= " GROUP BY Name";
		$stmt = $this->Conn->prepare($query);
		$stmt->execute();
		$stmt->store_result();
		$stmt->bind_result($Id, $Name, $Cuisines, $Location, $Rating, $NormalPrice, $ChildPrice, $LocationLink, $Logo);
		$foodSections = array();
		while ($stmt -> fetch()) {
			$foodSection = array("Id" => $Id, "Name" => $Name, "Cuisines" => $Cuisines, "Location" => $Location, "Rating" => $Rating, "NormalPrice" => $NormalPrice, "ChildPrice" => $ChildPrice, "LocationLink" => $LocationLink, "Logo" => '<img src="data:image/jpeg;base64,'.base64_encode( $Logo ).'" class="restaurantInfoImages"/>', );
			$foodSections[] = $foodSection;
		}
		return $foodSections;
	}
    
	//get all tickets by customer
	public function GetTickets($Id){
		//clean Id
		$IdSQL = mysqli_real_escape_string($this->Conn, $Id);
		//does a prepared query
		$stmt = $this->Conn->prepare("SELECT u.ID, Username, Role, Email, Registration_date, Image, r.Rolename from user as u inner join role as r on u.Role = r.Id where u.ID = ? limit 1 ");
		$stmt->bind_param("i", $IdSQL);
		$stmt->execute();
		$stmt->store_result();
		$stmt-> bind_result($Id, $Username, $role, $email, $registration_date, $image, $RoleName); 
		$User = array();
		while ($stmt -> fetch()) { 
			$user = array("ID"=>$Id, "Username"=>$Username, "Role"=>$role, "Email"=>$email, "Registration_date"=>$registration_date, "Image"=>$image, "RoleName"=>$RoleName);
			$User = $user;
		}
		return $User;
	}

	public function GetAllFoodSessions($query) {
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

	public function GetFoodDateTimes($name) {
		$stmt = $this->Conn->prepare("SELECT SessionStartDateTime FROM foodrestaurants WHERE Name LIKE ?");
		$stmt->bind_param("s", $name);
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

	public function Get_PageText($page){
		$stmt = $this->Conn->prepare("SELECT ParagraphText FROM EventParagraph WHERE EventPage LIKE ? ORDER BY PageSequenceNumber ASC");
		$stmt->bind_param("s", $page);
		$stmt->execute();
		$stmt->store_result();
		$stmt-> bind_result($string);
		$pageTextContent = array(); 
		while ($stmt -> fetch()) {
			$pageText = $string;
			$pageTextContent[] = $pageText;
		}
		return $pageTextContent;
	}

	public function Get_PageImage($page){
		$stmt = $this->Conn->prepare("SELECT Image FROM EventImage WHERE EventPage LIKE ? ORDER BY PageSequenceNumber ASC");
		$stmt->bind_param("s", $page);
		$stmt->execute();
		$stmt->store_result();
		$stmt-> bind_result($string); 
		$pageImageContent = array(); 
		while ($stmt -> fetch()) {
			$imageContent = $string;
			$pageImageContent[] = $imageContent;
		}
		return $pageImageContent;
	}

	//get all tickets by customer
	public function GetEventInfoFood($Id){
		//clean Id
		$IdSQL = mysqli_real_escape_string($this->Conn, $Id);
		//does a prepared query
		$stmt = $this->Conn->prepare("SELECT Id, StartDateTime, EndDateTime, Description from foodrestaurants where u.ID = ? limit 1 ");
		$stmt->bind_param("i", $IdSQL);
		$stmt->execute();
		$stmt->store_result();
		$stmt-> bind_result($Id, $Username, $role, $email, $registration_date, $image, $RoleName); 
		$User = array();
		while ($stmt -> fetch()) { 
			$user = array("ID"=>$Id, "Username"=>$Username, "Role"=>$role, "Email"=>$email, "Registration_date"=>$registration_date, "Image"=>$image, "RoleName"=>$RoleName);
			$User = $user;
		}
		return $User;
	}

	//get Artists for Jazz
	public function GetArtistsJazz($genreFilter){
		$sql = "";
		if (empty($genreFilter)){
			$sql = "SELECT ArtistName, ArtistImage, Genre FROM Jazz GROUP BY ArtistName";
		}
		else{
			$sql = "SELECT ArtistName, ArtistImage, Genre FROM Jazz WHERE ".$genreFilter." GROUP BY ArtistName";
		}
		//does a prepared query
		$stmt = $this->Conn->prepare($sql);
		$stmt->execute();
		$stmt->store_result();
		$stmt-> bind_result($Name, $Image, $Genre); 
		$artists = array();
		while ($stmt -> fetch()) { 
			$artist = array("Name"=>$Name, "Image"=>$Image, "Genre"=>$Genre);
			$artists[] = $artist;
		}
		return $artists;
	}

	

	//get Tickets for Jazz (date format yyyy-mm-dd)
	public function GetTicketsJazz($date){
		//does a prepared query
		$stmt = $this->Conn->prepare("SELECT ArtistName, StartDateTime, EndDateTime, Price, Hall FROM Jazz WHERE StartDateTime LIKE '".$date."%' ORDER BY StartDateTime ASC");
		$stmt->execute();
		$stmt->store_result();
		$stmt-> bind_result($Name, $StartDateTime, $EndDateTime, $Price, $Hall); 
		$tickets = array();
		while ($stmt -> fetch()) { 
			$ticket = array("Name"=>$Name, "StartDateTime"=>$StartDateTime, "EndDateTime"=>$EndDateTime, "Price"=>$Price, "Hall"=>$Hall);
			$tickets[] = $ticket;
		}
		return $tickets;
	}

	//get Tickets for Jazz
	public function GetTimeTableJazz(){
		//does a prepared query
		$stmt = $this->Conn->prepare("SELECT ArtistName, StartDateTime, EndDateTime FROM Jazz");
		$stmt->execute();
		$stmt->store_result();
		$stmt-> bind_result($Name, $StartDateTime, $EndDateTime); 
		$artists = array();
		while ($stmt -> fetch()) { 
			$artist = array("Name"=>$Name, "StartDateTime"=>$StartDateTime, "EndDateTime"=>$EndDateTime);
			$artists[] = $artist;
		}
		return $artists;
	}

	public function GetGenresJazz(){
		//does a prepared query
		$stmt = $this->Conn->prepare("SELECT Genre FROM Jazz GROUP BY Genre");
		$stmt->execute();
		$stmt->store_result();
		$stmt-> bind_result($Genre); 
		$genres = array();
		while ($stmt -> fetch()) { 
			$genre = array("Genre"=>$Genre);
			$genres[] = $genre;
		}
		return $genres;
	}

	//get all tickets by customer
	public function GetEventInfoDance($id){
		//clean Id
		$IdSQL = mysqli_real_escape_string($this->Conn, $id);
		//does a prepared query
		$stmt = $this->Conn->prepare("SELECT e.Id, v.Name, e.Description 'About', e.startdatetime, e.EndDateTime, GROUP_CONCAT(a.Name)'description', e.Price FROM danceevent e
			JOIN dancevenue v on v.Id = e.VenueId
			join performingact as p on p.EventId = e.Id 
			join DanceArtist a on a.Id = p.ArtistId
			where e.Id = ?");
		$stmt->bind_param("i", $IdSQL);
		$stmt->execute();
		$stmt->store_result();
		$stmt-> bind_result($Id, $Venue, $About, $StartDateTime, $EndDateTime, $Description, $Price); 
		$User = array();
		while ($stmt -> fetch()) { 
			$user = array("ID"=>$Id, "Venue"=>$Venue, "About"=>$About, "StartDateTime"=>$StartDateTime, "EndDateTime"=>$EndDateTime, "Description"=>$Description, "Price"=>$Price);
			$User = $user;
		}
		return $User;
	}

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//Insert
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

	//set the resetkey and the email in the database
	public function InsertIntoDB($email, $resetKey){
		$resetKeySQL = mysqli_real_escape_string($this->Conn, $resetKey);
		$emailSQL = mysqli_real_escape_string($this->Conn, $email);

		//does a prepared query
		$stmt = $this->Conn->prepare("INSERT INTO resetpassword (Email, ResetKey) VALUES(?, ?)");
		$stmt->bind_param("ss", $emailSQL, $resetKeySQL);
		/* Commit or rollback transaction */
		if ($stmt->execute()) {
			$this->Conn->commit();
	    	return "New record created successfully";
		} else {
			$this->Conn->rollback();
	    	return "Error: " . $sql . "<br>" . $this->Conn->error;
		} 
		$this->Conn->close();
	}

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//Update
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

	//update userinfo
	public function UpdateUser($Id, $Username, $Email, $Image = false, $Role){
		//cleans all variables
		$idSQL = mysqli_real_escape_string($this->Conn, $Id);
		$emailSQL = mysqli_real_escape_string($this->Conn, $Email);
		$usernameSQL = mysqli_real_escape_string($this->Conn, $Username);
		$roleSQL = mysqli_real_escape_string($this->Conn, $Role);
		//checks if image is set if not don't change the image
		if($Image == false ){
			$stmt = $this->Conn->prepare("UPDATE user SET Username = ?, Email = ?, Role = ? where ID = ?");
			$stmt->bind_param("ssii", $usernameSQL, $emailSQL, $roleSQL, $idSQL);
		}
		else{
			$stmt = $this->Conn->prepare("UPDATE user SET Username = ?, Email = ?, Image = ?, Role = ? where ID = ?");
			$stmt->bind_param("ssbii", $usernameSQL, $emailSQL, $Image, $roleSQL, $idSQL);
		}

		/* Commit or rollback transaction */
		if ($stmt->execute()) {
			$this->Conn->commit();
		    return "New record Updated successfully";
		} else {
			$this->Conn->rollback();
		   	return "Error: " . $sql . "<br>" . $this->Conn->error;
		} 
	}

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//Delete
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

	//delete the user from the database
	public function DeleteUser($Id){
		//cleans the Id
		$idSQL = mysqli_real_escape_string($this->Conn, $Id);
		
		$stmt = $this->Conn->prepare("DELETE FROM user where ID = ?");
		$stmt->bind_param("i", $idSQL);

		/* Commit or rollback transaction */
		if ($stmt->execute()) {
			$this->Conn->commit();
			return true;
		} else {
			$this->Conn->rollback();
				return "Error: " . $sql . "<br>" . $this->Conn->error;
		} 
	}
}
?>