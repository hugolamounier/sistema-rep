<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();
header ('Content-type: text/html; charset=utf-8');
header("Access-Control-Allow-Origin: *");
date_default_timezone_set("Brazil/East"); 

// Variables
define('ROOT_DIR', __DIR__);
define('AUTH_HASH', '29p6cn3tprhdbfnb7hh3dam7ki87f33fwcku9g2trll96yzio3');
define('SELECTOR_COOKIE', 'group-id');  // salva no cookie qual grupo domiciliar o usuário está acessando;

    // Database
    define('DATABASE_SERVER', 'localhost');
    define('DATABASE_USER', 'root');
    define('DATABASE_PASSWORD', '01954501');
    define('DATABASE_NAME', 'republica');
    define('DATABASE_CERT_KEY', NULL);
    define('DATABASE_CERT', NULL);
    define('DATABASE_CA', NULL);

// SDKs

// Classes
require ROOT_DIR."/class/Log.class.php";
require ROOT_DIR."/class//Route.class.php";
require ROOT_DIR."/class//Helper.class.php";
require ROOT_DIR."/class//User.class.php";
require ROOT_DIR."/class//Group.class.php";

try{
    $conn = Helper::mysqlConnect(DATABASE_SERVER, DATABASE_USER, DATABASE_PASSWORD, DATABASE_NAME, DATABASE_CERT_KEY, DATABASE_CERT, DATABASE_CA);
}catch(Exception $e){
    die("Erro ao conectar ao banco de dados");
}


?>