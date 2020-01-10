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
		$this->OrderRepository = new OrderRepository;

	}
	
	//get config
	public function GetConfig(){
		return $this->Config;
	}

	public function CheckOrderNumber($pageContent){
		if(isset($_POST["OrderNumber"])){
			setcookie('dsakjsdf891', EncryptionHelper::Encrypt($_POST["OrderNumber"]), time()+86400*30);
			return $this->GetTimeTable($_POST["OrderNumber"], $pageContent);
		}
		elseif (isset($_COOKIE["dsakjsdf891"])) {
			return $this->GetTimeTable(EncryptionHelper::Decrypt($_COOKIE["dsakjsdf891"]), $pageContent);
		}
	}

	public function GetTimeTable($orderNumber, $pageContent)
	{	
		$timeTable = "
					<div>
						<h2>".$pageContent[2]."</h2>
				    	<div class='Event FoodBackground'>Food</div>
				    	<div class='Event DanceBackground'>Dance</div>
				    	<div class='Event HistoricBackground'>Historic</div>
				    	<div class='Event JazzBackground'>Jazz</div>
				    </div>";
		$timeTable .= $this->GetTickets($orderNumber, $pageContent);
		$timeTable .= "<div><button onclick='TimeTablePDF(".$orderNumber.")' class='ProceeToCheckout'>Download</button></div>
						    </div>";
		return $timeTable;
	}

	public function GetTickets($id, $pageContent){
		$rows = "<table class='TimeTable'><THEAD>
			    <TR>
			      <TH></TH>
			      <TH>".$pageContent[3]."</TH>
			      <TH>".$pageContent[4]."</TH>
			      <TH>".$pageContent[5]."</TH>
			      <TH>".$pageContent[6]."</TH>
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
		$tickets = $this->OrderRepository->GetOrderTicketsDance($id);
		$rows = "";
		foreach ($tickets as $ticket) {
			$rows .= $this->SetRow($ticket, "DanceBackground");
		}
		return $rows;
	}

	public function GetTourTickets($id){
		$tickets = $this->OrderRepository->GetOrderTicketsTour($id);
		$rows = "";
		foreach ($tickets as $ticket) {
			$rows .= $this->SetRow($ticket, "HistoricBackground");
		}
		return $rows;
	}

	public function GetJazzTickets($id){
		$tickets = $this->OrderRepository->GetOrderTicketsJazz($id);
		$rows = "";
		foreach ($tickets as $ticket) {
			$rows .= $this->SetRow($ticket, "JazzBackground");
		}
		return $rows;
	}

	public function GetFoodTickets($id){
		$tickets = $this->OrderRepository->GetOrderTicketsFood($id);
		$rows = "";
		foreach ($tickets as $ticket) {
			$rows .= $this->SetRow($ticket, "FoodBackground");
		}
		return $rows;
	}

	public function SetRow($ticket, $typeEvent){
		////////////////////////////////DELETE WHEN MORE DATES FROM MORE EVENTS/////////////////
		$TijdelijkDate = array(
			date('Y-m-d', strtotime('2020-07-26')), 
			date('Y-m-d', strtotime('2020-07-27')), 
			date('Y-m-d', strtotime('2020-07-28')), 
			date('Y-m-d', strtotime('2020-07-29')));
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