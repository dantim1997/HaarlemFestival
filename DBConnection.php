<?php
//Singleton
class DBConnection
{
	private static $instance = null;
	private $conn;
	
	//information about the server interaction
	private $host = 'localhost';
	private $user = 'hfteam3_user';
	private $pass = 'ambFGSR2A';
	private $name = 'hfteam3_db';

	// The db connection is established in the private constructor.
	private function __construct()
	{
		$this->conn = new mysqli($this->host, $this->user, $this->pass, $this->name);
	}
  
	public static function getInstance()
	{
		if(!self::$instance)
		{
			self::$instance = new DBConnection();
		}
		return self::$instance;
  	}
  
  	public function getConnection()
  	{
    	return $this->conn;
  	}
};
?>
