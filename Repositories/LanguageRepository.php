<?php
class LanguageRepository
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

}
?>