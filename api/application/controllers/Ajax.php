<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*контроллер главной страницы*/

class Ajax extends CI_Controller
{

    /*тут хранятся настройки, закгружаются в конструкторе*/
    public $settings;
    public $data;

    public function __construct()
    {
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

        $this->data['patients_link'] = site_url('patients');
        $this->data['lpu_link'] = site_url('lpu');


        if ($this->auth_model->IsLogin()) {
            $this->data['auth'] = $this->session->userdata('auth');
            $this->load->view('nf_head', $this->data);
            $this->load->view('navbar/nf_admin_topnav', $this->data);
            /*шаблон страницы*/
            $this->load->view('main');

            $this->load->view('navbar/nf_admin', $this->data);

            $this->load->view('nf_footer', $this->data);
        } else {
            header('Location: ' . base_url('auth'));
            exit;
        }
    }

    public function search()
    {
        /*переменные для языков описанны тут: \application\language\*/


        if ($this->auth_model->IsLogin())
        {
            $this->data['auth']=$this->session->userdata('auth');
            $arg = array();
            $arg['search_string'] = '';
            $arg['dateload'] = '';
            
            /*какаято глупостть с присваиваением*/
            if (isset($_GET['search_string'])) $arg['search_string'] = $_GET['search_string'];
            if (isset($_GET['dateload1'])) $arg['dateload1'] = $_GET['dateload1'];

            if (isset($_GET['datel_1'])) $arg['datel_1'] = $_GET['datel_1'];
            if (isset($_GET['datel_2'])) $arg['datel_2'] = $_GET['datel_2'];

            $arg['user'] = $this->session->userdata('auth')->login;
            if($arg['user']=='admin')
            {
                if((isset($_GET['lpu']))and($_GET['lpu']!=''))
                {
                    $arg['lpu']=$_GET['lpu'];
                }
            }

            $this->data['patients'] = $this->patient_model->Search($arg);
            $this->load->view('searchRes', $this->data);


        } else {
            header('Location: ' . base_url('auth'));
            exit;
        }

    }

    public function search_new()
    {
        /*переменные для языков описанны тут: \application\language\*/


        if ($this->auth_model->IsLogin())
        {
            $this->data['auth']=$this->session->userdata('auth');
            $arg = array();
            $arg['search'] = '';
            $arg['dateload'] = '';

            /*какаято глупостть с присваиваением*/
            if (isset($_GET['search'])) $arg['search'] = $_GET['search'];
            if (isset($_GET['dateload1'])) $arg['dateload1'] = $_GET['dateload1'];
            if (isset($_GET['dateload2'])) $arg['dateload2'] = $_GET['dateload2'];

            if (isset($_GET['datel_1'])) $arg['datel_1'] = $_GET['datel_1'];
            if (isset($_GET['datel_2'])) $arg['datel_2'] = $_GET['datel_2'];

            $arg['user'] = $this->session->userdata('auth')->login;
            if($arg['user']=='admin')
            {
                if((isset($_GET['lpu']))and($_GET['lpu']!=''))
                {
                    $arg['lpu']=$_GET['lpu'];
                }
            }

            echo json_encode($this->data['patients'] = $this->patient_model->SearchNew($arg));



        } else {
            header('Location: ' . base_url('auth'));
            exit;
        }

    }

    public function PhpInfo1()
    {
        echo phpinfo();
    }
}
