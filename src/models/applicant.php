<?php
    require_once __DIR__ . '/../../config/database.php';

    class Applicant{
        private $conn;

        public function __construct(){
            $db = new Database();
            $this->conn = $db->connect();
        }

        public function saveApplication($name, $email, $portfolio, $letter){
            $stmt = $this->conn->prepare("INSERT INTO applicant_tbl(name, email, portfolio, letter) VALUES (?,?,?,?)");
            $stmt->bind_param("ssss", $name, $email, $portfolio, $letter);
            $stmt->execute();
            $stmt->close();
        }

        public function showApplicant(){
            $stmt = $this->conn->query("SELECT name, email, portfolio, letter, date FROM applicant_tbl ORDER BY date DESC LIMIT 5");
            return $stmt->fetch_all(MYSQLI_ASSOC);
        }
    }
?>