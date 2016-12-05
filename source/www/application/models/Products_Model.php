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

	public function GetImageUrl($ID)
	{
		if(is_numeric($ID))
		{
			$query = $this->db->query("SELECT * FROM `product_image` WHERE `product_id` = ".$ID.";");

			if($query->num_rows()>0)
			{
				return $query->result();
			}
			return 0;
		}
		return 0;
	}

	public function GetMainProductImage($ID)
	{
		if(is_numeric($ID))
		{
			$query = $this->db->query("SELECT * FROM `product_image` WHERE `product_id` = ".$ID." AND `image_id` = 1;");

			if($query->num_rows()>0)
			{

				foreach($query->result() as $row)

				return $row->imagename;
		
			}
			return 0;
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

	public function CategoryIsNotEmpty($ID)
	{
		if(is_numeric($ID))
		{
			$query = $this->db->query("SELECT * from `subcategory` WHERE `category_id` = ".$ID."");

			if($query->num_rows() > 0)
				return 1;

			return 0;
		}

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


	public function GetSubcategoryIDByName($Name)
	{

		$Name = addslashes($Name);

		$query = $this->db->query("SELECT * from `subcategory` WHERE `name` = '".$Name."';");
		
		if($query->num_rows() > 0)
		{

			foreach($query->result() as $row){

				return $row->ID;

		}
			return 0;
		}
		return 0;


	}


	public function GetCategoryIDByName($Name)
	{

		$Name = addslashes($Name);

		$query = $this->db->query("SELECT * from `category` WHERE `name` = '".$Name."';");
		
		if($query->num_rows() > 0)
		{

			foreach($query->result() as $row){

				return $row->ID;

		}
			return 0;
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


	public function IsCategoryExist($Category_Name)
	{
		$Category_Name = addslashes($Category_Name);

		$query = $this->db->query("SELECT * from `category` WHERE `name` = '".$Category_Name."';");

		if($query->num_rows() > 0)
			return 1;

		return 0;

	}


	public function IsSubCategoryExist($Subcategory_Name)
	{
		$Subcategory_Name = addslashes($Subcategory_Name);

		$query = $this->db->query("SELECT * from `subcategory` WHERE `name` = '".$Subcategory_Name."';");

		if($query->num_rows() > 0)
			return 1;

		return 0;

	}

	public function AddNewCategory($Category_Name)
	{
		$Category_Name = addslashes($Category_Name);

		$query = $this->db->query("SELECT * from `category` WHERE name = '".$Category_Name."';");

		if($query->num_rows() == 0)
		{

			$query2 = $this->db->query("INSERT INTO 
				`category` (
				`ID`, 
				`name`, 
				`description`) VALUES (
				NULL, 
				'".$Category_Name."', 
				'".$Category_Name."');");

		}

	}

	public function AddNewSubcategory($Subcategory_Name, $Category_Name)
	{

		$Subcategory_Name = addslashes($Subcategory_Name);

		$query = $this->db->query("SELECT * from `subcategory` WHERE name = '".$Subcategory_Name."';");

		if($query->num_rows() == 0)
		{
			$Subcategory_Name = addslashes($Subcategory_Name);


			//Zdobadz ID kategorii nadrzednej
			$Parent_ID = $this->GetCategoryIDByName($Category_Name);
			echo "PARENT ID = ".$Parent_ID;
			if($Parent_ID > 0)
			{

				$query = $this->db->query("INSERT INTO `subcategory` (
					`ID`, 
					`category_id`, 
					`name`) VALUES (
					NULL, 
					'".$Parent_ID."', 
					'".$Subcategory_Name."');");

			}

		}

	}


	public function GetProductIDByName($Name)
	{
		$Name = addslashes($Name);

		$query = $this->db->query("SELECT * from `product` WHERE `nazwa_produktu` = '".$Name."';");

		if($query->num_rows() > 0)
		{

			foreach($query->result() as $row){

				return $row->ID;

		}
			return 0;
		}
		return 0;


	}

	private function InsertNewImage($Product_ID, $ID, $URL)
	{
		$URL = addslashes($URL);

		$query = $this->db->query("INSERT INTO `product_image` (
			`ID`, 
			`product_id`, 
			`image_id`, 
			`imagename`) VALUES (
			NULL, 
			'".$Product_ID."', 
			'".$ID."', 
			'".$URL."');");

	}



	public function InsertProductToDatabase(
		$Subcategory_Name,
		$Product_Name,
		$Product_Price,
		$Product_Count,
		$Product_Description,
		$image1,
		$image2,
		$image3,
		$image4
		)
	{

		$Subcategory_ID = $this->GetSubcategoryIDByName($Subcategory_Name);
		$Products_Name = addslashes($Product_Name);
		$Product_Price = round($Product_Price,2);
		$Product_Description = addslashes($Product_Description);

		$query = $this->db->query("INSERT INTO `product` (
			`ID`, 
			`podkategoria_id`, 
			`nazwa_produktu`, 
			`cena_produktu`, 
			`ilosc`, 
			`opis`) VALUES (
			NULL, 
			'".$Subcategory_ID."', 
			'".$Product_Name."', 
			'".$Product_Price."', 
			'".$Product_Count."', 
			'".$Product_Description."'
			);");

		//Tymczasowa opcja dodawania zdjec

		$Product_ID = $this->GetProductIDByName($Product_Name);

		if(!empty($image1))
			$this->InsertNewImage($Product_ID, 1, $image1);
		if(!empty($image2))
			$this->InsertNewImage($Product_ID, 2, $image2);
		if(!empty($image3))
			$this->InsertNewImage($Product_ID, 3, $image3);
		if(!empty($image4))
			$this->InsertNewImage($Product_ID, 4, $image4);

	}


	public function CountProductItems($Product_ID)
	{

		if(is_numeric($Product_ID))
		{
			$query = $this->db->query("SELECT `ilosc` FROM `product` WHERE `ID` = ".$Product_ID.";");

			if($query->num_rows() > 0)
			{

			foreach($query->result() as $row){

				return $row->ilosc;
			}

			}
		return 0;

		}
		return 0;
	}
}

?>