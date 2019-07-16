<?php
require_once('../../Conexion/conexion.php');
require_once('../../Models/user.php');
require_once('../../Models/userPreferences.php');
class UserController
{
    private $conn;
    private $tbl="tbl_users";

    public function __construct($conn)
    {
        $this->conn=$conn;
    }

    public function index()
    {
        $query='SELECT * FROM '.$this->tbl;
        $stm=$this->conn->query($query);
        return $stm;
    }

    public function show($id)
    {
        $query='SELECT * from '.$this->tbl.' WHERE userId = '.$id;
        $stm=$this->conn->query($query);
        return $stm;
    }

    public function showByUserNickAndPass($userNick, $userPwd)
    {
        //Checar lo del password cifrado
        $query='SELECT * from '.$this->tbl.' WHERE userNick = "'.$userNick.'" and userPwd = "'.$userPwd.'"';
        $stm=$this->conn->query($query);
        return $stm;
    }

    public function store(User $user)
    {
        $query='INSERT INTO '.$this->tbl.' (userName, userLastName, userMotherLastName, userNick, userPwd,
        userRolId, userEmail,userUntil)
        VALUES ("'.$user->userName.'","'.$user->userLastName.'","'.$user->userMotherLastName.'",
        "'.$user->userNick.'","'.$user->userPwd.'",'.$user->userRolId.',"'.$user->userEmail.'","'.$user->userUntil.'")';

        $stm=$this->conn->query($query);
        $id=0;
        $id=mysqli_insert_id($this->conn);

        $usp=new UserPreferences();
        $this->storePreferences($usp, $id);
        return $stm;
    }

    public function storePreferences(UserPreferences $usp, $id)
    {
        $query='INSERT INTO tbl_user_preferences (userId, directory, language,notifications, recording, quality)
      VALUES ("'.$id.'","'.$usp->directory.'","'.$usp->language.'",'.$usp->notifications.'
      ,'.$usp->recording.',"'.$usp->quality.'")';

        $stm=$this->conn->query($query);
    }

    public function update(User $user, $id)
    {
        $query='UPDATE '.$this->tbl.'
          set userName="'.$user->userName.'",
          userLastName="'.$user->userLastName.'",
          userMotherLastName="'.$user->userMotherLastName.'",
          userNick="'.$user->userNick.'",
          userPwd="'.$user->userPwd.'",
          userRolId='.$user->userRolId.',
          userEmail="'.$user->userEmail.'",
          userUntil="'.$user->userUntil.'" where userId='.$id;

        $stm=$this->conn->query($query);
        return $stm;
    }

    public function destroy($id)
    {
        $query='DELETE from '.$this->tbl.' WHERE userId='.$id;
        $stm=$this->conn->query($query);
        return $stm;
    }
}
