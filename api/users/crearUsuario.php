<?php
require_once('../../Conexion/conexion.php');
require_once('../../Controllers/userController.php');
require_once('../../Models/user.php');

$data = json_decode(file_get_contents('php://input'), true);

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

 $db=new Conexion();
 $conn=$db->getConnection();
 $userController=new UserController($conn);

 $user=new User();
 $user->userName=$data['userName'];
 $user->userLastName=$data['userLastName'];
 $user->userMotherLastName=$data['userMotherLastName'];
 $user->userNick=$data['userNick'];
 $user->userPwd=$data['userPwd'];
 $user->userRolId=$data['userRolId'];
 $user->userUntil=$data['userUntil'];

 //Almacenar registro
 $stm=$userController->store($user);
 if ($stm) {
     $data=[
          'status'=>'success',
          'code'=>200,
          'message'=>'Usuario registrado correctamente'
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
