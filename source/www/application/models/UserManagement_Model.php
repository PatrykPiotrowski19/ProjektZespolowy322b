<?php


class UserManagement_Model extends CI_Model
{


	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}


	public function CheckMail($mail)
	{

		$mail = addslashes($mail);

		$query = $this->db->query("SELECT * FROM `users` WHERE `ADDRESS_TAB2` = '".$mail."'");

		if($query->num_rows() > 0)
			return 1;

		return 0;
	}


	public function InsertUserToDatabase(
		$username, 
		$password, 
		$register_name, 
		$register_surname, 
		$register_address, 
		$register_mail, 
		$register_postalcode, 
		$register_city)
	{

		$username = addslashes($username);
		$password = addslashes($password);
		$register_name = addslashes($register_name);
		$register_surname = addslashes($register_surname);
		$register_address = addslashes($register_address);
		$register_mail = addslashes($register_mail);
		$register_postalcode = addslashes($register_postalcode);
		$register_city = addslashes($register_city);

		//Wysylam zapytanie bazodanowe tworzące konto
		if($this->db->query("INSERT INTO `users` 
				            (`ID`, 
				            `LOGIN`, 
				            `PASSWORD`, 
				            `NAME`, 
				            `SURNAME`, 
				            `DATE_OF_BIRTH`, 
				            `ADDRESS_TAB`, 
				            `ADDRESS_TAB2`, 
				            `POSTAL_CODE`, 
				            `CITY`) 
				            VALUES 
				            (NULL, 
				            '".$username."', 
				            '".$password."', 
				            '".$register_name."', 
				            '".$register_surname."', 
				            NULL, 
				            '".$register_address."', 
				            '".$register_mail."', 
				            '".$register_postalcode."', 
				            '".$register_city."');"))

			return true;


		return false;		            
	}


	public function CheckUsername($username)
	{

		$username = addslashes($username);

		$query = $this->db->query("SELECT * FROM `users` WHERE `LOGIN` = '".$username."'");

		if($query->num_rows() > 0)
			return 1;

		return 0;
	}


	public function GetUserId($username)
	{
		$row=Array();

		$username = addslashes($username);

		$query = $this->db->query("SELECT `ID` FROM `users` WHERE `LOGIN` = '".$username."'");

		if($query->num_rows() == 1)
		{

			foreach($query->result() as $row){

				$value = $row->ID;

				return $value;
			}
		}


		return 0;
	}


	public function SetActivationCode($user_id, $mail_address)
	{

		$mail_address = addslashes($mail_address);

		$activation_code = $this->username.md5(rand()).rand(1,10000);
		$date = new DateTime();
		$expiration_time = $date->getTimestamp() + 24*3600*7; 


		$query = $this->db->query("INSERT INTO `activation` (
			`ID`, 
			`user_id`, 
			`code`, 
			`expiration_time`) 
			VALUES (
			NULL, 
			'".$user_id."', 
			'".$activation_code."', 
			'".$expiration_time."
			');");


		$this->load->library('email');
		$this->email->set_mailtype("html");

		$this->email->from('noreply@sklepinternetowy.pl', 'Sklep internetowy');
		$this->email->to($mail_address);

		$this->email->subject('Aktywacja konta');

		$this->email->message('Witaj <b>'.$row->LOGIN.'</b>.<br>Link do zakonczenia rejestracji : <i><a href="http://322b.esy.es/index.php/UserManagement?activation='.$activation_code.'">KLIKNIJ TUTAJ</a></i><br>Po 7 dniach link wygasa a konto zostaje usunięte.<br>');

		$this->email->send();

	} 


	public function CheckLoginAndPassword($username, $password)
	{

		$username = addslashes($username);
		$password = md5(addslashes($password));

		$query = $this->db->query("SELECT * FROM `users` WHERE `LOGIN` = '".$username."' AND `PASSWORD` = '".$password."'");

		if($query->num_rows() > 0)
		{
				foreach ($query->result() as $row)
						$status = $row->registered;

				return $status;
		}
			
		return -1;
	}

	public function RemoveUsernameFromID($ID)
	{

		$this->db->query("DELETE FROM `users` WHERE `ID` = ".$ID."");
	}

	public function RemoveActivationLinkFromToken($token)
	{
		$token = addslashes($token);
		$this->db->query("DELETE FROM `activation` WHERE `code` = '".$token."';");
	}

	public function GetActivationInfoFromToken($token)
	{

		$token = addslashes($token);

		$query = $this->db->query("SELECT * FROM `activation` WHERE `code` = '".$token."'");
		if($query->num_rows() > 0)
		{

			foreach($query->result() as $row)
			{
				return $row;
			}

		}

		return 0;
	}


	public function GetUserInfoFromMail($mail)
	{
		$mail = addslashes($mail);

		$query = $this->db->query("SELECT * FROM `users` WHERE `ADDRESS_TAB2` = '".$mail."'");

		if($query->num_rows() > 0)
		{

			foreach ($query->result() as $row);

			return $row;
		}

		return 0;
	}


	public function ActivateUserFromID($ID)
	{
		$ID = addslashes($ID);
		$this->db->query("UPDATE  `users` SET  `registered` =  '1' WHERE  `ID` = ".$ID.";");
	}

	public function ResetPasswordGenerateLink($ID, $token, $expiration_time)
	{
		$ID = addslashes($ID);
		$token = addslashes($token);
		$expiration_time = addslashes($expiration_time);
		

		$query = $this->db->query("INSERT INTO `password_reset` (
			`ID`, 
			`USER_ID`, 
			`CODE`, 
			`EXPIRATION_TIME`) 
			VALUES (
			NULL, 
			'".$ID."', 
			'".$token."', 
			'".$expiration_time."
			');");
	}


	public function ResetPasswordSendMail($mail, $token, $activate_time_in_hours)
	{
		$this->load->library('mail');
		$this->email->set_mailtype("html");

		$this->email->from('noreply@sklepinternetowy.pl', 'Sklep internetowy');
		$this->email->to($row->ADDRESS_TAB2);

		$this->email->subject('Reset hasła.');
		$this->email->message('Witaj <b>'.$row->LOGIN.'</b>.<br>Do resetowania hasła: <i>http://322b.esy.es/index.php/UserManagement?reset='.$token.'</i><br>Link wygasa po upływie '.$activate_time_in_hours.' godzin.<br>');

		$this->email->send();
	}

	public function GetPasswordResetInfo($token_pass)
	{
		$token_pass = addslashes($token_pass);
		$query = $this->db->query("SELECT * FROM `password_reset` WHERE `code` = '".$token_pass."'");

		if($query->num_rows() == 0)
		{
			return 0;
		}

		foreach($query->result() as $row);

		return $row;

	}

	public function DeletePasswordResetRecord($token_pass)
	{

		$token_pass = addslashes($token_pass);
		$query = $this->db->query("DELETE FROM `password_reset` WHERE `code` = '".$token_pass."';");
		
	}

	public function SetNewPassword($ID,$password)
	{
		$ID = addslashes($ID);
		$password = md5(addslashes($password));

		$query = $this->db->query("UPDATE `users` SET `PASSWORD` = '".$password."' WHERE `users`.`ID` = ".$ID.";");

	}

	public function DeletePasswordResetRecordsByUserID($ID)
	{

		$ID = addslashes($ID);
		$query = $this->db->query("DELETE FROM `password_reset` WHERE `password_reset`.`USER_ID` = ".$ID.";");

	}

}

?>