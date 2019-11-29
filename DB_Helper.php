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
		$stmt = $this->Conn->prepare("SELECT Id, Name, Types, About, KnownFor from DanceArtist");
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
		$stmt = $this->Conn->prepare("SELECT Id, Name, Location from DanceVenue");
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

	//get user by Id from DB by Id
	public function GetSearch($artistSearch, $locationSearch){
		//does a prepared query
		$stmt = $this->Conn->prepare("SELECT e.Id, v.Name, e.Description, StartDateTime, EndDateTime, Price, GROUP_CONCAT(a.Name) Artist FROM DanceEvent as e 
			join DanceVenue as v on v.Id = e.VenueId
			JOIN performingact as p on p.EventId = e.Id 
			join DanceArtist a on a.Id = p.ArtistId
			WHERE ".$artistSearch." ".$locationSearch." GROUP BY e.Id");
		//$stmt->bind_param("ss", $artistSearch, $locationSearch);
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
	public function GetUser($Id){
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

	//Get the sessions for historic
	public function GetToursByFilters($language, $day, $type){
		//does a prepared query
		$stmt = $this->Conn->prepare("SELECT Id, Description, StartDateTime, EndDateTime, Price, Language, TypeTicket from historictours WHERE Language LIKE ? AND StartDateTime LIKE ? AND TypeTicket LIKE ? ORDER BY StartDateTime ASC");
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

	public function GetAllFoodSections() {
		$stmt = $this->Conn->prepare("SELECT Id, Name, Cuisines, Location, Rating, NormalPrice, ChildPrice, LocationLink, Logo FROM foodrestaurants  GROUP BY Name");
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

	public function GetFoodSessions($name) {
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