<?php
require "./fpdf181/fpdf.php";

class Ticket extends FPDF{
	function header(){
		$this->Image('http://hfteam3.infhaarlem.nl/cms/Images/Home/Logo.png',10,6,50,50);
		$this->SetFont('Arial', 'B', 20);
		$this->Ln(20);
		$this->Cell(30);
		$this->Cell(0,5,'Haarlem Festival',0,0,'C');
		$this->Ln();
		$this->Cell(30);
		$this->SetFont('Times','',12);
		$this->Cell(0,10,'26 - 29 juni 2020',0,0,'C');
		$this->Ln(30);
	}
	function footer(){
		$this->SetY(-15);
		$this->SetFont('Arial','', 8);
		$this->Cell(0, 10, 'Page '.$this->PageNo().'/{nb}',0,0,'C');

	}
	function nameContent($info){
		$this->SetFont('Arial', 'B', 20);
		$this->Cell(20);
		$this->Cell(40,10,'Customer Info:',0,0,'L');

		$this->SetFont('Times', 'B', 12);
		$this->Ln(10);
		$this->Cell(20);
		$this->Cell(40,10,'Name',0,0,'L');
		$this->Cell(40,10,current($info),0,0,'L');
		$this->Ln();
		$this->Cell(20);
		$this->Cell(40,10,'Email',0,0,'L');
		$this->Cell(40,10,next($info),0,0,'L');
		$this->Ln();
		$this->Cell(20);
		$this->Cell(40,10,'Address',0,0,'L');
		$this->Cell(40,10,next($info),0,0,'L');
		$this->Ln();
		$this->Cell(20);
		$this->Cell(40,10,'Phonenumber',0,0,'L');
		$this->Cell(40,10,next($info),0,0,'L');
		$this->Ln();
		$this->Cell(20);
		$this->Cell(40,10,'Ordernumber',0,0,'L');
		$this->Cell(40,10,next($info),0,0,'L');
		$this->Ln();
		$this->Cell(20);
		$this->SetFont('Times', 'B', 8);
		$this->Cell(40,10,'*Use this number to see your program in my Program',0,0,'L');
	}

	function EventTicket($ticketInfo, $extraHeight, $qrImage){
		$this->Rect(7, 65 + $extraHeight, 190, 70);
		$this->SetFont('Arial', 'B', 10);
		
		
		$this->Cell( 25, 40, $this->Image('http://hfteam3.infhaarlem.nl/cms/Images/Home/Food.png', 50, 66 + $extraHeight, 49), 0, 0, 'L', false );
		$this->Cell( 25, 40, $this->Image('http://hfteam3.infhaarlem.nl/cms/Images/Home/Dance.png', 75, 66 + $extraHeight, 49), 0, 0, 'L', false );
		$this->Cell( 25, 40, $this->Image('http://hfteam3.infhaarlem.nl/cms/Images/Home/Historic.png', 100, 66 + $extraHeight, 49), 0, 0, 'L', false );
		$this->Cell( 25, 40, $this->Image('http://hfteam3.infhaarlem.nl/cms/Images/Home/Jazz.png', 125, 66 + $extraHeight, 49), 0, 0, 'L', false );
		$this->Ln(5);
		//name of event
		$this->Cell(2.);
		$this->Cell(50,0,current($ticketInfo),0,0,'L');
		
		//venue of event
		$this->SetFont('Arial', "", 7);
		$this->Cell(107);
		$this->Cell(14,10,'Ticket Price:',0,0,'L');
		$this->Cell(10,10,EURO." ".next($ticketInfo),0,0,'L');
		$this->Ln(7);
		$this->Cell(159);
		$this->Cell(12,3,'',0,0,'L');
		$this->MultiCell(17,3,"",0,"B");
		
		
		$this->Ln(-12);
		$this->SetFont('Arial', 'B', 10);
		//locatie of event
		$this->Cell(2);
		$this->Cell(50,20,next($ticketInfo),0,0,'L');
		$this->Ln(5);
		
		$this->Cell(2);
		$this->SetFont('Arial', '', 7);
		$this->Cell(50,17,next($ticketInfo),0,0,'L');
		$this->Ln(5);
		
		//datum of event
		$this->Cell(2);
		$this->SetFont('Arial', 'B', 10);
		$this->Cell(50,30,next($ticketInfo),0,0,'L');
		$this->Ln(5);
		
		//tijd of event
		$this->Cell(2);
		$this->Cell(50,30,next($ticketInfo),0,0,'L');
		
		$this->Ln(5);
		$this->Cell( 40, 40, $this->Image('http://hfteam3.infhaarlem.nl/cms/Images/Home/Logo.png', $this->GetX() +5, $this->GetY() +14, 28), 0, 0, 'L', false );
		//qrcode of event
		$this->Cell(105);
		$this->Cell( 25, 40, $this->Image($qrImage, $this->GetX()+ 6.5, $this->GetY()+10, 35), 0, 0, 'L', false );
		$this->Ln(50);
	}

}
class PDFMaker{
	public function MakePDF($customerInfo, $tickets)
	{
		/*$customerInfo = array("Tim", "Gras", "T@t.nl", "1544MK nieuwestraat 8", "061473655", 0);
		$tickets = array();
		$tickets[] = array("Hardwell B2B", "5060.00",  "Jopenkerk", "1544MK nieuwestraat 8", "Dinsdag 20 november", "15:00 - 16:00", 0);*/
		
		define('EURO',chr(128));
		require_once( "Autoloader.php");
		$qr  = new QrGenerator;
		$Config = Config::getInstance();
		$pdf = new Ticket();
		$height = 0;
		$pdf->AliasNbPages();
		$pdf->AddPage('P', 'A4', 0);
		$pdf->nameContent($customerInfo);
		$pdf->AddPage();
		$amountOnPage = 0;
		foreach($tickets as $ticket){
			if($amountOnPage == 3){
				$pdf->AddPage();
				$height = 0;
				$amountOnPage = 0;
			}
			$qrimage = $qr->GenerateQRCode("http://cms.hfteam3.infhaarlem.nl/" ."CMSTicket.php?TicketCode=". $ticket[6], $ticket[6]);
			$pdf->EventTicket($ticket, $height, $qrimage);
			$height += 73;
		
			$amountOnPage++;
		}
		return $pdf->Output('attachment.pdf', 'S');
	}
}


?>