<?php
class PaymentService
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
}
?>