<?php
	require_once( "Autoloader.php");
class CheckoutController 
{
	private $CheckoutModel;
	private $Session;
	private $Config;

	public function __construct($checkoutModel){
		$this->CheckoutModel = $checkoutModel;
		$this->Config = Config::getInstance();
	}
	
	//get config
	public function GetConfig(){
		return $this->Config;
	}
}

?>