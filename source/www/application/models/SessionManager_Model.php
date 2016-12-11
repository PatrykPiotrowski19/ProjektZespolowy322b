<?php

class SessionManager_Model extends CI_Model
{
	
	public function __construct()
	{
		$this->load->library('session');
		session_regenerate_id();

	}


	public function SetUserSession($username)
	{

		$username = addslashes($username);
		$_SESSION["username"] = $username;

	}
	

	public function GetUsername()
	{
		if($this->IsLogged())
		return $_SESSION["username"];

	}


	public function IsLogged()
	{

		return(isset($_SESSION["username"]) && !empty($_SESSION["username"]));

	}


	public function Logout()
	{

		unset($_SESSION["username"]);

	}

	public function GetUserID()
	{

		if($this->IsLogged())
		{
			$query = $this->db->query("SELECT * FROM `users` WHERE `LOGIN` = '".$this->GetUsername()."';");

			if($query->num_rows() == 1)
			{

				foreach($query->result() as $row){

				$value = $row->ID;

				return $value;
			}


		}
		return 0;

		}
		return 0;
	}


	public function IsAdmin()
	{
		$this->load->database();
		$query = $this->db->query("SELECT * FROM `users` WHERE `LOGIN` = '".$this->GetUsername()."'");

		if($query->num_rows() == 1 && $this->IsLogged())
		{

			foreach($query->result() as $row){

				$value = $row->account_type;

				return $value==1;
			}
		}

		return 0;

	}

}

?>