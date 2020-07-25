<?php
class Group{
    private $groupId; 
    protected $groupName;
    protected $groupOwner;
    protected $groupType; // 1 = República, 2 = Casa
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
        }else{
            $this->groupName = NULL;
            $this->groupOwner = NULL;
            $this->groupType = NULL;
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
}
?>