<?php
require_once('../../Conexion/conexion.php');
require_once('../../Controllers/userController.php');
$id=$_GET['userId'];

$db=new Conexion();
$conn=$db->getConnection();
$userController=new UserController($conn);
$stm=$userController->show($id);

if ($stm->num_rows > 0) {
    $user=[];
    while ($row= $stm->fetch_assoc()) {
        $usuario=array(
          'userId'=>$row['userId'],
          'userLastName'=>$row['userLastName'],
          'userMotherLastName'=>$row['userMotherLastName'],
          'userNick'=>$row['userNick'],
          'userPwd'=>$row['userPwd'],
          'userRolId'=>$row['userRolId'],
          'userLastAccessIP'=>$row['userLastAccessIP'],
          'userUniqueID'=>$row['userUniqueID'],
          'userLastAccess'=>$row['userLastAccess'],
          'userEmail'=>$row['userEmail'],
          'userUntil'=>$row['userUntil'],
          'userToken'=>$row['userToken'],
          'userPhone'=>$row['userPhone']
        );
        array_push($user, $usuario);
    }
    $data=[
      'status'=>'success',
      'code'=>200,
      'user'=>$user,
      'message'=>'Usuario encontrado'
    ];
} else {
    $data=[
        'status'=>'warning',
        'code'=>404,
        'message'=>'El usuario no se encuentra en la base de datos'
    ];
}
  $response=[];
  array_push($response, $data);
  http_response_code($data['code']);
  echo json_encode($response);
