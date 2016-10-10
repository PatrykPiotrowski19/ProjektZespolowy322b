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
     
     
     //Rejestracja
     private function register_attempt(){
        
        $register_empty_username = "<p>Nazwa użytkownika nie może być pusta.</p>";
        $register_empty_password = "<p>Hasło nie może być puste.</p>";
        $register_different_password = "<p>Hasła się od siebie różnią</p>";
        $register_password_short = "<p>Wpisane hasło jest za krótkie (minimum 6 znaków)</p>";
        $register_username_short = "<p>Wpisana nazwa użytkownika jest za krótka (minimum 6 znaków)<p>";
        $register_succeess = "<p id='notify_small'>Pomyślnie zarejestrowano użytkownika<p>";
        $register_rules_error = "<p>Musisz zaakceptować regulamin<p>";
        $register_processing = "<p>Musisz wyrazić zgodę na przetwarzanie danych<p>";
        $register_username_busy = "<p>Nazwa użytkownika jest już zajęta</p>";
        
        
        $register_name = "";
        $register_surname = "";
        $register_datebirth = "";
        $register_address = "";
        $register_postalcode = "";
        $register_city = "";
        
        $errors = 0;
        
        echo '<br><br><font id="notify_small2_red">';
        if(!empty($_POST["login"])){
            
            
            if(strlen($_POST["login"]) >= 6){
                

                
                $this->username = addslashes($_POST["login"]);
                
                
                $mysql_query = mysqli_query($this->link,"SELECT * FROM `users` WHERE `LOGIN` = '".$this->username."'");
                $num_rows = mysqli_num_rows($mysql_query);

                if($num_rows > 0){
                    echo $register_username_busy;
                    $errors++;
                }
            
            }
            else{
                echo $register_username_short;
                $errors++;
            }
        }
        else
        {
            echo $register_empty_username;
            $errors++;
        }
        
        if(!empty($_POST["password"]) && !empty($_POST["password2"])){
            
            if($_POST["password"] == $_POST["password2"]){
               
                if(strlen($_POST["password"]) >= 6) 
                    $this->password = md5(addslashes($_POST["password"]));
                else
                {
                    echo $register_password_short;
                    $errors++;
                }
                
            }else
            {
                echo $register_different_password;
                $errors++;
            }
            
        }
        else{
            echo $register_empty_password;
            $errors++;
        }
          
        if(!isset($_POST["regulamin"]))
        {
            echo $register_rules_error;
            $errors++;
        }

        if(!isset($_POST["dane"])){

            echo $register_processing;
            $errors++; 
            
        }

        if(!empty($_POST["name"])){
            $register_name = $_POST["name"];
            
        }else
        {
            $errors++;
        }
            
        if(!empty($_POST["surname"])){
            $register_surname = $_POST["surname"];
            
        }else
        {
            $errors++;
        }
                
                
        if(!empty($_POST["adres"])){
            $register_address = $_POST["adres"];
            
        }else
        {
            $errors++;
        }
        
        if(!empty($_POST["kod_pocztowy"])){
            $register_postalcode = $_POST["kod_pocztowy"];
            
        }else
        {
            
            $errors++;
        }
                
        if(!empty($_POST["miasto"])){

            $register_city = $_POST["miasto"];  

        }else
        {
            
            $errors++;
        }

        if($errors > 0){
            echo "<p>Wszystkie pola muszą być uzupełnione<p>";
        }

        echo '</font>';


        

        //Jezeli nie ma błędów
        if($errors == 0){
            

               
            
            
            mysqli_query($this->link,"INSERT INTO `users` 
            (`ID`, `LOGIN`, `PASSWORD`, `NAME`, `SURNAME`, `DATE_OF_BIRTH`, `ADDRESS_TAB`, `ADDRESS_TAB2`, `POSTAL_CODE`, `CITY`) 
            VALUES (NULL, '".$this->username."', '".$this->password."', '".$register_name."', '".$register_surname."', NULL, '".$register_address."', NULL, '".$register_postalcode."', '".$register_city."');");
            
            
            echo $register_succeess;
        }   


     }
     
     
     
     //Logowanie
     private function login_attempt(){
        
     }
     
     
     public function __construct($link){
        
        
        $this->link = $link;
        
        if($_GET["account_management"] == "login"){
            

            
            include('/visual/forms/login_form.htm');
            
            
        }
        if($_GET["account_management"] == "register"){
            
            
            if(isset($_POST["submit_register"])){
                
                $this->register_attempt();
                
            }          
            include("/visual/forms/register_form.htm");
            
        }
        
        
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