<?php 
class Database {
    private $DB_HOST = 'localhost';
    private $DB_NAME = 'charkin_cert';
    private $DB_PASS = 'Changeless11!';
    private $DB_USER = 'root';

    public function connect(){
        try {
            $this->con = new PDO('mysql:host='.$this->DB_HOST. ';dbname='.$this->DB_NAME, $this->DB_USER, $this->DB_PASS);
            $this->con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $this->con;
        } catch(PDOException $e) {
            echo 'Connection Error: ' .$e->getMessage();
        }
    } 

    
}


