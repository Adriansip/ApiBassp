<?php
require_once('../../Conexion/conexion.php');
require_once('../../Controllers/statusController.php');
header('Content-Type: application/json; charset=utf-8');

$statusGroup=$_GET['statusGroup'];

$db=new Conexion();
$conn=$db->getConnection();
$statusController=new StatusController($conn);

$stm=$statusController->index($statusGroup);

if ($stm->num_rows > 0) {
    $arrayStatus=[];
    while ($row = $stm->fetch_assoc()) {
        $status=array(
          'statusId'=>$row['statusId'],
          'status'=>$row['status'],
          'statusDesc'=>utf8_encode($row['statusDesc']),
          'statusGroup'=>$row['statusGroup']
        );
        array_push($arrayStatus, $status);
    }
    $data=[
      'estatus'=>'success',
      'code'=>200,
      'status'=>$arrayStatus,
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
