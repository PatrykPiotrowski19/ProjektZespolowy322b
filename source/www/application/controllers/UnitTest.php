<?php



class UnitTest extends CI_Controller{

	public function __construct()
	{
		parent::__construct();

	}

	public function index()
	{


	}


	public function Cart()
	{
		echo "TESTY JEDNOSTKOWE -> KOSZYK";
		$this->load->library('unit_test');
		$this->load->model("Cart_Model");

		$this->unit->run($this->Cart_Model->AddNewItemToCart(1,1),1,"Dodanie do koszyka");
		$this->unit->run($this->Cart_Model->ReturnProductCount(1),0,"Zwraca ilosc przedmiotow dla danego produktu");
		$this->unit->run($this->Cart_Model->ReturnProductCount(888),0,"Zwraca ilosc przedmiotow dla nieistniejącego produktu");
		$this->unit->run($this->Cart_Model->RemoveItem(1),1,"Usuniecie produktu z koszyka");		
		echo $this->unit->report();
	}

	public function Transaction()
	{
		echo "TESTY JEDNOSTKOWE -> Transakcje";
		$this->load->library('unit_test');
		$this->load->model("Transaction_Model");
		$this->unit->run($this->Transaction_Model->GetDeliveryInfoByID(0),null,"Zwraca informacje o transakcji");
		$this->unit->run($this->Transaction_Model->GetTransactionInfoByID(0),null,"Zwraca informacje o transakcji");
		
		echo $this->unit->report();
	}

}

?>
