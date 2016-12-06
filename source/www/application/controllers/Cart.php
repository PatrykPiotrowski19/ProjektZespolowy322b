<?php



class Cart extends CI_Controller
{


	public function index()
	{
		$this->load->view('header');
		$this->load->model("SessionManager_Model");
		$this->load->model("MainPage_Model");
		$this->load->model("Products_Model");

		$this->DisplayCart();

	}

	private function ChangeProductCount($Product_ID, $Count)
	{
		if(is_numeric($Product_ID) && is_numeric($Count) && $Count > 0)
		{
			if($this->Products_Model->CountProductItems($Product_ID) >= $Count)
			{
				$this->load->model("Cart_Model");
				$this->Cart_Model->AddNewItemToCart($Product_ID, $Count);
				return 1;
			}
			return 0;
		}
		return 0;

	}

	private function DisplayCart()
	{

		if(isset($_GET["remove"]))
		{
			$this->load->model("Cart_Model");
			$this->Cart_Model->RemoveItem($_GET["remove"]);

			header('Location: /index.php/Cart');
		}

		if(isset($_GET["ZmienIlosc"]))
		{
			if($this->ChangeProductCount($_GET["product_id"],$_GET["Value"]))
				header('Location: /index.php/Cart');
			else
				$arguments['Change_number_error'] = true;
		}



		if(isset($_COOKIE["product_cart"]))
		{


			foreach($_COOKIE['product_cart'] as $name=> $value)
			{

				$ID = addslashes(htmlspecialchars($name));
				$value = addslashes(htmlspecialchars($value));

				$image_url = $this->Products_Model->GetMainProductImage($ID);
				$product_info = $this->Products_Model->DisplayProductInfo($ID);

				//echo $image_url." ".$product_info->nazwa_produktu." ".$product_info->cena_produktu." ".$value." ".$product_info->cena_produktu*$value."<br>";
				$img_url[] = $image_url;
				$product_name[] = $product_info->nazwa_produktu;
				$product_cost[] = $product_info->cena_produktu;
				$product_id[] = $product_info->ID;
 				$product_count[] = $value;

			}

			$arguments['img_url'] = $img_url;
			$arguments['product_name'] = $product_name;
			$arguments['product_cost'] = $product_cost;
			$arguments['product_count'] = $product_count;
			$arguments['product_id'] = $product_id;


			$this->load->view("content/cart_info",$arguments);

		}
		else
		{
			$arguments["info"] = "Koszyk jest pusty";
			$this->load->view("forms_info",$arguments);
		}

	}

}



?>