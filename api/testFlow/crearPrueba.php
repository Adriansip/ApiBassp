<?php
require_once('../../Conexion/conexion.php');
require_once('../../Controllers/testFlowController.php');
require_once('../../Models/testFlow.php');
header('Content-Type: application/json; charset=utf-8');

$data = json_decode(file_get_contents('php://input'), true);

/*Validar desde el cliente
foreach ($data  as $val) {
    if (empty($val)) {
        $data=[
            'status'=>'danger',
            'code'=>400,
            'message'=>'Porfavor introduzca todos los campos'
        ];
        $response=[];
        http_response_code($data['code']);
        array_push($response, $data);
        echo json_encode($response);
        die();
    }
}*/

 $db=new Conexion();
 $conn=$db->getConnection();
 $testFlowController=new TestFlowController($conn);

 $test=new TestFlow();
 $test->testFlowName=utf8_decode($data['testFlowName']);
 $test->testFlowStatus=$data['testFlowStatus'];
 $test->asignedTo=$data['asignedTo'];
 $test->browserId=$data['browserId'];
 $test->testFlowType=$data['testFlowType'];
 $test->testCycle=$data['testCycle'];
 $test->userId=$data['userId'];

 //Almacenar registro
 $stm=$testFlowController->store($test);
 if ($stm) {
     $id=0;
     $id=mysqli_insert_id($conn);
     $data=[
          'status'=>'success',
          'code'=>200,
          'message'=>'Prueba registrada correctamente',
          'testFlowId'=>$id
        ];
 } else {
     $data=[
        'status'=>'danger',
        'code'=>404,
        'message'=>'Error al guardar el registro, verifique los datos'
      ];
 }

 $response=[];
 http_response_code($data['code']);
 array_push($response, $data);
 echo json_encode($response);
