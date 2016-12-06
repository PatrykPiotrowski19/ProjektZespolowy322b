<?php



class UnitTest extends CI_Controller{

	public function __construct()
	{
		parent::__construct();

	}


	public function UnitTest()
	{
		$this->load->library('unit_test');
		$this->unit->run(4+4,8,"Wynik sumowania");

		echo $this->unit->report();


	}

}

?>
