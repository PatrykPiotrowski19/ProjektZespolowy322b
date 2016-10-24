<?php


class ValidateModule{

public function __construct(){

}


}

class RegisterValidate extends ValidateModule{




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
?>