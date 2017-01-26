<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dsp_patients extends CI_Controller {


    public $data;

    public $root = '/';

    public function __construct()
    {
        parent::__construct();

        $this->load->library('session');
        $this->load->library('functions');
        $this->load->library('form_validation');
        $this->load->library('tfoms');
        $this->load->model('auth_model');
        $this->load->model('patient_model');
        $this->load->helper('form');
        $this->load->helper('url');

        $this->data['root'] = $this->root;
    }




    public function index()
    {

    }



    /*выдат исходные настройки*/
    public function GetDashboard() {
        /*проверяем аториз*/
        $res = array();
        if($this->auth_model->IsLogin()) {
            $res['auth'] = 1;
        } else {
            $res['auth'] = 0;
        }

        echo json_encode($res);
    }

    /*формирует парамтры фильтра из post*/
    public function GetFilterParams($data,$patient){
        $arg=array();

        $user = $this->auth_model->UserInfo();

        if(isset($patient['sex'])) $arg['sex'] = $patient['sex'];
        if(isset($patient['surname'])) $arg['surname'] = $patient['surname'];
        if(isset($patient['name'])) $arg['name'] = $patient['name'];
        if(isset($patient['secname'])) $arg['secname'] = $patient['secname'];

        if(isset($patient['chk1'])) $arg['chk1'] = $patient['chk1'];
        if(isset($patient['chk2'])) $arg['chk2'] = $patient['chk2'];
        if(isset($patient['chk3'])) $arg['chk3'] = $patient['chk3'];
        if(isset($patient['chk4'])) $arg['chk4'] = $patient['chk4'];
        if(isset($patient['chk_red'])) $arg['chk_red'] = $patient['chk_red'];

        if(isset($patient['q'])) $arg['q'] = $patient['q'];

        if((isset($data['sort']))and($data['sort']!=''))
            $arg['sort'] = $data['sort'];
        else $arg['sort'] = 'surname';
        if(isset($data['order']))$arg['order'] = $data['order'];

        if(!isset($data['limit']))  $data['limit'] = 100;
        if(!isset($data['offset']))  $data['offset'] = 0;

        $arg['age_beg'] = 21;
        $arg['age_end'] = 99;
        if(isset($patient['age_beg'])) $arg['age_beg'] = $patient['age_beg'];
        if(isset($patient['age_end'])) $arg['age_end']= $patient['age_end'];


        $arg['month_beg'] = 1;
        $arg['month_end'] = 12;
        if((isset($patient['month_beg']))and((int)$patient['month_beg']>0)) $arg['month_beg'] = $patient['month_beg'];
        if((isset($patient['month_end']))and((int)$patient['month_end']>0)) $arg['month_end']= $patient['month_end'];



        if(isset($patient['uch'])) $arg['uch']= $patient['uch'];

        /*только 400 записей максимум*/
        if((int)$data['limit']>400) $data['limit'] = 400;
        if((int)$data['offset']<0) $data['offset'] = 0;

        $arg['DRCODE'] = $user['DRCODE'];

        return array('arg'=>$arg,'data'=>$data);
    }

    public function GetPatients() {
        $res = array();
        if($this->auth_model->IsLogin()) {
            $res['auth'] = 1;
            $res['user'] = $this->auth_model->UserInfo();

            $data = $this->input->post('data');
            $patient = $this->input->post('patient');

            if($data!='') {
                $d = $this->GetFilterParams($data,$patient);
                $data = $d['data'];
                $arg = $d['arg'];
                $arg['lpucode'] = $res['user']['lpucode'];
                $res['patients']['rows'] = $this->patient_model->GetPatients($arg,$data['limit'],$data['offset']);

                $res['patients']['total'] = $this->patient_model->GetPatientsTotal($arg);
            }

        } else {
            $res['auth'] = 0;
        }

        echo json_encode($res);
    }

    /*Побщее ко-во подлежащих дисп на лпу*/
    public function GetDspTotalByLPU() {
        $res = array();
        if($this->auth_model->IsLogin()) {
            $res['auth'] = 1;
            $res['user'] = $this->auth_model->UserInfo();

            $arg=array();

            $arg['lpucode'] = $res['user']['lpucode'];
            $arg['sort'] = 'surname';

            $arg['order'] = 'desc';
            $arg['age_beg'] = 21;
            $arg['age_end'] = 99;

            $arg['month_beg'] = 1;
            $arg['month_end'] = 12;

            $res['total'] = $this->patient_model->GetPatientsTotal($arg);

        } else {
            $res['auth'] = 0;
        }

        echo json_encode($res);
    }

    /*доктора*/
    public function GetRegLPUDoctors(){
        $res = array();
        if($this->auth_model->IsLogin()) {
            $res['auth'] = 1;
            $res['user'] = $this->auth_model->UserInfo();
            $res['doctors'] = $this->patient_model->GetLPUDoctors($res['user']['lpucode']);

        } else {
            $res['auth'] = 0;
        }
        echo json_encode($res);
    }

    /*доктора*/
    public function GetRegLPUuch(){
        $res = array();
        if($this->auth_model->IsLogin()) {
            $res['auth'] = 1;
            $res['user'] = $this->auth_model->UserInfo();
            $DRCODE = '';
            if((isset($res['user']['DRCODE']))and($res['user']['DRCODE']!='')) $DRCODE = $res['user']['DRCODE'];
            $res['uch'] = $this->patient_model->GetLPUuch($res['user']['lpucode'] ,$DRCODE);

        } else {
            $res['auth'] = 0;
        }
        echo json_encode($res);
    }

    /*План дисп на год по зареганому лу*/
    public function GetDspPlanForYear($year){
        $res = array();
        if($this->auth_model->IsLogin()) {
            $res['auth'] = 1;
            $res['user'] = $this->auth_model->UserInfo();
            $res['DspPlanForYear'] = $this->patient_model->GetDspPlanForYear($res['user']['lpucode'],$year);

        } else {
            $res['auth'] = 0;
        }
        echo json_encode($res);
    }

    /*выдает пациента по его енп привзанного к зареганному юзеру*/
    public function get_patient($enp)
    {
        $res = array();
        if ($this->auth_model->IsLogin()) {
            $res['auth'] = 1;
            $res['user'] = $this->auth_model->UserInfo();
            $res['patient'] = $this->patient_model->GetPatientByEnp($enp);
            $res['test'] = date('Y-m-d',strtotime($res['patient']['BIRTHDAY']));

        } else {
            $res['auth'] = 0;
        }
        echo json_encode($res);
    }

    /*вставляет статус пациетна о дисп*/
    public function setstatus(){
        $res = array();
        if ($this->auth_model->IsLogin()) {
            $res['auth'] = 1;
            $res['user'] = $this->auth_model->UserInfo();
            $arg = array();
            $arg['enp'] = $this->input->post('patient_enp');
            $arg['status'] = $this->input->post('status');
            $arg['disp_year'] = $this->input->post('disp_year');
            $arg['disp_quarter'] = $this->input->post('disp_quarter');
            $arg['disp_type'] = 1;
            $arg['disp_lpu'] = $res['user']['lpucode'];
            $arg['age'] = 1;
            $arg['lgg_code'] = 1;
            $arg['drcode'] = 1;
            $arg['refusal_reason'] = 1;
            $arg['disp_start'] = '';
            $arg['stage_1_result'] = '';
            $arg['stage_2_result'] = '';
            $arg['guid'] = '';
            $arg['speccode'] = '';

            $this->patient_model->InsertPatientStatus($arg);


        } else {
            $res['auth'] = 0;
        }
        echo json_encode($res);
    }


    public function GetCountPatientsInPlan() {
        $res = array();
        if ($this->auth_model->IsLogin()) {
            if($this->input->post('year')=='') $year = 2017;
            $res['auth'] = 1;
            $res['user'] = $this->auth_model->UserInfo();

            $res['plan'] = $this->patient_model->GetCountPatientsInPlan($res['user'],$this->input->post('disp_year'));
            $res['DspPlanForYear'] = $this->patient_model->GetDspPlanForYear($res['user']['lpucode'],$year);

            $arg=array();

            $arg['lpucode'] = $res['user']['lpucode'];
            $arg['sort'] = 'surname';

            $arg['order'] = 'desc';
            $arg['age_beg'] = 21;
            $arg['age_end'] = 99;

            $arg['month_beg'] = 1;
            $arg['month_end'] = 12;

            $res['total'] = $this->patient_model->GetPatientsTotal($arg);
        } else {
            $res['auth'] = 0;
        }
        echo json_encode($res);
    }

    /*чекает всех в фильтре*/
    public function CheckAllFromFilter(){
        $res = array();
        if ($this->auth_model->IsLogin()) {
            $res['auth'] = 1;
            $res['user'] = $this->auth_model->UserInfo();
            $patient = $this->input->post('patient');


            $d = $this->GetFilterParams(array(), $patient);

            $arg = $d['arg'];
            $arg['lpucode'] = $res['user']['lpucode'];
            $arg['user'] = $res['user'];

            $arg['status'] = $this->input->post('status');
            $arg['disp_year'] = $this->input->post('disp_year');
            $this->patient_model->CheckAllFromFilter($arg);
        } else {
            $res['auth'] = 0;
        }
        echo json_encode($res);
    }

    /*загрузка срезов*/
    public function LoadSections(){
        $res = array();
        if ($this->auth_model->IsLogin()) {
            $res['auth'] = 1;
            $res['user'] = $this->auth_model->UserInfo();
            if(((isset($_FILES['f']['name'])))and($_FILES['f']['name']!=''))
            {
                $rnd=$this->elex->PassGen();
                $uploadfile = $_SERVER['DOCUMENT_ROOT'].$this->root."img/sections/". $res['user']['lpucode']."_".$rnd.'_'.$this->elex->rus2translit(basename($_FILES['f']['name']));

                if (move_uploaded_file($_FILES['f']['tmp_name'],$uploadfile))
                {
                    /*вставляем в таблицу*/
                    $arg = array();
                    $arg['lpu'] =  $res['user']['lpucode'];
                    $arg['filename'] =  $uploadfile;
                    /*todo сделать возможность указывать год*/
                    $arg['year'] =  2017;
                    $this->patient_model ->InsertUploadStatus($arg);

                }
                else
                {
                    //error
                }
            }
        } else {
                header('Location: '.$this->root);
                exit;
        }
        header('Location: '.$this->root."thx");
        exit;
    }


    public function PassGenAll(){
        $users = $this->auth_model->GetAllUsers();
        foreach($users as $key=>$u){
            //$this->auth_model->UpdateUserPassword($u['username'],$this->elex->PassGen());

        }
    }

    /*загружает планы из csv*/
    public function LoadPlans(){
        /*Заагружем*/
        $row = 1;
        if (($handle = fopen($_SERVER['DOCUMENT_ROOT']."/plan.csv", "r")) !== FALSE) {
            while (($data = fgetcsv($handle, 1000, ";")) !== FALSE) {

                //$user = $this->auth_model->GetUserByName($data[0]);
                    /*вставляем*/
                    $arg = array();
                    $arg['year'] = 2017;
                    $arg['lpucode'] = $data[0];
                    $arg['plan_count'] = $data[1];
                /*закоментил чтобы больше не вставлялось*/
                    //$this->patient_model->InsertPlan($arg);
            }
            fclose($handle);
        }
    }


    public function getFunctions(){

        print_r($this->tfoms->auth_test());
    }

    public function SendTestPlan(){
        /*STATE	EIN	NDOC	NSDOC	SDOC	DOCTYPE	SURNAME	NAME	SECNAME	FINSTAT	BIRTHDAY	SEX	NPOLIS	SPOLIS	RGN1	RGN2	RGN3	STREET	HOUSE	HOUSELITER	CORPUS	FLAT	FLATLITER	LOCAL	LPUBASE	LPUBASE_U	LPUDENT	AGRNUM	INSURER	DATE_IN	DATE_CH	PENSION	D_START	D_MODIF	D_FIN	COUNTER	ENP	KLADRST	LPUCHIEF	TER	RAZDEL	SMOMODDATE	POLISDATE	POLISTYPE	DOCDATE	type_u
0	NULL	744980	NULL	36 01	14	КАРГИН	ВАЛЕРИЙ	СЕРГЕЕВИЧ	1	1947-03-17 00:00:00.000	1	172164	ВМ	401	364	0	7	8	NULL	NULL	68	NULL	NULL	5113	4	5105	NULL	63002	NULL	NULL	008-529-811 58	NULL	2011-08-16 11:23:27.663	NULL	1	6376250832000198	NULL	5113	36	1	NULL	2003-12-08 00:00:00.000	1	NULL	NULL*/
        $arg = array();
        $arg['user_id'] = 2401;
        $arg['guid'] = $this->tfoms->GUID();
        $arg['disp_year'] = 2017;
        $arg['disp_quarter'] = 1;
        $arg['disp_type'] = 1;
        $arg['disp_lpu'] = 502;
        $arg['age'] = 57;
        $arg['lgg_code'] = '';
        $arg['drcode'] = '';
        $arg['speccode'] = '';
        $arg['refusal_reason'] = '';
        /*$arg['disp_start'] = '';*/
        $arg['date_planning'] = '2017-08-08';
        $arg['stage_1_result'] = '';
        $arg['stage_2_result'] = '';
        $arg['enp'] = '6356930839001091';

        $result = $this->tfoms->disp_plan_create($arg);

       /* echo "REQUEST:\n" . $this->tfoms->soap->__getLastRequest() . "\n";
        echo $this->tfoms->soap->faultcode;
        echo $result->faultstring;
        echo $this->tfoms->soap->__getLastRequest();*/

        //print_r($result);
    }

    public function CheckLoadPlans(){
        $res = array();
        //unset($_SESSION['auth']);
       // print_r($res);

        //if(empty($_SESSION['auth'])) echo 1;else echo 2;
        //echo '/////////';
        if ($this->auth_model->IsLogin()) {
            $res['auth'] = 1;
            $res['user'] = $_SESSION['auth'];
            $res['CheckLoadPlans'] = $this->patient_model->CheckLoadPlans($res['user']['lpucode'],'2017');
        }
        echo json_encode($res);
    }


    public function toexel(){
        $res = array();
        if($this->auth_model->IsLogin()) {
            $res['auth'] = 1;
            $res['user'] = $this->auth_model->UserInfo();

            $data = $this->input->post('data');
            $patient = $this->input->post('patient');



                $d = $this->GetFilterParams($data,$patient);
                $data = $d['data'];
                $arg = $d['arg'];
                $arg['lpucode'] = $res['user']['lpucode'];
                $res['patients']['rows'] = $this->patient_model->GetPatientsAll($arg);
        } else {
            $res['auth'] = 0;
        }
        echo json_encode($res);
    }
     public function toexelFrom(){
        $res = array();
        if($this->auth_model->IsLogin()) {
            $res['auth'] = 1;
            $res['user'] = $this->auth_model->UserInfo();

            $data = $this->input->post('data');
            $patient = $this->input->post('patient');



            $d = $this->GetFilterParams($data,$patient);
            $data = $d['data'];
            $arg = $d['arg'];
            $arg['lpucode'] = $res['user']['lpucode'];
            $arg['chk1']='true';
            $arg['chk2']='true';
            $arg['chk3']='true';
            $arg['chk4']='true';
            $res['patients']['rows'] = $this->patient_model->GetPatientsAll($arg);


        } else {
            $res['auth'] = 0;
        }
         $this->load->view('exel', $res);
    }




    private function GenUsername($username){
        $username = explode(' ',$username);
        return $this->elex->encodestring($username[0]);

    }

    public function LoadUsers(){
        if (($handle = fopen($_SERVER['DOCUMENT_ROOT']."/zz.csv", "r")) !== FALSE) {
            while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {


                //$user = $this->auth_model->GetUserByName($data[0]);
                /*вставляем*/
                $arg = array();

                /*закоментил чтобы больше не вставлялось*/
                //$this->patient_model->InsertPlan($arg);

                $arg['lpucode'] = $data[0];
                $arg['username'] = $arg['lpucode']."_".$this->GenUsername($data[1]);
                $arg['group'] = 2;
                $arg['description'] = mb_convert_encoding($data[2],"Windows-1251","UTF-8");
                $arg['fullname'] = mb_convert_encoding($data[1],"Windows-1251","UTF-8");
                $arg['DRCODE'] = mb_convert_encoding($data[3],"Windows-1251","UTF-8");
                $arg['password'] = $this->elex->PassGen();

                if($this->auth_model->AddUser2($arg))
                    print_r($arg);

            }
            fclose($handle);
        }
    }

    public function TestWSDL(){
        $this->tfoms->TestCurl();
    }

    public function PhpInfo(){
        phpinfo();
    }

    public function SendTfoms(){
        $res = array();
       // if($this->auth_model->IsLogin()) {
            $res['auth'] = 1;
            $res['user'] = $this->auth_model->UserInfo();

            $data = $this->input->post('data');
            $patient = $this->input->post('patient');
            $d = $this->GetFilterParams($data,$patient);
            $data = $d['data'];
            $arg = $d['arg'];
            $arg['lpucode'] = 3408;
            $arg['chk1']='true';
            $arg['chk2']='true';
            $arg['chk3']='true';
            $arg['chk4']='true';
            $res['patients']['rows'] = $this->patient_model->GetPatientsAll($arg);

            $send_data = [];
            /*перебераем пациентов*/
            $i=0;
            foreach($res['patients']['rows'] as $p){
                $i++;
                unset($arg);
                unset($send_data);
                $send_data = [];
                $arg = array();
                $arg['user_id'] = 2401;
                $arg['guid'] = $this->tfoms->GUID();
                $arg['disp_year'] = $p['disp_year'];
                $arg['disp_quarter'] = 1;
                $arg['disp_type'] = 1;
                $arg['disp_lpu'] = $p['disp_lpu'];
                $arg['age'] = $p['age'];
                $arg['lgg_code'] = '';
                $arg['drcode'] = '';
                $arg['speccode'] = '';
                $arg['refusal_reason'] = '';
                /*$arg['disp_start'] = '';*/
                $arg['date_planning'] = '2017-08-08';
                $arg['stage_1_result'] = '';
                $arg['stage_2_result'] = '';
                $arg['enp'] = $p['enp'];
                $send_data[]=array('DISP_PLAN'=>(object)$arg);
                $this->tfoms->disp_plan_create($send_data);
                print_r($arg);
                echo "============= ".$i." ==================="."\n\r";



                //if($i>3) break;
            }
      /*  } else {
            $res['auth'] = 0;
        }*/


    }

}
