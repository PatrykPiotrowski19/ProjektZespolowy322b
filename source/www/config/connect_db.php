<?php


/**
 * @author Patryk
 * @copyright 2016
 * 
 * Modu� ��czenia si� z baz� danych
 */

class connect_db{

    private $mysql_address = null;
    private $mysql_login = null;
    private $mysql_password = null;
    private $mysql_database_name = null;
    private $link = null;
    
    public function __construct($mysql_address, $mysql_login, $mysql_password, $mysql_database_name){
        
        $this->mysql_address = $mysql_address;
        $this->mysql_login = $mysql_login;
        $this->mysql_password = $mysql_password;
        $this->mysql_database_name = $mysql_database_name;

    }
      
    public function connection(){
        
        
        if (!($this->link = mysqli_connect($this->mysql_address, $this->mysql_login, $this->mysql_password, $this->mysql_database_name))) {
            
            echo "B��d: Nie mo�na po��czy� si� baz� danych." . PHP_EOL;
            echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
            echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
            exit;  
        }
        
        return $this->link;
    }
    
    public function __destruct(){
        
        unset($this->mysql_address);
        unset($this->mysql_login);
        unset($this->mysql_password);
        unset($this->mysql_database_name);
        mysqli_close($this->link);
        unset($this->link);
    }
}

?>