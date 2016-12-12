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

				foreach($query->result() as $row)
					return $row;

			return 0;

		}
			return 0;
	}


	public function GetDeliveryInfoByID($ID)
	{
		if(is_numeric($ID))
		{

			$query = $this->db->query("SELECT * FROM `delivery_options` WHERE `ID` = ".$ID.";");

				foreach($query->result() as $row)
					return $row;

			return 0;

		}
			return 0;
	}


	public function SendTransactionMail($Mail_address, $Transaction_ID)
	{
		$this->load->model("SessionManager_Model");

		$string_message = "Witaj ".$this->SessionManager_Model->GetUsername()." dokonałeś u nas zakupu następujących przedmiotów:<br><br><br>";
		$suma = 0;

		$result = $this->GetTransactionProductsByPaymentID($Transaction_ID);

		$transaction_info = $this->GetTransactionInfoByID($Transaction_ID);

		$delivery_info = $this->GetDeliveryInfoByID($transaction_info->delivery_id);

		$delivery_description = $delivery_info->nazwa_przesylki." za ".$delivery_info->koszt." zł.<br>";

		$suma += $delivery_info->koszt;

		$string_message = $string_message."<table border='1' style='background-color:silver;'>
		<td align='center' width='240'><b>Nazwa przedmiotu</b></td><td width='80' align='center'><b>Cena</b></td><td align='center' width='100'><b>Ilość sztuk</b></td><td width='80' align='center'><b>Razem</b></td></tr>

		";

		foreach($result as $res)
		{

			$string_message = $string_message."<tr><td align='center'>".$res->product_name."</td><td align='center'>".$res->product_cost." zł</td><td align='center'>".$res->product_count." szt</td><td align='center'>".$res->product_cost*$res->product_count." zł</td></tr>";

			$suma = $suma + $res->product_count * $res->product_cost;
		}
		$string_message = $string_message."<tr><td align='center'>Dostawa ".$delivery_info->nazwa_przesylki."</td><td align='center'>".$delivery_info->koszt." zł</td><td align='center'>1 szt</td><td align='center'>".$delivery_info->koszt." zł</td></tr>";		

		$string_message = $string_message."<tr><td></td><td></td><td></td><td align='center'><b>Suma</b><br>".$suma." zł</td></tr>";
		$string_message = $string_message.'</table>';


		if($delivery_info->opcja == 1)
		$string_message = $string_message."<br><font color='red'>Na wpłatę na konto czekamy 24 godziny, w przeciwnym wypadku Twoje zamówienie zostanie anulowane.</font><br><br><b>Tytuł przelewu: </b><i>Płatność numer ".$transaction_info->ID."</i>
		<br>
		<b>Dane firmy:<br>Sklep internetowy sp. z.o.o.<br>al. Wolności 31<br>71-064 Szczecin<br>NIP: 1234567890, REGON 123456789<br><br> Konto bankowe:<br>00 0000 0000 0000 0000 0000 0000 0001<br>ING BANK ŚLĄSKI S.A. O./Szczecin<br></b><br>";

		$string_message = $string_message."<br><br>Twoja przeysłka zostanie solidnie zapakowana i wysłana na dane adresowe Twojego Konta.<br><br>Pozdrawiamy i czekamy na dalsze zakupy,<br><i>Zespół Sklepu Internetowego</i>";

		$Mail_address = addslashes($Mail_address);
		$Transaction_ID = addslashes($Transaction_ID);


		echo $string_message;

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