<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*контроллер главной страницы*/
class Adminpanel extends CI_Controller {

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
        $this->load->model('patient_model');
    }

	public function index()
	{
        /*переменные для языков описанны тут: \application\language\*/

        $this->data['patients_link']=site_url('patients');
        $this->data['lpu_link']=site_url('lpu');
        $this->data['page']='main';


        if( $this->auth_model->IsLogin())
        {
            $this->data['auth']=$this->session->userdata('auth');

            $this->data['users'] = $this->auth_model->GetAllUsers();


            $this->load->view('nf_head',$this->data);
            $this->load->view('navbar/nf_admin_topnav',$this->data);

            /*Загруаем пациентов под ЛПУ*/
            if($this->session->userdata('auth')->login=='admin')
            {
                $this->data['patients'] = $this->patient_model->GetAll();
            }
            else
            {
                $this->data['patients'] = $this->patient_model->GetByLPU($this->session->userdata('auth')->login);
            }

            /*шаблон страницы*/
            $this->load->view('adminpanel/index',$this->data);
            $this->load->view('navbar/nf_admin',$this->data);
            $this->load->view('nf_footer',$this->data);
            $this->load->view('adminpanel/js',$this->data);
        }
        else
        {
            header('Location: '.base_url('auth'));
            exit;
        }

	}

    public function GetStat()
    {
        if( $this->auth_model->IsLogin()) {
            echo json_encode($this->patient_model->get_stat());
        }
        else
        {
            header('Location: '.base_url('auth'));
            exit;
        }
    }
}
