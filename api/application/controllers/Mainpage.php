<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/*  =========================================================
*
*                       _oo0oo_
*                      o8888888o
*                      88" . "88
*                      (| -_- |)
*                      0\  =  /0
*                    ___/`---'\___
 *                  .' \|     |// '.
 *                 / \|||  :  |||// \
 *                / _||||| -:- |||||- \
 *               |   | \\  -  /// |   |
 *               | \_|  ''\---/''  |_/ |
 *               \  .-\__  '-'  ___/-. /
 *             ___'. .'  /--.--\  `. .'___
 *          ."" '<  `.___\_<|>_/___.' >' "".
 *         | | :  `- \`.;`\ _ /`;.`/ - ` : | |
 *         \  \ `_.   \_ __\ /__ _/   .-` /  /
 *     =====`-.____`.___ \_____/___.-`___.-'=====
 *                       `=---='
*
 *     ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
 *
 *               Buddha Bless:  "No Bugs"
*
 * ========================================================= */

/*контроллер главной страницы*/
class Mainpage extends CI_Controller {

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

    }

	public function index()
	{
        /*переменные для языков описанны тут: \application\language\*/

        $this->data['patients_link']=site_url('patients');
        $this->data['lpu_link']=site_url('lpu');
        $this->data['page']='main';


        if( $this->auth_model->IsLogin())
        {
            if(isset($_POST['patient_id']))
            {
                $this->patient_model->UpdateFDate($_POST['patient_id'],$_POST['f_date']);

                header('Location: '.base_url());
                exit;
            }
            else
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
                $this->load->view('main',$this->data);
                $this->load->view('navbar/nf_admin',$this->data);
                $this->load->view('nf_footer',$this->data);
            }

        }
        else
        {
            header('Location: '.base_url('auth'));
            exit;
        }

	}
}
