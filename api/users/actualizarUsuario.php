<?php
require_once('../../Conexion/conexion.php');
require_once('../../Controllers/userController.php');
require_once('../../Models/user.php');

$data = json_decode(file_get_contents('php://input'), true);
$id=$_GET['userId'];


$db=new Conexion();
$conn=$db->getConnection();
$userController=new UserController($conn);
$stm=$userController->show($id);

if ($stm->num_rows > 0) {
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
    }

    $user=new User();
    $user->userName=$data['userName'];
    $user->userLastName=$data['userLastName'];
    $user->userEmail=$data['userEmail'];
    $user->userMotherLastName=$data['userMotherLastName'];
    $user->userNick=$data['userNick'];
    $user->userPwd=$data['userPwd'];
    $user->userRolId=$data['userRolId'];
    $user->userUntil=$data['userUntil'];

    //Almacenar registro
    $stm=$userController->update($user, $id);
    if ($stm) {
        $data=[
          'status'=>'success',
          'code'=>200,
          'message'=>'Usuario actualizado correctamente'
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
        'message'=>'El usuario no se encuentra en la base de datos'
      ];
}

 $response=[];
 http_response_code($data['code']);
 array_push($response, $data);
 echo json_encode($response);
