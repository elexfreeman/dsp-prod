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
        $this->load->library('excel');
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
        if(isset($patient['error_code'])) $arg['error_code'] = $patient['error_code'];

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
            $arg = array();
            $last_status = $this->patient_model->GetLastDspStatus($this->input->post('patient_enp'));
            if(isset($last_status)){
                $arg['disp_type'] = $last_status['disp_type'];
                $arg['age'] = $last_status['age'];
                $arg['lgg_code'] = $last_status['lgg_code'];
                $arg['drcode'] =$last_status['drcode'];
                $arg['refusal_reason'] = $last_status['refusal_reason'];
                $arg['disp_start'] = $last_status['disp_start'];
                $arg['stage_1_result'] = $last_status['stage_1_result'];
                $arg['stage_2_result'] = $last_status['stage_2_result'];
                $arg['guid'] = $last_status['guid'];
                $arg['speccode'] = $last_status['speccode'];
                $arg['disp_final'] = $last_status['disp_final'];
                $arg['date_planning'] = $last_status['date_planning'];


            } else {
                $arg['disp_type'] = 1;
                $arg['age'] = 1;
                $arg['lgg_code'] = 1;
                $arg['drcode'] = 1;
                $arg['refusal_reason'] = 1;
                $arg['disp_start'] = '';
                $arg['stage_1_result'] = '';
                $arg['stage_2_result'] = '';
                $arg['guid'] = '';
                $arg['speccode'] = '';
            }

            $res['auth'] = 1;
            $res['user'] = $this->auth_model->UserInfo();

            $arg['enp'] = $this->input->post('patient_enp');
            $arg['status'] = $this->input->post('status');
            $arg['disp_year'] = $this->input->post('disp_year');
            $arg['disp_quarter'] = $this->input->post('disp_quarter');

            $arg['disp_lpu'] = $res['user']['lpucode'];



            $res['id'] = $this->patient_model->InsertPatientStatus($arg);


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
            $arg['chk1']='true';
            $arg['chk2']='true';
            $arg['chk3']='true';
            $arg['chk4']='true';
            $arg['chk_red']='false';

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

         /*   $arg['chk1']='true';
            $arg['chk2']='true';
            $arg['chk3']='true';
            $arg['chk4']='true';
            $arg['chk4']='true';*/
            $arg['chk_red']='false';

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
            $res['LoadPlans'] = $this->patient_model->GetLoadPlans($res['user']['lpucode'],'2017');
            $res['LoadPlans'] = date('d.m.Y',strtotime($res['LoadPlans']['upload_date']));
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
           /* $arg['chk1']='true';
            $arg['chk2']='true';
            $arg['chk3']='true';
            $arg['chk4']='true';*/
            $res['patients']['rows'] = $this->patient_model->GetPatientsAll($arg);

            $this->load->library('excel');
            //activate worksheet number 1
            $this->excel->setActiveSheetIndex(0);
            //name the worksheet
            $this->excel->getActiveSheet()->setTitle('Диспансеризация');
            //set cell A1 content with some text
            $y=1;

            $this->excel->getActiveSheet()->setCellValue('A'.$y,'ЛПУ прикрепления');
            $this->excel->getActiveSheet()->setCellValue('B'.$y,'Наименование участка');
            $this->excel->getActiveSheet()->setCellValue('C'.$y,'Участок');
            $this->excel->getActiveSheet()->setCellValue('D'.$y,'Тип участка');
            $this->excel->getActiveSheet()->setCellValue('E'.$y,'Код врача');
            $this->excel->getActiveSheet()->setCellValue('F'.$y,'Специальность врача');
            $this->excel->getActiveSheet()->setCellValue('G'.$y,'Фамилия');
            $this->excel->getActiveSheet()->setCellValue('H'.$y,'Имя');
            $this->excel->getActiveSheet()->setCellValue('I'.$y,'Отчество');
            $this->excel->getActiveSheet()->setCellValue('J'.$y,'Возраст');
            $this->excel->getActiveSheet()->setCellValue('K'.$y,'Дата рождения');
            $this->excel->getActiveSheet()->setCellValue('L'.$y,'Пол');
            $this->excel->getActiveSheet()->setCellValue('M'.$y,'ЕНП');
            $this->excel->getActiveSheet()->setCellValue('N'.$y,'ЛПУ');
            $this->excel->getActiveSheet()->setCellValue('O'.$y,'Квартал');
            $this->excel->getActiveSheet()->setCellValue('P'.$y,'Тип диспансеризации');
            $this->excel->getActiveSheet()->setCellValue('R'.$y,'Год');

            foreach($res['patients']['rows'] as $row){
                $y++;
                $this->excel->getActiveSheet()->setCellValue('A'.$row['lpubase']);
                $this->excel->getActiveSheet()->setCellValue('B'.$y,$row['NAME']);
                $this->excel->getActiveSheet()->setCellValue('C'.$y,$row['lpubase_u']);
                $this->excel->getActiveSheet()->setCellValue('D'.$y,$row['typeui']);
                $this->excel->getActiveSheet()->setCellValue('E'.$y,$row['drcode']);
                $this->excel->getActiveSheet()->setCellValue('F'.$y,$row['speccode']);
                $this->excel->getActiveSheet()->setCellValue('G'.$y,$row['surname1']);
                $this->excel->getActiveSheet()->setCellValue('H'.$y,$row['name1']);
                $this->excel->getActiveSheet()->setCellValue('I'.$y,$row['secname1']);
                $this->excel->getActiveSheet()->setCellValue('J'.$y,$row['age']);
                $this->excel->getActiveSheet()->setCellValue('K'.$y,date('d.m.Y',strtotime($row['birthday1'])));
                $this->excel->getActiveSheet()->setCellValue('L'.$y,$row['sex']);
                $this->excel->getActiveSheet()->setCellValue('M'.$y,$row['enp']);
                $this->excel->getActiveSheet()->setCellValue('N'.$y,$row['disp_lpu']);
                $this->excel->getActiveSheet()->setCellValue('O'.$y,$row['disp_quarter']);
                $this->excel->getActiveSheet()->setCellValue('P'.$y,$row['disp_type']);
                $this->excel->getActiveSheet()->setCellValue('R'.$y,$row['disp_year']);
            }

            $filename='dsp.xls'; //save our workbook as this file name
            header('Content-Type: application/vnd.ms-excel'); //mime type
            header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
            header('Cache-Control: max-age=0'); //no cache

            //save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
            //if you want to save it as .XLSX Excel 2007 format
            $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
            //force user to download the Excel file without writing it to server's HD
            $objWriter->save('php://output');





        } else {
            $res['auth'] = 0;
        }

    }

    public function toexelFromInPlan(){
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
            $arg['chk_red']='false';
            $res['patients']['rows'] = $this->patient_model->GetPatientsAll($arg);

            $this->load->library('excel');
            //activate worksheet number 1
            $this->excel->setActiveSheetIndex(0);
            //name the worksheet
            $this->excel->getActiveSheet()->setTitle('Диспансеризация');
            //set cell A1 content with some text
            $y=1;

            $this->excel->getActiveSheet()->setCellValue('A'.$y,'ЛПУ прикрепления');
            $this->excel->getActiveSheet()->setCellValue('B'.$y,'Наименование участка');
            $this->excel->getActiveSheet()->setCellValue('C'.$y,'Участок');
            $this->excel->getActiveSheet()->setCellValue('D'.$y,'Тип участка');
            $this->excel->getActiveSheet()->setCellValue('E'.$y,'Код врача');
            $this->excel->getActiveSheet()->setCellValue('F'.$y,'Специальность врача');
            $this->excel->getActiveSheet()->setCellValue('G'.$y,'Фамилия');
            $this->excel->getActiveSheet()->setCellValue('H'.$y,'Имя');
            $this->excel->getActiveSheet()->setCellValue('I'.$y,'Отчество');
            $this->excel->getActiveSheet()->setCellValue('J'.$y,'Возраст');
            $this->excel->getActiveSheet()->setCellValue('K'.$y,'Дата рождения');
            $this->excel->getActiveSheet()->setCellValue('L'.$y,'Пол');
            $this->excel->getActiveSheet()->setCellValue('M'.$y,'ЕНП');
            $this->excel->getActiveSheet()->setCellValue('N'.$y,'ЛПУ');
            $this->excel->getActiveSheet()->setCellValue('O'.$y,'Квартал');
            $this->excel->getActiveSheet()->setCellValue('P'.$y,'Тип диспансеризации');
            $this->excel->getActiveSheet()->setCellValue('R'.$y,'Год');

            foreach($res['patients']['rows'] as $row){
                $y++;
                $this->excel->getActiveSheet()->setCellValue('A'.$row['lpubase']);
                $this->excel->getActiveSheet()->setCellValue('B'.$y,$row['NAME']);
                $this->excel->getActiveSheet()->setCellValue('C'.$y,$row['lpubase_u']);
                $this->excel->getActiveSheet()->setCellValue('D'.$y,$row['typeui']);
                $this->excel->getActiveSheet()->setCellValue('E'.$y,$row['drcode']);
                $this->excel->getActiveSheet()->setCellValue('F'.$y,$row['speccode']);
                $this->excel->getActiveSheet()->setCellValue('G'.$y,$row['surname1']);
                $this->excel->getActiveSheet()->setCellValue('H'.$y,$row['name1']);
                $this->excel->getActiveSheet()->setCellValue('I'.$y,$row['secname1']);
                $this->excel->getActiveSheet()->setCellValue('J'.$y,$row['age']);
                $this->excel->getActiveSheet()->setCellValue('K'.$y,date('d.m.Y',strtotime($row['birthday1'])));
                $this->excel->getActiveSheet()->setCellValue('L'.$y,$row['sex']);
                $this->excel->getActiveSheet()->setCellValue('M'.$y,$row['enp']);
                $this->excel->getActiveSheet()->setCellValue('N'.$y,$row['disp_lpu']);
                $this->excel->getActiveSheet()->setCellValue('O'.$y,$row['disp_quarter']);
                $this->excel->getActiveSheet()->setCellValue('P'.$y,$row['disp_type']);
                $this->excel->getActiveSheet()->setCellValue('R'.$y,$row['disp_year']);
            }

            //change the font size
            //$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(20);
            //make the font become bold
            //$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
            //merge cell A1 until D1
            //$this->excel->getActiveSheet()->mergeCells('A1:D1');
            //set aligment to center for that merged cell (A1 to D1)
            //$this->excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

            $filename='dsp.xls'; //save our workbook as this file name
            header('Content-Type: application/vnd.ms-excel'); //mime type
            header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
            header('Cache-Control: max-age=0'); //no cache

            //save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
            //if you want to save it as .XLSX Excel 2007 format
            $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
            //force user to download the Excel file without writing it to server's HD
            $objWriter->save('php://output');


        } else {
            $res['auth'] = 0;
        }

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

    public function get_manual_processing_errors(){
        $res = $this->tfoms->get_manual_processing_errors();

        foreach( $res->RESULT->row as $r){
            $r = (array)$r;
            print_r($r);
            $arg = [];
            $arg['error_code'] = $r['id'];
            $arg['description'] = $r['name'];
            //$this->patient_model->InsertTfomsErrorDescr($arg);
        }
    }

    public function SendTfoms(){
        $res = array();
        if($this->auth_model->IsLogin()) {
            $res['auth'] = 1;
            $res['user'] = $this->auth_model->UserInfo();

            $this->patient_model->PrepareTfoms($res['user']['lpucode']);

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

            $arg['chk_red']='false';
            $res['patients']['rows'] = $this->patient_model->GetPatientsAll($arg);

            $send_data = [];
            /*перебераем пациентов*/
            $i=0;
            $response = [];
            foreach($res['patients']['rows'] as $p){

               /*
                * Array
                    (
                        [vozr] => 48
                        [rn] => 2
                        [user_id] =>
                        [disp_year] => 2017
                        [disp_type] => 1
                        [disp_lpu] => 701
                        [age] => 48
                        [lpubase] => 703
                        [lpubase_u] => 20
                        [typeui] => 7
                        [enp] => 6350030833001043
                        [kol] => 70101
                        [drcode] => С335455
                        [speccode] => 51
                        [surname1] => АБАИМОВ
                        [name1] => ВЯЧЕСЛАВ
                        [secname1] => ВИКТОРОВИЧ
                        [birthday1] => 1969-09-16 00:00:00.000
                        [status] => 1
                        [NAME] =>
                        [guid] =>
                        [sex] => 1
                        [disp_quarter] => 3
                        [error] => 0
                    )*/
                //print_r($p);
                $i++;
                unset($arg);
                unset($send_data);
                $send_data = [];

                $user = $this->auth_model->GetRegUserInfo();

                $this->tfoms->username = $user['tfoms_username'];
                $this->tfoms->password = $user['tfoms_password'];
                $this->tfoms->user_id = $user['tfoms_user_id'];

                /*статусы
                - 0 не вкл в  план
                - 1 помечен
                - 2 отправлен с ошибкой
                - 3 отправлен
                - 4 дисп начата
                - 5 закончен 1-й этоп
                - 6 закончен 2-й этап
                */

                $arg = array();
                if($p['guid']=='')
                    $arg['guid'] =  $this->tfoms->GUID();
                else
                    $arg['guid'] = $p['guid'];

                $arg['enp'] = strval($p['enp']);
                $arg['disp_year'] = $p['disp_year'];
                $arg['disp_quarter'] = $p['disp_quarter'];
                $arg['disp_type'] = '1';
                $arg['disp_lpu'] = $p['disp_lpu'];
                if(($arg['disp_lpu']==9501)or($arg['disp_lpu']==4064)){
                    $arg['disp_lpu'] =4061;
                }
                $arg['age'] = $p['age'];
                //$arg['lgg_code'] = '';
                $arg['drcode'] = $p['drcode'];
                $arg['speccode'] = $p['speccode'];
               /* $arg['refusal_reason'] = '';
                $arg['stage_1_result'] = '';
                $arg['stage_2_result'] = '';*/
                $arg['date_planning'] = date('Y-m-d');
                $arg['user_id'] = $this->tfoms->user_id;
                if($p['disp_start']!='1900-01-01')  $arg['disp_start'] = $p['disp_start'];
                //if($p['stage_1_result']!=0)  $arg['stage_1_result'] = $p['stage_1_result'];
                //if($p['stage_2_result']!=0)  $arg['stage_2_result'] = $p['stage_2_result'];
                //if($p['refusal_reason']!=0)  $arg['refusal_reason'] = $p['refusal_reason'];

                /*$arg['disp_start'] = '';*/
                //print_r($arg);


                /*проверка на удаление*/
             /*   if($p['guid']!=''){

                    $delete_arg=[];
                    $delete_arg['guid'] = $p['guid'];
                    $delete_arg['user_id'] = $this->tfoms->user_id;
                    echo "<pre>";
                    echo "==============DELTE================== \r\n";
                    print_r($this->tfoms->disp_plan_deleteCurl($delete_arg));
                    echo "</pre>";
                }*/


                $tfoms_erors = $this->tfoms->disp_plan_createCurl($arg);
                echo "<pre>";
                echo "==============INSERT================== \r\n";
                print_r($tfoms_erors);
                echo "</pre>";

                /*стутусы*/
                $status_arg = [];
                /*статус дефаулт = 3 всехорошо*/
                $status_arg['status'] = 3;
                $status_arg['enp'] = $p['enp'];

                if($p['guid']=='')
                    $status_arg['guid'] =  $this->tfoms->GUID();
                else $status_arg['guid'] = $p['guid'];

                $status_arg['disp_year'] = $p['disp_year'];
                $status_arg['disp_quarter'] = $p['disp_quarter'];
                $status_arg['disp_type'] = '1';
                $status_arg['disp_lpu'] = $p['disp_lpu'];
                $status_arg['age'] = $p['age'];
                //$arg['lgg_code'] = '';
                $status_arg['drcode'] = $p['drcode'];
                $status_arg['speccode'] = $p['speccode'];

                /*проверяем ошибки*/
                $p['error_code']= '';
                $p['message']= '';
                if($tfoms_erors===false){
                    $p['error']= 'Сервер тфомс не доступен!';

                }elseif(isset($tfoms_erors->S_Body->S_Fault->detail->ns2_RequestException->errors)){
                    /*есть ошибки*/
                    $status_arg['status'] = 2;
                    $disp_plan_id = $this->patient_model->InsertPatientStatus($status_arg);
                    $errors_arg = [];
                    $errors_arg['enp'] = $p['enp'];
                    $errors_arg['error_code'] = $tfoms_erors->S_Body->S_Fault->detail->ns2_RequestException->errors->code;
                    $errors_arg['message'] = $tfoms_erors->S_Body->S_Fault->detail->ns2_RequestException->message;
                    $this->patient_model-> InsertTfomsErrors($disp_plan_id,$errors_arg);
                    $p['error_code']= $errors_arg['error_code'];
                    $p['message']= $errors_arg['message'] ;

                }
                else {
                    $disp_plan_id = $this->patient_model->InsertPatientStatus($status_arg);
                }

                $response[]=$p;
                //if($i>3) break;
            }

        } else {
            $res['auth'] = 0;
        }
    }


    public function SendTfoms701(){
        $res = array();

        $users = $this->patient_model->GetUserWithTfoms();
        foreach($users as $user){
            print_r($user);
            $this->tfoms->username = $user['tfoms_username'];
            $this->tfoms->password = $user['tfoms_password'];
            $this->tfoms->user_id = $user['tfoms_user_id'];

            $res['auth'] = 1;
            $res['user'] = $this->auth_model->UserInfo();

            $data = $this->input->post('data');
            $patient = $this->input->post('patient');
            $d = $this->GetFilterParams($data,$patient);
            $data = $d['data'];
            $arg = $d['arg'];
            $arg['lpucode'] = $user['lpucode'];

            $arg['chk1']='true';
            $arg['chk2']='true';
            $arg['chk3']='true';
            $arg['chk4']='true';

            $arg['chk_red']='false';
            $res['patients']['rows'] = $this->patient_model->GetPatientsAll10($arg);

            $send_data = [];
            /*перебераем пациентов*/
            $i=0;
            $response = [];
            foreach($res['patients']['rows'] as $p){

               /*
                * Array
                    (
                        [vozr] => 48
                        [rn] => 2
                        [user_id] =>
                        [disp_year] => 2017
                        [disp_type] => 1
                        [disp_lpu] => 701
                        [age] => 48
                        [lpubase] => 703
                        [lpubase_u] => 20
                        [typeui] => 7
                        [enp] => 6350030833001043
                        [kol] => 70101
                        [drcode] => С335455
                        [speccode] => 51
                        [surname1] => АБАИМОВ
                        [name1] => ВЯЧЕСЛАВ
                        [secname1] => ВИКТОРОВИЧ
                        [birthday1] => 1969-09-16 00:00:00.000
                        [status] => 1
                        [NAME] =>
                        [guid] =>
                        [sex] => 1
                        [disp_quarter] => 3
                        [error] => 0
                    )*/
                //print_r($p);

                unset($arg);
                unset($send_data);
                $send_data = [];

               /* $user = $this->auth_model->GetRegUserInfo();

                $this->tfoms->username = $user['tfoms_username'];
                $this->tfoms->password = $user['tfoms_password'];
                $this->tfoms->user_id = $user['tfoms_user_id'];*/

                /*статусы
                - 0 не вкл в  план
                - 1 помечен
                - 2 отправлен с ошибкой
                - 3 отправлен
                - 4 дисп начата
                - 5 закончен 1-й этоп
                - 6 закончен 2-й этап
                */

                /*
 * <xs:complexType name="dispPlan">
<xs:sequence>
<xs:element name="guid">
<xs:simpleType>
<xs:restriction base="xs:string">
<xs:pattern value="[a-fA-F0-9]{8}-[a-fA-F0-9]{4}-[a-fA-F0-9]{4}-[a-fA-F0-9]{4}-[a-fA-F0-9]{12}"/>
</xs:restriction>
</xs:simpleType>
</xs:element>
<xs:element name="enp" type="xs:long"/>
<xs:element name="disp_year" type="xs:short"/>
<xs:element name="disp_quarter" type="xs:short"/>
<xs:element name="disp_type" type="xs:short"/>
<xs:element name="disp_lpu" type="xs:int"/>
<xs:element name="age" type="xs:short"/>
<xs:element name="lgg_code" type="xs:int" minOccurs="0"/>
<xs:element minOccurs="0" name="drcode">
<xs:simpleType>
<xs:restriction base="xs:string">
<xs:maxLength value="8"/>
</xs:restriction>
</xs:simpleType>
</xs:element>
<xs:element name="speccode" type="xs:int" minOccurs="0"/>
<xs:element name="refusal_reason" type="xs:short" minOccurs="0"/>
<xs:element name="disp_start" type="xs:date" minOccurs="0"/>
<xs:element name="disp_final" type="xs:date" minOccurs="0"/>
<xs:element name="stage_1_result" type="xs:short" minOccurs="0"/>
<xs:element name="stage_2_result" type="xs:short" minOccurs="0"/>
<xs:element name="date_planning" type="xs:date"/>
</xs:sequence>
</xs:complexType>
 * */
                $arg = array();
                if($p['guid']=='')
                    $arg['guid'] =  $this->tfoms->GUID();
                else
                    $arg['guid'] = $p['guid'];

                $arg['enp'] = strval($p['enp']);
                $arg['disp_year'] = $p['disp_year'];
                $arg['disp_quarter'] = $p['disp_quarter'];
                $arg['disp_type'] = '1';
                $arg['disp_lpu'] = $p['disp_lpu'];
               /* if(($arg['disp_lpu']==9501)or($arg['disp_lpu']==4064)){
                    $arg['disp_lpu'] =4061;
                }*/
                $arg['age'] = $p['age'];
                //$arg['lgg_code'] = 0;
                $arg['drcode'] = $p['drcode'];
                $arg['speccode'] = $p['speccode'];
               // $arg['refusal_reason'] = 0;

                print_r($p);

                if($p['disp_start']!='1900-01-01')
                {
                    $arg_guid = array();
                    $arg_guid['enp'] = strval($p['enp']);
                    $arg_guid['lpu'] = $p['disp_lpu'];
                    unset($tfoms_erors);
                  /*  $tfoms_erors = $this->tfoms->disp_plan_selectByENPCurl($arg_guid);

                    if(!($tfoms_erors===false)) {
                        echo $tfoms_erors['guid'] . " " . $tfoms_erors['enp'] . " \r\n";
                        if($tfoms_erors['guid']!='')
                            $arg['guid'] =  $tfoms_erors['guid'];
                    }*/

                    $arg['disp_start'] = $p['disp_start'];
                    $arg['disp_final'] = $p['disp_final'];

                    $arg['stage_1_result'] = $p['stage_1_result'];
                  //  $arg['stage_2_result'] = 0;
                    $arg['date_planning'] = date('Y-m-d');
                    $arg['user_id'] = $this->tfoms->user_id;

                    print_r($arg);


                    $tfoms_erors = $this->tfoms->disp_plan_createCurl($arg);
                    echo "<pre>";
                    echo "==============INSERT================== \r\n";
                    print_r($tfoms_erors);
                    echo "</pre>";



                    /*стутусы*/
                    $status_arg = [];
                    /*статус дефаулт = 3 всехорошо*/
                    $status_arg['status'] = 3;
                    $status_arg['enp'] = $p['enp'];

                    $status_arg['guid'] = $arg['guid'];

                    $status_arg['disp_year'] = $p['disp_year'];
                    $status_arg['disp_quarter'] = $p['disp_quarter'];
                    $status_arg['disp_type'] = '1';
                    $status_arg['disp_lpu'] = $p['disp_lpu'];
                    $status_arg['age'] = $p['age'];
                    //$arg['lgg_code'] = '';
                    $status_arg['drcode'] = $p['drcode'];
                    $status_arg['speccode'] = $p['speccode'];
                    $status_arg['disp_start'] = $p['disp_start'];
                    $status_arg['disp_final'] = $p['disp_final'];
                    $status_arg['stage_1_result'] = $p['stage_1_result'];
                    //  $arg['stage_2_result'] = 0;
                    $status_arg['date_planning'] = date('Y-m-d');

                    /*проверяем ошибки*/
                    $p['error_code']= '';
                    $p['message']= '';
                    if($tfoms_erors===false){
                        $p['error']= 'Сервер тфомс не доступен!';

                    }elseif(isset($tfoms_erors->S_Body->S_Fault->detail->ns2_RequestException->errors)){
                        /*есть ошибки*/
                        $status_arg['status'] = 2;
                        $disp_plan_id = $this->patient_model->InsertPatientStatus($status_arg);
                        $errors_arg = [];
                        $errors_arg['enp'] = $p['enp'];
                        $errors_arg['error_code'] = $tfoms_erors->S_Body->S_Fault->detail->ns2_RequestException->errors->code;
                        $errors_arg['message'] = $tfoms_erors->S_Body->S_Fault->detail->ns2_RequestException->message;
                        $this->patient_model-> InsertTfomsErrors($disp_plan_id,$errors_arg);
                        $p['error_code']= $errors_arg['error_code'];
                        $p['message']= $errors_arg['message'] ;
                    }
                    else {
                        $disp_plan_id = $this->patient_model->InsertPatientStatus($status_arg);
                    }

                    $response[]=$p;
                   // if($i>3) break;
                    $i++;
                }
               ;
            }
        }
    }

    public function GetLpuP(){
        $res = array();
        if($this->auth_model->IsLogin()) {
            $res['auth'] = 1;
            $res['user'] = $this->auth_model->UserInfo();
            $res['LpuP'] = $this->patient_model->GetLpuP($res['user']['lpucode']);
        }
        else {
            $res['auth'] = 0;
        }
        echo json_encode($res);
    }

    public function GetTfomsErrorsList(){
        $res = array();
        if($this->auth_model->IsLogin()) {
            $res['auth'] = 1;
            $res['user'] = $this->auth_model->UserInfo();
            $res['TfomsErrors'] = $this->patient_model->GetTfomsErrorsList();
        }
        else {
            $res['auth'] = 0;
        }
        echo json_encode($res);
    }

    public function get_manual_filters(){
        $res = array();

            $res['TfomsErrors'] = $this->tfoms->get_manual_filters();

        echo print_r($res);
    }


    public function Testexel(){

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
            $arg['chk_red']='false';
            $res['patients']['rows'] = $this->patient_model->GetPatientsAll($arg);

            $this->load->library('excel');
            //activate worksheet number 1
            $this->excel->setActiveSheetIndex(0);
            //name the worksheet
            $this->excel->getActiveSheet()->setTitle('Диспансеризация');
            //set cell A1 content with some text
            $y=1;

            $this->excel->getActiveSheet()->setCellValue('A'.$y,'ЛПУ прикрепления');
            $this->excel->getActiveSheet()->setCellValue('B'.$y,'Наименование участка');
            $this->excel->getActiveSheet()->setCellValue('C'.$y,'Участок');
            $this->excel->getActiveSheet()->setCellValue('D'.$y,'Тип участка');
            $this->excel->getActiveSheet()->setCellValue('I'.$y,'Код врача');
            $this->excel->getActiveSheet()->setCellValue('F'.$y,'Специальность врача');
            $this->excel->getActiveSheet()->setCellValue('G'.$y,'Фамилия');
            $this->excel->getActiveSheet()->setCellValue('H'.$y,'Имя');
            $this->excel->getActiveSheet()->setCellValue('I'.$y,'Отчество');
            $this->excel->getActiveSheet()->setCellValue('J'.$y,'Возраст');
            $this->excel->getActiveSheet()->setCellValue('K'.$y,'Дата рождения');
            $this->excel->getActiveSheet()->setCellValue('L'.$y,'Пол');
            $this->excel->getActiveSheet()->setCellValue('M'.$y,'ЕНП');
            $this->excel->getActiveSheet()->setCellValue('N'.$y,'ЛПУ');
            $this->excel->getActiveSheet()->setCellValue('O'.$y,'Квартал');
            $this->excel->getActiveSheet()->setCellValue('P'.$y,'Квартал');
            $this->excel->getActiveSheet()->setCellValue('R'.$y,'Тип диспансеризации');
            $this->excel->getActiveSheet()->setCellValue('S'.$y,'Год');

            foreach($res['patients']['rows'] as $row){
                $y++;
                $this->excel->getActiveSheet()->setCellValue('A'.$row['lpubase']);
                $this->excel->getActiveSheet()->setCellValue('B'.$y,$row['NAME']);
                $this->excel->getActiveSheet()->setCellValue('C'.$y,$row['lpubase_u']);
                $this->excel->getActiveSheet()->setCellValue('D'.$y,$row['typeui']);
                $this->excel->getActiveSheet()->setCellValue('E'.$y,$row['drcode']);
                $this->excel->getActiveSheet()->setCellValue('F'.$y,$row['speccode']);
                $this->excel->getActiveSheet()->setCellValue('G'.$y,$row['surname1']);
                $this->excel->getActiveSheet()->setCellValue('H'.$y,$row['name1']);
                $this->excel->getActiveSheet()->setCellValue('I'.$y,$row['secname1']);
                $this->excel->getActiveSheet()->setCellValue('J'.$y,$row['age']);
                $this->excel->getActiveSheet()->setCellValue('K'.$y,$row['birthday1']);
                $this->excel->getActiveSheet()->setCellValue('L'.$y,$row['sex']);
                $this->excel->getActiveSheet()->setCellValue('M'.$y,$row['enp']);
                $this->excel->getActiveSheet()->setCellValue('N'.$y,$row['disp_lpu']);
                $this->excel->getActiveSheet()->setCellValue('O'.$y,$row['disp_quarter']);
                $this->excel->getActiveSheet()->setCellValue('P'.$y,$row['disp_type']);
                $this->excel->getActiveSheet()->setCellValue('R'.$y,$row['disp_year']);
                $this->excel->getActiveSheet()->setCellValue('S'.$y,'Год');

            }

            //change the font size
            //$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(20);
            //make the font become bold
            //$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
            //merge cell A1 until D1
            //$this->excel->getActiveSheet()->mergeCells('A1:D1');
            //set aligment to center for that merged cell (A1 to D1)
            //$this->excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

            $filename='dsp.xls'; //save our workbook as this file name
            header('Content-Type: application/vnd.ms-excel'); //mime type
            header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
            header('Cache-Control: max-age=0'); //no cache

            //save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
            //if you want to save it as .XLSX Excel 2007 format
            $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
            //force user to download the Excel file without writing it to server's HD
            $objWriter->save('php://output');

        } else {
            $res['auth'] = 0;
        }
    }


    public function UpdateGUID(){
        $res = array();

                $users = $this->patient_model->GetUserWithTfoms();
                foreach($users as $user){
                    $this->tfoms->username = $user['tfoms_username'];
                    $this->tfoms->password = $user['tfoms_password'];
                    $this->tfoms->user_id = $user['tfoms_user_id'];
                    $send_data = [];
                    /*перебераем пациентов*/
                    $i=0;
                    $response = [];

                    $data = $this->input->post('data');
                    $patient = $this->input->post('patient');
                    $d = $this->GetFilterParams($data,$patient);
                    $data = $d['data'];
                    $arg = $d['arg'];
                    $arg['lpucode'] = $user['lpucode'];

                    $arg['chk1']='true';
                    $arg['chk2']='true';
                    $arg['chk3']='true';
                    $arg['chk4']='true';

                    $arg['chk_red']='false';
                    $res['patients']['rows'] = $this->patient_model->GetPatientsAll($arg);


                    foreach($res['patients']['rows'] as $p){
                        unset($arg);
                        $arg = array();
                        $arg['enp'] = strval($p['enp']);
                        $arg['lpu'] = $p['disp_lpu'];
                        unset($tfoms_erors);
                        $tfoms_erors = $this->tfoms->disp_plan_selectByENPCurl($arg);

                        echo "==============GUID================== \r\n";
                        print_r($tfoms_erors);

                        if(!($tfoms_erors===false)){
                            echo $tfoms_erors['guid']." ".$tfoms_erors['enp']." \r\n";
                            /*вставляем строчку с */
                            unset($arg_insert);
                            $arg_insert=[];
                            $arg_insert = array();
                            $arg_insert['guid'] = $tfoms_erors['guid'];
                            $arg_insert['disp_year'] = $tfoms_erors['disp_year'];
                            $arg_insert['disp_quarter'] = $tfoms_erors['disp_quarter'];
                            $arg_insert['disp_type'] = $tfoms_erors['disp_type'];
                            $arg_insert['disp_lpu'] = $tfoms_erors['disp_type'];
                            $arg_insert['age'] = $tfoms_erors['age'];

                            $arg_insert['drcode'] = $tfoms_erors['drcode'];
                            $arg_insert['speccode'] = $tfoms_erors['speccode'];

                            $arg_insert['disp_start'] = $p['disp_start'];
                            $arg_insert['date_planning'] = $tfoms_erors['date_planning'];
                            $arg_insert['enp'] = $tfoms_erors['enp'];

                            $arg_insert['status'] = $p['status'];
                            $arg_insert['disp_final'] = $p['disp_final'];
                            $arg_insert['error'] = $p['error'];


                            $arg_insert['stage_1_result'] = $p['stage_1_result'];
                            if(isset($tfoms_erors['stage_1_result'])) $arg_insert['stage_1_result'] = $tfoms_erors['stage_1_result'];

                            $arg_insert['stage_2_result'] = $p['stage_2_result'];
                            if(isset($tfoms_erors['stage_2_result'])) $arg_insert['stage_2_result'] = $tfoms_erors['stage_2_result'];

                            $arg_insert['refusal_reason'] = $p['refusal_reason'];
                            if(isset($tfoms_erors['refusal_reason'])) $arg_insert['refusal_reason'] = $tfoms_erors['refusal_reason'];

                            $arg_insert['lgg_code'] = $p['lgg_code'];
                            if(isset($tfoms_erors['lgg_code'])) $arg_insert['lgg_code'] = $tfoms_erors['lgg_code'];

                            $this->patient_model->InsertPatientStatus($arg_insert);

                            print_r($arg_insert);


                            // $result = $this->tfoms->disp_plan_create($arg);

                        }
                    }
                }

    }
    public function UpdateGUIDLPU(){

        if($this->auth_model->IsLogin()) {
                    $res['auth'] = 1;
                    $res['user'] = $this->auth_model->UserInfo();

                    $this->tfoms->username = $res['user']['tfoms_username'];
                    $this->tfoms->password = $res['user']['tfoms_password'];
                    $this->tfoms->user_id = $res['user']['tfoms_user_id'];

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

                    $arg['chk_red']='false';


                    $send_data = [];
                    /*перебераем пациентов*/
                    $i=0;
                    $response = [];

                    $send_data = [];
                    /*перебераем пациентов*/
                    $i=0;
                    $response = [];

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

                    $arg['chk_red']='false';
                    $res['patients']['rows'] = $this->patient_model->GetPatientsAll($arg);


                    foreach($res['patients']['rows'] as $p){
                        unset($arg);
                        $arg = array();
                        $arg['enp'] = strval($p['enp']);
                        $arg['lpu'] = $p['disp_lpu'];
                        print_r($p);
                        unset($tfoms_erors);
                       $tfoms_erors = $this->tfoms->disp_plan_selectByENPCurl($arg);
                        //$tfoms_erors = false;

                        echo "==============GUID================== \r\n";
                        print_r($tfoms_erors);

                        if(!($tfoms_erors===false)){
                            echo $tfoms_erors['guid']." ".$tfoms_erors['enp']." \r\n";
                            /*вставляем строчку с */
                            unset($arg_insert);
                            $arg_insert=[];
                            $arg_insert = array();
                            $arg_insert['guid'] = $tfoms_erors['guid'];
                            $arg_insert['disp_year'] = $tfoms_erors['disp_year'];
                            $arg_insert['disp_quarter'] = $tfoms_erors['disp_quarter'];
                            $arg_insert['disp_type'] = $tfoms_erors['disp_type'];
                            $arg_insert['disp_lpu'] = $tfoms_erors['disp_type'];
                            $arg_insert['age'] = $tfoms_erors['age'];

                            $arg_insert['drcode'] = $tfoms_erors['drcode'];
                            $arg_insert['speccode'] = $tfoms_erors['speccode'];

                            $arg_insert['disp_start'] = $p['disp_start'];
                            $arg_insert['date_planning'] = $tfoms_erors['date_planning'];
                            $arg_insert['enp'] = $tfoms_erors['enp'];

                            $arg_insert['status'] = $p['status'];
                            $arg_insert['disp_final'] = $p['disp_final'];
                            $arg_insert['error'] = $p['error'];


                            $arg_insert['stage_1_result'] = $p['stage_1_result'];
                            if(isset($tfoms_erors['stage_1_result'])) $arg_insert['stage_1_result'] = $tfoms_erors['stage_1_result'];

                            $arg_insert['stage_2_result'] = $p['stage_2_result'];
                            if(isset($tfoms_erors['stage_2_result'])) $arg_insert['stage_2_result'] = $tfoms_erors['stage_2_result'];

                            $arg_insert['refusal_reason'] = $p['refusal_reason'];
                            if(isset($tfoms_erors['refusal_reason'])) $arg_insert['refusal_reason'] = $tfoms_erors['refusal_reason'];

                            $arg_insert['lgg_code'] = $p['lgg_code'];
                            if(isset($tfoms_erors['lgg_code'])) $arg_insert['lgg_code'] = $tfoms_erors['lgg_code'];

                            $this->patient_model->InsertPatientStatus($arg_insert);

                            print_r($arg_insert);

                            // $result = $this->tfoms->disp_plan_create($arg);

                        }
                    }
                }

    }


    public function UpdateGUIDLPU2(){

        if($this->auth_model->IsLogin()) {
                    $res['auth'] = 1;
                    $res['user'] = $this->auth_model->UserInfo();

                    $this->tfoms->username = $res['user']['tfoms_username'];
                    $this->tfoms->password = $res['user']['tfoms_password'];
                    $this->tfoms->user_id = $res['user']['tfoms_user_id'];

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

                    $arg['chk_red']='false';


                    $send_data = [];
                    /*перебераем пациентов*/
                    $i=0;
                    $response = [];

                    $send_data = [];
                    /*перебераем пациентов*/
                    $i=0;
                    $response = [];

                    $data = $this->input->post('data');
                    $patient = $this->input->post('patient');
                    $d = $this->GetFilterParams($data,$patient);
                    $data = $d['data'];
                    $arg = $d['arg'];
                    $arg['lpucode'] = $res['user']['lpucode'];


                        $arg = array();
                        $arg['EgeStart'] = 0;
                        unset($tfoms_erors);
                        $tfoms_erors = $this->tfoms->disp_plan_selectByEgeStartCurl($arg);
                        //$tfoms_erors = false;

                        echo "==============GUID================== \r\n";
                        foreach($tfoms_erors['DISP_PLAN'] as $t){
                            print_r((array)$t);
                        }
                        echo "===".count($tfoms_erors['DISP_PLAN'])."===";



                }

    }



    public function SendTfoms9501(){
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

            $arg['chk_red']='false';
            $res['patients']['rows'] = $this->patient_model->GetPatients9501($arg);

            $send_data = [];
            /*перебераем пациентов*/
            $i=0;
            $response = [];
            foreach($res['patients']['rows'] as $p){

                /*
                 * Array
                     (
                         [vozr] => 48
                         [rn] => 2
                         [user_id] =>
                         [disp_year] => 2017
                         [disp_type] => 1
                         [disp_lpu] => 701
                         [age] => 48
                         [lpubase] => 703
                         [lpubase_u] => 20
                         [typeui] => 7
                         [enp] => 6350030833001043
                         [kol] => 70101
                         [drcode] => С335455
                         [speccode] => 51
                         [surname1] => АБАИМОВ
                         [name1] => ВЯЧЕСЛАВ
                         [secname1] => ВИКТОРОВИЧ
                         [birthday1] => 1969-09-16 00:00:00.000
                         [status] => 1
                         [NAME] =>
                         [guid] =>
                         [sex] => 1
                         [disp_quarter] => 3
                         [error] => 0
                     )*/
                //print_r($p);
                $i++;
                unset($arg);
                unset($send_data);
                $send_data = [];

                $user = $this->auth_model->GetRegUserInfo();

                $this->tfoms->username = $user['tfoms_username'];
                $this->tfoms->password = $user['tfoms_password'];
                $this->tfoms->user_id = $user['tfoms_user_id'];

                /*статусы
                - 0 не вкл в  план
                - 1 помечен
                - 2 отправлен с ошибкой
                - 3 отправлен
                - 4 дисп начата
                - 5 закончен 1-й этоп
                - 6 закончен 2-й этап
                */

                $arg = array();
                if($p['guid']=='')
                    $arg['guid'] =  $this->tfoms->GUID();
                else
                    $arg['guid'] = $p['guid'];

                $arg['enp'] = strval($p['enp']);
                $arg['disp_year'] = $p['disp_year'];
                $arg['disp_quarter'] = $p['disp_quarter'];
                $arg['disp_type'] = '1';
                $arg['disp_lpu'] = $p['disp_lpu'];
                if(($arg['disp_lpu']==9501)or($arg['disp_lpu']==4064)){
                    $arg['disp_lpu'] =4061;
                }
                $arg['age'] = $p['age'];
                //$arg['lgg_code'] = '';
                $arg['drcode'] = $p['drcode'];
                $arg['speccode'] = $p['speccode'];
                /* $arg['refusal_reason'] = '';
                 $arg['stage_1_result'] = '';
                 $arg['stage_2_result'] = '';*/
                $arg['date_planning'] = date('Y-m-d');
                $arg['user_id'] = $this->tfoms->user_id;
                if($p['disp_start']!='1900-01-01')  $arg['disp_start'] = $p['disp_start'];
                //if($p['stage_1_result']!=0)  $arg['stage_1_result'] = $p['stage_1_result'];
                //if($p['stage_2_result']!=0)  $arg['stage_2_result'] = $p['stage_2_result'];
                //if($p['refusal_reason']!=0)  $arg['refusal_reason'] = $p['refusal_reason'];

                /*$arg['disp_start'] = '';*/
                //print_r($arg);


                /*проверка на удаление*/
                /*   if($p['guid']!=''){

                       $delete_arg=[];
                       $delete_arg['guid'] = $p['guid'];
                       $delete_arg['user_id'] = $this->tfoms->user_id;
                       echo "<pre>";
                       echo "==============DELTE================== \r\n";
                       print_r($this->tfoms->disp_plan_deleteCurl($delete_arg));
                       echo "</pre>";
                   }*/


                $tfoms_erors = $this->tfoms->disp_plan_createCurl($arg);
                echo "<pre>";
                echo "==============INSERT================== \r\n";
                print_r($tfoms_erors);
                echo "</pre>";

                /*стутусы*/
                $status_arg = [];
                /*статус дефаулт = 3 всехорошо*/
                $status_arg['status'] = 3;
                $status_arg['enp'] = $p['enp'];

                if($p['guid']=='')
                    $status_arg['guid'] =  $this->tfoms->GUID();
                else $status_arg['guid'] = $p['guid'];

                $status_arg['disp_year'] = $p['disp_year'];
                $status_arg['disp_quarter'] = $p['disp_quarter'];
                $status_arg['disp_type'] = '1';
                $status_arg['disp_lpu'] = $p['disp_lpu'];
                $status_arg['age'] = $p['age'];
                //$arg['lgg_code'] = '';
                $status_arg['drcode'] = $p['drcode'];
                $status_arg['speccode'] = $p['speccode'];

                /*проверяем ошибки*/
                $p['error_code']= '';
                $p['message']= '';
                if($tfoms_erors===false){
                    $p['error']= 'Сервер тфомс не доступен!';

                }elseif(isset($tfoms_erors->S_Body->S_Fault->detail->ns2_RequestException->errors)){
                    /*есть ошибки*/
                    $status_arg['status'] = 2;
                    $disp_plan_id = $this->patient_model->InsertPatientStatus($status_arg);
                    $errors_arg = [];
                    $errors_arg['enp'] = $p['enp'];
                    $errors_arg['error_code'] = $tfoms_erors->S_Body->S_Fault->detail->ns2_RequestException->errors->code;
                    $errors_arg['message'] = $tfoms_erors->S_Body->S_Fault->detail->ns2_RequestException->message;
                    $this->patient_model-> InsertTfomsErrors($disp_plan_id,$errors_arg);
                    $p['error_code']= $errors_arg['error_code'];
                    $p['message']= $errors_arg['message'] ;

                }
                else {
                    $disp_plan_id = $this->patient_model->InsertPatientStatus($status_arg);
                }

                $response[]=$p;
                //if($i>3) break;
            }

        } else {
            $res['auth'] = 0;
        }
    }



    public function print_pre($arg){
        echo "<pre>";
        print_r($arg);
        echo "</pre>";
    }


    public function SendTfomsTest(){
        $res = array();

        $users = $this->patient_model->GetUserWithTfoms();
        foreach($users as $user){

            print_r($user);
            $this->tfoms->username = $user['tfoms_username'];
            $this->tfoms->password = $user['tfoms_password'];
            $this->tfoms->user_id = $user['tfoms_user_id'];

            $res['auth'] = 1;
            $res['user'] = $this->auth_model->UserInfo();

            $data = $this->input->post('data');
            $patient = $this->input->post('patient');
            $d = $this->GetFilterParams($data,$patient);
            $data = $d['data'];
            $arg = $d['arg'];
            $arg['lpucode'] = $user['lpucode'];

            $arg['chk1']='true';
            $arg['chk2']='true';
            $arg['chk3']='true';
            $arg['chk4']='true';

            $arg['chk_red']='false';
            $res['patients']['rows'] = $this->patient_model->GetPatientsAll10($arg);

            $send_data = [];
            /*перебераем пациентов*/
            $i=0;
            $response = [];
            foreach($res['patients']['rows'] as $p){

                /*
                 * Array
                     (
                         [vozr] => 48
                         [rn] => 2
                         [user_id] =>
                         [disp_year] => 2017
                         [disp_type] => 1
                         [disp_lpu] => 701
                         [age] => 48
                         [lpubase] => 703
                         [lpubase_u] => 20
                         [typeui] => 7
                         [enp] => 6350030833001043
                         [kol] => 70101
                         [drcode] => С335455
                         [speccode] => 51
                         [surname1] => АБАИМОВ
                         [name1] => ВЯЧЕСЛАВ
                         [secname1] => ВИКТОРОВИЧ
                         [birthday1] => 1969-09-16 00:00:00.000
                         [status] => 1
                         [NAME] =>
                         [guid] =>
                         [sex] => 1
                         [disp_quarter] => 3
                         [error] => 0
                     )*/
                //print_r($p);

                unset($arg);
                unset($send_data);
                $send_data = [];

                /* $user = $this->auth_model->GetRegUserInfo();

                 $this->tfoms->username = $user['tfoms_username'];
                 $this->tfoms->password = $user['tfoms_password'];
                 $this->tfoms->user_id = $user['tfoms_user_id'];*/

                /*статусы
                - 0 не вкл в  план
                - 1 помечен
                - 2 отправлен с ошибкой
                - 3 отправлен
                - 4 дисп начата
                - 5 закончен 1-й этоп
                - 6 закончен 2-й этап
                */

                /*
 * <xs:complexType name="dispPlan">
<xs:sequence>
<xs:element name="guid">
<xs:simpleType>
<xs:restriction base="xs:string">
<xs:pattern value="[a-fA-F0-9]{8}-[a-fA-F0-9]{4}-[a-fA-F0-9]{4}-[a-fA-F0-9]{4}-[a-fA-F0-9]{12}"/>
</xs:restriction>
</xs:simpleType>
</xs:element>
<xs:element name="enp" type="xs:long"/>
<xs:element name="disp_year" type="xs:short"/>
<xs:element name="disp_quarter" type="xs:short"/>
<xs:element name="disp_type" type="xs:short"/>
<xs:element name="disp_lpu" type="xs:int"/>
<xs:element name="age" type="xs:short"/>
<xs:element name="lgg_code" type="xs:int" minOccurs="0"/>
<xs:element minOccurs="0" name="drcode">
<xs:simpleType>
<xs:restriction base="xs:string">
<xs:maxLength value="8"/>
</xs:restriction>
</xs:simpleType>
</xs:element>
<xs:element name="speccode" type="xs:int" minOccurs="0"/>
<xs:element name="refusal_reason" type="xs:short" minOccurs="0"/>
<xs:element name="disp_start" type="xs:date" minOccurs="0"/>
<xs:element name="disp_final" type="xs:date" minOccurs="0"/>
<xs:element name="stage_1_result" type="xs:short" minOccurs="0"/>
<xs:element name="stage_2_result" type="xs:short" minOccurs="0"/>
<xs:element name="date_planning" type="xs:date"/>
</xs:sequence>
</xs:complexType>
 * */
                $arg = array();
                if($p['guid']=='')
                    $arg['guid'] =  $this->tfoms->GUID();
                else
                    $arg['guid'] = $p['guid'];

                $arg['enp'] = strval($p['enp']);
                $arg['disp_year'] = $p['disp_year'];
                $arg['disp_quarter'] = $p['disp_quarter'];
                $arg['disp_type'] = '1';
                $arg['disp_lpu'] = $p['disp_lpu'];
                /* if(($arg['disp_lpu']==9501)or($arg['disp_lpu']==4064)){
                     $arg['disp_lpu'] =4061;
                 }*/
                $arg['age'] = $p['age'];
                //$arg['lgg_code'] = 0;
                $arg['drcode'] = $p['drcode'];
                $arg['speccode'] = $p['speccode'];
                // $arg['refusal_reason'] = 0;

                print_r($p);

                if($p['disp_start']!='1900-01-01')
                {
                    $arg_guid = array();
                    $arg_guid['enp'] = strval($p['enp']);
                    $arg_guid['lpu'] = $p['disp_lpu'];
                    unset($tfoms_erors);
                    /*  $tfoms_erors = $this->tfoms->disp_plan_selectByENPCurl($arg_guid);

                      if(!($tfoms_erors===false)) {
                          echo $tfoms_erors['guid'] . " " . $tfoms_erors['enp'] . " \r\n";
                          if($tfoms_erors['guid']!='')
                              $arg['guid'] =  $tfoms_erors['guid'];
                      }*/

                    $arg['disp_start'] = $p['disp_start'];
                    $arg['disp_final'] = $p['disp_final'];

                    $arg['stage_1_result'] = $p['stage_1_result'];
                    //  $arg['stage_2_result'] = 0;
                    $arg['date_planning'] = date('Y-m-d');
                    $arg['user_id'] = $this->tfoms->user_id;

                    print_r($arg);


                    $tfoms_erors = $this->tfoms->disp_plan_createCurl($arg);
                    echo "<pre>";
                    echo "==============INSERT================== \r\n";
                    print_r($tfoms_erors);
                    echo "</pre>";



                    /*стутусы*/
                    $status_arg = [];
                    /*статус дефаулт = 3 всехорошо*/
                    $status_arg['status'] = 3;
                    $status_arg['enp'] = $p['enp'];

                    $status_arg['guid'] = $arg['guid'];

                    $status_arg['disp_year'] = $p['disp_year'];
                    $status_arg['disp_quarter'] = $p['disp_quarter'];
                    $status_arg['disp_type'] = '1';
                    $status_arg['disp_lpu'] = $p['disp_lpu'];
                    $status_arg['age'] = $p['age'];
                    //$arg['lgg_code'] = '';
                    $status_arg['drcode'] = $p['drcode'];
                    $status_arg['speccode'] = $p['speccode'];
                    $status_arg['disp_start'] = $p['disp_start'];
                    $status_arg['disp_final'] = $p['disp_final'];
                    $status_arg['stage_1_result'] = $p['stage_1_result'];
                    //  $arg['stage_2_result'] = 0;
                    $status_arg['date_planning'] = date('Y-m-d');

                    /*проверяем ошибки*/
                    $p['error_code']= '';
                    $p['message']= '';
                    if($tfoms_erors===false){
                        $p['error']= 'Сервер тфомс не доступен!';

                    }elseif(isset($tfoms_erors->S_Body->S_Fault->detail->ns2_RequestException->errors)){
                        /*есть ошибки*/
                        $status_arg['status'] = 2;
                        $disp_plan_id = $this->patient_model->InsertPatientStatus($status_arg);
                        $errors_arg = [];
                        $errors_arg['enp'] = $p['enp'];
                        $errors_arg['error_code'] = $tfoms_erors->S_Body->S_Fault->detail->ns2_RequestException->errors->code;
                        $errors_arg['message'] = $tfoms_erors->S_Body->S_Fault->detail->ns2_RequestException->message;
                        $this->patient_model-> InsertTfomsErrors($disp_plan_id,$errors_arg);
                        $p['error_code']= $errors_arg['error_code'];
                        $p['message']= $errors_arg['message'] ;
                    }
                    else {
                        $disp_plan_id = $this->patient_model->InsertPatientStatus($status_arg);
                    }

                    $response[]=$p;
                    // if($i>3) break;
                    $i++;
                }
                ;
            }
        }
    }

    public function PrepareTfoms(){
        $res = array();
        if($this->auth_model->IsLogin()) {
            $res['auth'] = 1;
            $res['user'] = $this->auth_model->UserInfo();

            $this->patient_model->PrepareTfoms($res['user']['lpucode']);

        }
    }


    public function Test11(){
        print_r($this->patient_model->test11());
    }

}
