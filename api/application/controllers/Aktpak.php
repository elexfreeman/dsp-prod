<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Aktpak extends CI_Controller {

	/*переменная для вывода в view*/
	public $data;

	public function __construct()
	{
		parent::__construct();
		/*Загружаем  библиотеку сессий*/
		$this->load->library('session');
		/*Загружаем модели*/

		$this->load->model('aktpak_model');
		/*Закгружаем хелперы*/
		$this->load->helper('form');
		$this->load->helper('url');

	}

	public function LoadFromCache($tablename)
	{
		echo $tablename;
	}

	public function LoadFrom224($tablename)
	{
		$this->data['res']=$this->aktpak_model->GetTableSrv224($tablename);
		$this->load->view('head');
		$this->load->view('showtable',$this->data);

		$this->load->view('footer');
	}

	/*Главная страница выводит какуюто хрень*/
	public function index()
	{
		$this->data['res']=$this->aktpak_model->GetTableSrv224('AKPC_LPU');
		$this->load->view('head');
		$this->load->view('showtable',$this->data);

		$this->load->view('footer');
	}




	/*Загружает данные актпака*/
	/*Входящий параметр имя таблицы справочника*/
	/*todo сделать загрузку всех полей справочников скорее всего нужно грузить как есть все поля через цикл*/
	public function load($table)
	{
		/*Загружаем модели справочников*/
		$this->load->model('aktpak_doctors_model');
		$this->load->model('aktpak_lpu_model');
		/*выбор параметра загрузки*/
		/*c:\wamp64\bin\php\php5.6.16>php c:\wamp64\www\nrk\index.php aktpak load AKPC_DOCTORS*/
		if($table=='AKPC_DOCTORS') $this->aktpak_doctors_model->load_from_aktpak();
		if($table=='AKPC_LPU') $this->aktpak_lpu_model->load_from_aktpak();
	}

}
