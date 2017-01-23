<?php
/**
 * Created by PhpStorm.
 * User: cod_llo
 * Date: 11.03.16
 * Time: 17:11
 */
/*Модель для работой с докторами
пример как описывать любую модель данных для приложения
*/

/*
[AKTPAK].[AKPC_DOCTORS]
VACAKTPAKDoctors[$DRCODE]
VACAKTPAKDoctors[$DRCODE]['SHORT_NAME']
VACAKTPAKDoctors[$DRCODE]['NAME']
VACAKTPAKDoctors[$DRCODE]['SURNAME']
VACAKTPAKDoctors[$DRCODE]['SECNAME']
VACAKTPAKDoctors[$DRCODE]['DBSOURCE']
VACAKTPAKDoctors[$DRCODE]['PENSION']
VACAKTPAKDoctors[$DRCODE]['LPUWORK']
VACAKTPAKDoctors[$DRCODE]['CODEFRMP']
*/
class Aktpak_doctors_model extends CI_Model
{
    public $cacheDB;
    public $srv224DB;

    /*Имя базы*/
    public $GlobalDB = "";

    /*Глобал для Докторов*/
    public $DoctorsCache = "VACAKTPAKDoctors";


    public function __construct()
    {
        $this->cacheDB = $this->load->database('default', TRUE);
        $this->srv224DB = $this->load->database('srv224', TRUE);
        date_default_timezone_set('Europe/London');
        $this->load->helper('url');
        /*Имя базы*/
        $this->GlobalDB=$this->config->item('cache_db_name');
        $this->load->library('icache');
        $this->icache->init('default');
        $this->load->model('aktpak_model');
    }

    /*Вставляет/обновляет данные об докторе*/
    /*вставка и обновление идет паралельно*/
    /*особенноость Cache*/
    /*$doctor - массив */
    public function incert_update($doctor)
    {
        $this->icache->update($this->DoctorsCache,$doctor);  // Object instances will always be lower case
    }

    public function get($DRCODE)
    {

    }

    /*Загружает справочник докторов из актпака*/
    public function load_from_aktpak()
    {
        $doctors=$this->aktpak_model->GetTableSrv224('AKPC_DOCTORS');
        foreach ($doctors as $doctor)
        {
            unset($obj);
            $obj = array();
            $DRCODE=$doctor->DRCODE;
            $obj[$DRCODE]['SHORT_NAME'] = $doctor->SHORT_NAME;
            $obj[$DRCODE]['NAME'] = $doctor->NAME;
            $obj[$DRCODE]['SURNAME'] = $doctor->SURNAME;
            $obj[$DRCODE]['SECNAME'] = $doctor->SECNAME;
            $obj[$DRCODE]['DBSOURCE'] = $doctor->DBSOURCE;
            $obj[$DRCODE]['PENSION'] = $doctor->PENSION;
            $obj[$DRCODE]['LPUWORK'] = $doctor->LPUWORK;


            $this->incert_update($obj);
            echo $DRCODE."\n";
        }
    }





}