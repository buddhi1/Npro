<?php 

class db{ 
	
    private static $conn = NULL;

    private function __construct() {}

    public static function getConnection() {
		$servername = "localhost";
		$dbname = "proj_db";
		$uname = "root";
		$password = "";
		if (!isset(self::$conn)) {
			$pdo_options[PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;
			self::$conn = new PDO("mysql:host=$servername;dbname=$dbname", $uname, $password, $pdo_options);
		}
			return self::$conn;
	}
}

 ?>