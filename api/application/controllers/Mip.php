<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mip extends CI_Controller {

	/*переменная для вывода в view*/
	public $data;

	public function __construct()
	{
		parent::__construct();
		$this->load->model('mpi_model');

		/*Закгружаем хелперы*/
		$this->load->helper('form');
		$this->load->helper('url');

	}


	/*Главная страница выводит какуюто хрень*/
	public function index()
	{

		$this->data['res']=$this->mpi_model->get('КАЗАНЦЕВ','ВЯЧЕСЛАВ','ПЕТРОВИЧ','1973-03-21');
		//$this->data['res']=$this->master_index->container(1);

		$this->load->view('head');
		$this->load->view('showtable',$this->data);

		$this->load->view('footer');
	}



}
