<?php


class Products extends CI_Controller
{


	public function index()
	{
		$this->load->view('header');
		$this->load->model("SessionManager_Model");
		$this->load->model("MainPage_Model");
		$this->load->model("Products_Model");


		if(isset($_GET["Success"]))
		{
			$arg['info'] = 'Przedmiot został pomyślnie dodany';
			$this->load->view('forms_info',$arg);			
		}



		if(isset($_POST["DodajPrzedmiot"]))
		{
			$this->insert_product();
		}


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
				if($this->Products_Model->CategoryIsNotEmpty($Category_ID)){
				$result = $this->Products_Model->GetSubcategoryList($Category_ID);

				$category_name['name'] = $this->Products_Model->GetCategoryNameByID($Category_ID);
				$this->load->view('content/category_name',$category_name);

				$data['name'] = $result;
				$this->load->view('content/category_list',$data);
			}
			else
			{
				$arg['info'] = 'Brak podkategorii';
				$this->load->view('forms_err2',$arg);
			}
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

	private function insert_product()
	{

		//Jezeli uzytkownik ma uprawnienia
		if($this->SessionManager_Model->IsAdmin())
		{
			$this->load->view("forms_err2",$arg);

			$errors = 0;

			require_once("ValidateModule/ValidateModule.php");
			$validate_class = new AddProductValidate();
			$validate_class->AddVariables(
				$_POST["Kategoria"],
				$_POST["Podkategoria"],
				$_POST["NazwaPrzedmiotu"],
				$_POST["Ilosc"],
				$_POST["Cena"],
				$_POST["Opis"]
				);

			//Dodawanie nowych kategorii
			if($_POST["DodajPrzedmiot"] == "DodajPrzedmiot1")
			{
				$this->Products_Model->AddNewCategory($_POST["Kategoria"]);


			}

			//Dodawanie nowych podkategorii
			if($_POST["DodajPrzedmiot"] == "DodajPrzedmiot2")
			{
				$this->Products_Model->AddNewSubcategory($_POST["Podkategoria"],$_POST["Kategoria"]);

			}


			$result = $validate_class->GetResult();

			if(!$result[0])
			{
				$arg['info'] = 'Pole kategorii nie spełnia wymogów (długość 1-32 znaków)';
				$this->load->view('forms_err',$arg);
				$errors++;
			}

			if(!$result[1])
			{
				$arg['info'] = 'Pole podkategorii nie spełnia wymogów (długość 1-32 znaków)';
				$this->load->view('forms_err',$arg);
				$errors++;
			}

			if(!$result[2])
			{
				$arg['info'] = 'Pole nazwy przedmiotu nie spełnia wymogów (długość 1-64 znaków)';
				$this->load->view('forms_err',$arg);
				$errors++;
			}

			if(!$result[3])
			{
				$arg['info'] = 'Ilość przedmiotów musi być większa od 0';
				$this->load->view('forms_err',$arg);
				$errors++;
			}

			if(!$result[4])
			{
				$arg['info'] = 'Niepoprawnie wpisane pole cena';
				$this->load->view('forms_err',$arg);
				$errors++;
			}

			if(!$result[5])
			{
				$arg['info'] = 'Pole opisu nie spełnia wymogów (długość 1-4096 znaków)';
				$this->load->view('forms_err',$arg);
				$errors++;
			}
			if(empty($_POST["Zdjecie1"]))
			{
				//$arg['info'] = 'Nie dodałeś zdjęcia';
				//$this->load->view('forms_err',$arg);
				//$errors++;				
			}


			//Jezeli wprowadzone dane są poprawne i spełniają wymogi
			if($errors == 0)
			{
				if(!$this->Products_Model->IsCategoryExist($_POST["Kategoria"]))
				{
					$arg['info'] = 'Wprowadzona kategoria nie istnieje';
					$this->load->view('forms_err',$arg);
					$_POST["createcategory"] = 0;
					return;
				}
				if(!$this->Products_Model->IsSubcategoryExist($_POST["Podkategoria"]))
				{
					$arg['info'] = 'Wprowadzona podkategoria nie istnieje';
					$this->load->view('forms_err',$arg);
					$_POST["createsubcategory"] = 0;
					return;			
				}

			}

			//Dodaję nowy produkt do bazy danych

			$this->Products_Model->InsertProductToDatabase(
		$_POST["Podkategoria"],
		$_POST["NazwaPrzedmiotu"],
		$_POST["Cena"],
		$_POST["Ilosc"],
		$_POST["Opis"]
		);


		header('Location: /index.php//Products?Success');	


		}
		else
		{

			$arg["info"] = "Nie posiadasz uprawnień do tej strony";
			$this->load->view("forms_err2",$arg);

		}
	}



}




?>