<?php
include_once "functions.php";
session_start_control(false);
$_SESSION=array();
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time()-time()-1,
    $params["path"],$params["domain"],
    $params["secure"], $params["httponly"]);
}
session_destroy();
session_start();
$_SESSION["236037_msg_title"]="Logged out";
$_SESSION["236037_msg_body"]="You are no longer logged in. Bye!";
redirect_relative("index.php");
?>