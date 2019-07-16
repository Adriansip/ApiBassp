<?php
require_once('../../Conexion/conexion.php');
require_once('../../Models/user.php');
require_once('../../Controllers/userController.php');
require_once('jwt.php');
class JwtAuth
{
    public $key='';
    public function __construct()
    {
        $this->key='BasspKey';
    }

    public function signUp($userNick, $userPwd, $getToken=null)
    {
        $signup=false;
        //Buscar si existe el usuario
        $db=new Conexion();
        $conn=$db->getConnection();
        $userController=new UserController($conn);
        $stm=$userController->showByUserNickAndPass($userNick, $userPwd);
        if ($stm->num_rows>0) {
            $row= $stm->fetch_assoc();
            $signup=true;
            //Generar el token con los datos del usuario
            $token = array();
            $token['userId'] = $row['userId'];
            $token['userName']=$row['userName'];
            $token['userEmail']=$row['userEmail'];
            $token['lastName']=$row['userLastName'];
            $token['userNick']=$row['userNick'];
            $token['userRolId']=$row['userRolId'];
            $token['iat']=time();
            //Una semana
            $token['exp']=time()+(7*24*60*60);

            //token
            $jwt=JWT::encode($token, $this->key);

            //Datos del usuario
            $decoded=JWT::decode($jwt, $this->key, array('HS256'));

            if (is_null($getToken)) {
                $data=[
                  "token"=>$jwt,
                  "code"=> 200
                ];
            } else {
                //Datos del usuario
                $data=$decoded;
            }
            http_response_code(200);
        } else {
            $data = [
              'code'=> 400,
              'estatus' => 'error',
              'message'=>  'Login incorrecto, el usuario con estas credenciales no existe'
            ];
            http_response_code(200);
        }

        //Devolver los datos decodificados o el token
        $response=[];
        array_push($response, $data);
        echo json_encode($response);
    }

    //Verificar cada peitcion
    public function checkToken($jwt, $getIdentity=false)
    {
        $auth=false;
        try {
            //  $jwt=str_replace('"', '', $jwt);
            $decoded=JWT::decode($jwt, $this->key, array('HS256'));
        } catch (Exception $e) {
            $auth=false;
        } catch (Exception $e) {
            $auth=false;
        }

        if (!empty($decoded) && is_object($decoded) && isset($decoded->userId)) {
            $auth=true;
            if ($getIdentity) {
                $response=[];
                array_push($response, $decoded);
                echo json_encode($response);
            }
        } else {
            $auth=false;
        }
        $response=[];
        array_push($response, $auth);
        echo json_encode($response);
    }
}
