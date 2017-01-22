<?php



class Filter_Model extends CI_Model{
	

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}


	public function AddNewValues($Filter_Name, $Filter_Value, $Product_ID)
	{
		$Filter_ID = $this->GetFilterID($Filter_Name);
		if($Filter_ID <= 0)
			$Filter_ID = $this->InsertFilterName($Filter_Name);

		$FilterValue_ID = $this->GetFilterValueID($Filter_Value);
		if($FilterValue_ID <= 0)
			$FilterValue_ID = $this->InsertFilterValueName($Filter_Value,$Filter_ID);

		$this->InsertNewFilterToProduct($Filter_ID, $FilterValue_ID, $Product_ID);




	}

	public function GetFilterInfo($Info)
	{
		$values;
		$i = 0;

		if(!empty($Info))
		foreach($Info as $ProductInfo)
		{

			$query = $this->db->query("SELECT filter.name, product_filter.product_ID, filter.ID, filter_value.ID as filter_val_id, filter_value.value FROM (filter INNER JOIN filter_value ON filter.ID = filter_value.filter_ID) INNER JOIN product_filter ON (filter.ID = product_filter.filter_ID) AND (filter_value.ID = product_filter.filter_value_ID) WHERE (((product_filter.product_ID)=".$ProductInfo->ID."))");

			if($query->num_rows() > 0)
			{
				foreach($query->result() as $result)
				{
					$values[$i++] = $result;
				}

			}


		}

		if($values != 0)
		sort($values);

		return $values;


	}


	private function InsertNewFilterToProduct($Filter_ID, $FilterValue_ID, $Product_ID)
	{

		$query = $this->db->query("INSERT INTO `product_filter` (
			`ID`, 
			`product_ID`, 
			`filter_ID`, 
			`filter_value_ID`) VALUES (NULL, 
			'".$Product_ID."', 
			'".$Filter_ID."', 
			'".$FilterValue_ID."');");


	}


	private function InsertFilterName($Filter_Name)
	{

		$query = $this->db->query("INSERT INTO `filter` (`ID`, `name`) VALUES (NULL, '".$Filter_Name."');");

		return $this->db->insert_id();

	}

	private function InsertFilterValueName($Filter_Value,$Filter_ID)
	{

		$query = $this->db->query("INSERT INTO `filter_value` (`ID`, `filter_ID`, `value`) VALUES (NULL, '".$Filter_ID."', '".$Filter_Value."');");

		return $this->db->insert_id();

	}

	private function GetFilterID($Filter_Name)
	{

		$query = $this->db->query("SELECT * FROM `filter` WHERE `name` = '".$Filter_Name."'");

		if($query->num_rows() > 0)
		{
			foreach ($query->result() as $res) {
				return $res->ID;
			}
		}

		return 0;


	}

	private function GetFilterValueID($Filter_Value)
	{
		$query = $this->db->query("SELECT * FROM `filter_value` WHERE `value` = '".$Filter_Value."';");

		if($query->num_rows() > 0)
		{
			foreach ($query->result() as $res) {
				return $res->ID;
			}
		}

		return 0;


	}


	public function GetFilterProductInfo($Filter_info)
	{
		if($Filter_info == 0)
		{
			return 0;
		}

		$values;
		$i = 0;

		foreach($Filter_info as $Info)
		{

			if(is_numeric($Info))
			{

				$query = $this->db->query("SELECT `filter_ID`,`ID`,`value` FROM `filter_value` WHERE `ID` = '".$Info."' ;");
 

			if($query->num_rows() > 0)
			{
				foreach($query->result() as $result)
				{
					$values[$i++] = $result;
				}
			}


			}
		}

		if(!empty($values))
			sort($values);

		return $values; 

	}


	public function FilterProducts($Products,$Filters)
	{

		//Tworze zapytanie bazodanowe

		$text = " ";

		$i=0;
		$keys = 0;
		$last_filter = "0";

		foreach ($Filters as $values) {
			
			if($last_filter != $values->filter_ID)
			{


				if($i != 0)
				$text = $text.") OR (`filter_value_ID` = ".$values->ID;	
				else
				{
				$text = $text." (`filter_value_ID` = ".$values->ID;	
				$i = 1;
				}
				$keys++;
				$last_filter = $values->filter_ID;
			}
			else
			{
				$text = $text.") OR (`filter_value_ID` = ".$values->ID;	

			}


		}
		$text = $text.")";


		//echo $text."keys ->".$keys;

		//sprawdzam dla kazdego wyniku
		$k = 0;

		foreach($Products as $Product_Info)
		{
			$query = $this->db->query("SELECT product.*, product_filter.filter_value_ID FROM product INNER JOIN product_filter ON product.ID = product_filter.product_ID WHERE (`product_ID` = ".$Product_Info->ID." ) AND (".$text.");");

			if($query->num_rows() < $keys)
			{
				unset($Products[$k]);	
			}
			$k++;

		}

		return $Products;


	}


	
} 



?>