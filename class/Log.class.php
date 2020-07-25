<?php
class Log{
    // types: 1->error; 0->activity; 

    public static function insert(MySQLi $conn, String $agent, int $type, String $module, String $message, String $file){
        try{
            $date =  date("Y-m-d H:i:s");
            $sql = $conn->prepare("INSERT INTO log(agent, type, module, message, date, file) VALUES (?, ?, ?, ?, ?, ?)");
            $sql->bind_param("sissss", $agent, $type, $module, $message, $date, $file);
            $check = $sql->execute();
            $sql->store_result();
            if(!$check){
                error_log($conn->error);
            }
        }catch(Exception $e){
            error_log($e);
            return false;
        }
    }
}
?>