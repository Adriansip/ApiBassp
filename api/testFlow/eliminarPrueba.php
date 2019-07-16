<?php
require_once('../../Conexion/conexion.php');
require_once('../../Controllers/testFlowController.php');
require_once('../../Models/testFlow.php');

$id=$_GET['testFlowId'];

$db=new Conexion();
$conn=$db->getConnection();
$testController=new TestFlowController($conn);
$test=$testController->show($id);
if ($test->num_rows > 0) {
    $stm=$testController->destroy($id);
    if ($stm) {
        $data=[
          'status'=>'success',
          'code'=>200,
          'message'=>'Prueba eliminada correctamente'
        ];
    } else {
        $data=[
        'status'=>'danger',
        'code'=>400,
        'message'=>'Error al intentar eliminar, consulte con el administrador'
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
