<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*контроллер главной страницы*/
class Pg extends CI_Controller {

    /*тут хранятся настройки, закгружаются в конструкторе*/
    public $settings;
    public $data;

    public function __construct()
    {
        parent::__construct();
        /*Загружаем  библиотеку сессий*/
        $this->load->library('session');
        $this->load->library('form_validation');

        /*Загружаем модели*/


        /*Закгружаем хелперы*/
        $this->load->helper('form');
        $this->load->helper('url');

        $this->load->model('pg_model');
        $this->load->model('patient_model');
        $this->load->model('ipre_model');

    }

	public function index()
	{
        print_r($this->pg_model->Get_rhb_res());
	}


    /*вставляем всех в pg*/
    public function incertAllp()
    {
        /*
       DT    	date    	Дата разработки ИПР (XML: tIPRA-DavelopDate)
       SNILS 	char(15)	ПФР код (XML: tIPRA-Person-SNILS)
       LNAME 	char(30)	Фамилия обладателя ИПР/ПРП (XML: tIPRA-Person-FIO-LastName)
       FNAME 	char(30)	Имя обладателя ИПР/ПРП (XML: tIPRA-Person-FIO-FirstName)
       SNAME 	char(30)	Отчество обладателя ИПР/ПРП (XML: tIPRA-Person-FIO-SecondName)
       BDATE 	date    	Дата рождения обладателя ИПР/ПРП (XML: tIPRA-Person-BirthDate)
       GNDR  	smallint	Пол: 1-муж, 2-жен (XML: tIPRA-Person-IsMale)
       OIVID	int	PRG_OIV.ID Орган исполнительной власти (XML: tIPRA-Recipient-RecipientType-Id)
       DOCNUM	char(20)	Номер протокола (XML: tIPRA-ProtocolNum)
       DOCDT 	date    	Дата протокола проведения МСЭ (XML: tIPRA-ProtocolDate)
       PRG   	smallint	Программа: 1-ИПР, 2-ПРП
       PRGNUM	char(20)	Номер ИПР/ПРП (XML: tIPRA-Number)
       PRGDT 	date    	Дата выдачи ИПР (XML: tIPRA-IssueDate)
       MSEID 	char(36)	Ключ ИПР/ПРП из ФБ МСЭ (XML: tIPRA-Id !!! Обязателен к заполнению)
       UDT	TIMESTAMP with time zone	Метка времени изменения записи
       ADT	TIMESTAMP with time zone	Метка времени скачивания записи
*/
        $patients = $this->patient_model->GetAllp();
        foreach($patients as $p)
        {

            /*очищаемпамять*/
            unset($data);
            unset($xmlstring);
            unset($xml);

            $data = array();
            $xmlstring = file_get_contents($this->ipre_model->XMLPatientsPath.'\\'. $p['xml_file']);

            $xmlstring = str_replace("ct:", "", $xmlstring);
            $tIPRA = new SimpleXMLElement($xmlstring);

            $d = $tIPRA->DavelopDate;

            $year =  date( 'Y', strtotime($d) ) ;
            $month =  date( 'm', strtotime($d) ) ;
            $day =  date( 'd', strtotime($d) ) ;
            $d =  sprintf("%04d-%02d-%02d",$year,$month,$day);
            $data['dt'] = $d;

            $data['snils'] = $tIPRA->Person->SNILS;
            $data['lname'] = $tIPRA->Person->FIO->LastName;
            $data['fname'] = $tIPRA->Person->FIO->FirstName;
            $data['sname'] = $tIPRA->Person->FIO->SecondName;

            $d = $tIPRA->Person->BirthDate;
            $year =  date( 'Y', strtotime($d) ) ;
            $month =  date( 'm', strtotime($d) ) ;
            $day =  date( 'd', strtotime($d) ) ;
            $d =  sprintf("%04d-%02d-%02d",$year,$month,$day);
            $data['bdate'] = $d;

            if($tIPRA->Person->IsMale=='true') $data['gndr'] = 1; else $data['gndr'] = 2;
            $data['oivid'] = $tIPRA->Recipient->RecipientType->Id;
            $data['docnum'] = $tIPRA->ProtocolNum;

            $d = $tIPRA->ProtocolDate;
            $year =  date( 'Y', strtotime($d) ) ;
            $month =  date( 'm', strtotime($d) ) ;
            $day =  date( 'd', strtotime($d) ) ;
            $d =  sprintf("%04d-%02d-%02d",$year,$month,$day);
            $data['docdt'] = $d;

            $data['prgnum'] = $tIPRA->Number;

            $d = $tIPRA->ProtocolDate;
            $year =  date( 'Y', strtotime($d) ) ;
            $month =  date( 'm', strtotime($d) ) ;
            $day =  date( 'd', strtotime($d) ) ;
            $d =  sprintf("%04d-%02d-%02d",$year,$month,$day);
            $data['docdt'] = $d;

            $d = $tIPRA->IssueDate;
            $year =  date( 'Y', strtotime($d) ) ;
            $month =  date( 'm', strtotime($d) ) ;
            $day =  date( 'd', strtotime($d) ) ;
            $d =  sprintf("%04d-%02d-%02d",$year,$month,$day);
            $data['prgdt'] = $d;

            $data['mseid'] = $tIPRA->Id;
            $pg_id = $this->pg_model->insert_prg($data);
            /*обновляем базу*/
            $this->patient_model->update($p['id'],array('pg_id'=>$pg_id));
            echo $this->elex->rus2translit($data['lname']).
                " ".$this->elex->rus2translit($data['fname'])." ".
                $this->elex->rus2translit($data['sname'])." "."\n\r";

        }

    }



}
