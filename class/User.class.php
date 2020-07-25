<?php
class User{
    protected $userEmail;
    protected $userPassword; 
    protected $userName;
    protected $userProfilePicture;
    protected $userStatus; 
    protected $conn;

    public static $defaultUserPicture = "";

    public function __construct(MySQLi $conn, String $userEmail)
    {
        $this->conn = $conn;
        $sql = self::UserExist($this->conn, $userEmail);
        if($sql){
            $row = Helper::fetchAssocStatement($sql);
            $this->userEmail = $userEmail;
            $this->userPassword = $row['userPassword'];
            $this->userName = $row['userName'];
            $this->userProfilePicture = $row['userProfilePicture'];
            $this->userStatus = $row['userStatus'];
        }else{
            $this->userEmail = $userEmail;
            $this->userPassword = NULL;
            $this->userName = NULL;
            $this->userProfilePicture = NULL;
            $this->userStatus = NULL;
        }
    }

    public function addUser($hash)
    {
        if(self::UserExist($this->conn, $this->userEmail)){
            return 2; // E-mail cadastrado
        }
        try{
            $pwd_hashed = Helper::hashAndEncrypt($this->userPassword, $hash);
            $sql = $this->conn->prepare("INSERT INTO user(userEmail, userPassword, userName) VALUES (?, ?, ?)");
            $sql->bind_param('sss', $this->userEmail, $pwd_hashed, $this->userName);
            $check = $sql->execute();

            $sql->store_result();
            if($check){
                return true;
            }else{
                Log::insert($this->conn, "SYSTEM", 1, "addUser()", $this->conn->error."\nErro ao inserir informações no banco de dados.", __FILE__);
                error_log($this->conn->error);
                return false;
            }
        }catch(Exception $e){
            error_log($e);
            Log::insert($this->conn, "SYSTEM", 1, "User::add-user", $e, __FILE__);
            return false;
        }
        return false;
    }

    public static function UserExist(MySQLi $conn, String $userEmail)
    {
        try{
            $sql = $conn->prepare("SELECT * from user where userEmail = ?");
            $sql->bind_param("s", $userEmail);
            $sql->execute();
            $sql->store_result();

            if($sql->num_rows > 0){
                return $sql;
            }else{
                return false;
            }
        }catch(Exception $e){
            error_log($e);
            return false;
        }
    }

    /**
     * Get the value of userEmail
     */ 
    public function getUserEmail()
    {
        return $this->userEmail;
    }

    /**
     * Get the value of userPassword
     */ 
    public function getUserPassword()
    {
        return $this->userPassword;
    }

    /**
     * Set the value of userPassword
     *
     * @return  self
     */ 
    public function setUserPassword($userPassword)
    {
        $this->userPassword = $userPassword;

        return $this;
    }

    /**
     * Get the value of userName
     */ 
    public function getUserName()
    {
        return $this->userName;
    }

    /**
     * Set the value of userName
     *
     * @return  self
     */ 
    public function setUserName($userName)
    {
        $this->userName = $userName;

        return $this;
    }

    /**
     * Get the value of userProfilePicture
     */ 
    public function getUserProfilePicture()
    {
        return $this->userProfilePicture;
    }

    /**
     * Set the value of userProfilePicture
     *
     * @return  self
     */ 
    public function setUserProfilePicture($userProfilePicture)
    {
        $this->userProfilePicture = $userProfilePicture;

        return $this;
    }

    /**
     * Get the value of userStatus
     */ 
    public function getUserStatus()
    {
        return $this->userStatus;
    }
}
?>