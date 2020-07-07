<?php
require __DIR__."/config.php";

$password = $_GET["p"];

$pwd_peppered = hash_hmac("sha256", $password, AUTH_HASH);

$pwd_hashed = password_hash($pwd_peppered, PASSWORD_DEFAULT);

echo $pwd_hashed;
?>

