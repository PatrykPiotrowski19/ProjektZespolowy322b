<?php


class Products_Model extends CI_Model
{


	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}


	public function DisplayProductInfo($ID)
	{

		$query = $this->db->query("SELECT * FROM `product` WHERE ID = ".$ID." ;");

		if($query->num_rows() > 0){

			foreach($query->result() as $row){

				return $row;
			}
		}

		return 0;

	}

	public function CategoryExist($ID)
	{
		if(is_numeric($ID))
		{	

		$query = $this->db->query("SELECT * FROM `category` WHERE `ID` = ".$ID.";");

		if($query->num_rows() > 0)
			return 1;

		return 0;
		}

		return 0;

	}


	public function SubcategoryExist($ID)
	{
		if(is_numeric($ID))
		{	

		$query = $this->db->query("SELECT * FROM `subcategory` WHERE `ID` = ".$ID.";");

		if($query->num_rows() > 0)
			return 1;

		return 0;
		}

		return 0;
	}


	public function GetSubcategoryList($ID)
	{
		if(is_numeric($ID))
		{	
		$query = $this->db->query("SELECT * FROM `subcategory` WHERE `category_id` = ".$ID.";");

		if($query->num_rows() > 0)
		{

			return $query->result();

		}


		return 0;
		}

		return 0;

	}

	public function GetCategoryNameByID($ID)
	{
		if(is_numeric($ID))
		{
			$query = $this->db->query("SELECT * from `category` WHERE ID = ".$ID.";");
		

		if($query->num_rows() > 0)
		{

			foreach($query->result() as $row){

				return $row->name;

		}
			return 0;
		}

		}
				return 0;

	}


	public function ShowProductList($ID, $Maximum)
	{
		if(is_numeric($ID) && is_numeric($Maximum))
		{

			$query = $this->db->query("SELECT 
				product.ID,
				product.nazwa_produktu, 
				product.cena_produktu, 
				product_image.imagename
			FROM product INNER JOIN product_image ON 
			product.ID = product_image.product_id
			WHERE ((
			(product_image.image_id)=1)
			AND 
			(product.podkategoria_id) = ".$ID.") LIMIT ".$Maximum.";");

		if($query->num_rows() > 0)
		{

			return $query->result();

		}
			return 0;			

		}

		return 0;
	}



}

?>