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
        return $this->DB_Helper->CreateTicket($eventId, $typeEvent,"test");
    }
}
?>