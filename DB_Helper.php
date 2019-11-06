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
	}

	//looks if the password that is given is correct with de database one
	public function Login($Username, $Password){
		$usernameSQL = mysqli_real_escape_string($this->Conn, $Username);

		//does prepared query
		$stmt = $this->Conn->prepare("SELECT Password, ID from user WHERE Username = ? LIMIT 1");
		$stmt->bind_param("s", $usernameSQL);
		$stmt->execute();
		$stmt->store_result();
		$stmt-> bind_result($PasswordDB, $Id); 

		//checks the password with that of the database and return the Id
		if($stmt ->fetch()) { 
			if($Password == $PasswordDB){
				return $Id;
			}
			else{
				return 0;
			}
		}
	}

	//checks if username is al ready in use
	public function DoesUsernameExists($Username){
		$usernameSQL = mysqli_real_escape_string($this->Conn, $Username);

	    $stmt = $this->Conn->prepare("SELECT * from user WHERE Username =? LIMIT 1");
		$stmt->bind_param("s", $usernameSQL);
		$stmt->execute();
		$stmt->store_result();
		
		if($stmt->num_rows > 0) {
	        return "<br><p id='errormessage'> Your Username is already in use.<p>"; // The record(s) exist
	    }
		else{
			return false;
		}
	}


	//checks if Email is al ready in use
	public function DoesEmailExists($Email){
		$emailSQL = mysqli_real_escape_string($this->Conn, $Email);

		$stmt = $this->Conn->prepare("SELECT * from user WHERE Email =? LIMIT 1");
		$stmt->bind_param("s", $emailSQL);
		$stmt->execute();
		$stmt->store_result();
		if($stmt->num_rows > 0) {
	        return "<br><p id='errormessage'> Your Email is already in use.<p>"; // The record(s) exist
	    }
	}

	//checks if username exists
	public function DoesCurrentUsernameExists($Username, $currentUsername){
		//checks if username is his current username
		if(!$Username == $currentUsername){
			//clean username
			$usernameSQL = mysqli_real_escape_string($this->Conn, $Username);
			//does a prepared query
		    $stmt = $this->Conn->prepare("SELECT * from user WHERE Username =? LIMIT 1");
			$stmt->bind_param("s", $usernameSQL);
			$stmt->execute();
			$stmt->store_result();
			
			if($stmt->num_rows > 0) {
		        return "<br><p id='errormessage'> this Username is already in use, try an other.<p>"; // The record(s) exist
		    }
			else{
				return "";
			}
		}
		return "";
	}

	//checks if resetkey exists
	public function DoesResetKeyExists($resetKey){
		//cleans resetkey
		$resetKeySQL = mysqli_real_escape_string($this->Conn, $resetKey);

		//does a prepared query
		$stmt = $this->Conn->prepare("SELECT Email from resetpassword WHERE ResetKey = ? LIMIT 1");
		$stmt->bind_param("s", $resetKeySQL);
		$stmt->execute();
		$stmt->store_result();
		$stmt-> bind_result($email); 

		while ($stmt -> fetch()) { 
			if($stmt->num_rows == 0) {
		        return ""; // The does not exist
		    }
			else{
				return $email;
			}
		}
		$this->Conn->close();
	}

	//if the resetkey exists then get the user by email
	public function ResetKeyExists($email){
		//cleans email
		$emailSQL = mysqli_real_escape_string($this->Conn, $email);

		//does a prepared query
		$stmt = $this->Conn->prepare("SELECT * from resetpassword WHERE Email = ? LIMIT 1");
		$stmt->bind_param("s", $emailSQL);
		$stmt->execute();
		$stmt->store_result();

		if($stmt->num_rows > 0) {
	        return true;
	    }
		else{
			return false;
		}
		$this->Conn->close();
	}

	//checks if user exists
	public function DoesUserExists($email){
		//cleans email for sql
		$emailSQL = mysqli_real_escape_string($this->Conn, $email);
		//does a prepared query
		$stmt = $this->Conn->prepare("SELECT * from user WHERE Email =? LIMIT 1");
		$stmt->bind_param("s", $emailSQL);
		$stmt->execute();
		$stmt->store_result();

		if($stmt->num_rows == 0) {
	        return "<br><p id='errormessage'> this Email is not existing.<p>"; // The record(s) exist
	    }
		else{
			return "";
		}
		$this->Conn->close();
	}

	//serach for users email and date in the database
	public function SearchUser($seachText){
		//set % by string to find that string in a string
		$seachTextSQL = "%".mysqli_real_escape_string($this->Conn, $seachText)."%";
		//does prepared query
		$stmt = $this->Conn->prepare("SELECT u.Id, Username, role, email, registration_date, image, r.RoleName FROM `user`as u join role as r on u.Role = r.id WHERE Username LIKE ? OR Email like ? OR Registration_date like ?");
		$stmt->bind_param("sss", $seachTextSQL, $seachTextSQL, $seachTextSQL);
		$stmt->execute();
		$stmt->store_result();
		$stmt-> bind_result($Id, $Username, $role, $email, $registration_date, $image, $RoleName); 
		$Users[] = array();
		while ($stmt -> fetch()) { 
			$user = array("ID"=>$Id, "Username"=>$Username, "Role"=>$role, "Email"=>$email, "Registration_date"=>$registration_date, "Image"=>$image, "RoleName"=>$RoleName);
			$Users[] = $user;
		}
		return $Users;
	}


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//Insert
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

	//register the user in the database
	public function Register($Username, $Email, $Password){

		//clean username, password and email
		$usernameSQL = mysqli_real_escape_string($this->Conn, $Username);
		$emailSQL = mysqli_real_escape_string($this->Conn, $Email);
		$passwordSQL = mysqli_real_escape_string($this->Conn, $Password);

		$Date = date("Y/m/d");
		//does prepared query
		$stmt = $this->Conn->prepare("INSERT INTO user (Username, Email, Password, Registration_date) VALUES(?, ?, ?, ?)");
		$stmt->bind_param("ssss", $usernameSQL, $emailSQL, $passwordSQL, $Date);
		/* Commit or rollback transaction */
		if ($stmt->execute()) {
			$this->Conn->commit();
	    	return "<br><p id='succesmessage'>Your account has been created successfully</p>";
		} else {
			$this->Conn->rollback();
	    	return "<br><p id='errormessage'>Your account is not Created.</p>";
		}   
	}

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

	//reset the password with the new password and send a mail
	public function ResetPassword($email, $password){
		//cleans email and password
		$emailSQL = mysqli_real_escape_string($this->Conn, $email);
		$passwordSQL = mysqli_real_escape_string($this->Conn, $password);

		$passwordSQL = hash('sha512', $passwordSQL);
		//does a prepared query
		$stmt = $this->Conn->prepare("UPDATE user set Password = ? where Email = ?");
		$stmt->bind_param("ss", $passwordSQL, $emailSQL);
		/* Commit or rollback transaction */
		if ($stmt->execute()) {
			$this->Conn->commit();
			$this->RemoveResetKey($emailSQL);
			return true;
		} else {
			$this->Conn->rollback();
	    	return "<br><p id='errormessage'> Your password has not been updated.<p>";
		} 
	}

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

	//get user by Id from DB
	public function UpdatePassword($Id, $password){
		//clean Id and Password
		$idSQL = mysqli_real_escape_string($this->Conn, $Id);
		$passwordSQL = mysqli_real_escape_string($this->Conn, $password);

		//does a prepared query
		$stmt = $this->Conn->prepare("UPDATE user SET Password = ? where ID = ?");
		$stmt->bind_param("si", $passwordSQL, $idSQL);

		/* Commit or rollback transaction */
		if ($stmt->execute()) {
			$this->Conn->commit();
		    return "New record Updated successfully";
		} else {
			$this->Conn->rollback();
		   	return "Error: " . $sql . "<br>" . $this->Conn->error;
		} 
	}

	//if the key already exist then overwrithe the key
	public function UpdateResetKey($email, $resetKey){
		//cleans resetkey and email
		$resetKeySQL = mysqli_real_escape_string($this->Conn, $resetKey);
		$emailSQL = mysqli_real_escape_string($this->Conn, $email);

		//does a prepared query
		$stmt = $this->Conn->prepare("UPDATE resetpassword SET ResetKey = ? where Email = ?");
		$stmt->bind_param("ss", $resetKeySQL, $emailSQL);
		/* Commit or rollback transaction */
		if ($stmt->execute()) {
			$this->Conn->commit();
		} else {
			$this->Conn->rollback();
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

	//if the password has been changed delete the key
	public function RemoveResetKey($email){
		//cleans email
		$emailSQL = mysqli_real_escape_string($this->Conn, $email);
		
		//does a prepared query
		$stmt = $this->Conn->prepare("DELETE FROM resetpassword where Email = ?");
		$stmt->bind_param("s", $emailSQL);
		/* Commit or rollback transaction */
		if ($stmt->execute()) {
			$this->Conn->commit();
		} else {
			$this->Conn->rollback();
		} 
	}
}
?>