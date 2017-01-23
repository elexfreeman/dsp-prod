<?php
/**
 * Created by PhpStorm.
 * User: cod_llo
 * Date: 11.03.16
 * Time: 17:11
 */
/*Модель для работой с актпаком*/

class Aktpak_model extends CI_Model
{
    public $cacheDB;
    public $srv224DB;

    public $PatientsCache = 'Test.VACPatients';
    public $PatientsSQL = '[vaccination2].[dbo].[VACD_Patient]';

    /*Имя базы*/
    public $GlobalDB = "Test";

    /*Глобал для Докторов*/
    public $DoctorsCache = "VACAKTPAKDoctors";
    /*Глобал для LPU*/
    public $LPUCache = "VACAKTPAKLPU";


    public function __construct()
    {
        $this->cacheDB = $this->load->database('default', TRUE);
        $this->srv224DB = $this->load->database('srv224', TRUE);
        date_default_timezone_set('Europe/London');
        $this->load->helper('url');
    }




    public function GetTableSrv224($tablename)
    {
        $sql='SELECT  * FROM [AKTPAK].[dbo].['.$tablename.'] where D_FIN is NULL';

        $query = $this->srv224DB->query($sql);

        return $query->result();
    }

     public function GetTableCache($tablename)
    {
        $sql='SELECT * FROM [AKTPAK].[dbo].['.$tablename.']';

        $query = $this->srv224DB->query($sql);

        return $query->result_array();
    }


    /*Перезаливает справочник AKPC_LPU*/
    public function LoadLPU()
    {

        $sql_lpu = $this->GetTableSrv224('AKPC_LPU');

        /*Херим страые данные*/
        $sql='TRUNCATE TABLE AKTPAK.AKPCLPU';
        $this->cacheDB->query($sql);

        foreach ($sql_lpu as $lpu )
        {

            $sql= "INSERT INTO AKTPAK.AKPCLPU ( ";

            foreach ($lpu as $key=>$value )
            {
                //if(($key!='COUNTER')and($key!='DOMAIN')and($key!='CODE')) $sql.=" ".$key.", ";
               $sql.='"'.$key.'", ';
            }

            /*Теперь херим 2 последних символа в строке запроса*/
            $sql=substr($sql, 0, -2);


            $sql.=" ) VALUES ( ";
            foreach ($lpu as $key=>$value )
            {
                $value = str_replace(array("'",'"'),' ',$value);
                if($value=='') $value=" NULL "; else $value=" '".$value."' ";
                //if(($key!='COUNTER')and($key!='DOMAIN')) $sql.=" '".$value."', ";
                $sql.=" ".$value.", ";
            }
            $sql=substr($sql, 0, -2);
            $sql.=" )";
            echo $sql."<br>";
            $this->cacheDB->query($sql);
            echo $sql."<br>";
          //  $query = $this->db->query($sql);
        }
        $sql="INSERT INTO AKTPAK.AKPCLPU ( STATE, CODE, LPUCODE, TYPE_S, NAME, NAME_L, NAME_S, OMS, PMSP_YES, DENT_YES, AGE, INDEX, RGN1, RGN2, RGN3, STREET, HOUSE, HOUSELITER, CORPUS, FLAT, FLATLITER, E_MAIL, NPOST, FACE, PHONE, FAX, FACE1, PHONE1, NPOST3, FACE3, E_MAIL3, PHONE3, INN, OGRN, OWERCODE, NN_LPU, CHIEF, EKATC, OKPO, SOATO, SOOGU, KPP, TER, RAZDEL, D_START, D_MODIF, D_FIN, KOPF, OID, FOMSCODE, WWW, NN_TER ) VALUES ( '', '', '102', '2', 'ММУ АЛЕКСЕЕВСКАЯ ЦРБ ИМ.В.И.ГЛОТОВА', 'Муниципальное медицинское учреждение Алексеевская центральная районная больница им.В.И.Глотова ', 'ММУ Алексеевская ЦРБ им.В.И.Глотова ', '1', '1', '1', '3', '446640', '202', '808', '1', '112', '1', '', '0', '0', '', 'LPU0102@SAMTEL.RU', 'ГЛАВНЫЙ ВРАЧ', 'МУХОРТОВА НАТАЛЬЯ ВАСИЛЬЕВНА', '88467121632', '88467121632', 'АТНАКАЕВА НАДЕЖДА ВЛАДИМИРОВНА', '88467122516', 'СЕКРЕТАРЬ', 'КАЗНАЧЕЕВА ЕЛЕНА ВИКТОРОВНА', 'LPU0102@SAMTEL.RU', '88467121632', '6361005128', '1036303050365', '14', '1.1.1.5.', '0', '85.11.1', '01929577', '36202000000', '49007', '636101001', '36', '2', '2007-11-30 00:00:00', '', '2011-12-04 00:00:00', '81', '', '', '', ''')";;

    }


    public function sample()
        // public function search()
    {

        $sql='SELECT PName,PSurname Office FROM Sample.Patient';
        $query = $this->db->query($sql);
        return $query->result();

        //return $query;
    }

    public function sample_insert($Name,$Office)
    {
        $data = array(
            'Name' => mb_convert_encoding($Name,"Windows-1251","UTF-8"),
            'Office' => mb_convert_encoding($Office,"Windows-1251","UTF-8")

        );

        $sql= "INSERT INTO Sample.Patient (PName,PSurname)
    VALUES ('".mb_convert_encoding($Name,"Windows-1251","UTF-8")."','".mb_convert_encoding($Office,"Windows-1251","UTF-8")."')";;

        $query = $this->db->query($sql);
    }







}