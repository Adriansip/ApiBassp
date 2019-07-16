<?php
require_once('../../Conexion/conexion.php');
require_once('../../Controllers/userController.php');
require_once('../../Models/user.php');

$id=$_GET['userId'];

$db=new Conexion();
$conn=$db->getConnection();
$userController=new UserController($conn);
$user=$userController->show($id);
if ($user->num_rows > 0) {
    $stm=$userController->destroy($id);
    if ($stm) {
        $data=[
      'status'=>'success',
      'code'=>200,
      'message'=>'Usuario eliminado correctamente'
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
    'message'=>'El usuario no se encuentra en la base de datos'
    ];
}

 $response=[];
 http_response_code($data['code']);
 array_push($response, $data);
 echo json_encode($response);
