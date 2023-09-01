<?php

namespace Josafast\Polls\model;

use PDO;
use PDOException;

class Database {
				private $host;
				private $port;
				private $db;
				private $user;
				private $password;

				public function __construct()
				{
								$this->host = $_ENV["DB_HOST"];
								$this->port = $_ENV["DB_PORT"];
								$this->db = $_ENV["DB_DATABASE"];
								$this->user = $_ENV["DB_USERNAME"];
								$this->password = $_ENV["DB_PASSWORD"];
				}

				public function connect(){
								try {
												$connection = "pgsql:host=".$this->host.";port=".$this->port.";dbname=".$this->db.";";
												$options = [
																PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
																PDO::ATTR_EMULATE_PREPARES => false
												];

												$pdo = new PDO($connection, $this->user, $this->password, $options);
												return $pdo;
								} catch (PDOException $e) {
												print_r('Error connection: ' . $e->getMessage());
								}
				}
}
