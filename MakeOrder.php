<?php
require_once("Autoloader.php");
class MakeOrder{
    
	private $Session;
	private $Config;

    public function __construct()
    {
		$this->Config = Config::getInstance();
        $this->DB_Helper = new DB_Helper;
        $this->HistoricRepository = new HistoricRepository;
        $this->DanceRepository = new DanceRepository;
        $this->JazzRepository = new JazzRepository;
        $this->FoodRepository = new FoodRepository;
		$this->Session = new Session;
    }

    public function Order($orderInfo, $items)
    {   
        usleep(5);
        $uniqueCode = $orderInfo["OrderNumber"];
        if($orderInfo["OrderNumber"] == ""){
            $uniqueCode = microtime();
            $uniqueCode = str_replace(".","",$uniqueCode);
            $uniqueCode = str_replace(" ","",$uniqueCode);
        }
        $orderId = $this->DB_Helper->CreateOrder($orderInfo, $uniqueCode);
        foreach($items as $item)
        { 
            if(array_key_exists("Amount" , $item)){
                for($i = 0; $i < $item['Amount']; $i++){
                    $price = $this->GetEventPrice($item['EventId'], $item["TypeEvent"]);
                    $ticketId = $this->ticket($item['EventId'], $item['TypeEvent'], $price);
                    $this->DB_Helper->CreateOrderLine($orderId, $ticketId);
                }
            }
            if (array_key_exists("AdultAmount", $item)) {
                for ($i = 0; $i < $item['AdultAmount']; $i++) {
                    $price = $this->GetEventPrice($item['EventId'], $item["TypeEvent"], "Adult");
                    $ticketId = $this->ticket($item['EventId'], $item['TypeEvent'], $price);
                    $this->DB_Helper->CreateOrderLine($orderId, $ticketId);
                }
                for ($i = 0; $i < $item['ChildAmount']; $i++) {
                    $price = $this->GetEventPrice($item['EventId'], $item["TypeEvent"], "Child");
                    $ticketId = $this->ticket($item['EventId'], $item['TypeEvent'], $price);
                    $this->DB_Helper->CreateOrderLine($orderId, $ticketId);
                }
            }
        }
        //$this->Session->CleanCart();
        return $orderId;
    }

    public function ticket($eventId, $typeEvent, $price)
    {
        $uniqueCode = microtime(true);
        $uniqueCode = str_replace(".","",$uniqueCode);
        $ticketId = $this->DB_Helper->CreateTicket($eventId, $typeEvent, $uniqueCode, $price);
        if ($typeEvent == 1) {
            $this->DB_Helper->RemoveAvailableTicketFood($eventId);
        }
        if ($typeEvent == 2) {

            $this->DB_Helper->RemoveavAilableTicketDance($eventId);
        }
        if ($typeEvent == 4) {

            $this->DB_Helper->RemoveavAilableTicketJazz($eventId);
        }
        if ($typeEvent == 3) {

            $this->DB_Helper->RemoveavAilableTicketTour($eventId);
        }
        usleep(5);
        return $ticketId;
    }

    public function GetPrice()
    {
        $items = EncryptionHelper::Decrypt($_SESSION['Tickets']);
        $amountPay = 0;
        foreach($items as $item){
            switch ($item['TypeEvent']) {
                case 1:
                    $event = $this->FoodRepository->GetEventInfoFood($item['EventId']);
                    $amountPay += doubleval(10) * doubleval($item['ChildAmount']);
                    $amountPay += doubleval(10) * doubleval($item['AdultAmount']);
                    break;
                case 2:
                    $event = $this->DanceRepository->GetEventInfoDance($item['EventId']);
                    $amountPay += doubleval($event['Price']) * doubleval($item['Amount']);
                    break;
                case 3:
                    $event = $this->HistoricRepository->GetEventInfoHistoric($item['EventId']);
                    $amountPay += doubleval($event['Price']) * doubleval($item['Amount']);
                    break;
                case 4:
                    $event = $this->JazzRepository->GetEventInfoJazz($item['EventId']);
                    $amountPay += doubleval($event['Price']) * doubleval($item['Amount']);
                    break;
            }
        }
        return  number_format($amountPay, 2, '.', '');
    }

    public function GetEventPrice($eventId, $typeEvent, $typeTicket = "")
    {
        switch ($typeEvent) {
            case 1:
                $event = $this->FoodRepository->GetEventInfoFood($eventId);
                if ($typeTicket == "Child") {
                    return doubleval($event['ChildPrice']);
                }
                else {
                    return doubleval($event['AdultPrice']);
                }
                break;
            case 2:
                $event = $this->DanceRepository->GetEventInfoDance($eventId);
                return doubleval($event['Price']);
                break;
            case 3:
                $event = $this->HistoricRepository->GetEventInfoHistoric($eventId);
                return doubleval($event['Price']);
                break;
            case 4:
                $event = $this->JazzRepository->GetEventInfoJazz($eventId);
                return doubleval($event['Price']);
                break;
        }
    }
}
?>