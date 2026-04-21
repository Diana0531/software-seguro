<?php
    class DataBase{
        #  Conexión Local
        public static function connection(){
            $hostname = "localhost";
            $port = "3307";
            $database = "db_inventory";
            $username = "root";
            $password = getenv('MYSQL_SECURE_PASSWORD') ?: "Diana0531@";
			$pdo = new PDO("mysql:host=$hostname;port=$port;dbname=$database;charset=utf8",$username,$password);
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			return $pdo;
		}
	}
?>