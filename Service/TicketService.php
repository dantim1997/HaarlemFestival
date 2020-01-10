<?php
class TicketService
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
    public function RemoveAvailableTicketDance($eventId){
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

    public function RemoveAvailableTicketJazz($eventId){
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

    public function RemoveAvailableTicketTour($eventId){
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
}
?>