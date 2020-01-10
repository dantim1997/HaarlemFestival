<?php
require_once("Autoloader.php");
require "./fpdf181/fpdf.php";
class Invoice extends FPDF{
	function header(){
		$this->SetFont('Arial','B',25);
		$this->Image('http://hfteam3.infhaarlem.nl/cms/Images/Home/Logo.png',120,20,70);
		$this->Cell(1,60,'Invoice Haarlem Festival');
	}

	function content($customerinfo, $tickets){
		$this->SetFont('Arial','B',16);
		$this->Ln(50);
		$this->Rect(10,50,100,55);
		$this->Cell(1,0,'Personal Information:');
		$this->SetFont('Arial','B',11);
		$this->Ln(10);
		$this->Cell(1,0,'First Name:');
		$this->Cell(40);
		$this->SetFont('Arial','',11);
		$this->Cell(1,0,current($customerinfo));
		$this->Ln(5);
		$this->SetFont('Arial','B',11);
		$this->Cell(1,0,'Last Name:');
		$this->Cell(40);
		$this->SetFont('Arial','',11);
		$this->Cell(1,0,next($customerinfo));
		$this->Ln(5);
		$this->SetFont('Arial','B',11);
		$this->Cell(1,0,'Order Number:');
		$this->Cell(40);
		$this->SetFont('Arial','',11);
		$this->Cell(1,0,next($customerinfo));
		$this->Ln(5);
		$this->SetFont('Arial','B',11);
		$this->Cell(1,0,'Address:');
		$this->Cell(40);
		$this->SetFont('Arial','',11);
		$this->Cell(1,0,next($customerinfo));
		$this->Ln(5);
		$this->SetFont('Arial','B',11);
		$this->Cell(1,0,'Phone Number:');
		$this->Cell(40);
		$this->SetFont('Arial','',11);
		$this->Cell(1,0,next($customerinfo));
		$this->Ln(5);
		$this->SetFont('Arial','B',11);
		$this->Cell(1,0,'E-mail:');
		$this->Cell(40);
		$this->SetFont('Arial','',11);
		$this->Cell(1,0,next($customerinfo));
		$this->Ln(5);
		$this->SetFont('Arial','B',11);
		$this->Cell(1,0,'Invoice Date:');
		$this->Cell(40);
		$this->SetFont('Arial','',11);
		$this->Cell(1,0,next($customerinfo));
		$this->Ln(5);

		$extraAmount = 7 * (count($tickets)-1);
		$this->Ln(30);
		$this->Rect(10,130,190,17+$extraAmount);
		$this->Rect(10,147+$extraAmount,190,0);
		$this->Rect(10,140,190,0);
		$this->Rect(110,130,0,25+$extraAmount);
		$this->Rect(135,130,0,25+$extraAmount);
		$this->Rect(165,130,0,25+$extraAmount);
		$this->SetFont('Arial','B',14);
		$this->Cell(1,0,'Event:');
		$this->Cell(100);
		$this->Cell(1,0,'Amount:');
		$this->Cell(25);
		$this->Cell(1,0,'Sub Total:');
		$this->Cell(30);
		$this->Cell(1,0,'VAT:');

		$this->Ln(2);
		$this->events($tickets);

		$this->Ln(8);
		$TotalPriceAmount = 0;
		$TotalAmount = 0;
		foreach($tickets as $ticket){
			$TotalPriceAmount += $ticket[4];
			$TotalAmount += intval($ticket[3]);
		}
		$this->SetFont('Arial','B',14);
		$this->Cell(1,0,'Total:');
		$this->Cell(100);
		$this->SetFont('Arial','',12);
		$this->Cell(1,0,$TotalAmount);
		$this->Cell(25);
		$this->Cell(1,0,EURO." ".$TotalPriceAmount);
	}	
	
	public function Events($tickets)
	{
		foreach($tickets as $ticket){
			$this->Ln(7);
			$this->SetFont('Arial','',12);
			$this->Cell(1,0, current($ticket) . " ". next($ticket). " ". next($ticket));
			$this->Cell(100);
			$this->Cell(1,0,next($ticket));
			$this->Cell(25);
			$this->Cell(1,0,EURO." ".next($ticket));
			$this->Cell(30);
			$this->Cell(1,0, next($ticket));
		}
	}
}
class PDFInvoiceMaker{
	public function MakePDF($customerInfo, $tickets)
	{
		$pdf = new Invoice();
		define('EURO',chr(128));
		//$customerInfo = array("Tim", "Gras", "0000000000", "1544MK nieuwestraat 8", "061473655","T@t.nl", Date("d-m-Y"));
		$pdf->AliasNbPages();
		$pdf->AddPage();
		$pdf->content($customerInfo, $tickets);
		$pdf->Output();
	}
}
?>