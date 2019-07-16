<?php
require_once('../../Conexion/conexion.php');
require_once('../../Controllers/testFlowController.php');
require_once('../../Models/testFlow.php');
header('Content-Type: application/json; charset=utf-8');

$data = json_decode(file_get_contents('php://input'), true);
$id=$_GET['testFlowId'];

$db=new Conexion();
$conn=$db->getConnection();
$testFlowController=new TestFlowController($conn);
$stm=$testFlowController->show($id);

if ($stm->num_rows > 0) {
    //Validar en el cliente
    /*foreach ($data  as $val) {
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

    $test=new TestFlow();
    $test->testFlowName=utf8_decode($data['testFlowName']);
    $test->testFlowStatus=$data['testFlowStatus'];
    $test->asignedTo=$data['asignedTo'];
    $test->browserId=$data['browserId'];
    $test->testFlowType=$data['testFlowType'];
    $test->testCycle=$data['testCycle'];

    //Almacenar registro
    $stm=$testFlowController->update($test, $id);
    if ($stm) {
        $data=[
          'status'=>'success',
          'code'=>200,
          'message'=>'Prueba actualizada correctamente'
        ];
    } else {
        $data=[
        'status'=>'danger',
        'code'=>404,
        'message'=>'Error al actualizar el registro, verifique los datos'
      ];
    }
} else {
    $data=[
        'status'=>'warning',
        'code'=>404,
        'message'=>'La prueba no se encuentra en la base de datos'
      ];
}

 $response=[];
 http_response_code($data['code']);
 array_push($response, $data);
 echo json_encode($response);
