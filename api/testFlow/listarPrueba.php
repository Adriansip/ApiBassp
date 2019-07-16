<?php
require_once('../../Conexion/conexion.php');
require_once('../../Controllers/testFlowController.php');
header('Content-Type: application/json; charset=utf-8');

$testFlowId=$_GET['testFlowId'];

$db=new Conexion();
$conn=$db->getConnection();
$test=new TestFlowController($conn);
$stm=$test->show($testFlowId);
if ($stm->num_rows > 0) {
    $test=[];
    while ($row= $stm->fetch_assoc()) {
        $prueba=array(
          'testFlowId'=>$row['testFlowId'],
          'testFlowName'=>utf8_encode($row['testFlowName']),
          'testFlowType'=>$row['testFlowType'],
          'testFlowStatus'=>$row['testFlowStatus'],
          'asignedTo'=>$row['asignedTo'],
          'browserId'=>$row['browserId'],
          'testCycle'=>$row['testCycle'],
          'testFlowExecDate'=>$row['testFlowExecDate']
        );
        array_push($test, $prueba);
    }
    $data=[
      'status'=>'success',
      'code'=>200,
      'test'=>$test,
      'message'=>'Peticion exitosa'
    ];
} else {
    $data=[
    'status'=>'warning',
    'code'=>404,
    'message'=>'No hay registros'
  ];
}
  $response=[];
  array_push($response, $data);
  http_response_code($data['code']);
  echo json_encode($response);
