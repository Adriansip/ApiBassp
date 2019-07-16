<?php
require_once('../../Conexion/conexion.php');
require_once('../../Models/testFlow.php');
class TestFlowController
{
    private $conn;
    private $tbl="tbl_test_flow";

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

    public function show($id)
    {
        $query='SELECT * from '.$this->tbl.' WHERE testFlowId = '.$id;
        $stm=$this->conn->query($query);
        return $stm;
    }

    public function showByEmailAndPass($userEmail, $userPwd)
    {
        //Checar lo del password cifrado
        $query='SELECT * from '.$this->tbl.' WHERE userEmail = "'.$userEmail.'" and userPwd = "'.$userPwd.'"';
        $stm=$this->conn->query($query);
        return $stm;
    }

    public function store(TestFlow $test)
    {
        $query='INSERT INTO '.$this->tbl.' (testFlowName, testFlowType, testFlowStatus, asignedTo,
         browserId, testCycle)
        VALUES ("'.$test->testFlowName.'",'.$test->testFlowType.','.$test->testFlowStatus.',
        '.$test->asignedTo.','.$test->browserId.','.$test->testCycle.')';
        $stm=$this->conn->query($query);

        return $stm;
    }

    public function update(TestFlow $test, $id)
    {
        $query='UPDATE '.$this->tbl.'
          set testFlowName = "'.$test->testFlowName.'",
          testFlowType = '.$test->testFlowType.',
          testFlowStatus = '.$test->testFlowStatus.',
          asignedTo = '.$test->asignedTo.',
          browserId = '.$test->browserId.',
          testCycle = '.$test->testCycle.'
          where testFlowId = '.$id;
        $stm=$this->conn->query($query);
        return $stm;
    }

    public function destroy($id)
    {
        $query='DELETE from '.$this->tbl.' WHERE testFlowId='.$id;
        $stm=$this->conn->query($query);
        return $stm;
    }
}
