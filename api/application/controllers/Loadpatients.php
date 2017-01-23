<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*контроллер главной страницы*/
class Loadpatients extends CI_Controller {

    /*тут хранятся настройки, закгружаются в конструкторе*/
    public $settings;
    public $data;

    public function __construct()
    {
        parent::__construct();

        parent::__construct();
        /*Загружаем  библиотеку сессий*/
        $this->load->library('session');


        /*Загружаем модели*/


        /*Закгружаем хелперы*/
        $this->load->helper('form');
        $this->load->helper('url');

        $this->load->model('auth_model');
        $this->load->model('ipre_model');
    }

	public function index()
	{
        echo "<pre>";
        $this->ipre_model->LoadPatients();
        $this->ipre_model->UpdateProtocolDate();
        echo "</pre>";
	}

    public function update_develop_data()
    {
        $this->ipre_model->UpdateDevelopDate();

    }

    public function test()
    {
        $arg['NAME']='Александр';
        $arg['SECNAME']='Андреевич';
        $arg['SURNAME']='Полозов';
        $arg['BIRTHDAY']='04.09.1984';
        print_r($this->ipre_model->tfoms_search($arg));
    }

    public function reset_tfoms()
    {
        $this->ipre_model->ResetTfoms();
    }

    public function ResetTfomsBySNILS()
    {
        $this->ipre_model->ResetTfomsBySNILS();
    }

    public function LoadPatients2()
    {
        $this->ipre_model->LoadPatients2();
    }


    public function ReloadPatients()
    {
        $patient=$this->patient_model->Info2(13595);
        print_r($patient);
    }
}
