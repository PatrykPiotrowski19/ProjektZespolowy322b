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


		if(isset($_GET["AddNewProduct"]))
		{
				$this->insert_product();

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

		if(isset($_POST["AddToCart"]) && !empty($_POST["koszyk_ilosc"]))
		{

			if($_POST["AddToCart"] == "KUP!")
				$this->add_to_cart($_GET["ShowProduct"], $_POST["koszyk_ilosc"],1);
			else
				$this->add_to_cart($_GET["ShowProduct"], $_POST["koszyk_ilosc"],0);




		}

		if(is_numeric($result))
		{
				$arg["info"] = "Produkt o podanym ID nie istnieje";
				$this->load->view("forms_err2",$arg);
				return 0;
		}

		$this->load->model("Cart_Model");
		$this->load->model("Comments_Model");


		//Pobieranie komentarzy na temat produktów
		$result_comments = $this->Comments_Model->GetCommentsFromProduct($ID);

		if(!is_numeric($result_comments))
		{
			$arg["comments"] = $result_comments;

		}
		else
		{
			$arg["comments"] = null;
		}
		//KONIEC -> Pobieranie komentarzy na temat produktów

		$arg["insert_comments"] = false;
		
		//Sprawdza czy mozna dodac komentarze

		/* Dodawanie komentarzy na stronie produktu -> WYŁĄCZONE
		if($this->SessionManager_Model->IsLogged())
		{
			$User_ID = $this->SessionManager_Model->GetUserID();

			if($this->Comments_Model->CanInsertComment($result->nazwa_produktu, $User_ID))
			{

				if(isset($_POST["send_comment"]))
				{
					$jakosc_produktu = $_POST["val1"];
					$jakosc_obslugi = $_POST["val2"];
					$szybkosc_obslugi = $_POST["val3"];

					$kom = addslashes($_POST["description"]);

					if(strlen($kom) < 500 && strlen($kom) > 5)
					{
						if($this->Comments_Model->SetComment($result->ID,
							$result->nazwa_produktu,
							$User_ID, 
							$jakosc_produktu, 
							$jakosc_obslugi, 
							$szybkosc_obslugi,
							$kom
							))
							header('Location: /index.php/Products?ShowProduct='.$result->ID);


					}
					else
						$arg["invalid_comment"] = true;
				}

				$arg["insert_comments"] = true;
			}

		}
		*/
		//KONIEC -> Sprawdza czy mozna dodac komentarze


		//Przekazywanie zmiennych na temat produktu

		$arg["ID"] = $result->ID;
		$arg["nazwa"] = $result->nazwa_produktu;
		$arg["cena"] = $result->cena_produktu;
		$arg["ilosc"] = $result->ilosc;
		$arg["opis"] = $result->opis;
		$arg["count"] = $this->Cart_Model->ReturnProductCount($result->ID);



		$result2 = $this->Products_Model->GetImageUrl($arg["ID"]);
		$arg["img"] = $result2;

		//KONIEC -> Przekazywanie zmiennych na temat produktu

		$this->load->view("product_info",$arg);

		return 1;
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

					return 1;
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

				return 1;
			}

		}
		else
		{
			$arg['info'] = 'Podkategoria nie istnieje';
			$this->load->view('forms_err2',$arg);
		}

	}

	private function insert_product()
	{

		//Jezeli uzytkownik ma uprawnienia
		if($this->SessionManager_Model->IsAdmin())
		{
			$this->load->view("forms_err2",$arg);

			$errors = 0;

			if(isset($_POST["DodajPrzedmiot"]))
			{
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
				$arg['info'] = 'Nie dodałeś zdjęcia (przynajmniej jedno jest wymagane)';
				$this->load->view('forms_err',$arg);
				$errors++;				
			}

			echo $errors;
			//Jezeli wprowadzone dane są poprawne i spełniają wymogi
			if($errors == 0)
			{
				if(!$this->Products_Model->IsCategoryExist($_POST["Kategoria"]))
				{
					$arg['info'] = 'Wprowadzona kategoria nie istnieje';
					$this->load->view('forms_err',$arg);
					$arguments['Utworz_kategorie'] = 1;
					$errors++;
				}
				if(!$this->Products_Model->IsSubcategoryExist($_POST["Podkategoria"]))
				{
					$arg['info'] = 'Wprowadzona podkategoria nie istnieje';
					$this->load->view('forms_err',$arg);
					$arguments['Utworz_podkategorie'] = 1;		
					$errors++;
				}

			

			//Dodaję nowy produkt do bazy danych
		if($errors == 0 && $_POST["DodajPrzedmiot"] == "DodajPrzedmiot")
		{

				$this->Products_Model->InsertProductToDatabase(
			$_POST["Podkategoria"],
			$_POST["NazwaPrzedmiotu"],
			$_POST["Cena"],
			$_POST["Ilosc"],
			$_POST["Opis"],
			$_POST["Zdjecie1"],
			$_POST["Zdjecie2"],
			$_POST["Zdjecie3"],
			$_POST["Zdjecie4"]
			);

				header('Location: /index.php/Products?Success');
			}
		}
			}

			$arguments['Kategoria'] = $_POST["Kategoria"];
			$arguments['Podkategoria'] = $_POST["Podkategoria"];
			$arguments["NazwaPrzedmiotu"] = $_POST["NazwaPrzedmiotu"];
			$arguments["Ilosc"] = $_POST["Ilosc"];
			$arguments["Cena"] = $_POST["Cena"];
			$arguments["Zdj1"] =$_POST["Zdjecie1"];
			$arguments["Zdj2"] =$_POST["Zdjecie2"];
			$arguments["Zdj3"] =$_POST["Zdjecie3"];
			$arguments["Zdj4"] =$_POST["Zdjecie4"];
			$this->load->view("forms/add_product",$arguments);
		

		}
		else
		{

			$arg["info"] = "Nie posiadasz uprawnień do tej strony";
			$this->load->view("forms_err2",$arg);

		}

	}

	private function add_to_cart($item_ID, $count,$val)
	{
		if($this->Products_Model->CountProductItems($item_ID) >= $count)
		{

			$this->load->model("Cart_Model");
			$this->Cart_Model->AddNewItemToCart($item_ID, $count);

			if($val == 0)
				header('Location: /index.php/Products?ShowProduct='.$item_ID.'');
			else
				header('Location: /index.php/Cart');

		}
		else
		{
			$arguments["info"] = "Przykro nam, nie mamy takiej ilości przedmiotów w magazynie.";
			$this->load->view("forms_err2",$arguments);

		}

	}


	public function UnitTest()
	{
		$this->load->model("SessionManager_Model");
		$this->load->model("MainPage_Model");
		$this->load->model("Products_Model");


		$this->load->library('unit_test');
		
		echo $this->unit->run($this->show_item(1), 1,"Wyświetlanie przedmiotu, ktory isnieje w bazie danych");
		echo $this->unit->run($this->show_item(17), 1,"Wyświetlanie przedmiotu, ktory nie isnieje w bazie danych");
		echo $this->unit->run($this->show_category(1), 1,"Wyświetlanie kategorii, które istnieje w bazie danych");
		echo $this->unit->run($this->show_category(16), 1,"Wyświetlanie kategorii, które nie istnieje w bazie danych");
		echo $this->unit->run($this->show_subcategory_products(1), 1,"Wyświetlanie podkategorii, które nie istnieje w bazie danych");
		echo $this->unit->run($this->show_subcategory_products(595), 1,"Wyświetlanie podkategorii, które nie istnieje w bazie danych");

	}


}




?>