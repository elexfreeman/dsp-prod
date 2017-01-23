<?php
/*
ClassMethod Incert(mGlobal As %String, Keys As %String, Value As %String) As %String [ SqlProc ]
{
	//write ##class(Test.VACPatientClass).Incert("Mtest","Key1||Key2||","asdf")
	set i=1
	set q = ""
	set count = $LENGTH(Keys,"||")
	 while (i < count) {
		set q = q_" """_$PIECE(Keys,"||",i)_""","
		set i = i+1
	 }
	set q = $Extract(q,1,$L(q)-1)
	set q =  "^Test."_mGlobal_"("_q_")"
	set @q=Value

	Quit q
}*/

defined('BASEPATH') OR exit('No direct script access allowed');



class Icache {

    /*Соединение с базой*/
    public $cacheDB;
    /*Имя базы в каше*/
    public $GlobalDB = "";
    protected $CI;


    public function init($conn)
    {

        // Assign the CodeIgniter super-object
        $this->CI =& get_instance();
        date_default_timezone_set('Europe/London');
        $this->cacheDB = $this->CI->load->database($conn, TRUE);
        $this->GlobalDB=$this->CI->config->item('cache_db_name');
    }


    /*Вставляет запись в базу*/
    public function update_record($mGlobal,$Keys,$Value)
    {
        $sql = "select top 1 Test.VACPatientClass_Incert(
        '" . $mGlobal . "',
        '" . $Keys . "' , '" . $Value . "' ) from Test.VACPatientClass";
        //echo $sql;

        $this->cacheDB->query($sql);
        return 1;
        //return $query->result_array();
        //return $sql;

    }


    function update_rec($obj,$arr_key)
    {
        $res=array();
        foreach ($obj as $key=>$value)
        {
            if(is_array($value))
            {
                $res = array_merge($res,$this->update_rec($value,$arr_key."||".$key));
            }
            else
            {
                $res[] = $arr_key."||".$key."||".$obj[$key]."||";
            }
        }
        return $res;
    }



    /*раскладывает массив многомерный для Cache рекурсией*/
    public function update($mGlobal,$obj)
    {
        $res=array();
        foreach ($obj as $key=>$value)
        {
            if(is_array($value))
            {
                $res=$res+$this->update_rec($value,$key);
            }
            else
            {
                $res[] = $key."||".$obj[$key]."||";
            }
        }

        $res2=array();
        
        /*Теперь запихиваем значение в базу*/
        foreach ($res as $obj)
        {
            $obj = explode("||",$obj);
            $obj = array_splice($obj, 0, count($obj)-1);
            $Keys = array_splice($obj, 0, count($obj)-1);
            $Keys = implode ("||",$Keys)."||";
            $Value = $obj[count($obj)-1];
            if($Keys!='')
            {
               // $res2[]=$mGlobal." - ".$Keys." - ".$Value;
                $res2[]=$this->update_record($mGlobal,$Keys,$Value);
            }


        }

        unset($obj);
        unset($res);
        return $res2;




    }
}