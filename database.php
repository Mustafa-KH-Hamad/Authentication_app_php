<?php
class database {
    private $pdo ;
    public function __construct() {
        $this->pdo = $this->Db();
        $create_table = $this->pdo->prepare("create TABLE if not EXISTS users(
            id int(10) PRIMARY KEY AUTO_INCREMENT,
            email varchar(30) UNIQUE,
            password varchar(255),
            token varchar(255) null)
            ");

        $create_table->execute();
    }
    function Db(){
        try {
            $this->pdo = new PDO("mysql:host=localhost;dbname=authentication _app","root","",[
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
            ]);
            return $this->pdo;}
        catch(PDOException $e){
            echo "".$e->getMessage()."";
        }
    }
    function InsertData($email , $password){
        try{
            
            $hashedpassword = password_hash($password, PASSWORD_DEFAULT);
            $query = $this->pdo->prepare("insert into users (email,password) values (?,?)"); 
            $query->bindParam(1,$email);
            $query->bindParam(2,$hashedpassword);
            $query->execute();
        }catch(Exception $e){
            echo "". $e->getMessage();
        }

       }
    function ReadDb(){
        try{
            $query =$this->pdo ->query("Select * from users",PDO::FETCH_ASSOC);
        }catch(Exception $e){
            echo "". $e->getMessage();
        }
        return $query;
    }
    function CheckEmail($email){
        try{
        $query =$this->pdo -> prepare("select email from users where email = ? ");
        $query->bindValue(1,$email);
        $query->execute();
        if ($query->rowCount()> 0){
            return true;
        }else return false;
        }
         catch(Exception $e){ 
             echo "check email ". $e->getMessage();
             return false;
        }
    }
    function CheckPassword($email,$password){
        try{
            $query =$this->pdo ->prepare("select password from users where email = ? ");
            $query->bindValue(1,$email);
            $query->execute();
            $hashedPassword=$query->fetchColumn();
            if ($hashedPassword === "false"){//check if email does not exist the column gives as false 
                return false;
            }
            if (password_verify($password,$hashedPassword)){
                return true;
            }else { echo "fasle bw ";
                return false;
                }
        }catch(Exception $e){
             echo "check password". $e->getMessage();
             return false;
        }


    }

    function InsertToken($email , $token ){
        try{
            $query =$this->pdo -> prepare("update users set token = ? where email = ?");
            $query ->bindValue(1,$token);
            $query->bindValue(2,$email);
            $query->execute();
        }catch (Exception $e){
            echo "". $e->getMessage();
        }
    }
    function CheckToken($token){
        try{
            $query =$this->pdo -> prepare("select email from users where token = ?");
            $query ->bindValue(1,$token);
            $query->execute();
            $featchToken = $query->fetchColumn();
            if ($featchToken){
                return true;
            }else return false ; 
        }catch(Exception $e){
            echo "". $e->getMessage();
            return false;
        }
    }
    function ChangePassword($email,$password){
        try{
            $query =$this->pdo -> prepare("update table users set password=? where email=?");
            $query ->bindValue(1,$password);
            $query->bindParam(2,$email);
            $query->execute();
            if($query->rowCount()> 0){
                echo "password updated successfully";
            }else {
                echo "an error accured";
            }

        }catch(Exception $e){
            echo "". $e->getMessage();
        }
    }

}
?>