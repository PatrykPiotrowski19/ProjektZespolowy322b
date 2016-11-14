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


			if(isset($_GET["activation"])){

				$this->activate_user();
			}
	}

	}


	private function profile_management(){

		echo "Witaj ".$_SESSION["username"];
		echo "<p><a href=/index.php/UserManagement?Logout>Wyloguj się</a></p>";

	}


	private function reset_password2(){


		if(isset($_POST["submit_reset_password"])){
			$errors = 0;


				$_GET["reset"] = $_POST["token_pass"];

			if(!empty($_POST["password"]) && !empty($_POST["password"])){

				//etap walidacji
				if($_POST["password"] == $_POST["password2"]){

       			require_once("ValidateModule/ValidateModule.php");
				$validate_class = new RegisterValidate();

	 			if($validate_class->ValidatePassword(addslashes($_POST["password"]))){
						
						$this->password = md5(addslashes($_POST["password"]));
					
					}
					else
					{
						$errors++;
						$arguments["password_short"] = true;

					}
				}
				else
				{
					$errors++;
					$arguments["password_differents"] = true;

				}
			}
			else
			{
				$errors++;
				$arguments["password_empty"] = true;
			}

			if($errors == 0){	

				$query = $this->db->query("SELECT * FROM `password_reset` WHERE `code` = '".addslashes($_POST["token_pass"])."'");

				if($query->num_rows() == 0){

                  $arguments['reset_invalid_token'] = true;
				  $errors++;


              	}
              	else
              	{
					foreach ($query->result() as $row);
					$date = new DateTime();
					$expiration_time = $date->getTimestamp();

					if($row->EXPIRATION_TIME < $expiration_time){
                  		$arguments['reset_invalid_token'] = true;
						$this->load->view("forms_error.php",$arguments);
						$query3 = $this->db->query("DELETE FROM `password_reset` WHERE `code` = '".addslashes($_POST["token_pass"])."';");
					}
					else
					{
						$password = md5(addslashes($_POST["password"]));
						$query2 = $this->db->query("UPDATE `users` SET `PASSWORD` = '".$password."' WHERE `users`.`ID` = ".$row->USER_ID.";");
						$arguments["reset_complete"] = true;
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
			$reset_password_invalid_mail = "<p>Niepoprawny mail</p>";

			//Jezeli wcisnięto formularz

			if(isset($_POST["submit_reset_password"])){


					if(!empty($_POST["email"])){

					}
					else
					{
						$errors++;
						$arguments["reset_password_empty"] = true;

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

						$arguments['reset_password_send_mail'] = true;
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
							$arguments["reset_password_invalid_mail"] = true;
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

        $register_succeess = "<p>Twoje konto zostało utworzone pomyślnie, na maila otrzymasz link z aktywacją konta</p>";

        
        $register_name = "";
        $register_surname = "";
        $register_address = "";
        $register_postalcode = "";
        $register_city = "";
        $register_mail = "";


         $errors = 0;
        


         //Sama procedura rejestracji
         if(isset($_POST["submit_register"])){


        require_once("ValidateModule/ValidateModule.php");

		$validate_class = new RegisterValidate();


				        if(!empty($_POST["login"])){
				            
				            
				            if($validate_class->ValidateLogin($_POST["login"])){
				                
				                
				                $this->username = addslashes($_POST["login"]);
				                
				                
				                $mysql_query = $this->db->query("SELECT * FROM `users` WHERE `LOGIN` = '".$this->username."'");
				                if($mysql_query->num_rows()  > 0){

				                    $arguments['username_busy'] = true;
				                    $errors++;
				                }
				            
				            }
				            else{
				                $arguments['username_short'] = true;
				                $errors++;
				            }
				        }
				        else
				        {
				            $arguments['username_empty'] = true;
				            $errors++;
				        }
				        
				        if(!empty($_POST["password"]) && !empty($_POST["password2"])){
				            
				            if($_POST["password"] == $_POST["password2"]){
				               
				                if($validate_class->ValidatePassword(addslashes($_POST["password"]))) 
				                    $this->password = md5(addslashes($_POST["password"]));
				                else
				                {
				                    $arguments['password_short'] = true;
				                    $errors++;
				                }
				                
				            }else
				            {
				                $arguments['password_differents'] = true;
				                $errors++;
				            }
				            
				        }
				        else{
				            $arguments['password_empty'] = true;
				            $errors++;
				        }
				          
				        if(!isset($_POST["regulamin"]))
				        {
				            $arguments['rules_error'] = true;
				            $errors++;
				        }
				        if(!isset($_POST["dane"])){
				            $arguments['register_processing'] = true;
				            $errors++; 
				            
				        }

				        if($validate_class->ValidateMail($_POST["mail"])){

				        	$register_mail = addslashes($_POST["mail"]);


				        	$query2 = $this->db->query("SELECT * FROM `users` WHERE `ADDRESS_TAB2` = '".$register_mail."'");

				        		if($query2->num_rows()  > 0){

				                    $arguments['register_mail_busy'] = true;
				                    $errors++;
				                }


				        }else
				        {
				      		$arguments['register_invalid_mail'] = true;
				        	$errors++;
				        }

				        if($validate_class->ValidateName($_POST["name"])){
				            $register_name = addslashes($_POST["name"]);
				            
				        }else
				        {
				        	$arguments['register_name_error'] = true;
				            $errors++;
				        }
				            
				        if($validate_class->ValidateSurname($_POST["surname"])){
				            $register_surname = addslashes($_POST["surname"]);
				            
				        }else
				        {
				        	$arguments['register_surname_error'] = true;
				            $errors++;
				        }
				                
				                
				        if(!empty($_POST["adres"])){
				            $register_address = $_POST["adres"];
				            
				        }else
				        {
				        	$arguments['register_address_error'] = true;
				            $errors++;
				        }
				        
				        if($validate_class->ValidatePostalCode($_POST["kod_pocztowy"])){
				            $register_postalcode = $_POST["kod_pocztowy"];
				            
				        }else
				        {
				            $arguments['register_postalcode_error'] = true;
				            $errors++;
				        }
				                
				        if($validate_class->ValidateCityName($_POST["miasto"])){
				            $register_city = addslashes($_POST["miasto"]);  
				        }else
				        {
				            $arguments['register_city_error'] = true;
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
				            
				            
				            $arguments['account_created'] = true;

				            $activation_code = $this->username.md5(rand()).rand(1,10000);

				            $date = new DateTime();
				            $expration_time = $date->getTimestamp() + 24*3600*7; 


				            $query = $this->db->query("SELECT * from `users` WHERE `LOGIN` = '".$this->username."';");

				            foreach ($query->result() as $row)
				            	$user_id = $row->ID;


				            $this->db->query("INSERT INTO `activation` (`ID`, `user_id`, `code`, `expiration_time`) VALUES (NULL, '".$user_id."', 
				            	'".$activation_code."', '".$expration_time."');");


				            $this->load->library('email');
							$this->email->set_mailtype("html");

							$this->email->from('noreply@sklepinternetowy.pl', 'Sklep internetowy');
							$this->email->to($row->ADDRESS_TAB2);

							$this->email->subject('Aktywacja konta');
							$this->email->message('Witaj <b>'.$row->LOGIN.'</b>.<br>Zakończenie procesu rejestracji: <i>http://322b.esy.es/index.php/UserManagement?activation='.$activation_code.'</i><br>Po 7 dniach link wygasa a konto zostaje usunięte.<br>');

							$this->email->send();


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


		        
		        $errors = 0;

		        
		        if(!empty($_POST["login"])){
		            
		        }
		        else
		        {
		            $arguments['login_empty_username'] = true;
		            $errors++;
		        }
		        
		        if(!empty($_POST["password"])){
		            
		            
		        }else
		        {
		            $arguments['login_empty_password'] = true;
		            $errors++;
		        }
		        
		        
		        if($errors == 0){
		            
		            $this->username = addslashes($_POST["login"]);
		            $this->password = md5(addslashes($_POST["password"]));
		            
		            
		            $query = $this->db->query("SELECT * FROM `users` WHERE `LOGIN` = '".$this->username."' AND `PASSWORD` = '".$this->password."'");

		            //Jezeli warunki zostały spełnione
		            if($query->num_rows() > 0){
		                

						foreach ($query->result() as $row)
							$status = $row->registered;

						if($status){
		               			$_SESSION["username"] = $this->username;
		               			header('Location: /index.php/UserManagement?Profile&LoginSuccess');
			            }
			            else
			            	//Konto nie jest aktywne
			            {
			            	$arguments['login_unactive'] = true;
			            	$this->load->view('forms_error', $arguments);

			            }
		           
		            }
		            else
		            {
		         		$arguments['login_invalid_login_pass'] = true;
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


	private function activate_user(){

		$token = addslashes($_GET["activation"]);

		$query = $this->db->query("SELECT * FROM `activation` WHERE `code` = '".$token."'");

		if($query->num_rows() > 0){ 

			foreach ($query->result() as $row) 
			{
				$user_id = $row->user_id;
				$exp_time = $row->expiration_time;
			}

		$date = new DateTime();

		if($date->getTimestamp() > $exp_time){


			//usuwa rekord + uzytkownika - link wygasł
			$this->db->query("DELETE FROM `activation` WHERE `code` = '".$token."';");
			$this->db->query("DELETE FROM `users` WHERE `ID` = ".$user_id."");



			$arguments['activation_invalid_token'] = true;
			$this->load->view('forms_error', $arguments);


			}
			else
			//aktywacja konta	
			{
			$this->db->query("DELETE FROM `activation` WHERE `code` = '".$token."';");
			$this->db->query("UPDATE  `users` SET  `registered` =  '1' WHERE  `ID` = ".$user_id.";");


			$arguments['activation_success'] = true;
			$this->load->view('forms_info',$arguments);

			$this->load->view("forms/login_form.php");
			}

		}
		//Jezeli nieprawidlowy token
		else
		{
			$arguments['activation_invalid_token'] = true;
			$this->load->view('forms_error', $arguments);


		}

	}


}


?>