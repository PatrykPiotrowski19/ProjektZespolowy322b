<?php


class MainPage_Model extends CI_Model
{

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
		
	}

	public function ShowProductList()
	{

		$query = $this->db->query("SELECT * FROM `category`");


		foreach($query->result() as $row)
		{
			$arguments['product_name'] = $row->name;
			$arguments['ID'] = $row->ID;
			$this->load->view("menu_elements/product_list_header",$arguments);


			$tag["custom_tag"] = "<ul>";
			$this->load->view("custom_tag",$tag);

			$query2 = $this->db->query("SELECT * from `subcategory` WHERE `category_id` = ".$row->ID." order by `ID`");

			foreach($query2->result() as $row2)
			{
				$arguments2['product_name'] = $row2->name;
				$arguments2['ID'] = $row2->ID;
				$this->load->view("menu_elements/product_list_header2", $arguments2);
			}

			$tag["custom_tag"] = "</ul></li>";
			$this->load->view("custom_tag",$tag);

		}

	}

	public function ShowUserBar()
	{
		$this->load->model("SessionManager_Model");


			$tag["custom_tag"] = '<ol id="account"><li><a href="#">';
			$this->load->view("custom_tag",$tag);

			if($this->SessionManager_Model->IsLogged())
			{
				$tag["custom_tag"] = 'Witaj '.$this->SessionManager_Model->GetUsername();
				$this->load->view("custom_tag",$tag);
			}
			else
			{
				$tag["custom_tag"] = 'Konto';
				$this->load->view("custom_tag",$tag);
			}
				$tag["custom_tag"] = "</a><ul>";
				$this->load->view("custom_tag",$tag);


			if($this->SessionManager_Model->IsLogged())
			{
				//Jezeli uzytkownik jest administratorem
				if($this->SessionManager_Model->IsAdmin())
				{
					$tag["custom_tag"] = '<li><a href="/index.php/Products?AddNewProduct">Dodaj przedmiot</a></li>';
					$this->load->view("custom_tag",$tag);

				}

				$tag["custom_tag"] = '<li><a id="button" href="/index.php/UserManagement?Transactions">Moje transakcje</a></li><li><a href="/index.php/UserManagement?Logout">Wyloguj się</a></li>';
				$this->load->view("custom_tag",$tag);
			}
			else
			{
				$tag["custom_tag"] = '<li><a href="/index.php/UserManagement?Login">Logowanie</a></li>
        		<li><a id="button" href="/index.php/UserManagement?Register">Rejestracja</a></li>';
        		$this->load->view("custom_tag",$tag);
			}
			
	}


	public function GetGroupIDByUsername($username)
	{
		$username = addslashes($username);

		$query = mysqli_query("SELECT * FROM `users` WHERE `LOGIN` LIKE '".$username."'");

		if($query->num_rows() == 1)
		{

			foreach($query->result() as $row){

				$value = $row->account_type;

				return $value;
			}
		}

		return -1;

	}

}


?>