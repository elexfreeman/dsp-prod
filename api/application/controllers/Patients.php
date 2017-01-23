<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Patients extends CI_Controller {

	/*переменная для вывода в view*/
	public $data;

	public function __construct()
	{
		parent::__construct();
		/*Загружаем  библиотеку сессий*/
		$this->load->library('session');
		/*Загружаем модели*/
		$this->load->model('auth_model');


		$this->load->model('patient_model');
		$this->load->model('aktpak_lpu_model');

		/*Закгружаем хелперы*/
		$this->load->helper('form');
		$this->load->helper('url');

	}

	/*Загрузка из Cache*/
	public function LoadFromCache($tablename)
	{
		echo $tablename;
	}

	/*Загрузка из SQL*/
	public function load()
	{

		$this->load->view('head');
		echo "<pre>";
		$this->patient_model->LoadPatients();
		echo "</pre>";
		$this->load->view('footer');
	}




	/*Выводит данные об пациенте*/
	public function index()
	{
		if( $this->auth_model->IsLogin())
		{
			$this->data['auth']=$this->session->userdata('auth');
			$this->data['desctop_link']=site_url();
			//$this->data['lpu_list']=$this->aktpak_lpu_model->get_all();
//


			$this->load->view('nf_head',$this->data);
			$this->load->view('navbar/nf_admin_topnav',$this->data);
			/*шаблон страницы*/
			$this->data['search_form'] = $this->load->view('patients/search_form',$this->data, TRUE);

			$this->load->view('patients/index',$this->data);

			$this->load->view('navbar/nf_admin',$this->data);

			$this->load->view('nf_footer',$this->data);
		}
		else
		{
			header('Location: '.base_url('auth'));
			exit;
		}


	}

	public function get_by_mip($mip)
	{
		print_r($this->patient_model->get_next_by_mip($mip));
	}

	/*Загрузка инфы по вакцинации*/
	public function load_vaccination()
	{
		$this->load->view('head');
		$this->patient_model->load_vaccination();
		$this->load->view('footer');
	}



}
