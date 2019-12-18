<?php
	require_once( "Autoloader.php");
class MyProgramController 
{
	private $MyProgramModel;
	private $Session;
	private $Config;

	public function __construct($myProgramModel){
		$this->MyProgrammodel = $myProgramModel;
		$this->Config = Config::getInstance();
		$this->DB_Helper = new DB_Helper;

	}
	
	//get config
	public function GetConfig(){
		return $this->Config;
	}

	public function CheckOrderNumber(){
		if(isset($_POST["OrderNumber"])){
			return $this->GetTimeTable($_POST["OrderNumber"]);
		}
	}

	public function GetTimeTable($orderNumber)
	{
		$timeTable = "<div>
						<h2>Event Schedule:</h2>
				    	<div class='Event FoodBackground'>Food</div>
				    	<div class='Event DanceBackground'>Dance</div>
				    	<div class='Event HistoricBackground'>Historic</div>
				    	<div class='Event JazzBackground'>Jazz</div>
				    </div>";
		$timeTable .= $this->GetTickets($orderNumber);
		$timeTable .= "<div><button onclick='TimeTablePDF(".$orderNumber.")' class='ProceeToCheckout'>Download</button></div>
						    </div>";
		return $timeTable;
	}

	public function GetTickets($id){
		$rows = "<table class='TimeTable'><THEAD>
			    <TR>
			      <TH></TH>
			      <TH>Donderdag</TH>
			      <TH>Vrijdag</TH>
			      <TH>Zaterdag</TH>
			      <TH>Zondag</TH>
			    </TR>
			  </THEAD>";
		$rows .= $this->GetDanceTickets($id);
		$rows .= $this->GetTourTickets($id);
		$rows .= $this->GetJazzTickets($id);
		$rows .= $this->GetFoodTickets($id);

		$rows .= "</table>";
		return $rows;
	}

	public function GetDanceTickets($id){
		$tickets = $this->DB_Helper->GetOrderTicketsDance($id);
		$rows = "";
		foreach ($tickets as $ticket) {
			$rows .= $this->SetRow($ticket, "DanceBackground");
		}
		return $rows;
	}

	public function GetTourTickets($id){
		$tickets = $this->DB_Helper->GetOrderTicketsTour($id);
		$rows = "";
		foreach ($tickets as $ticket) {
			$rows .= $this->SetRow($ticket, "HistoricBackground");
		}
		return $rows;
	}

	public function GetJazzTickets($id){
		$tickets = $this->DB_Helper->GetOrderTicketsJazz($id);
		$rows = "";
		foreach ($tickets as $ticket) {
			$rows .= $this->SetRow($ticket, "JazzBackground");
		}
		return $rows;
	}

	public function GetFoodTickets($id){
		$tickets = $this->DB_Helper->GetOrderTicketsFood($id);
		$rows = "";
		foreach ($tickets as $ticket) {
			$rows .= $this->SetRow($ticket, "FoodBackground");
		}
		return $rows;
	}

	public function SetRow($ticket, $typeEvent){
		////////////////////////////////DELETE WHEN MORE DATES FROM MORE EVENTS/////////////////
		$TijdelijkDate = array(
			date('Y-m-d', strtotime('2020-07-27')), 
			date('Y-m-d', strtotime('2020-07-28')), 
			date('Y-m-d', strtotime('2020-07-29')), 
			date('Y-m-d', strtotime('2020-07-30')));
			$startDate = date('Y-m-d', strtotime($ticket["StartDateTime"]));
			$startTime = date("H:i",strtotime($ticket["StartDateTime"]));
			$endTime = date("H:i",strtotime($ticket["EndDateTime"]));
			$row = "<tr><td>".$ticket["Name"]."</td>";
			$time = "";
			if($startTime != "00:00"){
				$time = $startTime. " - " .$endTime;
				$endTime = "";
			}

		foreach ($TijdelijkDate as $date) {
			if($date == $startDate){
				$row .="<td class='".$typeEvent."'>".$ticket["description"]." ".$ticket["info"]."<br>
						".$time."
						</td>";
			}
			else{
				$row .="<td></td>";
			}
		}

		$row .="</tr>";
		return $row;
	}
}
?>