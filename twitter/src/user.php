<?php

class User {
    static public function GetUsers(mysqli $conn, $userName){

        isset($userName) ? $sql = "SELECT * FROM users WHERE login LIKE '%{$userName}%' ORDER BY login" :
                           $sql = "SELECT * FROM users ORDER BY login"; 
        $result = $conn->query($sql);

        $toReturn = [];

        if($result != false){
            foreach($result as $row){
                $newUser = new User();

                $newUser->id = $row['id'];
                $newUser->login = $row['login'];
                $newUser->hassedPassword = $row['hassed_password'];
                $newUser->description = $row['user_description'];
                $newUser->isActive = $row['is_active'];

                $toReturn[] = $newUser;
            }
        }
        return $toReturn;
    }

    static public function LogIn(mysqli $conn, $login, $password){
        $toReturn = null;
        $sql = "SELECT * FROM users WHERE login = '{$login}'";
        $result = $conn->query($sql);
        if($result != FALSE){
            if($result->num_rows === 1){
                $row = $result->fetch_assoc();
                $loggedUser = new User();
                $loggedUser->id = $row['id'];
                $loggedUser->login = $row['login'];
                $loggedUser->hassedPassword = $row['hassed_password'];
                $loggedUser->description = $row['user_description'];
                $loggedUser->isActive = $row['is_active'];

                if($loggedUser->verifyPassword($password)){
                    $toReturn = $loggedUser;
                }
            }
        }
        return $toReturn;
    }

    private $id;
    private $login;
    private $hassedPassword;
    private $description;
    private $isActive;

    public function __construct(){
        $this->id = -1;
        $this->login ='';
        $this->hassedPassword = '';
        $this->description = '';
        $this->isActive = 0;
    }

    public function getID (){
        return $this->id;
    }

    public function setLogin ($newLogin){
        $this->login = $newLogin;
    }

    public function getLogin (){
        return $this->login;
    }

    public function setPassword($newPassword, $newPassword2){
        if($newPassword != $newPassword2){
            return false;
        }
        $hassedPassword = password_hash($newPassword, PASSWORD_BCRYPT);
        $this->hassedPassword = $hassedPassword;
        return true;
    }

    public function setDescription($newDescritpion){
        $this->description = $newDescritpion;
    }

    public function getDescription (){
        return $this->description;
    }

    public function deactivate(){
        $this->isActive = 0;
    }
    public function activate(){
        $this->isActive = 1;
    }

    public function isUserActive(){
        return ($this->isActive === 1);
    }

    public function saveToDB (mysqli $conn){
        if($this->id === -1){
            $sql = "INSERT INTO users (login, hassed_password, user_description, is_active) VALUES
                    ('{$this->login}', '{$this->hassedPassword}', '{$this->description}', '{$this->isActive}')";
            $result = $conn->query($sql);
            if($result == TRUE){
                $this->id = $conn->insert_id;
                return TRUE;
            }else{
                return FALSE;
            }
        }else{
            $sql = "UPDATE users SET login='{$this->login}', "
                                    . "hassed_password = '{$this->hassedPassword}', "
                                    . "user_description = '{$this->description}', "
                                    . "is_active = '{$this->isActive}' "
                                    . "WHERE id = {$this->id}";

            $result = $conn->query($sql);
            return $result;
        }
    }

    public function loadFromDB (mysqli $conn, $id){
        $sql = "SELECT * FROM users WHERE id = $id";
        $result = $conn->query($sql);
        if($result != FALSE){
            if($result->num_rows === 1){
                $row = $result->fetch_assoc();
                $this->id = $row['id'];
                $this->login = $row['login'];
                $this->hassedPassword = $row['hassed_password'];
                $this->description = $row['user_description'];
                $this->isActive = $row['is_active'];

                return TRUE;
            }
        } return FALSE;
    }

    public function verifyPassword($password){
        return password_verify($password, $this->hassedPassword);
    }
}
?>