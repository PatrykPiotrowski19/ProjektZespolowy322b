<?php

/**
 * @author Patryk Piotrowski
 * @copyright 2016
 */
    class login_module{
        
     
     private $username = null;
     private $password = null;
     
     //wskaznik do polaczenia z baza danych
     private $link = null;
     
     
     private function login_attempt(){
        
     }
     
     private function register_attempt(){

     }
     
     
     public function __construct(){
        
        
        
        
        
     } 

     private function set_variables($option,$link, $username, $password){
        
        $this->link = $link;
        $this->username = addslashes($username);
        $this->password = md5(addslashes($password));
        unset($password);
        
        switch($option){
            
            case 1: login_attempt(); break;
            case 2: register_attempt(); break;
            
        }  
     } 
    }

?>