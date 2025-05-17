<?php
    class Database{
        private $host = 'localhost';
        private $user = 'root';
        private $pass = '';
        private $dbname = 'applicationdb';
        private $conn;

        public function connect(){
            if($this->conn){
                return $this->conn;
            }

            $this->conn = new mysqli($this->host, $this->user, $this->pass,$this->dbname);

            if($this->conn->connect_error){
                die("Connection Failed" . $this->conn->connect_error);
            }

            return $this->conn;
        }
    }
?>