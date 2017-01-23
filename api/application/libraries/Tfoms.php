<?php

/**
 * Created by PhpStorm.
 * User: User
 * Date: 12.05.2016
 * Time: 17:38
 */
class Tfoms
{
    public $address = '11.0.0.14';
    public $port = '8080';

    public $wsdl = '';

    public $username = "6005vedunov";
    public $password = "abouT565";

    public $soap;


    public function __construct()
    {
        $this->wsdl = $_SERVER['DOCUMENT_ROOT']."/services.wsdl";
        $this->soap = new SoapClient($this->wsdl,array('trace'=>true,'exceptions'=>true));
    }

    //генератор паролей
    public function PassGen($max=10)
    {
        // Символы, которые будут использоваться в пароле.
        $chars="qazxswedcvfrtgbnhyujmkip23456789QAZXSWEDCVFRTGBNHYUJMKLP";
        // Количество символов в пароле.

        // Определяем количество символов в $chars
        $size=StrLen($chars)-1;

        // Определяем пустую переменную, в которую и будем записывать символы.
        $password=null;

        // Создаём пароль.
        while($max--)
            $password.=$chars[rand(0,$size)];

        // Выводим созданный пароль.
        return $password;
    }

    /**
     * Return header for autentification
     * @return SoapHeader|array
     * формирует заголовк авторизации
     */
    protected function wssecurity_text_header() {
        $auth = '
        <wsse:Security SOAP-ENV:mustUnderstand="1" xmlns:wsse="http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-secext-1.0.xsd">
        <wsse:UsernameToken>
            <wsse:Username>' . $this->username . '</wsse:Username>
            <wsse:Password>' . $this->password . '</wsse:Password>
           </wsse:UsernameToken>
        </wsse:Security>
        ';
        $authvalues = new SoapVar($auth, XSD_ANYXML);
        return new SoapHeader("http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-secext-1.0.xsd", "Security", $authvalues, true);
    }

    /*тест авторизации*/
    public function auth_test(){
        return $this->soap->__soapCall('auth_test', array(),array(),$this->wssecurity_text_header());
    }

    /*Справочник ошибок обработки запросов – получение из РИИСЗ */
    public function get_manual_processing_errors(){
        return $this->soap->__soapCall('get_manual_processing_errors', array(),array(),$this->wssecurity_text_header());
    }

    /*Получение списков (групп) значений полей перечислимого типа.*/
    public function get_manual_all_lists(){
        return $this->soap->__soapCall('get_manual_all_lists', array(),array(),$this->wssecurity_text_header());
    }

  /*Получение справочника фильтров, необходимых для усечения результатов обработки получающих запросов.*/
    public function get_manual_filters(){
        return $this->soap->__soapCall('get_manual_filters', array(),array(),$this->wssecurity_text_header());
    }

   /*нкции: disp_plan_create.
    Основание: Приказ ФОМС от 11.05.2016 №88 раздел III п.п. 1,2,3,6,13,19.
    Описание функции: передача из МИС сведений о планах диспансеризации прикрепленного населения на текущий календарный год.
    Участники, предоставляющие данные: МО, к которым прикреплены граждане, включенные в план диспансеризации.*/
    public function disp_plan_create($arg){
        $a = array('DISP_PLAN'=>(object)$arg);

        $output = $this->wssecurity_text_header();
        try {
            $res =  $this->soap->__soapCall('disp_plan_create', array($a),$a,$output);
        }catch(SoapFault $fault) {

            $res = $this->soap->__getLastResponse();
            echo $this->soap->__getLastResponseHeaders();
            echo $this->soap->__getLastResponse();
            echo $fault->getMessage();
            echo $fault->faultstring;
            print_r($a);
            print_r($output);

        }

        return $res;


    }

    /*Наименование функции: disp_plan_select.
    Основание: Приказ ФОМС от 11.05.2016 №88 раздел IV п.п. 4,7,8,9.
    Описание функции: получение из РИИСЗ сведений о планах диспансеризации учреждений, имеющих прикрепленное население.
    Участники, получающие данные: а) СМО, являющаяся страхователем граждан,
    включенных в планы диспансеризации, на момент запроса, б) МО, к которой
    прикреплен пациент, на момент запроса, в) МО, в которой запланировано проведение диспансеризации.*/
    public function disp_plan_select($arg){
        return $this->soap->__soapCall('disp_plan_select', $arg,array(),$this->wssecurity_text_header());
    }


    /*Наименование функции: disp_plan_delete.
Основание: Приказ ФОМС от 11.05.2016 №88 раздел III п.п. 1,2,3,6,13,19.
Описание функции: удаление из РИИСЗ сведений о планах диспансеризации прикрепленного населения.
Участники, предоставляющие данные: МО, зарегистрировавшие в РИИСЗ удаляемые сведения планов диспансеризации.*/
    public function disp_plan_delete($arg){
        return $this->soap->__soapCall('disp_plan_delete', $arg,array(),$this->wssecurity_text_header());
    }


    function GUID()
    {
        if (function_exists('com_create_guid') === true)
        {
            return trim(com_create_guid(), '{}');
        }

        return sprintf('%04X%04X-%04X-%04X-%04X-%04X%04X%04X', mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(16384, 20479), mt_rand(32768, 49151), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535));
    }

    public function getFunctions(){
       return $this->soap->__getFunctions();
    }

    public function getTypes(){
       return $this->soap->__getTypes();
    }



}


/*
 * Пример отправки
   public function SendTestPlan(){
        /*STATE	EIN	NDOC	NSDOC	SDOC	DOCTYPE	SURNAME	NAME	SECNAME	FINSTAT	BIRTHDAY	SEX	NPOLIS	SPOLIS	RGN1	RGN2	RGN3	STREET	HOUSE	HOUSELITER	CORPUS	FLAT	FLATLITER	LOCAL	LPUBASE	LPUBASE_U	LPUDENT	AGRNUM	INSURER	DATE_IN	DATE_CH	PENSION	D_START	D_MODIF	D_FIN	COUNTER	ENP	KLADRST	LPUCHIEF	TER	RAZDEL	SMOMODDATE	POLISDATE	POLISTYPE	DOCDATE	type_u
 0	NULL	744980	NULL	36 01	14	КАРГИН	ВАЛЕРИЙ	СЕРГЕЕВИЧ	1	1947-03-17 00:00:00.000	1	172164	ВМ	401	364	0	7	8	NULL	NULL	68	NULL	NULL	5113	4	5105	NULL	63002	NULL	NULL	008-529-811 58	NULL	2011-08-16 11:23:27.663	NULL	1	6376250832000198	NULL	5113	36	1	NULL	2003-12-08 00:00:00.000	1	NULL	NULL
$arg = array();
$arg['user_id'] = 2401;
$arg['guid'] = $this->tfoms->GUID();
$arg['disp_year'] = 2017;
$arg['disp_quarter'] = 1;
$arg['disp_type'] = 1;
$arg['disp_lpu'] = 502;
$arg['age'] = 57;
// $arg['lgg_code'] = 1;
// $arg['drcode'] = 2401;
//   $arg['speccode'] = 2401;
//   $arg['refusal_reason'] = 2401;
//   $arg['disp_start'] = '2017-02-01';
//   $arg['stage_1_result'] = '';
//    $arg['stage_2_result'] = '';
$arg['enp'] = '6356930839001091';

$result = $this->tfoms->disp_plan_create($arg);
if (is_soap_fault($result)) {
    trigger_error("SOAP Fault: (faultcode: {$result->faultcode}, faultstring: {$result->faultstring})", E_USER_ERROR);
}

print_r($result);
}

*/
