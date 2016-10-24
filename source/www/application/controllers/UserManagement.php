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



			if(isset($_GET["reset"])){
				$this->reset_password2();
			}


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


	private function reset_password2(){

		$password_empty = "<p>Hasło nie może być puste</p>";
		$reset_different_password = "<p>Wpisane hasła różnią się od siebie</p>";
		$reset_password_short = "<p>Wpisane hasło nie spełnia wymagań (długość 8-32 znaków, co najmniej jedna duża litera, cyfra oraz znak specjalny)</p>";
		$reset_invalid_token = "<p>Nieprawidłowy link resetowania hasła albo już wygasł</p>";
		$reset_token_expired = "<p>Link resetowania hasła już wygasł</p>";
		$reset_complete = "<p>Hasło zostało pomyślnie zmienione</p>";

		if(isset($_POST["submit_reset_password"])){
			$errors = 0;


				$_GET["reset"] = $_POST["token_pass"];

			if(!empty($_POST["password"]) && !empty($_POST["password"])){

				//etap walidacji
				if($_POST["password"] == $_POST["password2"]){

       			require_once("ValidateModule\ValidateModule.php");
				$validate_class = new RegisterValidate();

	 			if($validate_class->ValidatePassword(addslashes($_POST["password"]))){
						
						$this->password = md5(addslashes($_POST["password"]));
					
					}
					else
					{
						$errors++;
						$arguments["password_short"] = $reset_password_short;

					}
				}
				else
				{
					$errors++;
					$arguments["password_differents"] = $reset_different_password;

				}
			}
			else
			{
				$errors++;
				$arguments["password_empty"] = $password_empty;
			}

			if($errors == 0){	

				$query = $this->db->query("SELECT * FROM `password_reset` WHERE `code` = '".addslashes($_POST["token_pass"])."'");

				if($query->num_rows() == 0){

                  $arguments['reset_invalid_token'] = $reset_invalid_token;
				  $errors++;


              	}
              	else
              	{
					foreach ($query->result() as $row);
					$date = new DateTime();
					$expiration_time = $date->getTimestamp();

					if($row->EXPIRATION_TIME < $expiration_time){
                  		$arguments['reset_invalid_token'] = $reset_invalid_token;
						$this->load->view("forms_error.php",$arguments);
						$query3 = $this->db->query("DELETE FROM `password_reset` WHERE `code` = '".addslashes($_POST["token_pass"])."';");
					}
					else
					{
						$password = md5(addslashes($_POST["password"]));
						$query2 = $this->db->query("UPDATE `users` SET `PASSWORD` = '".$password."' WHERE `users`.`ID` = ".$row->USER_ID.";");
						$arguments["reset_complete"] = $reset_complete;
						$this->load->view("forms_info.php",$arguments);
						$query3 = $this->db->query("DELETE FROM `password_reset` WHERE `password_reset`.`USER_ID` = ".$row->USER_ID.";");
					}




              	}	

			}


			if($errors > 0)
				$this->load->view("forms_error.php",$arguments);


		}

        		$this->load->view("forms/reset_password2.php");

	}


	private function reset_password(){

			$errors = 0;
			$reset_password_empty = "<p>Uzupełnij pole e-mail</p>";
			$reset_password_invalid_mail = "<p>Niepoprawny mail</p>";
			$reset_password_send_mail = "<p>Na podany adres e-mail został wysłany link z resetowaniem hasła.</p>";

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


						foreach ($query->result() as $row);


						$date = new DateTime();

						//12 godzin - link aktywny
						$activate_time_in_hours = 12;
						$expiration_time = $date->getTimestamp() + 12*3600; 
						$token =  md5(rand()).rand(1,10000);

						//Wysylanie maila

						$arguments['reset_password_send_mail'] = $reset_password_send_mail;
						$this->load->view('forms_info', $arguments);


							$query2 = $this->db->query("INSERT INTO `password_reset` (`ID`, `USER_ID`, `CODE`, `EXPIRATION_TIME`) VALUES (NULL, '".$row->ID."', '".$token."', '".$expiration_time."');");

							$this->load->library('email');
							$this->email->set_mailtype("html");

							$this->email->from('noreply@sklepinternetowy.pl', 'Sklep internetowy');
							$this->email->to($row->ADDRESS_TAB2);

							$this->email->subject('Reset hasła.');
							$this->email->message('Witaj <b>'.$row->LOGIN.'</b>.<br>Do resetowania hasła: <i>http://322b.esy.es/index.php/UserManagement?reset='.$token.'</i><br>Link wygasa po upływie '.$activate_time_in_hours.' godzin.<br>');

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



        		$this->load->view("forms/reset_password.php");

	}


	private function register_attempt(){



		$register_empty_username = "<p>Nazwa użytkownika nie może być pusta</p>";
        $register_empty_password = "<p>Hasło nie może być puste</p>";
        $register_different_password = "<p>Wpisane hasła różnią się od siebie</p>";
        $register_password_short = "<p>Wpisane hasło nie spełnia wymagań (długość 8-32 znaków, co najmniej jedna duża litera, cyfra oraz znak specjalny)</p>";
        $register_username_short = "<p>Wpisana nazwa użytkownika nie spełnia wymagań (długość 6-12 znaków, małe litery, brak polskich znaków)<p>";
        $register_succeess = "<p>Twoje konto zostało utworzone pomyślnie, możesz się teraz na nie zalogować</p>";
        $register_mail_busy = "<p>Konto z tym adresem e-mail jest już zarejestrowane</p>";
        $register_name_error = "<p>Pole imię nie spełnia wymagań (długość 1-12 znaków)</p>";
        $register_surname_error = "<p>Pole nazwisko nie spełnia wymagań (długość 1-24 znaków)</p>";
        $register_postalcode_error = "<p>Nieprawidłowy kod pocztowy</p>";
        $register_city_error = "<p>Pole miasto nie spełnia wymagań (długość 2-30 znaków)</p>";
        $register_rules_error = "<p>Musisz zaakceptować regulamin</p>";
        $register_address_error = "<p>Pole adresu nie może być puste</p>";
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


        require_once("ValidateModule\ValidateModule.php");

		$validate_class = new RegisterValidate();


				        if(!empty($_POST["login"])){
				            
				            
				            if($validate_class->ValidateLogin($_POST["login"])){
				                
				                
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
				               
				                if($validate_class->ValidatePassword(addslashes($_POST["password"]))) 
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

				        if($validate_class->ValidateMail($_POST["mail"])){

				        	$register_mail = addslashes($_POST["mail"]);


				        	$query2 = $this->db->query("SELECT * FROM `users` WHERE `ADDRESS_TAB2` = '".$register_mail."'");

				        		if($query2->num_rows()  > 0){

				                    $arguments['register_mail_busy'] = $register_mail_busy;
				                    $errors++;
				                }


				        }else
				        {
				      		$arguments['register_invalid_mail'] = $register_invalid_mail;
				        	$errors++;
				        }

				        if($validate_class->ValidateName($_POST["name"])){
				            $register_name = addslashes($_POST["name"]);
				            
				        }else
				        {
				        	$arguments['register_name_error'] = $register_name_error;
				            $errors++;
				        }
				            
				        if($validate_class->ValidateSurname($_POST["surname"])){
				            $register_surname = addslashes($_POST["surname"]);
				            
				        }else
				        {
				        	$arguments['register_surname_error'] = $register_surname_error;
				            $errors++;
				        }
				                
				                
				        if(!empty($_POST["adres"])){
				            $register_address = $_POST["adres"];
				            
				        }else
				        {
				        	$arguments['register_address_error'] = $register_address_error;
				            $errors++;
				        }
				        
				        if($validate_class->ValidatePostalCode($_POST["kod_pocztowy"])){
				            $register_postalcode = $_POST["kod_pocztowy"];
				            
				        }else
				        {
				            $arguments['register_postalcode_error'] = $register_postalcode_error;
				            $errors++;
				        }
				                
				        if($validate_class->ValidateCityName($_POST["miasto"])){
				            $register_city = addslashes($_POST["miasto"]);  
				        }else
				        {
				            $arguments['register_city_error'] = $register_city_error;
				            $errors++;
				        }
				        if($errors > 0){
				           // $arguments['all'] = "<p>Wszystkie pola muszą być uzupełnione<p>";
				        }
				        echo '</font>';
				        
				        //Jezeli nie ma błędów
				        if($errors == 0){
				            
				               
				            
				            
				            $this->db->query("INSERT INTO `users` 
				            (`ID`, `LOGIN`, `PASSWORD`, `NAME`, `SURNAME`, `DATE_OF_BIRTH`, `ADDRESS_TAB`, `ADDRESS_TAB2`, `POSTAL_CODE`, `CITY`) 
				            VALUES (NULL, '".$this->username."', '".$this->password."', '".$register_name."', '".$register_surname."', NULL, '".$register_address."', '".$register_mail."', '".$register_postalcode."', '".$register_city."');");
				            
				            
				            $arguments['account_created'] = $register_succeess;
				          	$this->load->view('forms_info', $arguments);
				        }
				        else
				        {

				        	$this->load->view('forms_error', $arguments);
				        }   


        }  

        		$this->load->view("forms/register_form.php");

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


			$this->load->view("forms/login_form.php");

		}




}


?>