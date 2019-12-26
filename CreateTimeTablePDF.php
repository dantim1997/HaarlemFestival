<?php
require_once( "Autoloader.php");
require "./fpdf181/fpdf.php";

class Ticket extends FPDF{
	public $User;

	function header(){
		
		$this->SetFont('Arial', 'B', 20);
		$this->Ln(20);
		$this->Cell(0,5,'Your Timetable from order: 630259',0,0,'L');
	}

	function headerline($date){
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
		//$this->MultiCell(39.5, 10, $event , 1, "B" , 1);
		$this->Cell(39.5,10,$event,1,0,'L',1);
	}
	function LeftColumn($event = "", $r = 255, $g=255, $b=255)
	{
		$splitEvent = explode(",", $event);
		$this->SetFillColor($r, $g, $b);
		$this->SetFont('Arial', '', 7);
		//$this->MultiCell(39.5, 10, $event , 1, "B" , 1);
		$this->Cell(39.5,10,$splitEvent[0],1,0,'L',1);
	}
}
if(isset($_GET)){

	$DB_Helper = new DB_Helper;
	$OrderId = $_GET['id'];
	$Date = array('2020-07-26', '2020-07-27', '2020-07-28', '2020-07-29');
	$pdf = new Ticket();
	$pdf->AliasNbPages();
	$pdf->AddPage('P', 'A4', 0);
	$pdf->headerline($Date);
	GetDanceTickets($DB_Helper,$OrderId, $pdf);
	GetFoodTickets($DB_Helper,$OrderId, $pdf);
	GetTourTickets($DB_Helper,$OrderId, $pdf);
	GetJazzTickets($DB_Helper,$OrderId, $pdf);
	$pdf->Output();
}
else{
	header("Location: MyProgram.php");
}
function GetDanceTickets($DB_Helper,$id, $pdf){
	$tickets = $DB_Helper->GetOrderTicketsDance($id);
	foreach ($tickets as $ticket) {
		SetRow($ticket, 2, $pdf);
	}
}
function GetTourTickets($DB_Helper,$id, $pdf){
	$tickets = $DB_Helper->GetOrderTicketsTour($id);
	foreach ($tickets as $ticket) {
		SetRow($ticket, 3,$pdf);
	}
}

function GetJazzTickets($DB_Helper,$id, $pdf){
	$tickets = $DB_Helper->GetOrderTicketsJazz($id);
	foreach ($tickets as $ticket) {
		SetRow($ticket, 4,$pdf);
	}
}

function GetFoodTickets($DB_Helper,$id, $pdf){
	$tickets = $DB_Helper->GetOrderTicketsFood($id);
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
				$pdf->column($ticket["description"] ." ". $ticket["info"], $r, $g, $b);
			}
			else{
				$pdf->column();
			}
		}
	$pdf->row();
}

?>