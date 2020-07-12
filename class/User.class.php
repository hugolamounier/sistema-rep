<?php
class User{
    protected $userEmail;
    protected $userPassword;
    protected $userName;
    private $db_conn;

    public function __construct(MySQLi $db_conn)
    {
        $this->db_conn = $db_conn;
        
    }
}
?>