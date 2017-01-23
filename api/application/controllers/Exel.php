<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*контроллер главной страницы*/

class Exel extends CI_Controller
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

            $this->data['patients'] = $this->patient_model->SearchExel($arg,false);

            $this->load->view('exel', $this->data);





        } else {
            header('Location: ' . base_url('auth'));
            exit;
        }
    }

}
