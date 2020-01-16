<?php
require_once( "Autoloader.php");
require "./fpdf181/fpdf.php";

class Ticket extends FPDF{
	public $User;
	
	function headerline($date, $OrderId){
		$this->SetFont('Arial', 'B', 20);
		$this->Ln(20);
		$this->Cell(0,5,'Your Timetable from order: '.$OrderId,0,0,'L');
		$this->Ln(20);
		$this->SetFont('Arial', '', 10);
		$r = 255; $g =255; $b=102;
		$this->SetFillColor($r, $g, $b);
		$this->Cell(16.5,10,"Food",1,0,'L',1);
		
		$r = 102; $g =255; $b=204;
		$this->SetFillColor($r, $g, $b);
		$this->Cell(16.5,10,"Dance",1,0,'L',1);
		
		$r = 255; $g =153; $b=51;
		$this->SetFillColor($r, $g, $b);
		$this->Cell(16.5,10,"Historic",1,0,'L',1);
		
		$r = 102; $g =255; $b=51;
		$this->SetFillColor($r, $g, $b);
		$this->Cell(16.5,10,"Jazz",1,0,'L',1);
		$this->Ln(10);

		$this->SetFont('Arial', '', 12);
		$this->Cell(39.5,10,'',1,0,'L');
		$this->Cell(39.5,10,date('l', strtotime(current($date))),1,0,'L');
		$this->Cell(39.5,10,date('l', strtotime(next($date))),1,0,'L');
		$this->Cell(39.5,10,date('l', strtotime(next($date))),1,0,'L');
		$this->Cell(39.5,10,date('l', strtotime(next($date))),1,0,'L');
		$this->Ln(10);
	}

	function row(){
		$this->SetFont('Arial', '', 10);
		$this->Ln(10);
		
	}
	
	function column($event = "", $r = 255, $g=255, $b=255)
	{
		$this->SetFillColor($r, $g, $b);
		$this->SetFont('Arial', '', 7);
		if($event != ""){
			$current_y = $this->GetY();
			$current_x = $this->GetX();
			$cell_width = 39.5;
			$this->MultiCell(39.5, 10, $event , 1, "B" , 1);
			$this->SetXY($current_x + $cell_width, $current_y);
			$current_x = $this->GetX();
		}
		else{
			$this->Cell(39.5,20,$event,1,0,'L',1);
			
		}
	}
	function LeftColumn($event = "", $r = 255, $g=255, $b=255)
	{
		$splitEvent = explode(",", $event);
		$this->SetFillColor($r, $g, $b);
		$this->SetFont('Arial', '', 7);
		$current_y = $this->GetY();
			$current_x = $this->GetX();
			$cell_width = 39.5;
			$this->MultiCell(39.5, 10, $event , 1, "B" , 1);
		$this->MultiCell(39.5, 10, $event , 1, "B" , 1);
		
		$this->SetXY($current_x + $cell_width, $current_y);
		$current_x = $this->GetX();
		//$this->Cell(39.5,20,$splitEvent[0],1,0,'L',1);
	}
}
if(isset($_GET)){
	$OrderRepository = new OrderRepository;
	$OrderId = $_GET['id'];
	$Date = array('2020-07-26', '2020-07-27', '2020-07-28', '2020-07-29');
	$pdf = new Ticket();
	$pdf->AliasNbPages();
	$pdf->AddPage('P', 'A4', 0);
	$pdf->headerline($Date,$OrderId);
	GetDanceTickets($OrderRepository,$OrderId, $pdf);
	GetFoodTickets($OrderRepository,$OrderId, $pdf);
	GetTourTickets($OrderRepository,$OrderId, $pdf);
	GetJazzTickets($OrderRepository,$OrderId, $pdf);
	$pdf->Output();
}
else{
	header("Location: MyProgram.php");
}
function GetDanceTickets($OrderRepository,$id, $pdf){
	$tickets = $OrderRepository->GetOrderTicketsDance($id);
	foreach ($tickets as $ticket) {
		SetRow($ticket, 2, $pdf);
	}
}
function GetTourTickets($OrderRepository,$id, $pdf){
	$tickets = $OrderRepository->GetOrderTicketsTour($id);
	foreach ($tickets as $ticket) {
		SetRow($ticket, 3,$pdf);
	}
}

function GetJazzTickets($OrderRepository,$id, $pdf){
	$tickets = $OrderRepository->GetOrderTicketsJazz($id);
	foreach ($tickets as $ticket) {
		SetRow($ticket, 4,$pdf);
	}
}

function GetFoodTickets($OrderRepository,$id, $pdf){
	$tickets = $OrderRepository->GetOrderTicketsFood($id);
	foreach ($tickets as $ticket) {
		SetRow($ticket, 1,$pdf);
	}
}

function SetRow($ticket, $typeEvent, $pdf){
	////////////////////////////////DELETE WHEN MORE DATES FROM MORE EVENTS/////////////////
	$TijdelijkDate = array(
		date('Y-m-d', strtotime('2020-07-26')), 
		date('Y-m-d', strtotime('2020-07-27')), 
		date('Y-m-d', strtotime('2020-07-28')), 
		date('Y-m-d', strtotime('2020-07-29')));
		$r = 0;
		$g = 0;
		$b = 0;
		switch($typeEvent){
			case 1: $r = 255; $g =255; $b=102; break;
			case 2: $r = 102; $g =255; $b=204; break;
			case 3: $r = 255; $g =153; $b=51; break;
			case 4: $r = 102; $g =255; $b=51; break;
		}
		$startDate = date('Y-m-d', strtotime($ticket["StartDateTime"]));
		$pdf->LeftColumn($ticket["Name"]);
		foreach ($TijdelijkDate as $date) {
			if($date == $startDate){
				$startEndTime = date("H:i",strtotime($ticket["StartDateTime"]));
				$endTime = date("H:i",strtotime($ticket["EndDateTime"]));
				$pdf->column($ticket["description"] ." ". $ticket["info"]." ". $startEndTime."-".$endTime, $r, $g, $b);
			}
			else{
				$pdf->column();
			}
		}
	$pdf->row();
}

?>