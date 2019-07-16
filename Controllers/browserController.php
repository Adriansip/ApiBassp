<?php
require_once('../../Conexion/conexion.php');
require_once('../../Models/status.php');
class BrowserController
{
    private $conn;
    private $tbl="cat_browsers";

    public function __construct($conn)
    {
        $this->conn=$conn;
    }

    public function index()
    {
        $query='SELECT * FROM '.$this->tbl;
        $stm=$this->conn->query($query);
        return $stm;
    }
}
