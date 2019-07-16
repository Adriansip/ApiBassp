<?php
class Conexion
{
    private $server="localhost";
    private $database="bassptic_demo";
    private $userName="root";
    private $password="";
    public $conn;

    public function getConnection()
    {
        $this->conn=mysqli_connect($this->server, $this->userName, $this->password, $this->database);
        return $this->conn;
    }
}
