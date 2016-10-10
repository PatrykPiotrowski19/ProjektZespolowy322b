<?php
session_start();

require_once("config/config.php");
require_once("visual/header.html");
require_once("modules/module_loader.php");

$database_connection = new connect_db($mysql_address, $mysql_username, $mysql_password, $mysql_dbname);
$link = $database_connection->connection();

/**
 * @author Patryk Piotrowski
 * @copyright 2016
 */


//$test = new login_module();


if(!empty($_SESSION["username"])){
    echo "<p>WITAJ <b>".$_SESSION["username"]."</b></p>";
    echo "<p><a href='index.php?account_management=logout'>Wyloguj sie</a></p>";
}
if(isset($_GET["account_management"]) && !empty($_GET["account_management"])){
    
    $test = new login_module($link);
    
}





require_once("visual/footer.html");
?>