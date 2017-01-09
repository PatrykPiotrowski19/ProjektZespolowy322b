<?php



class Comments_Model extends CI_Model{
	

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}


	public function GetCommentsFromProduct($Product_ID)
	{

		if(is_numeric($Product_ID))
		{
	
		$query = $this->db->query("SELECT comments.*, users.LOGIN FROM users INNER JOIN comments ON users.ID = comments.user_id WHERE (((comments.product_id)=".$Product_ID."))");


		if($query->num_rows()>0)
		{

			return $query->result();

		}
			return 0;

		}
		return 0;

	}


	public function IsPendingCommentExist($Comment_Token)
	{
		$Comment_Token = addslashes($Comment_Token);

		$query = $this->db->query("SELECT * FROM `pending_comments` WHERE `comment_token` = '".$Comment_Token."'");
		if($query->num_rows() > 0)
		{

			foreach ($query->result() as $result) {

				return $result;

			}


		}
		return false;

	}


	public function RemovePendingCommand($Comments_Token)
	{
		$Comments_Token = addslashes($Comments_Token);

		$this->db->query("DELETE FROM `pending_comments` WHERE `comment_token` = '".$Comments_Token."' ;");

	}



	public function CanInsertComment($Product_Name, $User_ID)
	{

		if(is_numeric($User_ID))
		{
			$Product_Name = addslashes($Product_Name);

			$query = $this->db->query("SELECT payments.*, payments_products.* FROM payments INNER JOIN payments_products ON payments.ID = payments_products.payment_id WHERE 
				payments.user_id = ".$User_ID." AND 
				payments_products.product_name = '".$Product_Name."' AND payments_products.commented = '0' ;");

			return $query->num_rows();
		}
		return 0;

	}

	private function GetPaymentID($Product_Name, $User_ID)
	{

		if(is_numeric($User_ID))
		{
			$Product_Name = addslashes($Product_Name);

			$query = $this->db->query("SELECT payments.*, payments_products.* FROM payments INNER JOIN payments_products ON payments.ID = payments_products.payment_id WHERE 
				payments.user_id = ".$User_ID." AND 
				payments_products.product_name = '".$Product_Name."' AND payments_products.commented = '0' ;");

			if($query->num_rows())
			{
				return $query->result();
			}
			return 0;
		}
		return 0;

	}


	public function SetComment($Product_ID,
		$User_ID,
		$jakosc_produktu, 
		$jakosc_obslugi, 
		$szybkosc_obslugi,
		$kom)
	{

	if(is_numeric($User_ID))
	{

		$Product_Name = addslashes($Product_Name);

		$this->db->query("
		INSERT INTO `comments` (
		`ID`, 
		`user_id`, 
		`product_id`, 
		`comment`, 
		`product_quality`, 
		`service_quality`, 
		`speed_service`) VALUES (
		NULL, 
		'".$User_ID."', 
		'".$Product_ID."', 
		'".$kom."', 
		'".$jakosc_produktu."', 
		'".$jakosc_obslugi."', 
		'".$szybkosc_obslugi."');
			");

		return 1;
	}
	return 0;

	}

	
} 



?>