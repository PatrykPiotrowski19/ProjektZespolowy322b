<?php

class UserManagement extends CI_Controller{


     
     private $username = null;
     private $password = null;
     

	public function index(){
		$this->load->database();
		$this->load->view("header.php");
		$this->load->library('session');

		if(isset($_SESSION["username"])){

			$this->profile_management();

		if(isset($_GET["Logout"])){

			unset($_SESSION["username"]);
		}


		}
		else{

			if(isset($_GET["Login"])){

				$this->login_attempt();

			}

			if(isset($_GET["Register"])){

				$this->register_attempt();
			}
	}

	}


	private function profile_management(){

		echo "Witaj ".$_SESSION["username"];

	}



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
        $register_address = "";
        $register_postalcode = "";
        $register_city = "";


         $errors = 0;
        


         //Sama procedura rejestracji
         if(isset($_POST["submit_register"])){

				        if(!empty($_POST["login"])){
				            
				            
				            if(strlen($_POST["login"]) >= 6){
				                
				                
				                $this->username = addslashes($_POST["login"]);
				                
				                
				                $mysql_query = $this->db->query("SELECT * FROM `users` WHERE `LOGIN` = '".$this->username."'");
				                if($mysql_query->num_rows()  > 0){

				                    $arguments['username_busy'] = $register_username_busy;
				                    $errors++;
				                }
				            
				            }
				            else{
				                $arguments['username_short'] = $register_username_short;
				                $errors++;
				            }
				        }
				        else
				        {
				            $arguments['username_empty'] = $register_empty_username;
				            $errors++;
				        }
				        
				        if(!empty($_POST["password"]) && !empty($_POST["password2"])){
				            
				            if($_POST["password"] == $_POST["password2"]){
				               
				                if(strlen($_POST["password"]) >= 6) 
				                    $this->password = md5(addslashes($_POST["password"]));
				                else
				                {
				                    $arguments['password_short'] = $register_password_short;
				                    $errors++;
				                }
				                
				            }else
				            {
				                $arguments['password_differents'] = $register_different_password;
				                $errors++;
				            }
				            
				        }
				        else{
				            $arguments['password_empty'] = $register_empty_password;
				            $errors++;
				        }
				          
				        if(!isset($_POST["regulamin"]))
				        {
				            $arguments['rules_error'] = $register_rules_error;
				            $errors++;
				        }
				        if(!isset($_POST["dane"])){
				            $arguments['register_processing'] = $register_processing;
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
				            $arguments['all'] = "<p>Wszystkie pola muszą być uzupełnione<p>";
				        }
				        echo '</font>';
				        
				        //Jezeli nie ma błędów
				        if($errors == 0){
				            
				               
				            
				            
				            $this->db->query("INSERT INTO `users` 
				            (`ID`, `LOGIN`, `PASSWORD`, `NAME`, `SURNAME`, `DATE_OF_BIRTH`, `ADDRESS_TAB`, `ADDRESS_TAB2`, `POSTAL_CODE`, `CITY`) 
				            VALUES (NULL, '".$this->username."', '".$this->password."', '".$register_name."', '".$register_surname."', NULL, '".$register_address."', NULL, '".$register_postalcode."', '".$register_city."');");
				            
				            
				            echo $register_succeess;
				        }
				        else
				        {

				        	$this->load->view('forms_error', $arguments);
				        }   


        }  

        		$this->load->view("forms/register_form.htm");

	}


	private function login_attempt(){



		if(isset($_POST["submit_login"])){

				$login_empty_username = "<p>Wprowadź swój login</p>";
		        $login_empty_password = "<p>Wprowadź hasło</p>";
		        $login_invalid_login_pass = "<p>Niepoprawny login/haslo bądź podany użytkownik nie istnieje</p>";
		        
		        $errors = 0;

		        
		        if(!empty($_POST["login"])){
		            
		        }
		        else
		        {
		            $arguments['login_empty_username'] = $login_empty_username;
		            $errors++;
		        }
		        
		        if(!empty($_POST["password"])){
		            
		            
		        }else
		        {
		            $arguments['login_empty_password'] =$login_empty_password;
		            $errors++;
		        }
		        
		        
		        if($errors == 0){
		            
		            $this->username = addslashes($_POST["login"]);
		            $this->password = md5(addslashes($_POST["password"]));
		            
		            
		            $query = $this->db->query("SELECT * FROM `users` WHERE `LOGIN` = '".$this->username."' AND `PASSWORD` = '".$this->password."'");
		            
		            if($query->num_rows() > 0){
		                
		                $_SESSION["username"] = $this->username;
		                header('Location: /index.php/UserManagement?Profile&LoginSuccess');
		           
		            }
		            else
		            {
		            	$arguments['login_invalid_login_pass'] = $login_invalid_login_pass;
		            	$this->load->view('forms_error', $arguments);
		            }
		            
		        }
		        


			}


			$this->load->view("forms/login_form.htm");

		}




}


?>