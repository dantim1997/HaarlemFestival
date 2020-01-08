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

}
?>