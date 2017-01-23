<?php
/**
 * Created by PhpStorm.
 * User: cod_llo
 * Date: 11.03.16
 * Time: 17:11
 */




class Ipre_model extends CI_Model
{
    public $cacheDB;
    public $srv224DB;

    public $PatientsCache = 'Test.VA4CPatients';
    public $PatientsSQL = '[vaccination2].[dbo].[VACD_Patient]';

    public $XMLPath = 'exe\XML';
    public $XMLPatientsPath = 'xml_patients';
    public $LPUPath = 'lpu';
    public $tfomsURL = '10.2.22.5:8788';
    public $patient_xml_table = 'ipre_xml';



    public function __construct()
    {
        $this->load->library('Simple_html_dom');
        $this->load->library('functions');

        $this->dbMySQL = $this->load->database('mysql', TRUE);
        //$this->srv224DB = $this->load->database('srv224', TRUE);
      //  $this->srvEreg = $this->load->database('srvEreg', TRUE);
        date_default_timezone_set('Europe/London');
        $this->load->helper('url');
        /*Загружаем библиотеку вставки в каше*/



        $this->load->model('patient_model');
        $this->load->model('auth_model');
        $today = date('d.m.Y');
        $this->makeDir($this->LPUPath.'\\'.$today);
        $this->LPUPath=$this->LPUPath.'\\'.$today;
    }



    /*Превращает node to array*/
    function getArray($node)
    {
        $array = false;

        if ($node->hasAttributes())
        {
            foreach ($node->attributes as $attr)
            {
                $array[$attr->nodeName] = $attr->nodeValue;
            }
        }

        if ($node->hasChildNodes())
        {
            if ($node->childNodes->length == 1)
            {
                $array[$node->firstChild->nodeName] = $node->firstChild->nodeValue;
            }
            else
            {
                foreach ($node->childNodes as $childNode)
                {
                    if ($childNode->nodeType != XML_TEXT_NODE)
                    {
                        $array[$childNode->nodeName][] = $this->getArray($childNode);
                    }
                }
            }
        }

        return $array;
    }

    function makeDir($path)
    {
        return is_dir($path) || mkdir($path);
    }


    /*выдает инфу из тфомса*/
    public function tfoms_search($arg)
    {
        $today = date('d.m.Y');

        if(!isset($arg['ENP'])) $arg['ENP']='';
        if(!isset($arg['SPOLIS'])) $arg['SPOLIS']='';
        if(!isset($arg['SNILS'])) $arg['SPOLIS']='';
        if(!isset($arg['NPOLIS'])) $arg['NPOLIS']='';
        if(!isset($arg['SDOC'])) $arg['SDOC']='';
        if(!isset($arg['NDOC'])) $arg['NDOC']='';
        if(!isset($arg['RGN1'])) $arg['RGN1']='';
        if(!isset($arg['STREET'])) $arg['STREET']='';
        if(!isset($arg['HOUSE'])) $arg['HOUSE']='';
        if(!isset($arg['FLAT'])) $arg['FLAT']='';
        if(!isset($arg['LPU'])) $arg['LPU']='';
        if(!isset($arg['SURNAME'])) $arg['SURNAME']='';
        else
        {
            $arg['SURNAME']=urlencode($arg['SURNAME']);
        }
        if(!isset($arg['NAME'])) $arg['NAME']='';
        else
        {
            $arg['NAME']=urlencode($arg['NAME']);
        }
        if(!isset($arg['SECNAME'])) $arg['SECNAME']='';
        else
        {
            $arg['SECNAME']=urlencode($arg['SECNAME']);
        }
        if(!isset($arg['BIRTHDAY'])) $arg['BIRTHDAY']=''; else
        {
            $arg['BIRTHDAY'] = strtotime($arg['BIRTHDAY']);
            $arg['BIRTHDAY'] = date('d.m.Y', $arg['BIRTHDAY']);
        }



        $url='http://'.$this->tfomsURL.'/pers/?';
        $fields='ENP='.$arg['ENP'].
        '&SPOLIS='.$arg['SPOLIS'].
        '&NPOLIS='.$arg['NPOLIS'].
        '&SS='.$arg['SNILS'].
        '&SDOC='.$arg['SDOC'].
        '&NDOC='.$arg['NDOC'].
        '&RGN1='.$arg['RGN1'].
        '&STREET='.$arg['STREET'].
        '&HOUSE='.$arg['HOUSE'].
        '&FLAT='.$arg['FLAT'].
        '&LPU='.$arg['LPU'].
        '&SURNAME='.$arg['SURNAME'].
        '&NAME='.$arg['NAME'].
        '&SECNAME='.$arg['SECNAME'].
        '&BIRTHDAY='.$arg['BIRTHDAY'].
        '&DATE_S='.date('d.m.Y').
        '&button=%D0%98%D1%81%D0%BA%D0%B0%D1%82%D1%8C&columns=4';


        $ch = curl_init();
        $timeout = 5;
        curl_setopt($ch, CURLOPT_URL, $url.$fields);
        //curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,true);
        //curl_setopt($ch, CURLOPT_POSTFIELDS,  $fields);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
        $html = curl_exec($ch);
        curl_close($ch);

        $patient =array();
        $this->simple_html_dom->load($html);
        $pp=$this->simple_html_dom->find('.element_td');
        /*todo сделать для нескольких результатов*/
        $i=0;
        foreach( $pp as $element)
        {
            $patient[]= $element->innertext;
            if($i>30) break;
        }
        $obj = new stdClass();
        $obj->LPU_CODE='20200';
        if(count($patient)==30)
        {
            $obj->ENP=$patient[0];
            $obj->SURNAME=$patient[1];
            $obj->NAME=$patient[2];
            $obj->SECNAME=$patient[3];
            $obj->BIRTHDAY=$patient[4];
            $obj->SEX=$patient[5];
            $obj->SDOC=$patient[6];
            $obj->NDOC=$patient[7];
            $obj->DOC_TYPE=$patient[8];
            $obj->DOC_DATE=$patient[9];
            $obj->N_POLIS=$patient[20];
            $obj->POLIS_TYPE=$patient[21];
            $obj->POLIS_DATE=$patient[22];
            $obj->LPU=$patient[24];
            $obj->LPU_NUCH=$patient[25];
            $obj->info=$patient;

            echo " TFOMS OK ";
        }
        else
        {
            $obj->LPU_CODE='20200';

        }

        return  $obj;

    }


    public function IncertLogCount($count)
    {
        $sql="insert into ipre_logs (`id`
            ,`insert_date`

            ,`files_count`

            )
            values (NULL
            ,NOW()
            ,'" . $count . "'
            )
            ";

        $query = $this->dbMySQL->query($sql);

    }

    /*загружает мастер-индексы пациентов и выстраивает базу их же*/
    public function LoadPatients()
    {

        /*Загружаем все данные XML из папки*/
        $files = scandir($this->XMLPath);

        /*Формируем текущею дату*/

        $today = date('d.m.Y');

        $patients_list=array();
        foreach($files as $folder)
        {
            /*Выбираем папку с текущей датой*/
            $pos  = strripos($folder, $today);

            if ($pos === false)
            {

            }
            else
            {
               /*залазим внутрь*/
                $files2=scandir($this->XMLPath.'\\'.$folder);
                foreach ($files2 as $folder2) {
                    if(($folder2!='..')and($folder2!='.'))
                    {
                        /*Загружаем XML в память*/
                        $patients_folder=scandir($this->XMLPath.'\\'.$folder."\\".$folder2);
                        $this->IncertLogCount(count($patients_folder)-2);
                        foreach($patients_folder as $patient_xml)
                        {
                            if(($patient_xml!='..')and($patient_xml!='.'))
                            {
                               // echo $patient_xml . "\n";
                                unset($p);
                                unset($xml);
                                $xmlstring = file_get_contents($this->XMLPath . '\\' . $folder . "\\" . $folder2 . "\\" . $patient_xml);
                                $xmlstring = str_replace("ct:", "", $xmlstring);
                                $xml = new SimpleXMLElement($xmlstring);


                                unset($doc);
                                $doc = new DOMDocument();
                                $doc->load($this->XMLPath . '\\' . $folder . "\\" . $folder2 . "\\" . $patient_xml);
                                unset($pp);
                                $pp = $this->getArray($doc->documentElement);
                                unset($patient);
                                $patient = new stdClass();
                                $patient->info_xml = $pp;
                                //if((isset($pp['Person'][0]['FIO'][0]['ct:SecondName'][0]['#text']))and(isset($pp['Person'][0]['BirthDate'][0]['#text'])))

                                $patient->lastName = '';
                                if (isset($xml->Person->FIO->LastName)) $patient->lastName = $xml->Person->FIO->LastName;

                                $patient->FirstName = '';
                                if (isset($xml->Person->FIO->FirstName)) $patient->FirstName = $xml->Person->FIO->FirstName;

                                $patient->middleName = '';
                                if (isset($xml->Person->FIO->SecondName)) $patient->middleName = $xml->Person->FIO->SecondName;

                                $patient->BirthDate = '';
                                if (isset($xml->Person->BirthDate)) $patient->BirthDate = $xml->Person->BirthDate;



                                //$FirstName = mb_convert_encoding($FirstName, "Windows-1251", "UTF-8");
                                //echo mb_convert_encoding($patient->lastName, "UTF-8", "Windows-1251");
                                // $patient->mip = $this->mpi_model->get('КАЗАНЦЕВ','ВЯЧЕСЛАВ','ПЕТРОВИЧ','1973-03-21');
                                /*  $patient->mip = $this->mpi_model->get(
                                      mb_convert_encoding($patient->lastName, "Windows-1251", "UTF-8"),
                                      mb_convert_encoding($patient->FirstName, "Windows-1251", "UTF-8"),
                                      mb_convert_encoding($patient->middleName, "Windows-1251", "UTF-8"),
                                      $patient->BirthDate);*/
                                $patient->mip = 0;


                                $arg['NAME'] = $patient->FirstName;
                                $arg['SECNAME'] = $patient->middleName;
                                $arg['SURNAME'] = $patient->lastName;
                                $arg['BIRTHDAY'] = $patient->BirthDate;


                                $patient->tfoms = $this->ipre_model->tfoms_search($arg);
                                $patient->lpuin = $patient->tfoms->LPU_CODE;

                                $this->makeDir($this->LPUPath . '\\' . $patient->lpuin);
                                $doc->save($this->LPUPath . '\\' . $patient->lpuin . "\\" . $patient_xml);

                                // $DevelopDate = strtotime( $xml->DevelopDate );
                                // $DevelopDate = date( 'd.m.Y', $DevelopDate );


                                $arg = array(
                                    'MIP' => 0,
                                    'LastName' => $patient->lastName,
                                    'FirstName' => $patient->FirstName,
                                    'SecondName' => $patient->middleName,
                                    'RegAddress' => $xml->Person->RegAddress->Value,
                                    'LPUCODE' => $patient->lpuin,
                                    'SNILS' => $xml->Person->SNILS,
                                    'DevelopDate' => $xml->DevelopDate,
                                    'ProtocolDate' => $xml->ProtocolDate,
                                    'BirthDate' => $patient->BirthDate,
                                    'NUMBER' => $xml->Number,
                                    'xml' => $xmlstring
                                );


                                echo $this->auth_model->AddUser($patient->lpuin);
                                echo $xml->Number.' ';
                                echo $this->functions->encodestring($patient->lastName).' ';
                                echo $this->functions->encodestring($patient->FirstName).' ';
                                echo $this->functions->encodestring($patient->middleName).' ';
                                $this->patient_model->insert($arg);
                                echo " \n\r";
                                echo " \n\r";
                                //echo $this->XMLPath . '/' . $folder . "/" . $folder2 . "/" . $patient_xml;
                                //unlink($this->XMLPath . '/' . $folder . "/" . $folder2 . "/" . $patient_xml);
                                //return $patients_list;
                                //$temp[0]['Person'][0]['FIO']

                            }

                        }

                    }
                }

              //  return $patients_list;

            }
        }
    }

    /*перешерстит все записи по тфмсу*/
    public function ResetTfoms()
    {
        $sql = "select * from ".$this->patient_model->patient_table;
        $query = $this->dbMySQL->query($sql);
        $row = $query->result_array();
        foreach ($row as $patient)
        {
            unset($arg);
            $arg=array();
            $arg['NAME'] = $patient['FirstName'];
            $arg['SECNAME'] = $patient['SecondName'];
            $arg['SURNAME'] = $patient['LastName'];
            $arg['BIRTHDAY'] = $patient['BirthDate'];

            $tfoms = $this->ipre_model->tfoms_search($arg);

            if($tfoms->LPU_CODE!='20200')
            {
                $this->dbMySQL->where('id', $patient['id']);
                $this->dbMySQL->update($this->patient_model->patient_table);
                echo "UPDATE";
            }
            echo $this->functions->encodestring($patient['FirstName']).' ';
            echo $this->functions->encodestring($patient['SecondName']).' ';
            echo $this->functions->encodestring($patient['LastName']).' ';
            echo $this->functions->encodestring($patient['BirthDate']).' ';
            echo " \n\r";
            unset($tfoms);

        }

    }


    function NormalizeSNILS($s)
    {
        $ss=explode("-",$s);

        if(count($ss)==3) {
            $sss=explode(" ",$ss[2]);

            return $ss[0]."-".$ss[1]."-".$sss[0]." ".$sss[1];
        }
        //else return $s;
    }


    /*выдает инфу из тфомса*/
    public function tfoms_search_new($arg)
    {
        $today = date('d.m.Y');

        if(!isset($arg['ENP'])) $arg['ENP']='';
        if(!isset($arg['SPOLIS'])) $arg['SPOLIS']='';
        if(!isset($arg['SNILS'])) $arg['SPOLIS']='';
        if(!isset($arg['NPOLIS'])) $arg['NPOLIS']='';
        if(!isset($arg['SDOC'])) $arg['SDOC']='';
        if(!isset($arg['NDOC'])) $arg['NDOC']='';
        if(!isset($arg['RGN1'])) $arg['RGN1']='';
        if(!isset($arg['STREET'])) $arg['STREET']='';
        if(!isset($arg['HOUSE'])) $arg['HOUSE']='';
        if(!isset($arg['FLAT'])) $arg['FLAT']='';
        if(!isset($arg['LPU'])) $arg['LPU']='';
        if(!isset($arg['SURNAME'])) $arg['SURNAME']='';
        else
        {
            $arg['SURNAME']=urlencode($arg['SURNAME']);
        }
        if(!isset($arg['NAME'])) $arg['NAME']='';
        else
        {
            $arg['NAME']=urlencode($arg['NAME']);
        }
        if(!isset($arg['SECNAME'])) $arg['SECNAME']='';
        else
        {
            $arg['SECNAME']=urlencode($arg['SECNAME']);
        }
        if(!isset($arg['BIRTHDAY'])) $arg['BIRTHDAY']=''; else
        {
            $arg['BIRTHDAY'] = strtotime($arg['BIRTHDAY']);
            $arg['BIRTHDAY'] = date('d.m.Y', $arg['BIRTHDAY']);
        }



        $url='http://'.$this->tfomsURL.'/pers/?';
        $fields='ENP='.$arg['ENP'].
            '&SPOLIS='.$arg['SPOLIS'].
            '&NPOLIS='.$arg['NPOLIS'].
            '&SS='.$arg['SNILS'].
            '&SDOC='.$arg['SDOC'].
            '&NDOC='.$arg['NDOC'].
            '&RGN1='.$arg['RGN1'].
            '&STREET='.$arg['STREET'].
            '&HOUSE='.$arg['HOUSE'].
            '&FLAT='.$arg['FLAT'].
            '&LPU='.$arg['LPU'].
            '&SURNAME='.$arg['SURNAME'].
            '&NAME='.$arg['NAME'].
            '&SECNAME='.$arg['SECNAME'].
            '&BIRTHDAY='.$arg['BIRTHDAY'].
            '&DATE_S='.date('d.m.Y').
            '&button=%D0%98%D1%81%D0%BA%D0%B0%D1%82%D1%8C&columns=4';


        $ch = curl_init();
        $timeout = 5;
        curl_setopt($ch, CURLOPT_URL, $url.$fields);
        //curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,true);
        //curl_setopt($ch, CURLOPT_POSTFIELDS,  $fields);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
        $html = curl_exec($ch);
        curl_close($ch);

        $patient =array();
        $this->simple_html_dom->load($html);
        $pp=$this->simple_html_dom->find('.element_td');
        /*todo сделать для нескольких результатов*/
        $i=0;
        foreach( $pp as $element)
        {
            $patient[]= $element->innertext;
            if($i>30) break;
        }
        $obj = new stdClass();
        $obj->LPU_CODE='20200';
        echo count($patient);
        if(count($patient)==32)
        {
            $obj->ENP=$patient[0];
            $obj->SURNAME=$patient[1];
            $obj->NAME=$patient[2];
            $obj->SECNAME=$patient[3];
            $obj->BIRTHDAY=$patient[4];
            $obj->SEX=$patient[5];
            $obj->SDOC=$patient[6];
            $obj->NDOC=$patient[7];
            $obj->DOC_TYPE=$patient[8];
            $obj->DOC_DATE=$patient[9];
            $obj->N_POLIS=$patient[20];
            $obj->POLIS_TYPE=$patient[21];
            $obj->POLIS_DATE=$patient[22];
            $obj->LPU=$patient[24];
            $obj->LPU_NUCH=$patient[25];
            $obj->info=$patient;
            $obj->LPU_CODE=explode(" ",$obj->LPU_NUCH);
            $obj->LPU_CODE=$obj->LPU_CODE[0];
            $obj->LPU_CODE = substr($obj->LPU_CODE, 1);
            $obj->LPU_CODE = substr($obj->LPU_CODE, 0,-1);



            echo " TFOMS OK ";
        }
        else
        {
            $obj->LPU_CODE='20200';

        }

        return  $obj;

    }

    /*перешерстит все записи по тфмсу по снилсу*/
    public function ResetTfomsBySNILS()
    {
        $sql = "select * from ".$this->patient_model->patient_table." ";
        $query = $this->dbMySQL->query($sql);
        $row = $query->result_array();
        foreach ($row as $patient)
        {
            unset($arg);
            $arg=array();

            $arg['SNILS'] = urlencode($this->NormalizeSNILS($patient['SNILS']));

            $tfoms = $this->tfoms_search_new($arg);


            if($tfoms->LPU_CODE!='20200')
            {
                $data=array();
                $data['LPUCODE']=$tfoms->LPU_CODE;
                $this->dbMySQL->where('id', $patient['id']);
                $this->dbMySQL->update($this->patient_model->patient_table,$data);
                echo "UPDATE";
            }
            echo $this->functions->encodestring($patient['FirstName']).' ';
            echo $this->functions->encodestring($patient['SecondName']).' ';
            echo $this->functions->encodestring($patient['LastName']).' ';

            echo $this->functions->encodestring($arg['SNILS']).' ';

            echo " \n\r";
            unset($tfoms);

        }
    }


    public function UpdateDevelopDate()
    {
        $sql="select * from ipre_xml";
        $query = $this->dbMySQL->query($sql);
        $qq = $query->result_array();
        foreach($qq as $xml_item)
        {
            $xml = new SimpleXMLElement($xml_item['xml']);
            if(isset($xml->DevelopDate))
            {
                echo $xml_item['id']." ".$xml->DevelopDate."\n";
                $sql_u="UPDATE ipre_xml SET DevelopDate ='".$xml->DevelopDate.' 00:00:00'."' where (id=".$xml_item['id'].")";
                $this->dbMySQL->query($sql_u);
            }
            else
            {
                echo $xml_item['id']." ".$xml->DevelopDate."\n";
                $sql_u="UPDATE ipre_xml SET DevelopDate =NOW() where (id=".$xml_item['id'].")";
                $this->dbMySQL->query($sql_u);
            }


        }

    }


    public function UpdateProtocolDate()
    {
        $sql="select * from ipre_xml";
        $query = $this->dbMySQL->query($sql);
        $qq = $query->result_array();
        foreach($qq as $xml_item)
        {
            $xml = new SimpleXMLElement($xml_item['xml']);
            if((isset($xml->ProtocolDate))and($xml->ProtocolDate!=''))
            {
                echo $xml_item['id']." ".$xml->ProtocolDate."\n";
                $sql_u="UPDATE ipre_xml SET ProtocolDate ='".$xml->ProtocolDate.' 00:00:00'."' where (id=".$xml_item['id'].")";
                $this->dbMySQL->query($sql_u);
            }
            else
            {
                echo $xml_item['id']." ".$xml->ProtocolDate."\n";
                $sql_u="UPDATE ipre_xml SET ProtocolDate =NOW() where (id=".$xml_item['id'].")";
                $this->dbMySQL->query($sql_u);
            }


        }

    }


    public function UpdatePatients()
    {
        $query = $this->dbMySQL->query("select * from ipre_xml");
        $res = $query->result_array();
        foreach($res as $r)
        {
            echo $r['LastName']." ".$r['FirstName']." ".$r['SecondName']."\n\r";
            $this->LoadSinglePatient2($r['xml']);
        }

    }



    /*Загружиает 1-го пациента*/
    /**
     * @param $xml - загруженный xml с помощью
     *  $xmlstring = file_get_contents($this->XMLPath . '\\' . $folder . "\\" . $folder2 . "\\" . $patient_xml);
        $xmlstring = str_replace("ct:", "", $xmlstring);
        $xml = new SimpleXMLElement($xmlstring);
     */

    public function  GetPatientsXML($patient_id)
    {
        $sql="select xml from ipre_xml where patient_id=".$patient_id;
        $query = $this->dbMySQL->query($sql);
        return $query->row_array();
    }

    public  function LoadSinglePatient2($xmlstring='')
    {
        $query = $this->dbMySQL->query("select * from ipre_patients");
        $res = $query->result_array();
        foreach ($res as $r) {
            unset($xmlstring);
            unset($xml);
            unset($res1);
            unset($sqlx);
            unset($patient);
            unset($query2);

            $sqlx="select xml from ipre_xml where patient_id=".$r['id'];
            $query2 = $this->dbMySQL->query($sqlx);
            $res1=$query2->row_array();
            $xmlstring=$res1['xml'];

            $xmlstring = str_replace("ct:", "", $xmlstring);
            $xml = new SimpleXMLElement($xmlstring);

            $patient = array();

            $patient['lastName'] = '' . "";
            if (isset($xml->Person->FIO->LastName)) $patient['lastName'] = $xml->Person->FIO->LastName . "";

            $patient['FirstName'] = '' . "";
            if (isset($xml->Person->FIO->FirstName)) $patient['FirstName'] = $xml->Person->FIO->FirstName . "";

            $patient['SecondName'] = '' . "";
            if (isset($xml->Person->FIO->SecondName)) $patient['SecondName'] = $xml->Person->FIO->SecondName . "";

            //$patient['BirthDate'] = '' . "";
            if (isset($xml->Person->BirthDate)) $patient['BirthDate'] = $xml->Person->BirthDate . "";

            $patient['SNILS'] = '' . "";
            if (isset($xml->Person->SNILS)) $patient['SNILS'] = $xml->Person->SNILS . "";

            $patient['RegAddress'] = '' . "";
            if (isset($xml->Person->RegAddress->Value)) $patient['RegAddress'] = $xml->Person->RegAddress->Value . "";

            $patient['RegAddress_Type'] = '' . "";
            if (isset($xml->Person->RegAddress->Type)) $patient['RegAddress_Type'] = $xml->Person->RegAddress->Type . "";

            $patient['RegAddress_Type'] = '' . "";
            if (isset($xml->Person->RegAddress->Type->Value)) $patient['RegAddress_Type'] = $xml->Person->RegAddress->Type->Value . "";

            $patient['RegAddress_ZipCode'] = '' . "";
            if (isset($xml->Person->RegAddress->Fields->ZipCode)) $patient['RegAddress_ZipCode'] = $xml->Person->RegAddress->Fields->ZipCode . "";

            $patient['RegAddress_Country'] = '' . "";
            if (isset($xml->Person->RegAddress->Fields->Country)) $patient['RegAddress_Country'] = $xml->Person->RegAddress->Fields->Country . "";

            $patient['RegAddress_TerritorySubjectID'] = '' . "";
            if (isset($xml->Person->RegAddress->Fields->TerritorySubjectID)) $patient['RegAddress_TerritorySubjectID'] = $xml->Person->RegAddress->Fields->TerritorySubjectID . "";

            $patient['RegAddress_TerritorySubjectName'] = '' . "";
            if (isset($xml->Person->RegAddress->Fields->TerritorySubjectName)) $patient['RegAddress_TerritorySubjectID'] = $xml->Person->RegAddress->Fields->TerritorySubjectName . "";

            $patient['RegAddress_PlaceTypeId'] = '' . "";
            if (isset($xml->Person->RegAddress->Fields->PlaceTypeId)) $patient['RegAddress_PlaceTypeId'] = $xml->Person->RegAddress->Fields->PlaceTypeId . "";

            $patient['RegAddress_PlaceTypeName'] = '' . "";
            if (isset($xml->Person->RegAddress->Fields->PlaceTypeName)) $patient['RegAddress_PlaceTypeName'] = $xml->Person->RegAddress->Fields->PlaceTypeName . "";

            $patient['RegAddress_PlaceKindId'] = '' . "";
            if (isset($xml->Person->RegAddress->Fields->PlaceKindId)) $patient['RegAddress_PlaceKindId'] = $xml->Person->RegAddress->Fields->PlaceKindId . "";

            $patient['RegAddress_PlaceKindName'] = '' . "";
            if (isset($xml->Person->RegAddress->Fields->PlaceKindName)) $patient['RegAddress_PlaceKindName'] = $xml->Person->RegAddress->Fields->PlaceKindName . "";

            $patient['RegAddress_Place'] = '' . "";
            if (isset($xml->Person->RegAddress->Fields->Place)) $patient['RegAddress_Place'] = $xml->Person->RegAddress->Fields->PlaceKindName . "";

            $patient['RegAddress_Street'] = '' . "";
            if (isset($xml->Person->RegAddress->Fields->Street)) $patient['RegAddress_Street'] = $xml->Person->RegAddress->Fields->Street . "";

            $patient['RegAddress_House'] = '' . "";
            if (isset($xml->Person->RegAddress->Fields->House)) $patient['RegAddress_House'] = $xml->Person->RegAddress->Fields->House . "";

            $patient['RegAddress_Appartment'] = '' . "";
            if (isset($xml->Person->RegAddress->Fields->Appartment)) $patient['RegAddress_Appartment'] = $xml->Person->RegAddress->Fields->Appartment . "";






            $patient['Buro_FullName'] = '' . "";
            if (isset($xml->Buro->FullName)) $patient['Buro_FullName'] = $xml->Buro->FullName . "";

            $patient['Recipient_Name'] = '' . "";
            if (isset($xml->Recipient->Name)) $patient['Recipient_Name'] = $xml->Recipient->Name . "";

            $patient['Recipient_Address'] = '' . "";
            if (isset($xml->Recipient->Address)) $patient['Recipient_Address'] = $xml->Recipient->Address . "";

            $patient['Recipient_RecipientType'] = '' . "";
            if (isset($xml->Recipient->RecipientType->Value)) $patient['Recipient_RecipientType'] = $xml->Recipient->RecipientType->Value . "";

            $patient['Number'] = '' . "";
            if (isset($xml->Number)) $patient['Number'] = $xml->Number . "";

            $patient['ProtocolNum'] = '' . "";
            if (isset($xml->ProtocolNum)) $patient['ProtocolNum'] = $xml->ProtocolNum . "";

            //$patient['ProtocolDate'] = '' . "";
            if (isset($xml->ProtocolDate)) {
                $patient['ProtocolDate'] = date('Y-m-d', strtotime($xml->ProtocolDate)) . "";
            }

            $patient['IsForChild'] = 1;
            if ((isset($xml->IsForChild)) and ($xml->IsForChild == 'false')) $patient['IsForChild'] = 0;

            $patient['Person_Id'] = '' . "";
            if (isset($xml->Person->Id)) $patient['Person_Id'] = $xml->Person->Id . "";

            $patient['Age_Years'] = '' . "";
            if (isset($xml->Person->Age->Years)) $patient['Age_Years'] = $xml->Person->Age->Years . "";

            $patient['Citizenship'] = '' . "";
            if (isset($xml->Person->Citizenship->Value)) $patient['Citizenship'] = $xml->Person->Citizenship->Value . "";

            $patient['LivingAddress'] = '' . "";
            if (isset($xml->Person->LivingAddress->Value)) $patient['LivingAddress'] = $xml->Person->LivingAddress->Value . "";

            $patient['LivingAddress_Type'] = '' . "";
            if (isset($xml->Person->LivingAddress->Type->Value)) $patient['LivingAddress_Type'] = $xml->Person->LivingAddress->Type->Value . "";

            $patient['LivingAddress_ZipCode'] = '' . "";
            if (isset($xml->Person->LivingAddress->Fields->ZipCode)) $patient['LivingAddress_ZipCode'] = $xml->Person->LivingAddress->Fields->ZipCode . "";

            $patient['LivingAddress_Country'] = '' . "";
            if (isset($xml->Person->LivingAddress->Fields->Country)) $patient['LivingAddress_Country'] = $xml->Person->LivingAddress->Fields->Country . "";

            $patient['LivingAddress_TerritorySubjectID'] = '' . "";
            if (isset($xml->Person->LivingAddress->Fields->TerritorySubjectID)) $patient['LivingAddress_TerritorySubjectID'] = $xml->Person->LivingAddress->Fields->TerritorySubjectID . "";


            $patient['LivingAddress_TerritorySubjectName'] = '' . "";
            if (isset($xml->Person->LivingAddress->Fields->TerritorySubjectName)) $patient['LivingAddress_TerritorySubjectName'] = $xml->Person->LivingAddress->Fields->TerritorySubjectName . "";

           /* $patient['LivingAddress_PlaceTypeId'] = '' . "";
            if (isset($xml->Person->LivingAddress->Fields->PlaceTypeId)) $patient['LivingAddress_PlaceTypeId'] = $xml->Person->LivingAddress->Fields->PlaceTypeId . "";*/

            $patient['LivingAddress_PlaceTypeName'] = 0;
            if (isset($xml->Person->LivingAddress->Fields->PlaceTypeName)) $patient['LivingAddress_PlaceTypeName'] = $xml->Person->LivingAddress->Fields->PlaceTypeName . "";


          /*  $patient['LivingAddress_PlaceKindId'] = '' . "";
            if (isset($xml->Person->LivingAddress->Fields->PlaceKindId)) $patient['LivingAddress_PlaceKindId'] = $xml->Person->LivingAddress->Fields->PlaceKindId . "";
*/

            $patient['LivingAddress_PlaceKindName'] = '' . "";
            if (isset($xml->Person->LivingAddress->Fields->PlaceKindName)) $patient['LivingAddress_PlaceKindName'] = $xml->Person->LivingAddress->Fields->PlaceKindName . "";

            $patient['LivingAddress_Place'] = '' . "";
            if (isset($xml->Person->LivingAddress->Fields->Place)) $patient['LivingAddress_Place'] = $xml->Person->LivingAddress->Fields->Place . "";

            $patient['LivingAddress_CityDistrict'] = '' . "";
            if (isset($xml->Person->LivingAddress->Fields->CityDistrict)) $patient['LivingAddress_CityDistrict'] = $xml->Person->LivingAddress->Fields->CityDistrict . "";

            $patient['LivingAddress_Street'] = '' . "";
            if (isset($xml->Person->LivingAddress->Fields->Street)) $patient['LivingAddress_Street'] = $xml->Person->LivingAddress->Fields->Street . "";

            $patient['LivingAddress_House'] = '' . "";
            if (isset($xml->Person->LivingAddress->Fields->House)) $patient['LivingAddress_House'] = $xml->Person->LivingAddress->Fields->House . "";

            $patient['LivingAddress_Appartment'] = '' . "";
            if (isset($xml->Person->LivingAddress->Fields->Appartment)) $patient['LivingAddress_Appartment'] = $xml->Person->LivingAddress->Fields->Appartment . "";

            $patient['Phone'] = '' . "";
            if (isset($xml->Person->Phones->Phone)) $patient['Phone'] = $xml->Person->Phones->Phone . "";


            $patient['IdentityDoc_Title'] = '' . "";
            if (isset($xml->Person->IdentityDoc->Title)) $patient['IdentityDoc_Title'] = $xml->Person->IdentityDoc->Title . "";

            $patient['IdentityDoc_Series'] = '' . "";
            if (isset($xml->Person->IdentityDoc->Series)) $patient['IdentityDoc_Series'] = $xml->Person->IdentityDoc->Series . "";

            $patient['IdentityDoc_Number'] = '' . "";
            if (isset($xml->Person->IdentityDoc->Number)) $patient['IdentityDoc_Number'] = $xml->Person->IdentityDoc->Number . "";

            $patient['IdentityDoc_Issuer'] = '' . "";
            if (isset($xml->Person->IdentityDoc->Issuer)) $patient['IdentityDoc_Issuer'] = $xml->Person->IdentityDoc->Issuer . "";

            //$patient['IdentityDoc_IssueDate'] = '';
            if (isset($xml->Person->IdentityDoc->IssueDate)) $patient['IdentityDoc_IssueDate'] = date('Y-m-d', strtotime($xml->Person->IdentityDoc->IssueDate)) . "";

            $patient['IsMale'] = 1;
            if ((isset($xml->Person->IsMale)) and ($xml->Person->IsMale == 'false'))
                $patient['IsMale'] = 0;


            $patient['LifeRestrictions_SelfCare'] = '' . "";
            if (isset($xml->LifeRestrictions->SelfCare)) $patient['LifeRestrictions_SelfCare'] = $xml->LifeRestrictions->SelfCare . "";

            $patient['LifeRestrictions_Moving'] = '' . "";
            if (isset($xml->LifeRestrictions->Moving)) $patient['LifeRestrictions_Moving'] = $xml->LifeRestrictions->Moving . "";

            $patient['LifeRestrictions_Orientation'] = '' . "";
            if (isset($xml->LifeRestrictions->Orientation)) $patient['LifeRestrictions_Orientation'] = $xml->LifeRestrictions->Orientation . "";

            $patient['LifeRestrictions_Communication'] = '' . "";
            if (isset($xml->LifeRestrictions->Communication)) $patient['LifeRestrictions_Communication'] = $xml->LifeRestrictions->Communication . "";

            $patient['LifeRestrictions_Learn'] = '' . "";
            if (isset($xml->LifeRestrictions->Learn)) $patient['LifeRestrictions_Learn'] = $xml->LifeRestrictions->Learn . "";

            $patient['LifeRestrictions_Work'] = '' . "";
            if (isset($xml->LifeRestrictions->Work)) $patient['LifeRestrictions_Work'] = $xml->LifeRestrictions->Work . "";

            $patient['LifeRestrictions_BehaviorControl'] = '' . "";
            if (isset($xml->LifeRestrictions->BehaviorControl)) $patient['LifeRestrictions_BehaviorControl'] = $xml->LifeRestrictions->BehaviorControl . "";


            $patient['IsFirst'] = 1;
            if ((isset($xml->IsFirst)) and ($xml->IsFirst == 'false'))
                $patient['IsFirst'] = 0;


            //$patient['EndDate'] = '' . "";
            if (isset($xml->EndDate)) {
                $patient['EndDate'] = date('Y-m-d', strtotime($xml->EndDate)) . "";
            }

            //$patient['IssueDate'] = '' . "";
            if (isset($xml->IssueDate)) {
                $patient['IssueDate'] = date('Y-m-d', strtotime($xml->IssueDate)) . "";
            }

            $patient['MedSection_EventGroups'] = json_encode(array()) . "";
            if (isset($xml->MedSection->EventGroups)) {
                $patient['MedSection_EventGroups'] = json_encode($xml->MedSection->EventGroups) . "";
            }

            $patient['MedSection_PrognozResult'] = json_encode(array()) . "";
            if (isset($xml->MedSection->PrognozResult)) {
                $patient['MedSection_PrognozResult'] = json_encode($xml->MedSection->PrognozResult) . "";
            }

            $patient['SenderMedOrgName'] = '' . "";
            if (isset($xml->MedSection->SenderMedOrgName)) $patient['SenderMedOrgName'] = $xml->MedSection->SenderMedOrgName . "";

            $patient['RequiredHelp'] = '' . "";
            if (isset($xml->RequiredHelp)) $patient['RequiredHelp'] = json_encode($xml->RequiredHelp) . "";

            $patient['IsAgreed'] = 1;
            if ((isset($xml->IsAgreed)) and ($xml->IsAgreed == 'false'))
                $patient['IsAgreed'] = 0;

            $patient['IsRepresentativeSign'] = 1;
            if ((isset($xml->IsRepresentativeSign)) and ($xml->IsRepresentativeSign == 'false'))
                $patient['IsRepresentativeSign'] = 0;

            $patient['FIOHead_LastName'] = '' . "";
            if (isset($xml->FIOHead->LastName)) $patient['FIOHead_LastName'] = $xml->FIOHead->LastName . "";

            $patient['FIOHead_FirstName'] = '' . "";
            if (isset($xml->FIOHead->FirstName)) $patient['FIOHead_FirstName'] = $xml->FIOHead->FirstName . "";

            $patient['FIOHead_SecondName'] = '' . "";
            if (isset($xml->FIOHead->SecondName)) $patient['FIOHead_SecondName'] = $xml->FIOHead->SecondName . "";

            echo $this->functions->encodestring($r['id'].$r['LastName']." ".$r['FirstName']." ".$r['FirstName'])."\r\n";

            $this->dbMySQL->reset_query();
            $this->dbMySQL->where('id', $r['id']);
            $this->dbMySQL->update('ipre_patients', $patient);

        }
    }


    public  function IncertPatient2($xmlstring='',$patient_xml)
    {
        if(true)
        {
            unset($patient);
            unset($xml);


            $xmlstring = str_replace("ct:", "", $xmlstring);
            $xml = new SimpleXMLElement($xmlstring);


            $patient = array();

            $patient['lastName'] = '' . "";
            if (isset($xml->Person->FIO->LastName)) $patient['lastName'] = $xml->Person->FIO->LastName . "";

            $patient['FirstName'] = '' . "";
            if (isset($xml->Person->FIO->FirstName)) $patient['FirstName'] = $xml->Person->FIO->FirstName . "";

            $patient['SecondName'] = '' . "";
            if (isset($xml->Person->FIO->SecondName)) $patient['SecondName'] = $xml->Person->FIO->SecondName . "";

            //$patient['BirthDate'] = '' . "";
            if (isset($xml->Person->BirthDate)) $patient['BirthDate'] = $xml->Person->BirthDate . "";

            $patient['SNILS'] = '' . "";
            if (isset($xml->Person->SNILS)) $patient['SNILS'] = $xml->Person->SNILS . "";

            $patient['RegAddress'] = '' . "";
            if (isset($xml->Person->RegAddress->Value)) $patient['RegAddress'] = $xml->Person->RegAddress->Value . "";

            $patient['RegAddress_Type'] = '' . "";
            if (isset($xml->Person->RegAddress->Type)) $patient['RegAddress_Type'] = $xml->Person->RegAddress->Type . "";

            $patient['Buro_FullName'] = '' . "";
            if (isset($xml->Buro->FullName)) $patient['Buro_FullName'] = $xml->Buro->FullName . "";

            $patient['Recipient_Name'] = '' . "";
            if (isset($xml->Recipient->Name)) $patient['Recipient_Name'] = $xml->Recipient->Name . "";

            $patient['Recipient_Address'] = '' . "";
            if (isset($xml->Recipient->Address)) $patient['Recipient_Address'] = $xml->Recipient->Address . "";

            $patient['Recipient_RecipientType'] = '' . "";
            if (isset($xml->Recipient->RecipientType->Value)) $patient['Recipient_RecipientType'] = $xml->Recipient->RecipientType->Value . "";

            $patient['Number'] = '' . "";
            if (isset($xml->Number)) $patient['Number'] = $xml->Number . "";

            $patient['ProtocolNum'] = '' . "";
            if (isset($xml->ProtocolNum)) $patient['ProtocolNum'] = $xml->ProtocolNum . "";

            //$patient['ProtocolDate'] = '' . "";
            if (isset($xml->ProtocolDate)) {
                $patient['ProtocolDate'] = date('Y-m-d', strtotime($xml->ProtocolDate)) . "";
            }

            $patient['IsForChild'] = 1;
            if ((isset($xml->IsForChild)) and ($xml->IsForChild == 'false')) $patient['IsForChild'] = 0;

            $patient['Person_Id'] = '' . "";
            if (isset($xml->Person->Id)) $patient['Person_Id'] = $xml->Person->Id . "";

            $patient['Age_Years'] = '' . "";
            if (isset($xml->Person->Age->Years)) $patient['Age_Years'] = $xml->Person->Age->Years . "";

            $patient['Citizenship'] = '' . "";
            if (isset($xml->Person->Citizenship->Value)) $patient['Citizenship'] = $xml->Person->Citizenship->Value . "";

            $patient['LivingAddress'] = '' . "";
            if (isset($xml->Person->LivingAddress->Value)) $patient['LivingAddress'] = $xml->Person->LivingAddress->Value . "";

            $patient['LivingAddress_Type'] = '' . "";
            if (isset($xml->Person->LivingAddress->Type->Value)) $patient['LivingAddress_Type'] = $xml->Person->LivingAddress->Type->Value . "";

            $patient['LivingAddress_ZipCode'] = '' . "";
            if (isset($xml->Person->LivingAddress->Fields->ZipCode)) $patient['LivingAddress_ZipCode'] = $xml->Person->LivingAddress->Fields->ZipCode . "";

            $patient['LivingAddress_Country'] = '' . "";
            if (isset($xml->Person->LivingAddress->Fields->Country)) $patient['LivingAddress_Country'] = $xml->Person->LivingAddress->Fields->Country . "";

            $patient['LivingAddress_TerritorySubjectID'] = '' . "";
            if (isset($xml->Person->LivingAddress->Fields->TerritorySubjectID)) $patient['LivingAddress_TerritorySubjectID'] = $xml->Person->LivingAddress->Fields->TerritorySubjectID . "";


            $patient['LivingAddress_TerritorySubjectName'] = '' . "";
            if (isset($xml->Person->LivingAddress->Fields->TerritorySubjectName)) $patient['LivingAddress_TerritorySubjectName'] = $xml->Person->LivingAddress->Fields->TerritorySubjectName . "";

            /* $patient['LivingAddress_PlaceTypeId'] = '' . "";
             if (isset($xml->Person->LivingAddress->Fields->PlaceTypeId)) $patient['LivingAddress_PlaceTypeId'] = $xml->Person->LivingAddress->Fields->PlaceTypeId . "";*/

            $patient['LivingAddress_PlaceTypeName'] = 0;
            if (isset($xml->Person->LivingAddress->Fields->PlaceTypeName)) $patient['LivingAddress_PlaceTypeName'] = $xml->Person->LivingAddress->Fields->PlaceTypeName . "";


            /*  $patient['LivingAddress_PlaceKindId'] = '' . "";
              if (isset($xml->Person->LivingAddress->Fields->PlaceKindId)) $patient['LivingAddress_PlaceKindId'] = $xml->Person->LivingAddress->Fields->PlaceKindId . "";
  */

            $patient['LivingAddress_PlaceKindName'] = '' . "";
            if (isset($xml->Person->LivingAddress->Fields->PlaceKindName)) $patient['LivingAddress_PlaceKindName'] = $xml->Person->LivingAddress->Fields->PlaceKindName . "";

            $patient['LivingAddress_Place'] = '' . "";
            if (isset($xml->Person->LivingAddress->Fields->Place)) $patient['LivingAddress_Place'] = $xml->Person->LivingAddress->Fields->Place . "";

            $patient['LivingAddress_CityDistrict'] = '' . "";
            if (isset($xml->Person->LivingAddress->Fields->CityDistrict)) $patient['LivingAddress_CityDistrict'] = $xml->Person->LivingAddress->Fields->CityDistrict . "";

            $patient['LivingAddress_Street'] = '' . "";
            if (isset($xml->Person->LivingAddress->Fields->Street)) $patient['LivingAddress_Street'] = $xml->Person->LivingAddress->Fields->Street . "";

            $patient['LivingAddress_House'] = '' . "";
            if (isset($xml->Person->LivingAddress->Fields->House)) $patient['LivingAddress_House'] = $xml->Person->LivingAddress->Fields->House . "";

            $patient['LivingAddress_Appartment'] = '' . "";
            if (isset($xml->Person->LivingAddress->Fields->Appartment)) $patient['LivingAddress_Appartment'] = $xml->Person->LivingAddress->Fields->Appartment . "";

            $patient['Phone'] = '' . "";
            if (isset($xml->Person->Phones->Phone)) $patient['Phone'] = $xml->Person->Phones->Phone . "";


            $patient['IdentityDoc_Title'] = '' . "";
            if (isset($xml->Person->IdentityDoc->Title)) $patient['IdentityDoc_Title'] = $xml->Person->IdentityDoc->Title . "";

            $patient['IdentityDoc_Series'] = '' . "";
            if (isset($xml->Person->IdentityDoc->Series)) $patient['IdentityDoc_Series'] = $xml->Person->IdentityDoc->Series . "";

            $patient['IdentityDoc_Number'] = '' . "";
            if (isset($xml->Person->IdentityDoc->Number)) $patient['IdentityDoc_Number'] = $xml->Person->IdentityDoc->Number . "";

            $patient['IdentityDoc_Issuer'] = '' . "";
            if (isset($xml->Person->IdentityDoc->Issuer)) $patient['IdentityDoc_Issuer'] = $xml->Person->IdentityDoc->Issuer . "";

            //$patient['IdentityDoc_IssueDate'] = '';
            if (isset($xml->Person->IdentityDoc->IssueDate)) $patient['IdentityDoc_IssueDate'] = date('Y-m-d', strtotime($xml->Person->IdentityDoc->IssueDate)) . "";

            $patient['IsMale'] = 1;
            if ((isset($xml->Person->IsMale)) and ($xml->Person->IsMale == 'false'))
                $patient['IsMale'] = 0;


            $patient['LifeRestrictions_SelfCare'] = '' . "";
            if (isset($xml->LifeRestrictions->SelfCare)) $patient['LifeRestrictions_SelfCare'] = $xml->LifeRestrictions->SelfCare . "";

            $patient['LifeRestrictions_Moving'] = '' . "";
            if (isset($xml->LifeRestrictions->Moving)) $patient['LifeRestrictions_Moving'] = $xml->LifeRestrictions->Moving . "";

            $patient['LifeRestrictions_Orientation'] = '' . "";
            if (isset($xml->LifeRestrictions->Orientation)) $patient['LifeRestrictions_Orientation'] = $xml->LifeRestrictions->Orientation . "";

            $patient['LifeRestrictions_Communication'] = '' . "";
            if (isset($xml->LifeRestrictions->Communication)) $patient['LifeRestrictions_Communication'] = $xml->LifeRestrictions->Communication . "";

            $patient['LifeRestrictions_Learn'] = '' . "";
            if (isset($xml->LifeRestrictions->Learn)) $patient['LifeRestrictions_Learn'] = $xml->LifeRestrictions->Learn . "";

            $patient['LifeRestrictions_Work'] = '' . "";
            if (isset($xml->LifeRestrictions->Work)) $patient['LifeRestrictions_Work'] = $xml->LifeRestrictions->Work . "";

            $patient['LifeRestrictions_BehaviorControl'] = '' . "";
            if (isset($xml->LifeRestrictions->BehaviorControl)) $patient['LifeRestrictions_BehaviorControl'] = $xml->LifeRestrictions->BehaviorControl . "";


            $patient['IsFirst'] = 1;
            if ((isset($xml->IsFirst)) and ($xml->IsFirst == 'false'))
                $patient['IsFirst'] = 0;


            //$patient['EndDate'] = '' . "";
            if (isset($xml->EndDate)) {
                $patient['EndDate'] = date('Y-m-d', strtotime($xml->EndDate)) . "";
            }

            //$patient['IssueDate'] = '' . "";
            if (isset($xml->IssueDate)) {
                $patient['IssueDate'] = date('Y-m-d', strtotime($xml->IssueDate)) . "";
            }

            $patient['MedSection_EventGroups'] = json_encode(array()) . "";
            if (isset($xml->MedSection->EventGroups)) {
                $patient['MedSection_EventGroups'] = json_encode($xml->MedSection->EventGroups) . "";
            }

            $patient['MedSection_PrognozResult'] = json_encode(array()) . "";
            if (isset($xml->MedSection->PrognozResult)) {
                $patient['MedSection_PrognozResult'] = json_encode($xml->MedSection->PrognozResult) . "";
            }

            $patient['SenderMedOrgName'] = '' . "";
            if (isset($xml->MedSection->SenderMedOrgName)) $patient['SenderMedOrgName'] = $xml->MedSection->SenderMedOrgName . "";

            $patient['RequiredHelp'] = '' . "";
            if (isset($xml->RequiredHelp)) $patient['RequiredHelp'] = json_encode($xml->RequiredHelp) . "";

            $patient['IsAgreed'] = 1;
            if ((isset($xml->IsAgreed)) and ($xml->IsAgreed == 'false'))
                $patient['IsAgreed'] = 0;

            $patient['IsRepresentativeSign'] = 1;
            if ((isset($xml->IsRepresentativeSign)) and ($xml->IsRepresentativeSign == 'false'))
                $patient['IsRepresentativeSign'] = 0;

            $patient['FIOHead_LastName'] = '' . "";
            if (isset($xml->FIOHead->LastName)) $patient['FIOHead_LastName'] = $xml->FIOHead->LastName . "";

            $patient['FIOHead_FirstName'] = '' . "";
            if (isset($xml->FIOHead->FirstName)) $patient['FIOHead_FirstName'] = $xml->FIOHead->FirstName . "";

            $patient['FIOHead_SecondName'] = '' . "";
            if (isset($xml->FIOHead->SecondName)) $patient['FIOHead_SecondName'] = $xml->FIOHead->SecondName . "";

            $patient['xml_file']= $patient_xml;
            $patient_id=0;
            //$patient['BirthDate'] = '' . "";
            if (isset($xml->Person->BirthDate)) $patient['BirthDate'] = $xml->Person->BirthDate . "";

            if(isset($xml->Person->SNILS))
            {
                /*обновляем по снилсу*/
                $patient_id=$this->GetPatientBySnils($xml->Person->SNILS);
                if($patient_id==0)
                {
                    $this->dbMySQL->reset_query();
                    $this->dbMySQL->insert($this->patient_model->patient_table, $patient);
                    $patient_id=$this->dbMySQL->insert_id();

                    /*Вставлям xml*/
                    $arg=array();
                    $arg['insert_date']=date('Y-m-d');
                    $arg['xml']=$xmlstring;
                    $arg['patient_id']=$patient_id;
                    $this->dbMySQL->insert($this->patient_xml_table, $arg);


                    unset($arg);
                    $arg=array();
                    /*Ищем по тфомсу*/
                    $arg['SNILS'] = urlencode($this->NormalizeSNILS($xml->Person->SNILS));
                    $tfoms = $this->tfoms_search_new($arg);
                    if($tfoms->LPU_CODE!='20200')
                    {
                        $data=array();
                        $data['LPUCODE']=$tfoms->LPU_CODE;
                        $this->dbMySQL->where('id', $patient_id);
                        $this->dbMySQL->update($this->patient_model->patient_table,$data);
                        echo "UPDATE";
                    }
                }
                else
                {
                    $this->dbMySQL->reset_query();
                    $this->dbMySQL->where('id', $patient_id);
                    $this->dbMySQL->update('ipre_patients', $patient);
                }
            }
            elseif((isset($xml->Person->FIO->LastName))and(isset($xml->Person->FIO->FirstName))and(isset($xml->Person->FIO->SecondName))and
                (isset($xml->Person->BirthDate)))
            {
                $patient_id=$this->GetPatientByFIOB($xml->Person->FIO->LastName,$xml->Person->FIO->FirstName,$xml->Person->FIO->SecondName
                    ,$xml->Person->BirthDate);
                if($patient_id==0)
                {
                    $this->dbMySQL->reset_query();
                    $this->dbMySQL->insert($this->patient_model->patient_table, $patient);
                    $patient_id=$this->dbMySQL->insert_id();

                    /*Вставлям xml*/
                    $arg=array();
                    $arg['insert_date']=date('Y-m-d');
                    $arg['xml']=$xmlstring;
                    $arg['patient_id']=$patient_id;
                    //$this->dbMySQL->insert($this->patient_xml_table, $arg);
                }
                else
                {
                    $this->dbMySQL->reset_query();
                    $this->dbMySQL->where('id', $patient_id);
                    $this->dbMySQL->update('ipre_patients', $patient);
                }
            }
            else
            {
                $this->dbMySQL->reset_query();
                $this->dbMySQL->insert($this->patient_model->patient_table, $patient);
                $patient_id=$this->dbMySQL->insert_id();
                /*Вставлям xml*/
                $arg=array();
                $arg['insert_date']=date('Y-m-d');
                $arg['xml']=$xmlstring;
                $arg['patient_id']=$patient_id;
                $this->dbMySQL->insert($this->patient_xml_table, $arg);
            }

            echo $this->functions->encodestring($patient_id." ".$xml->Person->FIO->LastName
                    ." ".$xml->Person->FIO->FirstName." ".$xml->Person->FIO->SecondName)."\r\n";
        }




    }


    public function GetPatientByFIOB($LastName,$FirstName,$SecondName,$BirthDate)
    {
        $BirthDate=date('Y-m-d', strtotime($BirthDate));
        $this->dbMySQL->reset_query();
        $query = $this->dbMySQL->get_where('ipre_patients',
            array('LastName' => $LastName,'FirstName' => $FirstName,'SecondName' => $SecondName,'BirthDate' => $BirthDate));
        $q = $query->row_array();
        if(isset($q)) return $q['id']; else return 0;
    }

    public function GetPatientBySnils($SNILS)
    {
        $this->dbMySQL->reset_query();
        $query = $this->dbMySQL->get_where('ipre_patients',
            array('SNILS' => $SNILS));
        $q = $query->row_array();
        if(isset($q)) return $q['id']; else return 0;
    }

    /*загружает мастер-индексы пациентов и выстраивает базу их же*/
    public function LoadPatients2()
    {

        /*Загружаем все данные XML из папки*/
        $files = scandir($this->XMLPath);

        /*Формируем текущею дату*/

        $today = date('d.m.Y');

        $patients_list=array();
        foreach($files as $folder)
        {
            /*Выбираем папку с текущей датой*/
            $pos  = strripos($folder, $today);

            if ($pos === false)
            {

            }
            else
            {
                /*залазим внутрь*/
                $files2=scandir($this->XMLPath.'\\'.$folder);
                foreach ($files2 as $folder2) {
                    if(($folder2!='..')and($folder2!='.'))
                    {
                        /*Загружаем XML в память*/
                        $patients_folder=scandir($this->XMLPath.'\\'.$folder."\\".$folder2);
                        $this->IncertLogCount(count($patients_folder)-2);
                        foreach($patients_folder as $patient_xml)
                        {
                            if(($patient_xml!='..')and($patient_xml!='.'))
                            {
                                // echo $patient_xml . "\n";
                                unset($p);
                                unset($xml);
                                unset($xmlstring);
                                $xmlstring = file_get_contents($this->XMLPath . '\\' . $folder . "\\" . $folder2 . "\\" . $patient_xml);
                                /*Копируем файл пациента в папку*/
                                if (!copy($this->XMLPath . '\\' . $folder . "\\" . $folder2 . "\\" . $patient_xml
                                    , $this->XMLPatientsPath . '\\'. $patient_xml
                                )) {
                                    echo "Cant copy patient XML File...\n";
                                }
                                //$this->IncertPatient2($xmlstring,$patient_xml);
                                /*пациент*/
                                if(true)
                                {
                                    unset($patient);
                                    unset($xml);

                                    $xmlstring = str_replace("ct:", "", $xmlstring);
                                    $xml = new SimpleXMLElement($xmlstring);


                                    $patient = array();

                                    $patient['lastName'] = '' . "";
                                    if (isset($xml->Person->FIO->LastName)) $patient['lastName'] = $xml->Person->FIO->LastName . "";

                                    $patient['FirstName'] = '' . "";
                                    if (isset($xml->Person->FIO->FirstName)) $patient['FirstName'] = $xml->Person->FIO->FirstName . "";

                                    $patient['SecondName'] = '' . "";
                                    if (isset($xml->Person->FIO->SecondName)) $patient['SecondName'] = $xml->Person->FIO->SecondName . "";

                                    //$patient['BirthDate'] = '' . "";
                                    if (isset($xml->Person->BirthDate)) $patient['BirthDate'] = $xml->Person->BirthDate . "";

                                    $patient['SNILS'] = '' . "";
                                    if (isset($xml->Person->SNILS)) $patient['SNILS'] = $xml->Person->SNILS . "";

                                    $patient['RegAddress'] = '' . "";
                                    if (isset($xml->Person->RegAddress->Value)) $patient['RegAddress'] = $xml->Person->RegAddress->Value . "";

                                    $patient['RegAddress_Type'] = '' . "";
                                    if (isset($xml->Person->RegAddress->Type)) $patient['RegAddress_Type'] = $xml->Person->RegAddress->Type . "";

                                    $patient['Buro_FullName'] = '' . "";
                                    if (isset($xml->Buro->FullName)) $patient['Buro_FullName'] = $xml->Buro->FullName . "";

                                    $patient['Recipient_Name'] = '' . "";
                                    if (isset($xml->Recipient->Name)) $patient['Recipient_Name'] = $xml->Recipient->Name . "";

                                    $patient['Recipient_Address'] = '' . "";
                                    if (isset($xml->Recipient->Address)) $patient['Recipient_Address'] = $xml->Recipient->Address . "";

                                    $patient['Recipient_RecipientType'] = '' . "";
                                    if (isset($xml->Recipient->RecipientType->Value)) $patient['Recipient_RecipientType'] = $xml->Recipient->RecipientType->Value . "";

                                    $patient['Number'] = '' . "";
                                    if (isset($xml->Number)) $patient['Number'] = $xml->Number . "";

                                    $patient['ProtocolNum'] = '' . "";
                                    if (isset($xml->ProtocolNum)) $patient['ProtocolNum'] = $xml->ProtocolNum . "";

                                    //$patient['ProtocolDate'] = '' . "";
                                    if (isset($xml->ProtocolDate)) {
                                        $patient['ProtocolDate'] = date('Y-m-d', strtotime($xml->ProtocolDate)) . "";
                                    }

                                    $patient['IsForChild'] = 1;
                                    if ((isset($xml->IsForChild)) and ($xml->IsForChild == 'false')) $patient['IsForChild'] = 0;

                                    $patient['Person_Id'] = '' . "";
                                    if (isset($xml->Person->Id)) $patient['Person_Id'] = $xml->Person->Id . "";

                                    $patient['Age_Years'] = '' . "";
                                    if (isset($xml->Person->Age->Years)) $patient['Age_Years'] = $xml->Person->Age->Years . "";

                                    $patient['Citizenship'] = '' . "";
                                    if (isset($xml->Person->Citizenship->Value)) $patient['Citizenship'] = $xml->Person->Citizenship->Value . "";

                                    $patient['LivingAddress'] = '' . "";
                                    if (isset($xml->Person->LivingAddress->Value)) $patient['LivingAddress'] = $xml->Person->LivingAddress->Value . "";

                                    $patient['LivingAddress_Type'] = '' . "";
                                    if (isset($xml->Person->LivingAddress->Type->Value)) $patient['LivingAddress_Type'] = $xml->Person->LivingAddress->Type->Value . "";

                                    $patient['LivingAddress_ZipCode'] = '' . "";
                                    if (isset($xml->Person->LivingAddress->Fields->ZipCode)) $patient['LivingAddress_ZipCode'] = $xml->Person->LivingAddress->Fields->ZipCode . "";

                                    $patient['LivingAddress_Country'] = '' . "";
                                    if (isset($xml->Person->LivingAddress->Fields->Country)) $patient['LivingAddress_Country'] = $xml->Person->LivingAddress->Fields->Country . "";

                                    $patient['LivingAddress_TerritorySubjectID'] = '' . "";
                                    if (isset($xml->Person->LivingAddress->Fields->TerritorySubjectID)) $patient['LivingAddress_TerritorySubjectID'] = $xml->Person->LivingAddress->Fields->TerritorySubjectID . "";


                                    $patient['LivingAddress_TerritorySubjectName'] = '' . "";
                                    if (isset($xml->Person->LivingAddress->Fields->TerritorySubjectName)) $patient['LivingAddress_TerritorySubjectName'] = $xml->Person->LivingAddress->Fields->TerritorySubjectName . "";

                                    /* $patient['LivingAddress_PlaceTypeId'] = '' . "";
                                     if (isset($xml->Person->LivingAddress->Fields->PlaceTypeId)) $patient['LivingAddress_PlaceTypeId'] = $xml->Person->LivingAddress->Fields->PlaceTypeId . "";*/

                                    $patient['LivingAddress_PlaceTypeName'] = 0;
                                    if (isset($xml->Person->LivingAddress->Fields->PlaceTypeName)) $patient['LivingAddress_PlaceTypeName'] = $xml->Person->LivingAddress->Fields->PlaceTypeName . "";


                                    /*  $patient['LivingAddress_PlaceKindId'] = '' . "";
                                      if (isset($xml->Person->LivingAddress->Fields->PlaceKindId)) $patient['LivingAddress_PlaceKindId'] = $xml->Person->LivingAddress->Fields->PlaceKindId . "";
                          */

                                    $patient['LivingAddress_PlaceKindName'] = '' . "";
                                    if (isset($xml->Person->LivingAddress->Fields->PlaceKindName)) $patient['LivingAddress_PlaceKindName'] = $xml->Person->LivingAddress->Fields->PlaceKindName . "";

                                    $patient['LivingAddress_Place'] = '' . "";
                                    if (isset($xml->Person->LivingAddress->Fields->Place)) $patient['LivingAddress_Place'] = $xml->Person->LivingAddress->Fields->Place . "";

                                    $patient['LivingAddress_CityDistrict'] = '' . "";
                                    if (isset($xml->Person->LivingAddress->Fields->CityDistrict)) $patient['LivingAddress_CityDistrict'] = $xml->Person->LivingAddress->Fields->CityDistrict . "";

                                    $patient['LivingAddress_Street'] = '' . "";
                                    if (isset($xml->Person->LivingAddress->Fields->Street)) $patient['LivingAddress_Street'] = $xml->Person->LivingAddress->Fields->Street . "";

                                    $patient['LivingAddress_House'] = '' . "";
                                    if (isset($xml->Person->LivingAddress->Fields->House)) $patient['LivingAddress_House'] = $xml->Person->LivingAddress->Fields->House . "";

                                    $patient['LivingAddress_Appartment'] = '' . "";
                                    if (isset($xml->Person->LivingAddress->Fields->Appartment)) $patient['LivingAddress_Appartment'] = $xml->Person->LivingAddress->Fields->Appartment . "";

                                    $patient['Phone'] = '' . "";
                                    if (isset($xml->Person->Phones->Phone)) $patient['Phone'] = $xml->Person->Phones->Phone . "";


                                    $patient['IdentityDoc_Title'] = '' . "";
                                    if (isset($xml->Person->IdentityDoc->Title)) $patient['IdentityDoc_Title'] = $xml->Person->IdentityDoc->Title . "";

                                    $patient['IdentityDoc_Series'] = '' . "";
                                    if (isset($xml->Person->IdentityDoc->Series)) $patient['IdentityDoc_Series'] = $xml->Person->IdentityDoc->Series . "";

                                    $patient['IdentityDoc_Number'] = '' . "";
                                    if (isset($xml->Person->IdentityDoc->Number)) $patient['IdentityDoc_Number'] = $xml->Person->IdentityDoc->Number . "";

                                    $patient['IdentityDoc_Issuer'] = '' . "";
                                    if (isset($xml->Person->IdentityDoc->Issuer)) $patient['IdentityDoc_Issuer'] = $xml->Person->IdentityDoc->Issuer . "";

                                    //$patient['IdentityDoc_IssueDate'] = '';
                                    if (isset($xml->Person->IdentityDoc->IssueDate)) $patient['IdentityDoc_IssueDate'] = date('Y-m-d', strtotime($xml->Person->IdentityDoc->IssueDate)) . "";

                                    $patient['IsMale'] = 1;
                                    if ((isset($xml->Person->IsMale)) and ($xml->Person->IsMale == 'false'))
                                        $patient['IsMale'] = 0;


                                    $patient['LifeRestrictions_SelfCare'] = '' . "";
                                    if (isset($xml->LifeRestrictions->SelfCare)) $patient['LifeRestrictions_SelfCare'] = $xml->LifeRestrictions->SelfCare . "";

                                    $patient['LifeRestrictions_Moving'] = '' . "";
                                    if (isset($xml->LifeRestrictions->Moving)) $patient['LifeRestrictions_Moving'] = $xml->LifeRestrictions->Moving . "";

                                    $patient['LifeRestrictions_Orientation'] = '' . "";
                                    if (isset($xml->LifeRestrictions->Orientation)) $patient['LifeRestrictions_Orientation'] = $xml->LifeRestrictions->Orientation . "";

                                    $patient['LifeRestrictions_Communication'] = '' . "";
                                    if (isset($xml->LifeRestrictions->Communication)) $patient['LifeRestrictions_Communication'] = $xml->LifeRestrictions->Communication . "";

                                    $patient['LifeRestrictions_Learn'] = '' . "";
                                    if (isset($xml->LifeRestrictions->Learn)) $patient['LifeRestrictions_Learn'] = $xml->LifeRestrictions->Learn . "";

                                    $patient['LifeRestrictions_Work'] = '' . "";
                                    if (isset($xml->LifeRestrictions->Work)) $patient['LifeRestrictions_Work'] = $xml->LifeRestrictions->Work . "";

                                    $patient['LifeRestrictions_BehaviorControl'] = '' . "";
                                    if (isset($xml->LifeRestrictions->BehaviorControl)) $patient['LifeRestrictions_BehaviorControl'] = $xml->LifeRestrictions->BehaviorControl . "";


                                    $patient['IsFirst'] = 1;
                                    if ((isset($xml->IsFirst)) and ($xml->IsFirst == 'false'))
                                        $patient['IsFirst'] = 0;


                                    //$patient['EndDate'] = '' . "";
                                    if (isset($xml->EndDate)) {
                                        $patient['EndDate'] = date('Y-m-d', strtotime($xml->EndDate)) . "";
                                    }

                                    //$patient['IssueDate'] = '' . "";
                                    if (isset($xml->IssueDate)) {
                                        $patient['IssueDate'] = date('Y-m-d', strtotime($xml->IssueDate)) . "";
                                    }

                                    $patient['MedSection_EventGroups'] = json_encode(array()) . "";
                                    if (isset($xml->MedSection->EventGroups)) {
                                        $patient['MedSection_EventGroups'] = json_encode($xml->MedSection->EventGroups) . "";
                                    }

                                    $patient['MedSection_PrognozResult'] = json_encode(array()) . "";
                                    if (isset($xml->MedSection->PrognozResult)) {
                                        $patient['MedSection_PrognozResult'] = json_encode($xml->MedSection->PrognozResult) . "";
                                    }

                                    $patient['SenderMedOrgName'] = '' . "";
                                    if (isset($xml->MedSection->SenderMedOrgName)) $patient['SenderMedOrgName'] = $xml->MedSection->SenderMedOrgName . "";

                                    $patient['RequiredHelp'] = '' . "";
                                    if (isset($xml->RequiredHelp)) $patient['RequiredHelp'] = json_encode($xml->RequiredHelp) . "";

                                    $patient['IsAgreed'] = 1;
                                    if ((isset($xml->IsAgreed)) and ($xml->IsAgreed == 'false'))
                                        $patient['IsAgreed'] = 0;

                                    $patient['IsRepresentativeSign'] = 1;
                                    if ((isset($xml->IsRepresentativeSign)) and ($xml->IsRepresentativeSign == 'false'))
                                        $patient['IsRepresentativeSign'] = 0;

                                    $patient['FIOHead_LastName'] = '' . "";
                                    if (isset($xml->FIOHead->LastName)) $patient['FIOHead_LastName'] = $xml->FIOHead->LastName . "";

                                    $patient['FIOHead_FirstName'] = '' . "";
                                    if (isset($xml->FIOHead->FirstName)) $patient['FIOHead_FirstName'] = $xml->FIOHead->FirstName . "";

                                    $patient['FIOHead_SecondName'] = '' . "";
                                    if (isset($xml->FIOHead->SecondName)) $patient['FIOHead_SecondName'] = $xml->FIOHead->SecondName . "";

                                    $patient['xml_file']= $patient_xml;
                                    $patient_id=0;
                                    //$patient['BirthDate'] = '' . "";
                                    if (isset($xml->Person->BirthDate)) $patient['BirthDate'] = date('Y-m-d', strtotime($xml->Person->BirthDate));

                                    if(isset($xml->Person->SNILS))
                                    {
                                        /*обновляем по снилсу*/
                                        $patient_id=$this->GetPatientBySnils($xml->Person->SNILS);
                                        if($patient_id==0)
                                        {
                                            $this->dbMySQL->reset_query();
                                            $this->dbMySQL->insert($this->patient_model->patient_table, $patient);
                                            $patient_id=$this->dbMySQL->insert_id();

                                            /*Вставлям xml*/
                                            $arg=array();
                                            $arg['insert_date']=date('Y-m-d');
                                            $arg['xml']=$xmlstring;
                                            $arg['patient_id']=$patient_id;
                                            $this->dbMySQL->insert($this->patient_xml_table, $arg);


                                            unset($arg);
                                            $arg=array();
                                            /*Ищем по тфомсу*/
                                            $arg['SNILS'] = urlencode($this->NormalizeSNILS($xml->Person->SNILS));
                                            $tfoms = $this->tfoms_search_new($arg);
                                            if($tfoms->LPU_CODE!='20200')
                                            {
                                                $data=array();
                                                $data['LPUCODE']=$tfoms->LPU_CODE;
                                                $this->dbMySQL->where('id', $patient_id);
                                                $this->dbMySQL->update($this->patient_model->patient_table,$data);
                                                echo "UPDATE";
                                            }
                                        }
                                        else
                                        {
                                            $this->dbMySQL->reset_query();
                                            $this->dbMySQL->where('id', $patient_id);
                                            $this->dbMySQL->update('ipre_patients', $patient);
                                        }
                                    }
                                    elseif((isset($xml->Person->FIO->LastName))and(isset($xml->Person->FIO->FirstName))and(isset($xml->Person->FIO->SecondName))and
                                        (isset($xml->Person->BirthDate)))
                                    {
                                        $patient_id=$this->GetPatientByFIOB($xml->Person->FIO->LastName,$xml->Person->FIO->FirstName,$xml->Person->FIO->SecondName
                                            ,$xml->Person->BirthDate);
                                        if($patient_id==0)
                                        {
                                            $this->dbMySQL->reset_query();
                                            $this->dbMySQL->insert($this->patient_model->patient_table, $patient);
                                            $patient_id=$this->dbMySQL->insert_id();

                                            /*Вставлям xml*/
                                            $arg=array();
                                            $arg['insert_date']=date('Y-m-d');
                                            $arg['xml']=$xmlstring;
                                            $arg['patient_id']=$patient_id;
                                            //$this->dbMySQL->insert($this->patient_xml_table, $arg);
                                        }
                                        else
                                        {
                                            $this->dbMySQL->reset_query();
                                            $this->dbMySQL->where('id', $patient_id);
                                            $this->dbMySQL->update('ipre_patients', $patient);
                                        }
                                    }
                                    else
                                    {
                                        $this->dbMySQL->reset_query();
                                        $this->dbMySQL->insert($this->patient_model->patient_table, $patient);
                                        $patient_id=$this->dbMySQL->insert_id();
                                        /*Вставлям xml*/
                                        $arg=array();
                                        $arg['insert_date']=date('Y-m-d');
                                        $arg['xml']=$xmlstring;
                                        $arg['patient_id']=$patient_id;
                                        $this->dbMySQL->insert($this->patient_xml_table, $arg);
                                    }

                                    echo $this->functions->encodestring($patient_id." ".$xml->Person->FIO->LastName
                                            ." ".$xml->Person->FIO->FirstName." ".$xml->Person->FIO->SecondName)."\r\n";
                                }
                                /*пациент*/


                            }

                        }

                    }
                }

                //  return $patients_list;

            }
        }
    }

}