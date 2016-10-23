<?php

class UserManagement extends CI_Controller{


     
     private $username = null;
     private $password = null;
     

	public function index(){
		$this->load->database();
		$this->load->view("header.php");
		$this->load->library('session');

		
		if(isset($_GET["logout_success"])){
			
			echo "<p>Wylogowano się pomyślnie</p>";
			
		}
		
		
		if(isset($_SESSION["username"])){

			$this->profile_management();



			
		if(isset($_GET["Logout"])){

			unset($_SESSION["username"]);
			header('Location: /index.php/UserManagement?logout_success');
		}


		}
		else{

			if(isset($_GET["Login"])){

				$this->login_attempt();

			}

			if(isset($_GET["ResetPassword"])){

				$this->reset_password();

			}

			if(isset($_GET["Register"])){

				$this->register_attempt();
			}
	}

	}


	private function profile_management(){

		echo "Witaj ".$_SESSION["username"];
		echo "<p><a href=/index.php/UserManagement?Logout>Wyloguj się</a></p>";

	}

	private function reset_password(){

			$errors = 0;
			$reset_password_empty = "<p>Uzupełnij pole e-mail</p>";
			$reset_password_invalid_mail = "<p>Niepoprawny mail</p>";
			//Jezeli wcisnięto formularz

			if(isset($_POST["submit_reset_password"])){


					if(!empty($_POST["email"])){

					}
					else
					{
						$errors++;
						$arguments["reset_password_empty"] = $reset_password_empty;

					}


					if($errors == 0){

						$mail_address = addslashes($_POST["email"]);

						$query = $this->db->query("SELECT * FROM `users` WHERE `ADDRESS_TAB2` = '".$mail_address."'");

						if($query->num_rows()  > 0){

							echo "<p>Poprawny mail, wysylam</p>";

						foreach ($query->result() as $row);


						$date = new DateTime();

						//24 godziny - link aktywny
						$expiration_time = $date->getTimestamp() + 86400; 
						$token =  md5(rand());

						//Wysylanie maila

						
							$query2 = $this->db->query("INSERT INTO `password_reset` (`ID`, `USER_ID`, `CODE`, `EXPIRATION_TIME`) VALUES (NULL, '".$row->ID."', '".$token."', '".$expiration_time."');");



							
							$query2 = $this->db->query("INSERT INTO `password_reset` (`ID`, `USER_ID`, `CODE`, `EXPIRATION_TIME`) VALUES (NULL, '".$row->ID."', '".$token."', '".$expiration_time."');");


							$this->load->library('email');
							$this->email->set_mailtype("html");

							$this->email->from('noreply@sklepinternetowy.pl', 'Sklep internetowy');
							$this->email->to($row->ADDRESS_TAB2);

							$this->email->subject('Reset hasła.');
							$this->email->message('Witaj <b>'.$row->LOGIN.'</b><br>. Link do zresetowania hasła <i>http://322b.esy.es/index.php/UserManagement?reset='.$token.'</i><br>Link wygasa w przeciągu 24 godzin.<br>');

							$this->email->send();


						}
						else
						{
							$arguments["reset_password_invalid_mail"] = $reset_password_invalid_mail;
							$errors++;
						}


					}


			}



			if($errors > 0){

					$this->load->view('forms_error', $arguments);

			}



        		$this->load->view("forms/reset_password.htm");

	}


	private function register_attempt(){



		$register_empty_username = "<p>Nazwa użytkownika nie może być pusta</p>";
        $register_empty_password = "<p>Hasło nie może być puste</p>";
        $register_different_password = "<p>Hasła się od siebie różnią</p>";
        $register_password_short = "<p>Wpisane hasło jest za krótkie (minimum 6 znaków)</p>";
        $register_username_short = "<p>Wpisana nazwa użytkownika jest za krótka (minimum 6 znaków)<p>";
        $register_succeess = "<p id='notify_small'>Pomyślnie zarejestrowano użytkownika<p>";
        $register_rules_error = "<p>Musisz zaakceptować regulamin<p>";
        $register_processing = "<p>Musisz wyrazić zgodę na przetwarzanie danych<p>";
        $register_username_busy = "<p>Nazwa użytkownika jest już zajęta</p>";
        $register_invalid_mail = "<p>Niepoprawny adres e-mail</p>";
        
        $register_name = "";
        $register_surname = "";
        $register_address = "";
        $register_postalcode = "";
        $register_city = "";
        $register_mail = "";


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

				        if(!empty($_POST["mail"])){

				        	$register_mail = $_POST["mail"];

				        }else
				        {
				      		$arguments['register_invalid_mail'] = $register_invalid_mail;
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
				            VALUES (NULL, '".$this->username."', '".$this->password."', '".$register_name."', '".$register_surname."', NULL, '".$register_address."', '".$register_mail."', '".$register_postalcode."', '".$register_city."');");
				            
				            
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
		        else
		            {

		            	$this->load->view('forms_error', $arguments);
		            }
		        


			}


			$this->load->view("forms/login_form.htm");

		}




}


?>