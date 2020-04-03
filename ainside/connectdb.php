<?php 
class Database
{
	static $pdo;
	function __construct()
	{
		if(self::$pdo) return;
		$this->ConnectDb();
	}
	public function ConnectDb()
	{
		try {
			self::$pdo = new PDO("mysql:host=localhost;dbname=itvideos","root","4303");
			//self::$pdo = new PDO("mysql:host=localhost;dbname=p-14825_task;","p-148_kooz","ghasJLl985LHH");
		}
		catch(PDOException $e) {
			echo $e->getMessage();
		}
	}
}


?>