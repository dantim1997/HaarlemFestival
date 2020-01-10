<?php
class FooterRepository
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
}
?>