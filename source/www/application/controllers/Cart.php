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


	public function Checkout()
	{
		$this->load->view('header');
		$this->load->model("SessionManager_Model");
		$this->load->model("MainPage_Model");
		$this->load->model("Products_Model");
		$this->load->model("Cart_Model");
		$this->CheckoutDisplayInfo();

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

		if(isset($_GET["clear_cart"]))
		{
			$this->load->model("Cart_Model");
			$this->Cart_Model->ClearCart();
			header('Location: /index.php/Cart');
		}
		if(isset($_GET["complete"]))
		{
			$this->load->model("Cart_Model");
			$this->Cart_Model->ClearCart();
			header('Location: /index.php/Cart?transaction_complete');
			
		}
		if(isset($_GET["transaction_complete"]))
		{
			$this->load->view("content/checkout_success");
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



	private function CheckoutDisplayInfo()
	{

		if(isset($_COOKIE["product_cart"]))
		{

			//Czy uzytkownik jest zalogowany
			if($this->SessionManager_Model->IsLogged())
			{

				if(isset($_POST["finalbuy"]))
				{

					if($this->FinalizeTransaction())
						{
							header('Location: /index.php/Cart?complete');
							return 1;
						}

				}

			foreach($_COOKIE['product_cart'] as $name=> $value)
			{

				$ID = addslashes(htmlspecialchars($name));
				$value = addslashes(htmlspecialchars($value));

				$image_url = $this->Products_Model->GetMainProductImage($ID);
				$product_info = $this->Products_Model->DisplayProductInfo($ID);


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

			$arguments['delivery_option'] = $this->Products_Model->GetDeliveryOptions();

			$this->load->view("content/checkout",$arguments);




			}
			else
			{
			$arguments["info"] = "Musisz być zalogowany w celu finalizacji zamówienia";
			$this->load->view("forms_err",$arguments);
			}
		}
		else
		{
			$arguments["info"] = "Koszyk jest pusty";
			$this->load->view("forms_info",$arguments);
		}

	}


	private function FinalizeTransaction()
	{
		$payment = $this->Products_Model->GetDeliveryOption($_POST["opcjaprzesylki"]);
		$errors = 0;
		if($payment->opcja != 0)
		{

			foreach($_COOKIE['product_cart'] as $name=> $value)
			{

				$ID = addslashes(htmlspecialchars($name));
				$value = addslashes(htmlspecialchars($value));

				if($value > $this->Products_Model->CountProductItems($ID))
				{
					$product_inf = $this->Products_Model->DisplayProductInfo($ID);

					$arguments["info"] = "Błąd produktu: ".$product_inf->nazwa_produktu." - nie mamy takiej ilości w magazynie.";
					$this->load->view("forms_err",$arguments);							
					$errors++;
				}
			}			


				//Etap dodawania produktu
				if($errors == 0)
				{
					$this->load->model("Transaction_Model");

					$date = new DateTime();

					$Payment_ID =  $this->Transaction_Model->AddNewPayment($this->SessionManager_Model->GetUserID(), 
						$date->getTimestamp(),
						$_POST["opcjaprzesylki"]
						);

					$k = 0;

					foreach($_COOKIE['product_cart'] as $name=> $value)
					{

						$ID = addslashes(htmlspecialchars($name));
						$value = addslashes(htmlspecialchars($value));

						$product_inf = $this->Products_Model->DisplayProductInfo($ID);
						
						$this->Transaction_Model->InsertNewProductInPayment(
						$Payment_ID,
						$product_inf->nazwa_produktu,
						$product_inf->cena_produktu,
						$value
						);

						$tokens[$k++] =$this->Transaction_Model->CreateNewPendingComments($ID, $this->SessionManager_Model->GetUserID());


						$this->Products_Model->RemoveItemsInProduct($product_inf->ID, $value);

					}

					$this->load->model("UserManagement_Model");

					$this->Transaction_Model->SendTransactionMail(
					$this->UserManagement_Model->GetMailAddressFromUserID($this->SessionManager_Model->GetUserID()),
					$Payment_ID, $tokens);


					return 1;
				}

			return 0;
		}
		else
		{

			$arguments["info"] = "Niepoprawna opcja przesyłki";
			$this->load->view("forms_err",$arguments);		
			return 0;	

		}

		return 0;

	}


	public function test()
	{

		$this->load->model("Transaction_Model");
		$this->Transaction_Model->SendTransactionMail("Mail@wp.pl",39);
	}


}



?>