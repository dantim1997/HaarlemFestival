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

	/*VOORBEELD METHODES
	//gets all users for DB by role
	public function Get_AllUsers($role){
		//does a prepared query
		$stmt = $this->Conn->prepare("SELECT u.ID, Username, Role, Email, Registration_date, Image, r.Rolename from user as u inner join role as r on u.Role = r.Id where Role < ?");
		$stmt->bind_param("i", $role);
		$stmt->execute();
		$stmt->store_result();
		$stmt-> bind_result($Id, $Username, $role, $email, $registration_date, $image, $RoleName); 
		$Users = array();
		while ($stmt -> fetch()) { 
			$user = array("ID"=>$Id, "Username"=>$Username, "Role"=>$role, "Email"=>$email, "Registration_date"=>$registration_date, "Image"=>$image, "RoleName"=>$RoleName);
			$Users[] = $user;
		}
		//return $array;
		return $Users;
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
	}*/


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