<?php
require_once('../../Conexion/conexion.php');
require_once('../../Controllers/testFlowController.php');
header('Content-Type: application/json; charset=utf-8');

$db=new Conexion();
$conn=$db->getConnection();
$test=new TestFlowController($conn);
$stm=$test->index();
if ($stm->num_rows > 0) {
    $tests=[];
    while ($row= $stm->fetch_assoc()) {
        $test=array(
          'testFlowId'=>$row['testFlowId'],
          'testFlowName'=>utf8_encode($row['testFlowName']),
          'testFlowType'=>$row['testFlowType'],
          'testFlowStatus'=>$row['testFlowStatus'],
          'asignedTo'=>$row['asignedTo'],
          'browserId'=>$row['browserId'],
          'testCycle'=>$row['testCycle'],
          'testFlowExecDate'=>$row['testFlowExecDate']
        );
        array_push($tests, $test);
    }
    $data=[
      'status'=>'success',
      'code'=>200,
      'tests'=>$tests,
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
