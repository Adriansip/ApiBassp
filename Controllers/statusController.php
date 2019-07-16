<?php
require_once('../../Conexion/conexion.php');
require_once('../../Models/status.php');
class StatusController
{
    private $conn;
    private $tbl="cat_status";

    public function __construct($conn)
    {
        $this->conn=$conn;
    }

    public function index($statusGroup)
    {
        $query='SELECT * FROM '.$this->tbl.' where statusGroup = '.$statusGroup;
        $stm=$this->conn->query($query);
        return $stm;
    }
}
