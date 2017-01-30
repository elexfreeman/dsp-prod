<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dsp_auth extends CI_Controller {


    public $data;

    public function __construct()
    {
        parent::__construct();

        $this->load->library('session');
        $this->load->library('functions');
        $this->load->library('form_validation');
        $this->load->model('auth_model');
        $this->load->helper('form');
        $this->load->helper('url');
    }


    public function index()
    {

    }

    /*проверка если юзер зареган*/
    public function isAuth() {
        if($this->auth_model->IsLogin())
            echo json_encode(['status'=>1]);
        else
            echo json_encode(['status'=>0]);
    }


    /*Событие входа пользователя*/
    public function login()
    {
        $auth=$this->auth_model->GetUserByNameAndPass($_POST['username'],$_POST['password']);

        if( $auth['username']==$_POST['username'])
        {
            $this->session->set_userdata('auth', $auth);
            echo json_encode(['status'=>1]);
        }
        else
            echo json_encode(['status'=>0]);
    }

    /*проверка на существование пользователя*/
    public function user_check($username)
    {
        /*ищем клиента по телефону*/
        $user=$this->auth_model->GetUserByName($username);
        /*если нету то и ошибки нету*/
        if($user['id']==0) return true;else return false;

    }

    /*добавлеие пользователя*/
    public function adduser()
    {
        $this->data['auth']=$this->session->userdata('auth');
        $this->data['page']='users';
        if(($this->auth_model->IsLogin())and($this->data['auth']->login=='admin'))
        {

            /*валидатор полей*/
            $this->form_validation->set_rules('login', 'Логин', 'required|callback_user_check');
            $this->form_validation->set_rules('password', 'Пароль', 'required');

            /*Собираем форму*/
            $this->data['login'] = form_input(array(
                'name' => 'login',
                'id' => 'login',
                'type' => 'text',
                'class'=>'form-control',
                'value' => $this->input->post('login'),
            ));

            if($this->input->post('password')=='') $pass=$this->functions->PassGen();else $pass=$this->input->post('password');
            $this->data['password'] = form_input(array(
                'name' => 'password',
                'id' => 'password',
                'type' => 'text',
                'class'=>'form-control',
                'value' => $pass,
            ));

            $this->data['users_roots'] = form_input(array(
                'name' => 'users_roots',
                'id' => 'users_roots',
                'type' => 'text',
                'class'=>'form-control',
                'value' => $this->input->post('users_roots'),
            ));

            if($this->form_validation->run() == FALSE)
            {
                $this->data['auth']=$this->session->userdata('auth');
                $this->load->view('nf_head',$this->data);
                $this->load->view('navbar/nf_admin_topnav',$this->data);
                /*шаблон страницы*/
                $this->load->view('auth/user_add_form',$this->data);
                $this->load->view('navbar/nf_admin',$this->data);
                $this->load->view('nf_footer',$this->data);

            }
            else
            {
                $this->auth_model->AddUserAlldata($_POST);
                header('Location: '.base_url('auth/users'));
                exit;
            }


        }
        else
        {
            header('Location: '.base_url('auth'));
            exit;
        }
    }

    public function users($user_id='')
    {
        $this->data['page']='users';
        if( $this->auth_model->IsLogin())
        {
            if($user_id=='')
            {
                $this->data['auth']=$this->session->userdata('auth');
                $this->load->view('nf_head',$this->data);
                $this->load->view('navbar/nf_admin_topnav',$this->data);

                /*Загруаем пациентов под ЛПУ*/
                if($this->session->userdata('auth')->login=='admin')
                {
                    $this->data['users'] = $this->auth_model->GetAllUsers();
                }
                else
                {
                    header('Location: '.base_url('auth'));
                    exit;
                }

                /*шаблон страницы*/
                $this->data['users']=$this->auth_model->GetAllUsers();
                $this->load->view('auth/users',$this->data);
                $this->load->view('navbar/nf_admin',$this->data);
                $this->load->view('nf_footer',$this->data);
            }
            else
            {
                if(!empty($_POST))
                {
                    $this->auth_model->UpdateUser($user_id,$_POST);
                    header('Location: '.base_url('auth/users'));
                    exit;
                }
                else
                {
                    $this->data['auth']=$this->session->userdata('auth');
                    $this->load->view('nf_head',$this->data);
                    $this->load->view('navbar/nf_admin_topnav',$this->data);
                    $this->data['user'] = $this->auth_model->GetUserByID($user_id);

                    /*Загруаем пациентов под ЛПУ*/
                    if($this->session->userdata('auth')->login=='admin')
                    {
                        $this->data['users'] = $this->auth_model->GetAllUsers();
                    }
                    else
                    {
                        header('Location: '.base_url('auth'));
                        exit;
                    }

                    /*шаблон страницы*/
                    $this->data['users']=$this->auth_model->GetAllUsers();
                    $this->load->view('user_edit_form',$this->data);
                    $this->load->view('navbar/nf_admin',$this->data);
                    $this->load->view('nf_footer',$this->data);
                }

            }
        }
        else
        {
            header('Location: '.base_url('auth'));
            exit;
        }
    }

    public function logout()
    {
        unset($_SESSION['auth']);
        echo json_encode(['status'=>1]);

    }

    public function GetUserSettings(){

        echo json_encode($this->auth_model->GetRegUserInfo());

    }

    public function SettingsSave(){
        if($this->auth_model->IsLogin()){
            $arg = [];
          //  $arg['tfoms_date_planning'] = $this->input->post('tfoms_date_planning');
            $arg['tfoms_password'] = $this->input->post('tfoms_password');
            $arg['tfoms_user_id'] = $this->input->post('tfoms_user_id');
            $arg['tfoms_username'] = $this->input->post('tfoms_username');

            $this->auth_model->UpdateUserTfoms($arg);
            echo json_encode(['status'=>1,'post'=>$_POST]);
        }

        else
        {
            echo json_encode(['status'=>0]);
        }

    }
}
