<?php

class Transaction_Model extends CI_Model
{


	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	public function AddNewPayment($User_ID, $Timestamp,$Payment_ID)
	{

		if(is_numeric($User_ID) && is_numeric($Timestamp) && is_numeric($Payment_ID))
		{
			$query = $this->db->query("INSERT INTO `payments` (
				`ID`, 
				`user_id`, 
				`payment_status`, 
				`buy_time`,
				`delivery_id`
				) VALUES (
				NULL, 
				'".$User_ID."', 
				'0', 
				'".$Timestamp."',
				'".$Payment_ID."'
				);");

			return $this->db->insert_id();

		}
		return 0;

	}

	public function InsertNewProductInPayment(
		$Payment_ID,
		$Product_name,
		$Product_cost,
		$Product_count
		)
	{	
		$Payment_ID = addslashes($Payment_ID);
		$Product_name = addslashes($Product_name);
		$Product_cost = addslashes($Product_cost);
		$Product_count = addslashes($Product_count);

		$this->db->query("INSERT INTO `payments_products` (
			`ID`, 
			`payment_id`, 
			`product_name`, 
			`product_cost`, 
			`product_count`) VALUES (
			NULL, 
			'".$Payment_ID."', 
			'".$Product_name."', 
			'".$Product_cost."', 
			'".$Product_count."');");

	}

	public function GetTransactionProductsByPaymentID($Payment_ID)
	{
		if(is_numeric($Payment_ID))
		{
			$query = $this->db->query("SELECT * FROM `payments_products` WHERE `payment_id` = ".$Payment_ID." ;");

			if($query->num_rows() > 0)
			{
				return $query->result();
			}
			return 0;
		}
		return 0;

	}


	public function GetTransactionInfoByID($Transaction_ID)
	{

		if(is_numeric($Transaction_ID))
		{

			$query = $this->db->query("SELECT * FROM `payments` WHERE `ID` = ".$Transaction_ID." ;");

				return $query->result();

			return 0;

		}
			return 0;
	}


	public function GetDeliveryInfoByID($ID)
	{
		if(is_numeric($ID))
		{

			$query = $this->db->query("SELECT * FROM `delivery_option` WHERE `ID` = ".$ID.";");
			if($query->num_rows()>0)
				return $query->result();

			return 0;

		}
			return 0;
	}


	public function SendTransactionMail($Mail_address, $Transaction_ID)
	{


		$string_message = "Witaj<br>dokonałeś u nas zakupu:<br>";
		$suma = 0;

		$result = $this->GetTransactionProductsByPaymentID($Transaction_ID);

		//$transaction_info = $this->GetTransactionInfoByID($Transaction_ID);

		//$delivery_info = $this->GetDeliveryInfoByID($transaction_info->delivery_id);

		foreach($result as $res)
		{

			$string_message = $string_message.$res->product_name." <b> ".$res->product_cost." zł</b> * <i> ".$res->product_count." szt</i> = <i>".$res->product_cost*$res->product_count." zł</i><br>";

			$suma = $suma + $res->product_count * $res->product_cost;
		}

		$string_message = $string_message."<br>Łączna kwota do zapłaty: ".$suma." zł<br>";

		$string_message = $string_message."Na wpłatę na konto czekamy 24 godziny, w przeciwnym wypadku Twoje zamówienie zostanie anulowane.<br><b>Dane firmy:<br>Sklep internetowy sp. z.o.o.<br>al. Wolności 31<br>71-064 Szczecin<br>NIP: 1234567890, REGON 123456789<br><br>Konto bankowe:<br>00 0000 0000 0000 0000 0000 0000 0001<br>ING BANK ŚLĄSKI S.A. O./Szczecin<br></b><br>Pozdrawiamy i czekamy na dalsze zakupy,<br>Zespół Sklepu Internetowego";

		$Mail_address = addslashes($Mail_address);
		$Transaction_ID = addslashes($Transaction_ID);

		$this->load->library('email');
		$this->email->set_mailtype("html");

		$this->email->from('noreply@sklepinternetowy.pl', 'Sklep internetowy');
		$this->email->to($Mail_address);

		$this->email->subject('Dokonałeś (-aś) zakupu w naszym sklepie.');

		$this->email->message($string_message);


		$this->email->send();




	}



}


?>