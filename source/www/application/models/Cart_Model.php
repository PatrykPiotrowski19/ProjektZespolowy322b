<?php



class Cart_Model extends CI_Model
{


	public function AddNewItemToCart($ID, $Count)
	{

	if(setcookie("product_cart[$ID]", $Count))
		return 1;

	return 0;

	}

	public function ReturnProductCount($ID)
	{
		if(is_numeric($ID))
		{

			if(isset($_COOKIE["product_cart"]))
			{

    			foreach ($_COOKIE['product_cart'] as $name => $value) 
    			{

        		$name = htmlspecialchars($name);
        		$value = htmlspecialchars($value);
        		if($name == $ID)
        			return $value;

    			}

			}
			return 0;

		}
		return 0;

	}

	public function RemoveItem($ID)
	{
		if(is_numeric($ID))
		{
			setcookie("product_cart[$ID]", "", time()-3600);
			return 1;
		}
		return 0;

	}

	public function ClearCart()
	{

			if(isset($_COOKIE["product_cart"]))
			{

    			foreach ($_COOKIE['product_cart'] as $name => $value) 
    			{

        		echo $this->RemoveItem($name);
        		
    			}

			}
	}


}

?>