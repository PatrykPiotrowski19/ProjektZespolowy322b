<?php


class ValidateModule
{

public function __construct(){

}


}

class RegisterValidate extends ValidateModule
{




		public function ValidateName($str){

		if(preg_match('/^[\pL\']{1,12}$/u', $str))
			return 1;

		return 0;
		}


		public function ValidateSurname($str){

		if(preg_match('/^[\pL\'-]{1,24}$/u', $str))
			return 1;

		return 0;

		}


		public function ValidatePassword($str){


		if(preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[!@#$%\^&*_])(?:[a-zA-Z0-9!@#$%\^&*_]{8,32})$/', $str))
			return 1;

		return 0;




		}

		public function ValidateMail($str){

		if(preg_match('/^[a-zA-Z0-9\.\-_]+\@[a-zA-Z0-9\.\-_]+\.[a-z]{2,4}$/D', $str))
			return 1;

		return 0;

		}

		public function ValidatePostalCode($str){

		if(preg_match("/^([0-9]{2})(-[0-9]{3})?$/i", $str))
			return 1;


		return 0;

		}


		public function ValidateLogin($str){

		if(preg_match('/^[a-z0-9]{6,12}$/D', $str))
			return 1;

		return 0;

		}


		public function ValidateCityName($str){

		if(strlen($str) >= 2 && strlen($str) <= 30)
			return 1;

		return 0;
		}

}

class AddProductValidate extends ValidateModule
{

	private $result;

	private $category;
	private $subcategory;
	private $item_name;
	private $count;
	private $description;

	public function __construct()
	{

	
	}


	public function AddVariables(
		$category,
		$subcategory,
		$item_name,
		$count,
		$cost,
		$description
		)
	{
		$this->category = $category;
		$this->subcategory = $subcategory;
		$this->item_name = $item_name;
		$this->count = $count;
		$this->cost = $cost;
		$this->description = $description;
	}

	public function GetResult()
	{
		$this->result[0] = $this->ValidateCategory($this->category);
		$this->result[1] = $this->ValidateSubcategory($this->subcategory);
		$this->result[2] = $this->ValidateItemName($this->item_name);
		$this->result[3] = $this->ValidateCount($this->count);
		$this->result[4] = $this->ValidateCost($this->cost);
		$this->result[5] = $this->ValidateDescription($this->description);

		return $this->result;

	}

	private function ValidateCategory($str)
	{

		if(!empty($str) && strlen($str) < 32)
			return 1;

		return 0;

	}

	private function ValidateSubcategory($str)
	{

		if(!empty($str) && strlen($str) < 32)
			return 1;

		return 0;

	}

	private function ValidateItemName($str)
	{

		if(!empty($str) && strlen($str) < 64)
			return 1;

		return 0;

	}

	private function ValidateCount($str)
	{

		if(is_numeric($str))
		{
			if($str > 0)
				return 1;

		}
		return 0;

	}

	private function ValidateCost($str)
	{
		if(is_numeric($str) && $str > 0.01)
			return 1;

		return 0;
	}

	private function ValidateDescription($str)
	{

		if(strlen($str) <= 4096 && !empty($str))
			return 1;

		return 0;
	}

}


?>