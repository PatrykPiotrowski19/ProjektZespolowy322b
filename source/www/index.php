<?php


require_once("config/config.php");
require_once("visual/header.html");
require_once("modules/module_loader.php");

$database_connection = new connect_db($mysql_address, $mysql_username, $mysql_password, $mysql_dbname);
$database_connection->connection();

/**
 * @author Patryk Piotrowski
 * @copyright 2016
 */


//$test = new login_module();

if(isset($_GET["account_management"])){
    
    $test = new login_module();
    
}





require_once("visual/footer.html");
?>