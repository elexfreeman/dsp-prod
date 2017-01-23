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

/*получиение мастер индекса пациента*/

class Master_index {

    protected $CI;

    public $client;

    public function init($param)
    {
        $this->CI =& get_instance();
        date_default_timezone_set('Europe/London');
        $this->CI->config->item('mip_login');
        $this->CI->config->item('mip_password');
/*
        $this->client = new SoapClient("http://141.0.177.162:57772/csp/healthshare/ehrdev/isc.emr.EMRReceiverService.cls?wsdl", array('login' => $this->CI->config->item('mip_login'),
            'password' => $this->CI->config->item('mip_password')));

        var_dump($this->client->__getTypes());
       return  $this->client->Container();
        //$this->client->Container();
*/

        require_once dirname(__FILE__) . '/mpi/MyMPIAutoload.php';
        $this->client = new MyMPIServiceContainer();
// sample call for MyMPIServiceContainer::container()
        if($this->client->container(new MyMPIStructContainer('161952','105714001')))
            print_r($this->client->getResult());
        return $this->client;
       /* else
            print_r($this->client->getLastError());*/

    }

    public function getresult()
    {
        return $this->client->getResult();
    }



}