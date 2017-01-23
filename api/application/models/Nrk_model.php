<?php
/**
 * Created by PhpStorm.
 * User: cod_llo
 * Date: 11.03.16
 * Time: 17:11
 */
/*Модель для поиска по базе*/

class Nrk_model extends CI_Model
{

    public function __construct()
    {
        $this->load->database();
        date_default_timezone_set('Europe/London');
        $this->load->helper('url');
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

    public function Odbc1()
    {
        $dsn="DRIVER={InterSystems ODBC}; SERVER=141.0.177.162; PORT=1972; DATABASE=SAMPLES; UID=polozov; PWD=lRLZuT5v;";


        $sql="SELECT  ID, Name, DOB, Office FROM sample.person";

        if ($conn_id=odbc_connect($dsn,"","")){

            echo "connected to DSN: $dsn";

            if($result=odbc_do($conn_id, $sql)) {

                echo "executing '$sql'";

                echo "Results: ";

                odbc_result_all($result);
                print_r($result);

                echo "freeing result";

                odbc_free_result($result);

            }else{

                echo "can not execute '$sql' ";

            }

            echo "closing connection $conn_id";

            odbc_close($conn_id);
    }
    }

}