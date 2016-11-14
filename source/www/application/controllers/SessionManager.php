<?php

class SessionManager extends CI_Controller{


	public function index(){

	}


	public function __construct(){

		$this->load->database();

	}


	private function is_logged(){


		if((isset($_SESSION["username"]) && !empty($_SESSION["username"])){

			return true;

		}




	}

}


?>