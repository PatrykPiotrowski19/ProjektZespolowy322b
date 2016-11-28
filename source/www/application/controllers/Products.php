<?php


class Products extends CI_Controller
{


	public function index()
	{
		$this->load->view('header');
		$this->load->model("SessionManager_Model");
		$this->load->model("MainPage_Model");
		$this->load->model("Products_Model");


		if(isset($_GET["AddNewProduct"]))
		{
			$this->add_new();
		}

		//Wyswietlanie produktów
		if(isset($_GET["ShowProduct"]))
		{
			if(is_numeric($_GET["ShowProduct"]))
			{

				$this->show_item($_GET["ShowProduct"]);

			}
			else
			{
				$arg["info"] = "Produkt o podanym ID nie istnieje";
				$this->load->view("forms_err2",$arg);
			}
		}

		//Wyswietlanie kategorii
		if(isset($_GET["ShowCategory"]))
		{
			$this->show_category($_GET["ShowCategory"]);

		}

		if(isset($_GET["Subcategory"]))
		{

			$this->show_subcategory_products($_GET["Subcategory"]);

		}


	}


	private function show_item($ID)
	{

		$result = $this->Products_Model->DisplayProductInfo($ID);

		if(is_numeric($result))
		{
				$arg["info"] = "Produkt o podanym ID nie istnieje";
				$this->load->view("forms_err2",$arg);
				return;
		}

		$arg["ID"] = $result->ID;
		$arg["nazwa"] = $result->nazwa_produktu;
		$arg["cena"] = $result->cena_produktu;
		$arg["ilosc"] = $result->ilosc;
		$arg["opis"] = $result->opis;

		$this->load->view("product_info",$arg);

	}

	private function show_category($Category_ID)
	{

		if($this->Products_Model->CategoryExist($Category_ID))
		{
			
			$result = $this->Products_Model->GetSubcategoryList($Category_ID);

			$category_name['name'] = $this->Products_Model->GetCategoryNameByID($Category_ID);
			$this->load->view('content/category_name',$category_name);

			$data['name'] = $result;
			$this->load->view('content/category_list',$data);
		}
		else
		{
			$arg['info'] = 'Kategoria nie istnieje';
			$this->load->view('forms_err2',$arg);
		}

	}

	private function show_subcategory_products($Category_ID)
	{
		if($this->Products_Model->SubcategoryExist($Category_ID))
		{



			$result = $this->Products_Model->ShowProductList($Category_ID, 25);

			if(is_numeric($result))
			{

				$arg['info'] = 'Brak produktów w tej podkategorii';
				$this->load->view('forms_err2',$arg);

			}
			else
			{
				$data['data'] = $result;
				$this->load->view("content/show_products",$data);

			}

		}
		else
		{
			$arg['info'] = 'Podkategoria nie istnieje';
			$this->load->view('forms_err2',$arg);
		}

	}


	private function add_new()
	{
		$tag['custom_tag'] = "<br><br><br>";
		$this->load->view("custom_tag",$tag);
		
		//Jezeli uzytkownik ma uprawnienia
		if($this->SessionManager_Model->IsAdmin())
		{

			$this->load->view("forms/add_product");

		}
		else
		{

			$arg["info"] = "Nie posiadasz uprawnień do tej strony";
			$this->load->view("forms_err2",$arg);

		}

	}



}




?>