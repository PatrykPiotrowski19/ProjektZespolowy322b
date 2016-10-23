<?php

class SendMailTest extends CI_Controller{


public function index(){
	$this->load->library('email');

	$this->email->from('noreply@sklepinternetowy.pl', 'Sklep internetowy');
	$this->email->to('patryk.piotrowski19@gmail.com');

	$this->email->subject('Witam');
	$this->email->message('Testing the email class.');

	$this->email->send();

	echo "wyslano";
}	


}


?>