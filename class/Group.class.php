<?php
class Group{
    private $groupId; 
    protected $groupName;
    protected $groupOwner;
    protected $groupType; // 1 = República, 2 = Casa
    protected $groupAddress;
    protected $groupCEP;
    protected $conn;


    public function __construct(MySQLi $conn, int $groupId = NULL)
    {
        $this->conn = $conn;
        $this->groupId = $groupId;
        $sql = $this->conn->prepare("SELECT * FROM group_ WHERE groupId = ?");
        $sql->bind_param('i', $groupId);
        $check = $sql->execute();
        $sql->store_result();

        if($sql->num_rows > 0){
            $row = Helper::fetchAssocStatement($sql);
            $this->groupName = $row['groupName'];
            $this->groupOwner = $row['groupOwner'];
            $this->groupType = $row['groupType'];
            $this->groupAddress = $row['groupAddress'];
            $this->groupCEP = $row['groupCEP'];
        }else{
            $this->groupName = NULL;
            $this->groupOwner = NULL;
            $this->groupType = NULL;
            $this->groupAddress = NULL;
            $this->groupCEP = NULL;
        }

    }

    public function addGroup(){
        if(!is_null($this->groupId)){
            Log::insert($this->conn, "SYSTEM", 1, "Group::addGroup()", "Tentativa de adicionar um grupo que já existe. groupId:".$this->groupId, __FILE__);
            return false;
        }
        try{
            $sql = $this->conn->prepare('INSERT INTO group_ (groupName, groupOwner, groupType, groupAddress, groupCEP) VALUES (?, ?, ?, ?, ?)');
            $sql->bind_param('ssiss', $this->groupName, $this->groupOwner, $this->groupType, $this->groupAddress, $this->groupCEP);
            $check = $sql->execute();
            $sql->store_result();

            if($check){
                return true;
            }else{
                return false;
            }
        }catch(Exception $e){
            Log::insert($this->conn, "SYSTEM", 1, "Group::addGroup()", $e, __FILE__);
            return false;
        }
    }

    public function insertMember(String $userEmail, int $authority){
        if(is_null($this->groupId)){
            Log::insert($this->conn, "SYSTEM:::".$_SESSION['userEmail'], 1, "Group::insertMember()", "Tentativa de inserir membro em um grupo que não existe.", __FILE__);
            return false;
        }
        if(self::isMember($this->conn, $userEmail, $this->groupId)){
            Log::insert($this->conn, "SYSTEM:::".$_SESSION['userEmail'], 1, "Group::insertMember()", "Tentativa de entrar em um grupo que já é membro.", __FILE__);
            return false;
        }
        try{
            $sql = $this->conn->prepare("INSERT INTO group_member (groupId, userEmail, memberAuthority) VALUES (?, ?, ?)");
            $sql->bind_param('isi', $this->groupId, $userEmail, $authority);
            $check = $sql->execute();
            $sql->store_result();

            if($check){
                return true;
            }else{
                return false;
            }
        }catch(Exception $e){
            Log::insert($this->conn, "SYSTEM", 1, "Group::insertMember()", $e, __FILE__);
            return false;
        }
        
    }

    public static function isMember(MySQLi $conn, String $userEmail, int $groupId){
        try{
            $sql = $conn->prepare('SELECT userEmail FROM group_memer WHERE userEmail = ? AND groupId = ?');
            $sql->bind_param('si', $userEmail, $groupId);
            $sql->execute();
            $sql->store_result();
            if($sql->num_rows > 0){
                return true;
            }else{
                return false;
            }
        }catch(Exception $e){
            Log::insert($conn, "SYSTEM", 1, "Group::isMember()", $e, __FILE__);
            return false;
        }
    }

    public function returnMembers(){

    }

    public static function existGroup(MySQLi $conn, int $groupId){  
        $sql = $conn->prepare('SELECT groupId from group_ where groupId = ?');
        $sql->bind_param('i', $groupId);
        $check = $sql->execute();
        $sql->store_result();

        if($sql->num_rows > 0){
            return true;
        }else{
            return false;
        }
    }

    public static function userIsOnGroup(MySQLi $conn, String $userEmail){ 
        // First check if user owns groups
        $sql = $conn->prepare("SELECT groupId from group_ WHERE groupOwner = ?");
        $sql->bind_param('s', $userEmail);
        $check = $sql->execute();
        $sql->store_result();

        // Save groups that user owns
        $groupIdOwner = [];
        if($sql->num_rows > 0){
            while($row = Helper::fetchAssocStatement($sql)){
                $groupIdOwner[] = $row['groupId'];
            }
            unset($sql, $check, $row);
        }

        // Look for groups he is a member
        $sql = $conn->prepare("SELECT groupId FROM group_member where userEmail = ?");
        $sql->bind_param('s', $userEmail);
        $check = $sql->execute();
        $sql->store_result();

        // Save groups user is member
        $groupIdMember = [];
        if($sql->num_rows > 0){
            while($row = Helper::fetchAssocStatement($sql)){
                $groupIdMember[] = $row['groupId'];
            }
        }

        $groupId = [];
        $groupId[0] = $groupIdOwner;
        $groupId[1] = $groupIdMember;
        return $groupId;
    }

    /**
     * Get the value of groupId
     */ 
    public function getGroupId()
    {
        return $this->groupId;
    }

    /**
     * Get the value of groupName
     */ 
    public function getGroupName()
    {
        return $this->groupName;
    }

    /**
     * Set the value of groupName
     *
     * @return  self
     */ 
    public function setGroupName($groupName)
    {
        $this->groupName = $groupName;

        return $this;
    }

    /**
     * Get the value of groupOwner
     */ 
    public function getGroupOwner()
    {
        return $this->groupOwner;
    }

    /**
     * Set the value of groupOwner
     *
     * @return  self
     */ 
    public function setGroupOwner($groupOwner)
    {
        $this->groupOwner = $groupOwner;

        return $this;
    }

    /**
     * Get the value of groupType
     */ 
    public function getGroupType()
    {
        return $this->groupType;
    }

    /**
     * Set the value of groupType
     *
     * @return  self
     */ 
    public function setGroupType($groupType)
    {
        $this->groupType = $groupType;

        return $this;
    }

    /**
     * Get the value of groupAddress
     */ 
    public function getGroupAddress()
    {
        return $this->groupAddress;
    }

    /**
     * Set the value of groupAddress
     *
     * @return  self
     */ 
    public function setGroupAddress($groupAddress)
    {
        $this->groupAddress = $groupAddress;

        return $this;
    }

    /**
     * Get the value of groupCEP
     */ 
    public function getGroupCEP()
    {
        return $this->groupCEP;
    }

    /**
     * Set the value of groupCEP
     *
     * @return  self
     */ 
    public function setGroupCEP($groupCEP)
    {
        $this->groupCEP = $groupCEP;

        return $this;
    }
}
?>