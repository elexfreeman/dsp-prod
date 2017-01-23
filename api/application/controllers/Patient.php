<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*контроллер главной страницы*/
class Patient extends CI_Controller {

    /*тут хранятся настройки, закгружаются в конструкторе*/
    public $settings;
    public $data;

    public function __construct()
    {
        parent::__construct();

        parent::__construct();
        /*Загружаем  библиотеку сессий*/
        $this->load->library('session');
        $this->load->library('form_validation');

        /*Загружаем модели*/


        /*Закгружаем хелперы*/
        $this->load->helper('form');
        $this->load->helper('url');

        $this->load->model('auth_model');
        $this->load->model('ipre_model');
        $this->load->model('patient_model');
        $this->load->model('pg_model');
    }

	public function index()
	{

            header('Location: '.base_url('auth'));


	}

    public function show($patient_id)
    {
        $this->form_validation->set_rules('description', 'Описание', 'required');

        $this->data['page']='main';
        $this->data['patient_id'] = $patient_id;

        if( $this->auth_model->IsLogin())
        {
            if ($this->form_validation->run() == FALSE)
            {
                $this->data['auth']=$this->session->userdata('auth');
                $this->data['main_page_link'] = site_url();

                $this->load->view('nf_head',$this->data);
                $this->load->view('navbar/nf_admin_topnav',$this->data);
                $this->data['user']=$this->session->userdata('auth')->login;
                /*Загруаем пациентов под ЛПУ*/
                $this->data['patient'] = $this->patient_model->Info($patient_id);
                $this->data['patient']['files']=$this->patient_model->GetPatientFiles($patient_id);
                $this->data['prg_rhb'] = $this->patient_model->Get_prg_rhb($this->data['patient']['pg_id']);
                if(isset($this->data['patient']['xml_file']))
                {
                    $xmlstring = file_get_contents($this->ipre_model->XMLPatientsPath.'\\'. $this->data['patient']['xml_file']);

                    $xmlstring = str_replace("ct:", "", $xmlstring);
                    $this->data['xml'] = new SimpleXMLElement($xmlstring);
                    $this->data['RequiredHelp'] = array();
                }



                /*шаблон страницы*/
                $this->load->view('patients/patient',$this->data);
                $this->load->view('navbar/nf_admin',$this->data);
                $this->load->view('nf_footer',$this->data);
            }
            else
            {
                $this->patient_model->addFiles($patient_id);
               /* header('Location: '.base_url());
                exit;*/
            }

        }
        else
        {
            header('Location: '.base_url('auth'));
            exit;
        }
    }

    public function show_xml($patient_id)
    {
        $this->data['page']='main';
        $this->data['patient_id'] = $patient_id;
        if( $this->auth_model->IsLogin())
        {
            $this->data['auth']=$this->session->userdata('auth');
            $this->data['main_page_link'] = site_url();


            $this->load->view('nf_head',$this->data);

            $this->data['user']=$this->session->userdata('auth')->login;
            /*Загруаем пациентов под ЛПУ*/
            $this->data['patient'] = $this->patient_model->Info($patient_id);


            $xmlstring = file_get_contents($this->ipre_model->XMLPatientsPath.'\\'. $this->data['patient']['xml_file']);

            $xmlstring = str_replace("ct:", "", $xmlstring);
            $this->data['xml'] = new SimpleXMLElement($xmlstring);

            echo "<pre>";
            print_r($this->data['xml']);
            echo "</pre>";

        }
        else
        {
            header('Location: '.base_url('auth'));
            exit;
        }
    }

    public function xml($patient_id)
    {
        $this->data['page']='main';
        if( $this->auth_model->IsLogin())
        {

            /*Загруаем пациентов под ЛПУ*/
            $this->data['patient'] = $this->patient_model->Info($patient_id);
            $this->data['patient_id'] = $patient_id;
            header("Content-Type: text/xml");
            header("Expires: Thu, 19 Feb 1998 13:24:18 GMT");
            header("Last-Modified: ".gmdate("D, d M Y H:i:s")." GMT");
            header("Cache-Control: no-cache, must-revalidate");
            header("Cache-Control: post-check=0,pre-check=0");
            header("Cache-Control: max-age=0");
            header("Pragma: no-cache");
            $xmlstring = file_get_contents($this->ipre_model->XMLPatientsPath.'\\'. $this->data['patient']['xml_file']);

            //$xmlstring = str_replace("ct:", "", $xmlstring);
            //$this->data['xml'] = new SimpleXMLElement($xmlstring);
            echo $xmlstring;
        }
        else
        {
            header('Location: '.base_url('auth'));
            exit;
        }
    }

    public function word($patient_id)
    {
        $this->data['page']='main';
        if( $this->auth_model->IsLogin())
        {

            /*Загруаем пациентов под ЛПУ*/
            $this->data['patient'] = $this->patient_model->Info($patient_id);
            $this->data['patient_id'] = $patient_id;
            $xmlstring = file_get_contents($this->ipre_model->XMLPatientsPath.'\\'. $this->data['patient']['xml_file']);

            $xmlstring = str_replace("ct:", "", $xmlstring);
            $this->data['xml'] = new SimpleXMLElement($xmlstring);

            /*Протезирование и ортезирование*/
            $this->data['EventGroups'][36] = $this->patient_model->GetEventGroup($this->data['xml'],36);

            /*Медицинская реабилитация*/
            $this->data['EventGroups'][34] = $this->patient_model->GetEventGroup($this->data['xml'],34);

            /*Санаторно-курортное лечение*/
            $this->data['EventGroups'][37] = $this->patient_model->GetEventGroup($this->data['xml'],37);


            /*??? Реконструктивная хирургия*/
            $this->data['EventGroups'][35] = $this->patient_model->GetEventGroup($this->data['xml'],35);

            $this->data['BirthDate'] =  $this->patient_model->GetDate($this->data['xml']->Person->BirthDate);


            //$PeriodTo = strtotime( $this->data['EventGroups'][34] );

            if((isset($this->data['EventGroups'][34]))and($this->data['EventGroups'][34]!=''))
            $this->data['PeriodTo_d']  =$this->patient_model->GetDate( $this->data['EventGroups'][34]);
            else  $this->data['PeriodTo_d']='';


            $this->data['HelpItems']  =$this->patient_model->ConvertHelpItems( $this->data['xml']->RequiredHelp->HelpItems->HelpItem);



            /*  header("Content-Type: text/xml");
              header("Expires: Thu, 19 Feb 1998 13:24:18 GMT");
              header("Last-Modified: ".gmdate("D, d M Y H:i:s")." GMT");
              header("Cache-Control: no-cache, must-revalidate");
              header("Cache-Control: post-check=0,pre-check=0");
              header("Cache-Control: max-age=0");
              header("Pragma: no-cache");*/
            $this->load->view('patients/word',$this->data);
        }
        else
        {
            header('Location: '.base_url('auth'));
            exit;
        }
    }

    public function edit($patient_id)
    {
        $this->data['page']='main';
        $this->data['patient_id'] = $patient_id;
        $this->data['users'] = $this->auth_model->GetAllUsers();

        if( $this->auth_model->IsLogin())
        {
            $this->data['auth']=$this->session->userdata('auth');
            $this->data['main_page_link'] = site_url();


            if(isset($_POST['lpu']))
            {
                $this->patient_model->UpdateLpu($patient_id,$_POST['lpu']);
                header('Location: '.base_url('auth'));
                exit;
            }
            else
            {
                $this->load->view('nf_head',$this->data);
                $this->load->view('navbar/nf_admin_topnav',$this->data);
                $this->data['user']=$this->session->userdata('auth')->login;
                /*Загруаем пациентов под ЛПУ*/
                $this->data['patient'] = $this->patient_model->Info($patient_id);
                $this->data['xml'] = new SimpleXMLElement($this->data['patient']['xml']);
                $this->data['xml_orig']= $this->data['patient']['xml'];
                /*шаблон страницы*/
                $this->load->view('patients/edit',$this->data);
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

    public function m_add($patient_id)
    {
        $this->form_validation->set_rules('description', 'Описание', 'required');

        $this->data['page']='main';
        $this->data['patient_id'] = $patient_id;
        if( $this->auth_model->IsLogin())
        {
            if ($this->form_validation->run() == FALSE)
            {
                $this->data['auth']=$this->session->userdata('auth');
                $this->data['main_page_link'] = site_url();

                $this->load->view('nf_head',$this->data);
                $this->load->view('navbar/nf_admin_topnav',$this->data);
                $this->data['user']=$this->session->userdata('auth')->login;
                /*Загруаем пациентов под ЛПУ*/
                $this->data['patient'] = $this->patient_model->Info($patient_id);

                $this->data['rhb_type'] = $this->pg_model->Get_rhb_type();
                $this->data['rhb_evnt'] = $this->pg_model->Get_rhb_evnt(2);
                $this->data['rhb_res'] = $this->pg_model->Get_rhb_res();



                if(isset($this->data['patient']['xml_file']))
                {
                    $xmlstring = file_get_contents($this->ipre_model->XMLPatientsPath.'\\'. $this->data['patient']['xml_file']);

                    $xmlstring = str_replace("ct:", "", $xmlstring);
                    $this->data['xml'] = new SimpleXMLElement($xmlstring);
                    $this->data['RequiredHelp'] = array();
                }



                /*шаблон страницы*/
                $this->load->view('patients/m_add.php',$this->data);
                $this->load->view('navbar/nf_admin',$this->data);
                $this->data['js']=$this->load->view('patients/app_js',$this->data,true);
                $this->load->view('nf_footer',$this->data);
            }
            else
            {
                $this->patient_model->addFiles($patient_id);
                /* header('Location: '.base_url());
                 exit;*/
            }

        }
        else
        {
            header('Location: '.base_url('auth'));
            exit;
        }
    }

    /*форма добавления мероприятия*/
    public function Get_m_add_form($patient_id)
    {
        if( $this->auth_model->IsLogin())
        {
            $data = array();
            $data['patient'] = $this->patient_model->Info($patient_id);
            $data['rhb_type'] = $this->pg_model->Get_rhb_type();
            $data['rhb_evnt'] = $this->pg_model->Get_rhb_evnt(2);
            $data['rhb_res'] = $this->pg_model->Get_rhb_res();
            $data['user'] = $this->auth_model->GetUserByName($this->session->userdata('auth')->login);
            unset($data['user']['password']);

            echo json_encode($data);
        }
    }


    public function Get_rhb_evnt($rhb_type_id)
    {
        if( $this->auth_model->IsLogin())
        {
            $data = array();
            $data['rhb_evnt'] = $this->pg_model->Get_rhb_evnt($rhb_type_id);
            echo json_encode($data);

        }
    }

    public function m_save()
    {
        if( $this->auth_model->IsLogin())
        {
            /*сохраняем*/
            $data = array();
            $data['typeid'] = $this->input->post('typeid');
            $data['evntid'] = $this->input->post('evntid');
            $data['name'] = $this->input->post('name');
            if($this->input->post('prgid')!='')
            {
                $data['prgid'] = $this->input->post('prgid');
                if($this->input->post('dt_exc')!='')
                {
                    $data['dt_exc'] = $this->input->post('dt_exc') ;;
                }
                if($this->input->post('rhb_res')!='')
                {
                    if($this->input->post('rhb_res')==1) $data['resid']=1;
                    else
                        $data['resid'] = $this->input->post('rhb_res_no');

                }
                if($this->input->post('agree')=='true')
                    $data['publish'] = 1;
                $this->patient_model->insert_prg_rhb($data);
                echo json_encode(['status'=>1,'data'=>$data]);
            }
            else{
                echo json_encode(['status'=>0]);
            }


        }
    }


    public function m_edit($patient_id,$rhb_id)
    {


        $this->data['page']='main';
        $this->data['patient_id'] = $patient_id;
        $this->data['rhb_id'] = $rhb_id;
        if( $this->auth_model->IsLogin())
        {
            if ($this->form_validation->run() == FALSE)
            {
                $this->data['auth']=$this->session->userdata('auth');
                $this->data['main_page_link'] = site_url();

                $this->load->view('nf_head',$this->data);
                $this->load->view('navbar/nf_admin_topnav',$this->data);
                $this->data['user']=$this->session->userdata('auth')->login;
                /*Загруаем пациентов под ЛПУ*/
                $this->data['patient'] = $this->patient_model->Info($patient_id);




                if(isset($this->data['patient']['xml_file']))
                {
                    $xmlstring = file_get_contents($this->ipre_model->XMLPatientsPath.'\\'. $this->data['patient']['xml_file']);

                    $xmlstring = str_replace("ct:", "", $xmlstring);
                    $this->data['xml'] = new SimpleXMLElement($xmlstring);
                    $this->data['RequiredHelp'] = array();
                }



                /*шаблон страницы*/
                $this->load->view('patients/m_edit',$this->data);
                $this->load->view('navbar/nf_admin',$this->data);
                $this->data['js']=$this->load->view('patients/app_js',$this->data,true);
                $this->load->view('nf_footer',$this->data);
            }
            else
            {
                $this->patient_model->addFiles($patient_id);
                /* header('Location: '.base_url());
                 exit;*/
            }

        }
        else
        {
            header('Location: '.base_url('auth'));
            exit;
        }
    }


    /*для ерестар*/
    public function get_prg_rhb($patient_id,$rhb_id)
    {
        if( $this->auth_model->IsLogin()){
            $data['patient'] = $this->patient_model->Info($patient_id);
            $data['rhb_type'] = $this->pg_model->Get_rhb_type();
            $data['prg_rhb'] = $this->patient_model->Get_prg_rhb_for_edit($rhb_id);
            $data['rhb_evnt'] = $this->pg_model->Get_rhb_evnt($data['prg_rhb']['typeid']);
            $data['rhb_res'] = $this->pg_model->Get_rhb_res();
            $data['user'] = $this->auth_model->GetUserByName($this->session->userdata('auth')->login);

            unset($data['user']['password']);

            echo json_encode($data);
        }

    }

}
