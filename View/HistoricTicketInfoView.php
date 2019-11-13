<?php 
require_once("Autoloader.php");
class HistoricTicketInfoView
{
	private $HistoricTicketInfoController;
	private $HistoricTicketInfoModel;

	public function __construct($historicTicketInfoController, $historicTicketInfoModel)
	{
		$this->HistoricTicketInfoController = $historicTicketInfoController;
		$this->HistoricTicketInfoModel = $historicTicketInfoModel;
	}

	//output to html
	public function output(){
		$page = "";
		$page .= $this->Header();
		$page .= $this->Body();
		$page .= $this->Footer();
		return $page;
	}

	private function Header(){
		return $this->HistoricTicketInfoController->GetConfig()->GetHeader("Historic");
	}

	private function Body(){
		//setnav()
		return "<div id='main'>
		<div class='lol'></div>
		<div class='pageCenter'>
			<div class='ticketInfoContainer'>
				<div class='headerContainer'><div class='blackBar3'></div><h2>Time & date</h2><div class='blackBar3'></div></div><br>
			</div>
			<div class='ticketInfoContainer'>
				<div class='headerContainer'><div class='blackBar4'></div><h2>Prices & more</h2><div class='blackBar4'></div></div><br>
			</div>
		</div>
		</div>";
	}

	private function Footer(){
		return "
		<div class='Footer'>
			<p id='DesignedBy'>Designed by: Chris Lips, Thijs van Tol, Tim Gras, Stan Roozendaal en Stef Robbe
			<image class='MediaIcons' src='Images/instagram-icon-black.png'>
			<image class='MediaIcons' src='Images/facebook-icon.png'>
			</p>
		</div>
		</body></html> ";
	}
}
?>