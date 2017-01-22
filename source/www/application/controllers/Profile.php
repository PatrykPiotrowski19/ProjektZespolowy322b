<?php


class Profile extends CI_Controller
{


	private function header()
	{
		$this->load->view('header');
		$this->load->model("SessionManager_Model");
		$this->load->model("MainPage_Model");
		$this->load->model("Products_Model");

	}

	public function index()
	{

		$this->header();

	}



	public function Transactions()
	{
		$this->header();

		if($this->SessionManager_Model->IsLogged())
		{
			$this->load->model("Transaction_Model");
			$transactions = $this->Transaction_Model->GetTransactionsByUserID($this->SessionManager_Model->GetUserID());
	

			$this->load->view("transactions_info", $transactions);



		}
		else
		{
			$arguments["info"] = "Musisz być zalogowany.";
			$this->load->view("forms_err",$arguments);
		}


	}


}



?>