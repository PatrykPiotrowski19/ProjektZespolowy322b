<?php


class Comments extends CI_Controller
{

	public function index()
	{
		$this->load->view('header');
		$this->load->model("SessionManager_Model");
		$this->load->model("MainPage_Model");
		$this->load->model("Products_Model");

		if(isset($_GET["add_comment"]) && !empty($_GET["add_comment"]))
		{
			$this->add_comment($_GET["add_comment"]);
		}


	}


	private function add_comment($comment_token)
	{
		$this->load->model("Comments_Model");
		if(($values = $this->Comments_Model->IsPendingCommentExist($comment_token)) != 0) 
		{

			echo $values->user_id;

			if(isset($_POST["send_comment"]))
			{

				$description = addslashes($_POST["description"]);
				$val1 = $_POST["val1"];
				$val2 = $_POST["val2"];
				$val3 = $_POST["val3"];

				if(strlen($description) < 500 && strlen($description) >= 5 && $val1 >= 1 && $val1 <= 10 && $val2 >= 1 && $val2 <= 10 && $val3 >= 1 && $val3 <= 10)
				{

					$this->Comments_Model->SetComment($values->product_id,
					$values->user_id,
					$val1, 
					$val2, 
					$val3,
					$description);

					$this->Comments_Model->RemovePendingCommand($comment_token);

					$arg["success"] = true;
					
				}
				else
					//nieprawidłowo wprowadzone dane
				{

					$arguments["info"] = "Nieprawidłowe dane w komentarzu...";
					$this->load->view("forms_err",$arguments);	

				}	
			}


			$arg["token"] = $comment_token;


			$this->load->view("add_comment",$arg);


		}
		else
		{

			$arguments["info"] = "Nieprawidłowy link do wystawienia komentarza, albo komentarz już został wystawiony.";
			$this->load->view("forms_err",$arguments);	


		}

	}






}

?>