<?php

class UserManagement extends CI_Controller{


     
     public $username = null;
     private $password = null;
     

	public function index()
	{
		$this->load->database();
		$this->load->view('header');
		$this->load->library('session');
		$this->load->model("UserManagement_Model");
		
				$tag['custom_tag'] = "<br><br><br>";
				$this->load->view("custom_tag",$tag);

		if(isset($_GET["logout_success"]))
		{
			
			echo "<p>Wylogowano się pomyślnie</p>";
			
		}
	
		
		if(isset($_SESSION["username"]))
		{

			$this->profile_management();

			
		if(isset($_GET["Logout"]))
		{

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


	private function profile_management()
	{

		$tag['custom_tag'] = "<p><a href=/index.php/UserManagement?Logout>Wyloguj się</a></p>";
		$this->load->view("custom_tag",$tag);

	}


	private function reset_password2()
	{

		if(isset($_POST["submit_reset_password"])){
			$errors = 0;


				$_GET["reset"] = $_POST["token_pass"];

			if(!empty($_POST["password"]) && !empty($_POST["password2"])){

				//etap walidacji
				if($_POST["password"] == $_POST["password2"]){

       			require_once("ValidateModule/ValidateModule.php");
				$validate_class = new RegisterValidate();

	 			if($validate_class->ValidatePassword(addslashes($_POST["password"]))){
						
						$this->password = ($_POST["password"]);
					
					}
					else
					{
						$errors++;
				        $arg['info'] = 'Wpisane hasło nie spełnia wymagań (długość 8-32 znaków, co najmniej jedna duża litera, cyfra oraz znak specjalny)';
				        $this->load->view('forms_err',$arg);						

					}
				}
				else
				{
					$errors++;
				    $arg['info'] = 'Wpisane hasła różnią się od siebie';
				    $this->load->view('forms_err',$arg);
				}
			}
			else
			{
				$errors++;
				$arg['info'] = 'Wprowadź hasło';
				$this->load->view('forms_err',$arg);				
			}

			if($errors == 0){	

				$row = $this->UserManagement_Model->GetPasswordResetInfo($_POST["token_pass"]);

				if(!isset($row->ID)){

				  $arg['info'] = 'Nieprawidłowy link resetowania hasła albo już wygasł';
				  $this->load->view('forms_err',$arg);                  
				  $errors++;
              	}
              	else
              	{
					$date = new DateTime();
					$expration_time = $date->getTimestamp();

					if($row->expiration_time < $expration_time){
				  		$arg['info'] = 'Nieprawidłowy link resetowania hasła albo już wygasł';
				  		$this->load->view('forms_err',$arg);   
						$this->UserManagement_Model->DeletePasswordResetRecord($_POST["token_pass"]);
					}
					else
					{
						$this->UserManagement_Model->SetNewPassword($row->USER_ID,$this->password);
				  		$arg['info'] = 'Hasło zostało pomyślnie zmienione';
				  		$this->load->view('forms_info',$arg); 

						$this->UserManagement_Model->DeletePasswordResetRecordsByUserID($row->USER_ID);
					}

              	}	

			}

		}

        		$this->load->view("forms/reset_password2.php");

	}


	private function reset_password()
	{

			$errors = 0;
			$reset_password_invalid_mail = "<p>Niepoprawny mail</p>";

			//Jezeli wcisnięto formularz

			if(isset($_POST["submit_reset_password"])){


					if(!empty($_POST["email"])){

					}
					else
					{
						$errors++;
						$arg['info'] = 'Hasło nie może być puste';
				  		$this->load->view('forms_err',$arg);   

					}


					if($errors == 0){

						$mail_address = $_POST["email"];

						$row = $this->UserManagement_Model->GetUserInfoFromMail($mail_address);

						if(isset($row->ID)){

						$date = new DateTime();


						//12 godzin - link aktywny
						$activate_time_in_hours = 12;
						$expiration_time = $date->getTimestamp() + 12*3600; 
						$token =  md5(rand()).rand(1,10000);

						//Wysylanie maila

				  		$arg['info'] = 'Rejestracja została zakończona pomyślnie, link z aktywacją konta został wysłany na adres e-mail';
				  		$this->load->view('forms_info',$arg); 						



						$this->UserManagement_Model->ResetPasswordGenerateLink($row->ID, $token, $expiration_time);
						$this->UserManagement_Model->ResetPasswordSendMail($row->ADDRESS_TAB2, $token, $expiration_time);

						}
						else
						{
							$arg['info'] = 'Niepoprawny adres e-mail';
				  			$this->load->view('forms_err',$arg);  							

							$errors++;
						}
					}
			}


        	$this->load->view("forms/reset_password.php");

	}


	private function register_attempt()
	{

		$row=Array();
		$this->load->view("custom_tag",$tag);
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

							$this->username = $_POST["login"];	                
				                
				                //Sprawdza czy uzytkownik istnieje
          
				            if($this->UserManagement_Model->CheckUsername($this->username)){

				            		$arg['info'] = 'Nazwa użytkownika jest już zajęta';
				            		$this->load->view('forms_err',$arg);				                  
				                    $errors++;
				                }				          
				            }

				            else{

					                $arg['info'] = 'Nazwa użytkownika jest za krótka';
					                $this->load->view('forms_err',$arg);

				                $errors++;
				            }
				        }
				        else
				        {
				         	$arg['info'] = 'Wprowadź swój login';
					        $this->load->view('forms_err',$arg);
				            $errors++;
				        }
				        
				        if(!empty($_POST["password"]) && !empty($_POST["password2"])){
				            
				            if($_POST["password"] == $_POST["password2"]){
				               
				                if($validate_class->ValidatePassword(addslashes($_POST["password"]))) 
				                    $this->password = md5(addslashes($_POST["password"]));
				                else
				                {
				                   	$arg['info'] = 'Wpisane hasło nie spełnia wymagań (długość 8-32 znaków, co najmniej jedna duża litera, cyfra oraz znak specjalny)';
					       			$this->load->view('forms_err',$arg);
				                    $errors++;
				                }
				                
				            }else
				            {
				              	$arg['info'] = 'Wpisane hasła różnią się od siebie';
					        	$this->load->view('forms_err',$arg);
				                $errors++;
				            }
				            
				        }
				        else{

				            $arg['info'] = 'Hasło nie może być puste';
					        $this->load->view('forms_err',$arg);
				            $errors++;
				        }
				          
				        if(!isset($_POST["regulamin"]))
				        {

				            $errors++;
				        }
				        if(!isset($_POST["dane"])){
				          
				            $arg['info'] = 'Musisz wyrazić zgodę na przetwarzanie danych';
					        $this->load->view('forms_err',$arg);
				        	
				            $errors++; 
				            
				        }

				        if($validate_class->ValidateMail($_POST["mail"])){

				        	$register_mail = $_POST["mail"];

				        		if($this->UserManagement_Model->CheckMail($register_mail)){

				                	$arg['info'] = 'Konto z tym adresem e-mail jest już zarejestrowane';
					        		$this->load->view('forms_err',$arg);
				                    $errors++;
				                }


				        }
				        else
				        {
				      		$arg['info'] = 'Niepoprawny adres e-mail';
					        $this->load->view('forms_err',$arg);
				        	$errors++;

				        }

				        if($validate_class->ValidateName($_POST["name"])){
				            $register_name = addslashes($_POST["name"]);
				            
				        }else
				        {
				        	$arg['info'] = 'Pole imię nie spełnia wymagań (długość 1-12 znaków)';
					        $this->load->view('forms_err',$arg);
				            $errors++;
				        }
				            
				        if($validate_class->ValidateSurname($_POST["surname"])){
				            $register_surname = addslashes($_POST["surname"]);
				            
				        }else
				        {
				        	$arg['info'] = 'Pole nazwisko nie spełnia wymagań (długość 1-24 znaków)';
					        $this->load->view('forms_err',$arg);
				            $errors++;
				        }
				                
				                
				        if(!empty($_POST["adres"])){
				            $register_address = $_POST["adres"];
				            
				        }else
				        {	        	
				        	$arg['info'] = 'Pole adresu nie może być puste';
					        $this->load->view('forms_err',$arg);
				            $errors++;
				        }
				        
				        if($validate_class->ValidatePostalCode($_POST["kod_pocztowy"])){
				            $register_postalcode = $_POST["kod_pocztowy"];
				            
				        }else
				        {				        	
				        	$arg['info'] = 'Nieprawidłowy kod pocztowy';
					        $this->load->view('forms_err',$arg);
				            $errors++;
				        }
				                
				        if($validate_class->ValidateCityName($_POST["miasto"])){
				            $register_city = addslashes($_POST["miasto"]);  
				        }else
				        {
				        	$arg['info'] = 'Pole miasto nie spełnia wymagań (długość 2-30 znaków)';
					        $this->load->view('forms_err',$arg);
				            $errors++;
				        }
				        if($errors > 0){
				        	$arg['info'] = 'Wszystkie pola muszą być uzupełnione';
				        	$this->load->view('forms_err',$arg);
				        }
				        echo '</font>';
				        
				        //Jezeli nie ma błędów
				        if($errors == 0){
				            
				            	            
				            
				           if($this->UserManagement_Model->InsertUserToDatabase(
				            	$this->username,
				            	$this->password,
				            	$register_name,
				            	$register_surname,
				            	$register_address,
				            	$register_mail,
				            	$register_postalcode,
				            	$register_city
				            	))
				            	{				          
				        		$arg['info'] = 'Konto zostało pomyślnie utworzone';
				  				$this->load->view('forms_info',$arg); 
				  		}	
				        else{

				        		return;
				        }

				        $user_id = $this->UserManagement_Model->GetUserId($this->username);

				            $this->UserManagement_Model->SetActivationCode($user_id,$register_mail);

				        }

        }  

        		$this->load->view("forms/register_form.php");

	}


	private function login_attempt()
	{



		if(isset($_POST["submit_login"])){


		        
		        $errors = 0;

		        
		        if(!empty($_POST["login"])){
		            
		        }
		        else
		        {
			         $arg['info'] = 'Wprowadź swój login';
					 $this->load->view('forms_err',$arg);
		            $errors++;
		        }
		        
		        if(!empty($_POST["password"])){
		            
		            
		        }else
		        {
			         $arg['info'] = 'Wprowadź swoje hasło';
					 $this->load->view('forms_err',$arg);
		            $errors++;
		        }
		        
		        
		        if($errors == 0){
		            
		            $this->username = $_POST["login"];
		            $this->password = $_POST["password"];
		            
		            $result = $this->UserManagement_Model->CheckLoginAndPassword($this->username, $this->password);

		            //Jezeli warunki zostały spełnione
		            if($result >= 0){
		                
						if($result == 1){
		               			$_SESSION["username"] = $this->username;
		               			header('Location: /index.php/UserManagement?Profile&LoginSuccess');
			            }
			            else
			            	//Konto nie jest aktywne
			            {
			            	$arg['info'] = 'Musisz aktywować swoje konto, link z aktywacją konta został wysłany na twoją skrzynkę pocztową';
					        $this->load->view('forms_err',$arg);
			            }
		           
		            }
		            else
		            {	
			            $arg['info'] = 'Niepoprawny login/haslo bądź podany użytkownik nie istnieje';
					    $this->load->view('forms_err',$arg);
		            }
		        }		        
			}

			$this->load->view("forms/login_form.php");
		}


	private function activate_user()
	{

		$token = $_GET["activation"];

		$row = $this->UserManagement_Model->GetActivationInfoFromToken($token);
		if(isset($row->expiration_time))
		{

			$exp_time = $row->expiration_time;
			$user_id = $row->user_id;

			echo "ID uzytkownika: ".$user_id;

			$date = new DateTime();

			if($date->getTimestamp() > $exp_time){


				//usuwa rekord + uzytkownika - link wygasł
				$this->UserManagement_Model->RemoveActivationLinkFromToken($token);
				$this->UserManagement_Model->RemoveUsernameFromID($user_id);

				$arg['info'] = 'Nieprawidłowy klucz aktywacji albo link już wygasł';
				$this->load->view('forms_err',$arg);

				}
				else
				//aktywacja konta	
				{
				$this->UserManagement_Model->RemoveActivationLinkFromToken($token);
				$this->UserManagement_Model->ActivateUserFromID($user_id);

				$arg['info'] = 'Pomyślnie aktywowano twoje konto. Możesz się teraz zalogować.';
				$this->load->view('forms_info',$arg); 	


				$this->load->view("forms/login_form.php");
				}

		}
		//Jezeli nieprawidlowy token
		else
		{
				$arg['info'] = 'Nieprawidłowy klucz aktywacji albo link już wygasł';
				$this->load->view('forms_err',$arg);
		}

	}


}


?>