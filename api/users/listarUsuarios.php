<?php
require_once('../../Conexion/conexion.php');
require_once('../../Controllers/userController.php');

$db=new Conexion();
$conn=$db->getConnection();
$user=new UserController($conn);
$stm=$user->index();

if ($stm->num_rows > 0) {
    $users=[];
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
        array_push($users, $usuario);
    }
    $data=[
  'status'=>'success',
  'code'=>200,
  'users'=>$users,
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
