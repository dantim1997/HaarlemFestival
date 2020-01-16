<?php
require_once( "Autoloader.php");
class InvoiceModel
{	
	function __construct()
	{
	}

    public function InvoiceModelMaker($tickets)
    {
        //array($artist, $description, $startdate, $enddate, $amount, $price , $vat);
        //$tickets[] = array("Hardwell B2B", "2020/-07-12", "15:00 - 16:00", 5, "300.00", "9%");
        $newTickets = array();
        foreach($tickets as $ticket){
            $startDate = date('d/m/Y', strtotime($ticket[2]));
            $startTime = date("H:i",strtotime($ticket[2]));
            $endTime = date("H:i",strtotime($ticket[3]));
            $newTickets[] = array(  $ticket[0]." ".$ticket[1], 
                                    $startDate, 
                                    $startTime ." - ". $endTime, 
                                    $ticket[4], 
                                    $ticket[5], 
                                    $ticket[6]);
        }
        return $newTickets;
    }
}
?>