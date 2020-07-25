<?php
class Helper{
    public static function mysqlConnect($db_server, $db_username, $db_password, $db_name, $key = NULL, $cert = NULL, $ca = NULL)
    {
        $connection = new MySQLi();
        if($key != null || $cert != null || $ca != null){
            $connection->ssl_set($key, $key, $ca, NULL, NULL);
        }
        $connection->real_connect($db_server, $db_username, $db_password, $db_name);
        if($connection->connect_error)
        {
            die($connection->connect_error);
            return false;
        }else{
            $connection->set_charset("UTF-8");
            return $connection;
        }
    }

    // Authentication
        // Ecrypt and Decrypt
    public static function hashAndEncrypt($password, $hash)
    {
        $password_peppered = hash_hmac("sha256", $password, $hash);
        $password_hashed = password_hash($password_peppered, PASSWORD_DEFAULT);
        return $password_hashed;
    }

    public static function decryptAndVerify($password, $password_hashed, $hash)
    {
        $password_peppered = hash_hmac("sha256", $password, $hash);
        if(password_verify($password_peppered, $password_hashed))
        {
            return true;
        }else{
            return false;
        }
    }

    public static function login(MySQLi $conn, String $userEmail, String $userPassword, String $hash)
    {
        $sql = $conn->prepare("SELECT userEmail, userPassword FROM user WHERE userEmail = ? LIMIT 1");
        $sql->bind_param("s", $userEmail);
        $sql->execute();
        $sql->store_result();

        if($sql->num_rows > 0)
        {
            $row = self::fetchAssocStatement($sql);
            if(self::decryptAndVerify($userPassword, $row["userPassword"], $hash))
            {
                $_SESSION["userEmail"] = $userEmail;
                return true;
            }else{
                return false;
            }
        }else{
            return false;
        }
    }
    public static function isLogged(MySQLi $conn, String $hash)
    {
        if(!isset($_SESSION["userEmail"]))
        {
            return false;
        }

        $sql = $conn->prepare("SELECT userEmail, userPassword FROM user WHERE userEmail = ? LIMIT 1");
        $sql->bind_param("s", $_SESSION["userEmail"]);
        $sql->execute(); 
        $sql->store_result();
        
        if($sql->num_rows > 0)
        {
            $row = self::fetchAssocStatement($sql);
            if(self::decryptAndVerify($row['userPassword'], self::hashAndEncrypt($row['userPassword'], $hash), $hash))
            {
                return true;
            }else{
                return false;
            }
        }else{
            return false;
        }
    }

    public static function logout()
    {
        session_destroy();
        $_SESSION["userEmail"] = "";
        setcookie('group-id', null, -1);
        header("location:/");
    }

// Authentication end

    public static function fetchAssocStatement($stmt) // Replaces ->fetch_assoc() when you cant use mysqlnd
    {  
        if($stmt->num_rows>0)
        {
            $result = array();
            $md = $stmt->result_metadata();
            $params = array();
            while($field = $md->fetch_field()) {
                $params[] = &$result[$field->name];
            }
            call_user_func_array(array($stmt, 'bind_result'), $params);
            if($stmt->fetch())
                return $result;
        }
        return null;
    }

    public static function returnError(String $errorMsg){
        return "<div class=\"error\"><i class=\"icon fa-times-circle\"></i><span>$errorMsg</span></div>";
    }
}
?>