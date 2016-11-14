<?php


class Products extends CI_Controller{



	public function index(){
		$this->load->database();
		$this->load->view("header.php");
		$this->load->library('session');

		if(isset($_GET["id"]) && is_numeric($_GET["id"])){




		}
		else
		{
			$arguments['invalid_product'] = true;
			$this->load->view('forms_error', $arguments);
		}

	}


	private function show_item($id){

		$id = addslashes($id);




	}



}




?>