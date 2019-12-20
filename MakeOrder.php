<?php
require_once("Autoloader.php");
class MakeOrder{
    
	private $Session;
	private $Config;

    public function __construct()
    {
		$this->Config = Config::getInstance();
		$this->DB_Helper = new DB_Helper;
		$this->Session = new Session;
    }

    public function Order($orderInfo, $items)
    {
        $orderId = $this->DB_Helper->CreateOrder($orderInfo);
        error_log($_SESSION["Tickets"]);
        foreach($items as $item)
        {
            for($i = 0; $i < $item['Amount']; $i++){
                $ticketId = $this->ticket($item['EventId'], $item['TypeEvent']);
                $this->DB_Helper->CreateOrderLine($orderId, $ticketId);
            }
        }
        $this->Session->CleanCart();
    }

    public function ticket($eventId, $typeEvent)
    {
        $ticketId = $this->DB_Helper->CreateTicket($eventId, $typeEvent,"test");
        if($typeEvent == 2){
            $this->DB_Helper->RemoveavAilableTicketDance($eventId);
        }
        return $ticketId;
    }

    public function GetPrice()
    {
        $items = $_SESSION['Tickets'];
        $amountPay = 0;
        foreach($items as $item){
            switch ($item['TypeEvent']) {
                case 1:
                    break;
                case 2:
                    $event = $this->DB_Helper->GetEventInfoDance($item['EventId']);
                    $amountPay += doubleval($event['Price']) * doubleval($item['Amount']);
                    break;
                case 3:
                    $event = $this->DB_Helper->GetEventInfoHistoric($item['EventId']);
                    $amountPay += doubleval($event['Price']) * doubleval($item['Amount']);
                    break;
                case 4:
                    $event = $this->DB_Helper->GetEventInfoJazz($item['EventId']);
                    $amountPay += doubleval($event['Price']) * doubleval($item['Amount']);
                    break;
            }
        }
        return  number_format($amountPay, 2, '.', '');
    }
}
?>