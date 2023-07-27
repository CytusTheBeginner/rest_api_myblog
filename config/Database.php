<?php
class Database {
    //DB Params
    private $host = 'localhost';
    private $db_name = 'myblog';
    private $username = 'root';
    private $password = '';
    private $conn; //connection

    //DB Connect
    public function connect() {
        $this->conn = null; //reset connection
        try {
            $this->conn = new PDO('mysql:host='.$this->host.';dbname='.$this->db_name,$this->username,$this->password); //create connection
            $this->conn->setAttribute(
                PDO::ATTR_ERRMODE, //set attribute
                PDO::ERRMODE_EXCEPTION //set error mode
            );
        } catch(PDOException $e) {
            echo 'connection error: ' . $e->getMessage(); //output error message

        }
        return $this->conn;//return connection
    }
}
?>