<?php
class DB_Helperr
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
		$stmt = $this->Conn->prepare("SELECT e.Id, e.Description, e.Price FROM DanceEvent as e WHERE Special = 1 && Amount > 0");
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
		$stmt = $this->Conn->prepare("SELECT e.Id, v.Name as venue, v.Location as location, e.Description, e.StartDateTime, e.EndDateTime, e.Price, GROUP_CONCAT(a.Name) artist 
		FROM DanceEvent as e 
		join DanceVenue as v on v.Id = e.VenueId 
		join performingact p on p.EventId = e.Id 
		join DanceArtist a on a.Id = p.ArtistId 
		where StartDateTime LIKE ? AND Special = 0 AND e.Amount > 0 GROUP by e.Id");
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
		$stmt = $this->Conn->prepare("SELECT da.Id, da.Name, da.Types, ep.ParagraphTextEnglish, da.KnownFor, ei.Image from DanceArtist da
		JOIN EventImage ei on ei.Id = da.ImageRef
		JOIN EventParagraph ep on ep.Id = da.ParagraphId
		where da.Id != 0");
		//$stmt->bind_param();
		$stmt->execute();
		$stmt->store_result();
		$stmt-> bind_result($Id, $Name, $Types, $About, $KnownFor, $ImageName); 
		$artists = array();
		while ($stmt -> fetch()) { 
			$artist = array("Id"=>$Id, "Name"=>$Name, "Types"=>$Types, "About"=>$About, "KnownFor"=>$KnownFor, "ImageName"=>"http://hfteam3.infhaarlem.nl/cms/".$ImageName);
			$artists[] = $artist;
		}
		return $artists;
	}

	//get user by Id from DB by Id
	public function GetArtistsNL(){
		//does a prepared query
		$stmt = $this->Conn->prepare("SELECT da.Id, da.Name, da.Types, ep.ParagraphTextDutch, da.KnownFor, ei.Image from DanceArtist da
		JOIN EventImage ei on ei.Id = da.ImageRef
		JOIN EventParagraph ep on ep.Id = da.ParagraphId
		where da.Id != 0");
		//$stmt->bind_param();
		$stmt->execute();
		$stmt->store_result();
		$stmt-> bind_result($Id, $Name, $Types, $About, $KnownFor, $ImageName); 
		$artists = array();
		while ($stmt -> fetch()) { 
			$artist = array("Id"=>$Id, "Name"=>$Name, "Types"=>$Types, "About"=>$About, "KnownFor"=>$KnownFor, "ImageName"=>"http://hfteam3.infhaarlem.nl/cms/".$ImageName);
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
			join DanceVenue as v on v.Id = e.VenueId
			join performingact as p on p.EventId = e.Id
			join DanceArtist a on a.Id = p.ArtistId
			where p.ArtistId = ? AND Special = 0 AND e.Amount > 0");
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
	public function GetSearch($artistSearch, $locationSearch){
		if($artistSearch != "" && $locationSearch != ""){
			$artistSearch .= " OR ";
		}
		//does a prepared query
		$stmt = $this->Conn->prepare("SELECT e.Id, v.Name, e.Description, StartDateTime, EndDateTime, Price, GROUP_CONCAT(a.Name) Artist FROM DanceEvent as e 
			join DanceVenue as v on v.Id = e.VenueId
			JOIN performingact as p on p.EventId = e.Id 
			join DanceArtist a on a.Id = p.ArtistId
			WHERE ".$artistSearch." ".$locationSearch." AND e.Amount > 0 GROUP BY e.Id");
		$stmt->execute();
		$stmt->store_result();
		$stmt-> bind_result($Id, $venue, $description, $startDateTime, $endDateTime, $price, $artist); 
		$events = array();
		while ($stmt -> fetch()) { 
			$event = array("ID"=>$Id, "Venue"=>$venue, "description"=>$description, "StartDateTime"=>$startDateTime, "EndDateTime"=>$endDateTime, "Price"=>$price, "artist"=>$artist);
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

	//get tickets
	public function GetOrderTicketsJazz($orderId){
		//does a prepared query
		$stmt = $this->Conn->prepare("SELECT j.id, j.Location, j.StartDateTime, j.EndDateTime, j.ArtistName, '' info
			FROM `Order` o
			join OrderLine ol on ol.OrderId = o.id
			join Tickets t on t.Id = ol.TicketId
			join Jazz j on j.Id = t.EventId
			WHERE o.OrderNumber = ? && t.TypeEvent = 4");
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

	//Get the sessions for historic
	public function GetToursByFilters($language, $day, $type){
		//does a prepared query
		$stmt = $this->Conn->prepare("SELECT Id, Description, StartDateTime, EndDateTime, Price, Language, TypeTicket, ReferenceId, Amount from HistoricTours WHERE Language LIKE ? AND StartDateTime LIKE ? AND TypeTicket LIKE ? ORDER BY StartDateTime ASC");
		$day = "%".$day."%"; 
		$stmt->bind_param("sss", $language, $day, $type);
		$stmt->execute();
		$stmt->store_result();
		$stmt-> bind_result($Id, $Description, $StartDateTime, $EndDateTime, $Price, $Language, $TypeTicket, $ReferenceId, $Amount); 
		$tours = array();
		while ($stmt -> fetch()) { 
			$tour = array("Id"=>$Id, "Description"=>$Description, "StartDateTime"=>$StartDateTime, "EndDateTime"=>$EndDateTime, "Price"=>$Price, "Language"=>$Language, "TypeTicket"=>$TypeTicket, "ReferenceId"=>$ReferenceId, "Amount"=>$Amount);
			$tours[] = $tour;
		}
		return $tours;
	
	}

	public function GetRestaurantInfo() {
		$stmt = $this->Conn->prepare("SELECT r.Name, ei.Image, r.Cuisines FROM Restaurants r JOIN EventImage ei ON r.ImageRef = ei.Id");
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
			$foodSection = array("Id" => $Id, "Name" => $Name, "Cuisines" => $Cuisines, "Location" => $Location, "Rating" => $Rating, "NormalPrice" => $NormalPrice, "ChildPrice" => $ChildPrice, "LocationLink" => $LocationLink, "Logo" => '<img src= http://hfteam3.infhaarlem.nl/cms/'.$Logo.' class="restaurantInfoImages"/>', "SessionStartDateTime" => $SessionStartDateTime, "SessionEndDateTime" => $SessionEndDateTime, "Amount" => $Amount);
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

	public function Get_PageTextEnglish($page){
		$stmt = $this->Conn->prepare("SELECT ParagraphTextEnglish FROM EventParagraph WHERE EventPage LIKE ? ORDER BY PageSequenceNumber ASC");
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

	public function Get_PageTextDutch($page){
		$stmt = $this->Conn->prepare("SELECT ParagraphTextDutch FROM EventParagraph WHERE EventPage LIKE ? ORDER BY PageSequenceNumber ASC");
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
			$artist = array("Name"=>$Name, "Image"=>"http://hfteam3.infhaarlem.nl/cms/".$Image, "Genre"=>$Genre);
			$artists[] = $artist;
		}
		return $artists;
	}

	//get Tickets for Jazz
	public function GetTicketsJazz($date){
		//does a prepared query
		$stmt = $this->Conn->prepare("SELECT ID, ArtistName, StartDateTime, EndDateTime, Price, Hall FROM Jazz WHERE StartDateTime LIKE ? OR (ArtistName LIKE '%whole%' AND EndDateTime > '".$date."%') ORDER BY EndDateTime, Hall ASC");
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
	public function GetArtistTableJazz($datetime){
		//does a prepared query
		$stmt = $this->Conn->prepare("SELECT ArtistName FROM Jazz WHERE StartDateTime LIKE ? AND Genre IS NOT NULL");
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
		$stmt = $this->Conn->prepare("SELECT Genre FROM Jazz WHERE Genre IS NOT NULL GROUP BY Genre");
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

	//Get dates for jazz
	public function GetDatesJazz(){
		//does a prepared query
		$stmt = $this->Conn->prepare("SELECT StartDateTime, EndDateTime FROM Jazz GROUP BY DATE(StartDateTime) ASC");
		$stmt->execute();
		$stmt->store_result();
		$stmt-> bind_result($StartDateTime, $EndDateTime); 
		$dates = array();
		while ($stmt -> fetch()) { 
			$date = array("StartDateTime"=>$StartDateTime, "EndDateTime"=>$EndDateTime);
			$dates[] = $date;
		}
		return $dates;
	}

	//Get times for jazz programme
	public function GetTimesJazz(){
		//does a prepared query
		$stmt = $this->Conn->prepare("SELECT StartDateTime, EndDateTime FROM Jazz WHERE Genre IS NOT NULL GROUP BY TIME(StartDateTime) ASC");
		$stmt->execute();
		$stmt->store_result();
		$stmt-> bind_result($StartDateTime, $EndDateTime); 
		$dates = array();
		while ($stmt -> fetch()) { 
			$date = array("StartDateTime"=>$StartDateTime, "EndDateTime"=>$EndDateTime);
			$dates[] = $date;
		}
		return $dates;
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

	//get all tickets by customer
	public function GetEventInfoDance($id){
		//clean Id
		$IdSQL = mysqli_real_escape_string($this->Conn, $id);
		//does a prepared query
		$stmt = $this->Conn->prepare("SELECT e.Id, v.Name, e.Description 'About', e.startdatetime, e.EndDateTime, GROUP_CONCAT(a.Name)'description', e.Price FROM DanceEvent e
			JOIN DanceVenue v on v.Id = e.VenueId
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

	public function GetEventInfoHistoric($id){
		//clean Id
		$IdSQL = mysqli_real_escape_string($this->Conn, $id);
		//does a prepared query
		$stmt = $this->Conn->prepare("SELECT Id, Language, TypeTicket, Price, StartDateTime, EndDateTime FROM HistoricTours WHERE Id = ?");
		$stmt->bind_param("i", $IdSQL);
		$stmt->execute();
		$stmt->store_result();
		$stmt-> bind_result($Id, $Language, $TypeTicket, $Price, $StartDateTime, $EndDateTime); 
		$Ticket = array();
		while ($stmt -> fetch()) { 
			$ticket = array("ID"=>$Id, "Venue"=>"Church of St. Bavo", "About"=>$Language, "StartDateTime"=>$StartDateTime, "EndDateTime"=>$EndDateTime, "Description"=>$TypeTicket ." Tour", "Price"=>$Price);
		}
		return $ticket;
		}

	public function GetEventInfoJazz($id){
		//clean Id
		$IdSQL = mysqli_real_escape_string($this->Conn, $id);
		//does a prepared query
		$stmt = $this->Conn->prepare("SELECT Id, ArtistName, Hall, Location, Price, StartDateTime, EndDateTime FROM Jazz WHERE Id = ?");
		$stmt->bind_param("i", $IdSQL);
		$stmt->execute();
		$stmt->store_result();
		$stmt-> bind_result($Id, $ArtistName, $Hall, $Location, $Price, $StartDateTime, $EndDateTime);
		$stmt->fetch();
		$ticket = array("ID"=>$Id, "About"=>"<br><strong>".$ArtistName."</strong>", "Description"=>null, "Venue"=>$Location.", ".$Hall, "StartDateTime"=>$StartDateTime, "EndDateTime"=>$EndDateTime, "Price"=>$Price);
		return $ticket;
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

	public function GetContentPage($id){
		//clean Id
		$IdSQL = mysqli_real_escape_string($this->Conn, $id);
		//does a prepared query
		$stmt = $this->Conn->prepare("SELECT TitleEnglish, TitleDutch, PageTextEnglish, PageTextDutch, LastEdited FROM Pages WHERE Id = ?");
		$stmt->bind_param("i", $IdSQL);
		$stmt->execute();
		$stmt->store_result();
		$stmt-> bind_result($EnglishTitle, $DutchTitle, $EnglishText, $DutchText, $Date);
		$stmt->fetch();
		$ticket = array("EnglishTitle"=>$EnglishTitle, "DutchTitle"=>$DutchTitle, "EnglishText"=>$EnglishText, "DutchText"=>$DutchText, "Date"=>$Date);
		return $ticket;
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

	public function GetToursByReferenceId($referenceId){
		//clean Id
		$IdSQL = mysqli_real_escape_string($this->Conn, $referenceId);
		//does a prepared query
		$stmt = $this->Conn->prepare("SELECT Id FROM HistoricTours WHERE ReferenceId = ?");
		$stmt->bind_param("i", $IdSQL);
		$stmt->execute();
		$stmt->store_result();
		$stmt-> bind_result($Id);
		$stmt->fetch();
		return $Id;
	}

	public function GetFooterPages(){
		//does a prepared query
		$stmt = $this->Conn->prepare("SELECT Id, TitleDutch, TitleEnglish FROM Pages");
		$stmt->execute();
		$stmt->store_result();
		$stmt-> bind_result($Id, $TitleDutch, $TitleEnglish); 
		$pages = array();
		while ($stmt -> fetch()) { 
			$page = array("ID"=>$Id, "EnglishTitle"=>$TitleEnglish, "DutchTitle"=>$TitleDutch);
			$pages[] = $page;
		}
		return $pages;
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

	public function GetEventDates(){
		//does a prepared query
		$stmt = $this->Conn->prepare("SELECT StartDateTime From Jazz GROUP BY DATE(StartDateTime)");
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

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//Insert
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

public function CreateOrder($orderInfo, $uniqueCode){
	//clean username, password and email
	$FirstName = mysqli_real_escape_string($this->Conn, $orderInfo['FirstName']);
	$LastName = mysqli_real_escape_string($this->Conn, $orderInfo['LastName']);
	$Email = mysqli_real_escape_string($this->Conn, $orderInfo['Email']);
	$Street = mysqli_real_escape_string($this->Conn, $orderInfo['Street']);
	$PostCode = mysqli_real_escape_string($this->Conn, $orderInfo['PostCode']);
	$HouseNumber = mysqli_real_escape_string($this->Conn, $orderInfo['HouseNumber']);
	var_dump($orderInfo['PhoneNumber']);
	if(isset($orderInfo['PhoneNumber'])){
		$PhoneNumber = mysqli_real_escape_string($this->Conn, $orderInfo['PhoneNumber']);
	}
	else{
		$PhoneNumber = "";
	}
	$adress = $PostCode . " ". $Street . " ". $HouseNumber;
	$Date = date("Y-m-d H:i:s");
	//does prepared query
	$stmt = $this->Conn->prepare("INSERT INTO `Order` (FirstName, LastName, Email, Address, Date, OrderNumber, PhoneNumber) VALUES(?, ?, ?, ?, ?, ?, ?)");
	$stmt->bind_param("sssssss", $FirstName, $LastName, $Email,$adress, $Date, $uniqueCode, $PhoneNumber);
	// Commit or rollback transaction
	if ($stmt->execute()) {
		$this->Conn->commit();
		return $stmt->insert_id;
	} else {
		$this->Conn->rollback();
		return 0;
	} 
}

public function CreateTicket($eventId, $TypeEvent, $QRCode, $price){
	//clean username, password and email
	$eventId = mysqli_real_escape_string($this->Conn, $eventId);
	$typeEvent = mysqli_real_escape_string($this->Conn, $TypeEvent);
	$QRCode = mysqli_real_escape_string($this->Conn, $QRCode);

	//does prepared query
	$stmt = $this->Conn->prepare("INSERT INTO `Tickets` (EventId, TypeEvent, QRCode, Price) VALUES(?, ?, ?, ?)");
	$stmt->bind_param("iisd", $eventId, $typeEvent, $QRCode, $price);
	/* Commit or rollback transaction */
	if ($stmt->execute()) {
		$this->Conn->commit();
		return $stmt->insert_id;
	} else {
		$this->Conn->rollback();
		return 0;
	}   
}

public function CreateOrderLine($orderId, $ticketId){
	//clean username, password and email
	$orderId = mysqli_real_escape_string($this->Conn, $orderId);
	$ticketId = mysqli_real_escape_string($this->Conn, $ticketId);

	//does prepared query
	$stmt = $this->Conn->prepare("INSERT INTO `OrderLine` (OrderId, TicketId) VALUES(?, ?)");
	$stmt->bind_param("ii", $orderId, $ticketId);
	/* Commit or rollback transaction */
	if ($stmt->execute()) {
		$this->Conn->commit();
		return $stmt->insert_id;
	} else {
		$this->Conn->rollback();
		return 0;
	}   
}

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//Update
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

public function RemoveAvailableTicketFood($restaurantId){
	// does a prepared query
	$stmt = $this->Conn->prepare("UPDATE FoodRestaurants SET Amount = Amount - 1 WHERE Id = ?");
	$stmt->bind_param("i", $restaurantId);

	// commit or rollback transaction
	if ($stmt->execute()) {
		$this->Conn->commit();
		return true;
	} else {
		$this->Conn->rollback();
	} 
}

//reset the password with the new password and send a mail
public function RemoveavAilableTicketDance($eventId){
	//cleans email and password
	$emailSQL = mysqli_real_escape_string($this->Conn, $eventId);

	//does a prepared query
	$stmt = $this->Conn->prepare("UPDATE DanceEvent set Amount = Amount - 1 where Id = ?");
	$stmt->bind_param("i", $eventId);
	/* Commit or rollback transaction */
	if ($stmt->execute()) {
		$this->Conn->commit();
		return true;
	} else {
		$this->Conn->rollback();
	} 
}

public function RemoveavAilableTicketJazz($eventId){
	//cleans email and password
	$emailSQL = mysqli_real_escape_string($this->Conn, $eventId);

	//does a prepared query
	$stmt = $this->Conn->prepare("UPDATE Jazz set Amount = Amount - 1 where Id = ?");
	$stmt->bind_param("i", $eventId);
	/* Commit or rollback transaction */
	if ($stmt->execute()) {
		$this->Conn->commit();
		return true;
	} else {
		$this->Conn->rollback();
	} 
}

public function RemoveavAilableTicketTour($eventId){
	//cleans email and password
	$id = mysqli_real_escape_string($this->Conn, $eventId);
	//does a prepared query
	$stmt = $this->Conn->prepare("SELECT TypeTicket, ReferenceId FROM HistoricTours WHERE Id = ?");
	$stmt->bind_param("i", $id);
	$stmt->execute();
	$stmt->store_result();
	$stmt-> bind_result($Type, $ReferenceId);
	$stmt->fetch();
	$type = $Type;
	$ref = $ReferenceId;
	if ($type == 'Family') {
		$id = $ReferenceId;
	}
	//does a prepared query
	$stmt = $this->Conn->prepare("UPDATE HistoricTours set Amount = Amount - 1 where Id = ?");
	$stmt->bind_param("i", $id);
	/* Commit or rollback transaction */
	if ($stmt->execute()) {
		$this->Conn->commit();
		return true;
	} else {
		$this->Conn->rollback();
	} 
}

public function UpdateTickets($orderId){
	//cleans email and password
	$orderId = mysqli_real_escape_string($this->Conn, $orderId);

	//does a prepared query
	$stmt = $this->Conn->prepare("UPDATE Tickets set StatusId = 1 where Id = ?");
	$stmt->bind_param("i", $orderId);
	/* Commit or rollback transaction */
	if ($stmt->execute()) {
		$this->Conn->commit();
		return true;
	} else {
		$this->Conn->rollback();
	} 
}

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//Delete
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

}
?>