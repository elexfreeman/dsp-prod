<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Eln extends CI_Controller {

	/*переменная для вывода в view*/
	public $data;

	public function __construct()
	{
		parent::__construct();
		/*Загружаем  библиотеку сессий*/
		$this->load->library('session');

		$this->load->library('icache');
		$this->icache->init('default');

		/*Загружаем модели*/


		/*Закгружаем хелперы*/
		$this->load->helper('form');
		$this->load->helper('url');

	}

	public function index()
	{

		$this->load->view('head');
		$obj=array();
		$DRCODE='1212';

		$obj[$DRCODE]['SHORT_NAME'] = "Anton Ivanovich Pomidorov";
		$obj[$DRCODE]['NAME'] = "Anton";
		$obj[$DRCODE]['SURNAME'] = "Pomidorov";
		$obj[$DRCODE]['SECNAME'] = "Ivanovich";
		$obj[$DRCODE]['DBSOURCE'] = '123';
		$obj[$DRCODE]['PENSION'] = "eertg";
		$obj[$DRCODE]['LPUWORK']['CODE'] = '3304';
		$obj[$DRCODE]['LPUWORK']['CAPTION'] = 'Наше супер ЛПУ';

		$obj[$DRCODE]['CODEFRMP'] = 'true';
		$this->data['obj1']=$obj;  // Object instances will always be lower case
		$this->data['obj']=$this->icache->update('VACDOCTORS',$obj);  // Object instances will always be lower case
		$this->load->view('eln_main',$this->data);

		$this->load->view('footer');
	}



}
