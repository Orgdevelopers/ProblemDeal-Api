<?php

class Database{
	
	private $host  = DB_HOST;
    private $user  = DB_USERNAME;
    private $password   = DB_PASSWORD;
    private $database  = DB_DATABASE; 
    private $port = DB_PORT;
    
    public function getConnection(){	
		//die;	
		$conn = new mysqli($this->host, $this->user, $this->password, $this->database,$this->port);
		$conn->set_charset("utf8mb4");
		if($conn->connect_error){
			die("Error failed to connect to MySQL: " . $conn->connect_error);
		} else {
			return $conn;
		}
    }
}

// class DatabaseConnector {

//     private $dbConnection = null;

//     public function __construct()
//     {
//         $host = DB_HOST;
//         $port = DB_PORT;
//         $db   = DB_DATABASE;
//         $user = DB_USERNAME;
//         $pass = DB_PASSWORD;

//         try {
//             $this->dbConnection = new \PDO(
//                 "mysql:host=$host;port=$port;charset=utf8mb4;dbname=$db",
//                 $user,
//                 $pass
//             );
//         } catch (\PDOException $e) {
//             exit($e->getMessage());
//         }
//     }

//     public function getConnection()
//     {
//         return $this->dbConnection;
//     }
// }

?>