<?php
/**
 * Created by PhpStorm.
 * User: cod_llo
 * Date: 11.03.16
 * Time: 17:11
 */
/*Модель для работой с Пациентом*/


class Patient_model extends CI_Model
{

    public $patient_table = '[OMS].[dbo].[OMSC_INSURED]';
    public $UsersTable = '[DISP_WEB].[dbo].[users]';
    public $DocTable = '[AKTPAK].[dbo].[AKPC_DOCTORS]';

    public function __construct()
    {
        date_default_timezone_set('Europe/London');
        $this->load->helper('url');
        $this->db_mssql = $this->load->database('default',true);
        $this->load->library('elex');
    }


    public function GetUchByDRCODE($lpu,$drcode){
        $sql="SELECT d2.LPUTER_U
  FROM [DISP_WEB].[dbo].[users] u2
  join  [AKTPAK].[dbo].[AKPC_TMODOC] d2 on u2.drcode = d2.DRCODE
  where (u2.lpucode = ".$lpu.") and (u2.drcode = '". mb_convert_encoding($drcode,"Windows-1251","UTF-8")."')and(d2.D_FIN is null)";

        $query = $this->db_mssql->conn_id->query($sql);
        /*http://proft.me/2008/11/28/primery-ispolzovaniya-pdo/*/
        return $this->elex->result_array($query);
    }
    private function CreateFilter($arg,$limit,$offset){
        $res = array();

        $limit = (int)$limit;
        $offset = (int)$offset;
        $lpu = (int)$arg['lpucode'];

        $uch_d='';
        $uch_w='';

        /*пишем список участвов*/
        if((isset($arg['uch']))and($arg['uch']!='')){
            $uch_w = " and LPUBASE_U = ".$arg['uch'];
        }elseif((isset($arg['DRCODE']))and($arg['DRCODE']!='')){
            /*если вставлен доктор*/
            $uch_list_rows = $this->GetUchByDRCODE($lpu,$arg['DRCODE']);
            $uch_list = [];
            foreach($uch_list_rows as $u){
                $uch_list[]=$u['LPUTER_U'];
            }
            $uch_list = implode(',',$uch_list);
            $uch_w = "and LPUBASE_U in (".$uch_list.") ";
        }

        $sex='';
        if((isset($arg['sex']))and((int)$arg['sex']>0)){
            $sex = "and(sex = ".$arg['sex'].")";
        }

        $error_code='';
        if((isset($arg['error_code']))and((int)$arg['error_code']>0)){
            $error_code = "and(error_code = ".$arg['error_code'].")";


        }        $q='';
        if((isset($arg['q']))and((int)$arg['q']>0)){
            $q = "and(disp_quarter = ".$arg['q'].")";
        }


        $chk_status='';
        if((isset($arg['chk1']))or(isset($arg['chk2']))or(isset($arg['chk3']))or(isset($arg['chk4']))){
            $chk = '';
            if((isset($arg['chk1'])and($arg['chk1']=='true'))) $chk_status.="or((disp_quarter = 1)and(status > 0))";
            if((isset($arg['chk2'])and($arg['chk2']=='true'))) $chk_status.="or((disp_quarter = 2)and(status > 0))";
            if((isset($arg['chk3'])and($arg['chk3']=='true'))) $chk_status.="or((disp_quarter = 3)and(status > 0))";
            if((isset($arg['chk4'])and($arg['chk4']=='true'))) $chk_status.="or((disp_quarter = 4)and(status > 0))";
            if($chk_status!=''){
                $chk_status = substr($chk_status,2);
                $chk_status = 'and('.$chk_status.')and not((drcode is null) or (speccode is null))';
            }
        }

        $chk_red = '';
        if((isset($arg['chk_red'])and($arg['chk_red']=='true'))){
            $chk_red = "(drcode is null) or (speccode is null)";
        }
        if((isset($arg['chk_red'])and($arg['chk_red']=='false'))){
            $chk_red = "(not((drcode is null) or (speccode is null)))";
        }

        $fio = '';
        if((isset($arg['surname'])and($arg['surname']!='')))
            $fio.= "and (i.surname like '%".mb_convert_encoding($arg['surname'],"Windows-1251","UTF-8")."%')";

        if((isset($arg['name'])and($arg['name']!='')))
            $fio.= "and (i.name like '%".mb_convert_encoding($arg['name'],"Windows-1251","UTF-8")."%')";

        if((isset($arg['secname'])and($arg['secname']!='')))
            $fio.= "and (i.secname like '%".mb_convert_encoding($arg['secname'],"Windows-1251","UTF-8")."%')";




        /*сортировка*/
        $order_by=' order by surname1 ';
        if((isset($arg['sort']))and(isset($arg['order'])))
            $order_by = ' order by '.$arg['sort']." ".$arg['order'];

        $res['uch_d'] = $uch_d;
        $res['uch_w'] = $uch_w;
        $res['lpu'] = $lpu;
        $res['order_by'] = $order_by;
        $res['chk_status'] = $chk_status;
        $res['chk_red'] = $chk_red;
        $res['q'] = $q;
        $res['sex'] = $sex;
        $res['fio'] = $fio;
        $res['error_code'] = $error_code;
        return $res;
    }

    public function GetPatients($arg,$limit,$offset) {

        $limit = (int)$limit;
        $offset = (int)$offset;
        $lpu = (int)$arg['lpucode'];

        $params = $this->CreateFilter($arg,$limit,$offset);
        $uch_d = $params['uch_d'];
        $uch_w = $params['uch_w'];
        $sex = $params['sex'];
        $chk_status = $params['chk_status'];
        $chk_red = $params['chk_red'];
        if($chk_red!='') $chk_red=' and '.$chk_red;
        $q = $params['q'];
        $fio = $params['fio'];
        $error_code = $params['error_code'];


        $sql="

declare @month_beg int = ".$arg['month_beg'].";
declare @month_end int = ".$arg['month_end'].";
declare @age_beg int = ".$arg['age_beg'].";
declare @age_end int = ".$arg['age_end'].";
declare @drcode varchar(8);
$uch_d

declare @year int = 3;
declare @lpu int = ".$lpu.";


select *
from(
select *, ROW_NUMBER() over(order by surname1) as rn,
case when drcode is null or speccode is null then 1 else 0 end as error
from
(select  year(getdate()) - year(i.BIRTHDAY) as vozr,


 null as user_id,


 2017 as  disp_year,
 1 as disp_type,
 i.lpuchief as disp_lpu,
 year(getdate()) - year(i.BIRTHDAY) as  age,

 i.lpubase,
 i.lpubase_u,
 i.type_u as typeui,

 i. enp,


(select count(*) from [OMS].[dbo].[OMSC_INSURED_SREZ]
where d_fin is null
  and lpuchief = @lpu
  and (year(getdate()) - year(i.BIRTHDAY)) % 3 = 0
  and year(getdate()) - year(i.BIRTHDAY) >=21
".$uch_w."
  ) as kol,


  (select top 1 drcode
      from aktpak.[dbo].akpc_tmodoc
	  where d_fin is null

		and DBSOURCE = 'D'

		and isnull(LPUTER_U,0) = isnull(i.lpubase_u,0)
		and isnull(LPUTER,0) = isnull(i.lpubase,0)
		and isnull(type_u,0) = isnull(i.type_u,0)
      order by drcode
      )  as drcode,
  (select top 1 speccode
      from aktpak.[dbo].akpc_tmodoc
	  where d_fin is null

		and DBSOURCE = 'D'

		and isnull(LPUTER_U,0) = isnull(i.lpubase_u,0)
		and isnull(LPUTER,0) = isnull(i.lpubase,0)
		and isnull(type_u,0) = isnull(i.type_u,0)
      order by drcode
      )  as speccode,

  i.surname as surname1, i.name as name1, i.secname as secname1, i.birthday as birthday1

  ,dp.[status],
  pld.NAME
  , i.SEX sex
  ,dp.[disp_quarter]
  ,e.error_code
    ,te.[description] error_code_description
   ,dp.[disp_start]
   ,dp.[stage_1_result]
   ,dp.[stage_2_result]
   ,dp.[refusal_reason]
   ,dp.[lgg_code]
   ,dp.[disp_final]
from [OMS].[dbo].[OMSC_INSURED_SREZ] i


left join ( select * ,
            ROW_NUMBER() over(partition by enp  order by id desc) as nom
            from [DISP_WEB].[dbo].[disp_plan])
       dp on ((dp.enp=i.ENP) and (nom = 1))

left join [POLYCLINIC_2010].[dbo].[POLM_LPU_DISTRICTS] pld
on (pld.NUM = i.LPUBASE_U)and(pld.LPUCODE = i.LPUBASE)and(pld.D_FIN is null) and i.type_u = pld.typedistrict



left join (select disp_plan_id, error_code,
           ROW_NUMBER() over(partition by disp_plan_id  order by id desc) as nom
		   from  [DISP_WEB].[dbo].[tfoms_errors]) e

on dp.id = e.disp_plan_id and e.nom = 1

		   left join [DISP_WEB].[dbo].[tfoms_errors_descriptions] as  te
on te.error_code = e.error_code

where i.d_fin is null
  and i.lpuchief = @lpu
  and (year(getdate()) - year(i.BIRTHDAY)) % 3 = 0
  and year(getdate()) - year(i.BIRTHDAY) >= 21
  and month(i.birthday) between @month_beg and @month_end
  and (year(getdate()) - year(i.BIRTHDAY)) between  @age_beg and @age_end
  ".$fio."

) x
where (1=1)
".$uch_w."
".$sex."
$chk_status
".$q."
".$chk_red."
".$error_code."

) y
where  (rn between ".$offset." and ".($offset+$limit).") order by rn
";


        $query = $this->db_mssql->conn_id->query($sql);

        /*http://proft.me/2008/11/28/primery-ispolzovaniya-pdo/*/
        return $this->elex->result_array($query);
    }

    public function GetPatientsAll($arg) {


        $lpu = (int)$arg['lpucode'];

        $params = $this->CreateFilter($arg,10,10);
        $uch_d = $params['uch_d'];
        $uch_w = $params['uch_w'];
        $sex = $params['sex'];
        $chk_status = $params['chk_status'];
        $chk_red = $params['chk_red'];
        if($chk_red!='') $chk_red=' and '.$chk_red;
        $q = $params['q'];

        if((!isset($arg['age_beg']))or($arg['age_beg']=='')) $arg['age_beg']=21;
        if((!isset($arg['age_end']))or($arg['age_end']=='')) $arg['age_end']=99;

        if((!isset($arg['month_beg']))or($arg['month_beg']=='')) $arg['month_beg']=1;
        if((!isset($arg['month_end']))or($arg['month_end']=='')) $arg['month_end']=12;


        $sql="
declare @month_beg int = ".$arg['month_beg'].";
declare @month_end int = ".$arg['month_end'].";
declare @age_beg int = ".$arg['age_beg'].";
declare @age_end int = ".$arg['age_end'].";
declare @drcode varchar(8);
$uch_d

declare @year int = 3;
declare @lpu int = ".$lpu.";


select   *
from(
select *,
case when drcode is null or speccode is null then 1 else 0 end as error
from
(select  year(getdate()) - year(i.BIRTHDAY) as vozr,
 ROW_NUMBER() over(order by i.surname) as rn,

 null as user_id,


 2017 as  disp_year,
 1 as disp_type,
 i.lpuchief as disp_lpu,
 year(getdate()) - year(i.BIRTHDAY) as  age,

 i.lpubase,
 i.lpubase_u,
 i.type_u as typeui,

 i. enp,


(select count(*) from [OMS].[dbo].[OMSC_INSURED_SREZ]
where d_fin is null
  and lpuchief = @lpu
  and (year(getdate()) - year(i.BIRTHDAY)) % 3 = 0
  and year(getdate()) - year(i.BIRTHDAY) >=21
".$uch_w."
  ) as kol,


  (select top 1 drcode
      from aktpak.[dbo].akpc_tmodoc
	  where d_fin is null

		and DBSOURCE = 'D'

		and isnull(LPUTER_U,0) = isnull(i.lpubase_u,0)
		and isnull(LPUTER,0) = isnull(i.lpubase,0)
		and isnull(type_u,0) = isnull(i.type_u,0)
      order by drcode
      )  as drcode,
  (select top 1 speccode
      from aktpak.[dbo].akpc_tmodoc
	  where d_fin is null

		and DBSOURCE = 'D'

		and isnull(LPUTER_U,0) = isnull(i.lpubase_u,0)
		and isnull(LPUTER,0) = isnull(i.lpubase,0)
		and isnull(type_u,0) = isnull(i.type_u,0)
      order by drcode
      )  as speccode,

  i.surname as surname1, i.name as name1, i.secname as secname1, i.birthday as birthday1

  ,dp.[status]
  ,dp.guid
  ,pld.NAME
  , i.SEX sex
  ,dp.[disp_quarter]
  ,dp.[disp_start]
    ,dp.[stage_1_result]
   ,dp.[stage_2_result]
   ,dp.[refusal_reason]
   ,dp.[lgg_code]
   ,dp.[disp_final]
from [OMS].[dbo].[OMSC_INSURED_SREZ] i


left join ( select * ,
            ROW_NUMBER() over(partition by enp  order by id desc) as nom
            from [DISP_WEB].[dbo].[disp_plan]) dp on ((dp.enp=i.ENP) and (nom = 1))

left join [POLYCLINIC_2010].[dbo].[POLM_LPU_DISTRICTS] pld
on (pld.NUM = i.LPUBASE_U)and(pld.LPUCODE = i.LPUBASE)and(pld.D_FIN is null) and i.type_u = pld.typedistrict

where i.d_fin is null
and i.lpuchief = @lpu
  and (year(getdate()) - year(i.BIRTHDAY)) % 3 = 0
  and year(getdate()) - year(i.BIRTHDAY) >= 21
  and month(i.birthday) between @month_beg and @month_end
  and (year(getdate()) - year(i.BIRTHDAY)) between  @age_beg and @age_end
) x
where (1=1)
".$uch_w."
".$sex."
$chk_status
".$q."
".$chk_red."

) y

";


        $query = $this->db_mssql->conn_id->query($sql);


        /*http://proft.me/2008/11/28/primery-ispolzovaniya-pdo/*/


        return $this->elex->result_array($query);
    }

    public function GetPatientsAll10($arg) {


        $lpu = (int)$arg['lpucode'];

        $params = $this->CreateFilter($arg,10,10);
        $uch_d = $params['uch_d'];
        $uch_w = $params['uch_w'];
        $sex = $params['sex'];
        $chk_status = $params['chk_status'];
        $chk_red = $params['chk_red'];
        if($chk_red!='') $chk_red=' and '.$chk_red;
        $q = $params['q'];


        $sql="
declare @month_beg int = ".$arg['month_beg'].";
declare @month_end int = ".$arg['month_end'].";
declare @age_beg int = ".$arg['age_beg'].";
declare @age_end int = ".$arg['age_end'].";
declare @drcode varchar(8);
$uch_d

declare @year int = 3;
declare @lpu int = ".$lpu.";


select *
from(
select *,
case when drcode is null or speccode is null then 1 else 0 end as error
from
(select  year(getdate()) - year(i.BIRTHDAY) as vozr,
 ROW_NUMBER() over(order by i.surname) as rn,

 null as user_id,


 2017 as  disp_year,
 1 as disp_type,
 i.lpuchief as disp_lpu,
 year(getdate()) - year(i.BIRTHDAY) as  age,

 i.lpubase,
 i.lpubase_u,
 i.type_u as typeui,

 i. enp,


(select count(*) from [OMS].[dbo].[OMSC_INSURED_SREZ]
where d_fin is null
  and lpuchief = @lpu
  and (year(getdate()) - year(i.BIRTHDAY)) % 3 = 0
  and year(getdate()) - year(i.BIRTHDAY) >=21
".$uch_w."
  ) as kol,


  (select top 1 drcode
      from aktpak.[dbo].akpc_tmodoc
	  where d_fin is null

		and DBSOURCE = 'D'

		and isnull(LPUTER_U,0) = isnull(i.lpubase_u,0)
		and isnull(LPUTER,0) = isnull(i.lpubase,0)
		and isnull(type_u,0) = isnull(i.type_u,0)
      order by drcode
      )  as drcode,
  (select top 1 speccode
      from aktpak.[dbo].akpc_tmodoc
	  where d_fin is null

		and DBSOURCE = 'D'

		and isnull(LPUTER_U,0) = isnull(i.lpubase_u,0)
		and isnull(LPUTER,0) = isnull(i.lpubase,0)
		and isnull(type_u,0) = isnull(i.type_u,0)
      order by drcode
      )  as speccode,

  i.surname as surname1, i.name as name1, i.secname as secname1, i.birthday as birthday1

  ,dp.[status]
  ,dp.guid
  ,pld.NAME
  , i.SEX sex
  ,dp.[disp_quarter]
  ,dp.[disp_start]
    ,dp.[stage_1_result]
   ,dp.[stage_2_result]
   ,dp.[refusal_reason]
   ,dp.[lgg_code]
   ,dp.[disp_final]
   ,dp.[operator]
from [OMS].[dbo].[OMSC_INSURED_SREZ] i


left join ( select * ,
            ROW_NUMBER() over(partition by enp  order by id desc) as nom
            from [DISP_WEB].[dbo].[disp_plan]) dp on ((dp.enp=i.ENP) and (nom = 1))

left join [POLYCLINIC_2010].[dbo].[POLM_LPU_DISTRICTS] pld
on (pld.NUM = i.LPUBASE_U)and(pld.LPUCODE = i.LPUBASE)and(pld.D_FIN is null) and i.type_u = pld.typedistrict

where i.d_fin is null
and i.lpuchief = @lpu
  and (year(getdate()) - year(i.BIRTHDAY)) % 3 = 0
  and year(getdate()) - year(i.BIRTHDAY) >= 21
  and month(i.birthday) between @month_beg and @month_end
  and (year(getdate()) - year(i.BIRTHDAY)) between  @age_beg and @age_end
) x
where (1=1)

 and (not((drcode is null) or (speccode is null)))
 and(disp_start<>'1900-01-01')
 and(operator = 'TumanovaVV3')

) y

";

//echo $sql;


        $query = $this->db_mssql->conn_id->query($sql);


        /*http://proft.me/2008/11/28/primery-ispolzovaniya-pdo/*/


        return $this->elex->result_array($query);
    }
    public function GetPatientsAll9501($arg) {


        $lpu = (int)$arg['lpucode'];

        $params = $this->CreateFilter($arg,10,10);
        $uch_d = $params['uch_d'];
        $uch_w = $params['uch_w'];
        $sex = $params['sex'];
        $chk_status = $params['chk_status'];
        $chk_red = $params['chk_red'];
        if($chk_red!='') $chk_red=' and '.$chk_red;
        $q = $params['q'];


        $sql="
declare @month_beg int = ".$arg['month_beg'].";
declare @month_end int = ".$arg['month_end'].";
declare @age_beg int = ".$arg['age_beg'].";
declare @age_end int = ".$arg['age_end'].";
declare @drcode varchar(8);
$uch_d

declare @year int = 3;
declare @lpu int = ".$lpu.";


select top 3 *
from(
select *,
case when drcode is null or speccode is null then 1 else 0 end as error
from
(select  year(getdate()) - year(i.BIRTHDAY) as vozr,
 ROW_NUMBER() over(order by i.surname) as rn,

 null as user_id,


 2017 as  disp_year,
 1 as disp_type,
 i.lpuchief as disp_lpu,
 year(getdate()) - year(i.BIRTHDAY) as  age,

 i.lpubase,
 i.lpubase_u,
 i.type_u as typeui,

 i. enp,


(select count(*) from [OMS].[dbo].[OMSC_INSURED_SREZ]
where d_fin is null
  and lpuchief = @lpu
  and (year(getdate()) - year(i.BIRTHDAY)) % 3 = 0
  and year(getdate()) - year(i.BIRTHDAY) >=21
".$uch_w."
  ) as kol,


  (select top 1 drcode
      from aktpak.[dbo].akpc_tmodoc
	  where d_fin is null

		and DBSOURCE = 'D'

		and isnull(LPUTER_U,0) = isnull(i.lpubase_u,0)
		and isnull(LPUTER,0) = isnull(i.lpubase,0)
		and isnull(type_u,0) = isnull(i.type_u,0)
      order by drcode
      )  as drcode,
  (select top 1 speccode
      from aktpak.[dbo].akpc_tmodoc
	  where d_fin is null

		and DBSOURCE = 'D'

		and isnull(LPUTER_U,0) = isnull(i.lpubase_u,0)
		and isnull(LPUTER,0) = isnull(i.lpubase,0)
		and isnull(type_u,0) = isnull(i.type_u,0)
      order by drcode
      )  as speccode,

  i.surname as surname1, i.name as name1, i.secname as secname1, i.birthday as birthday1

  ,dp.[status]
  ,dp.guid
  ,pld.NAME
  , i.SEX sex
  ,dp.[disp_quarter]
  ,dp.[disp_start]
    ,dp.[stage_1_result]
   ,dp.[stage_2_result]
   ,dp.[refusal_reason]
   ,dp.[lgg_code]
   ,dp.[disp_final]
from [OMS].[dbo].[OMSC_INSURED_SREZ] i


left join ( select * ,
            ROW_NUMBER() over(partition by enp  order by id desc) as nom
            from [DISP_WEB].[dbo].[disp_plan]) dp on ((dp.enp=i.ENP) and (nom = 1))

left join [POLYCLINIC_2010].[dbo].[POLM_LPU_DISTRICTS] pld
on (pld.NUM = i.LPUBASE_U)and(pld.LPUCODE = i.LPUBASE)and(pld.D_FIN is null) and i.type_u = pld.typedistrict

where i.d_fin is null
and i.lpuchief = @lpu
  and (year(getdate()) - year(i.BIRTHDAY)) % 3 = 0
  and year(getdate()) - year(i.BIRTHDAY) >= 21
  and month(i.birthday) between @month_beg and @month_end
  and (year(getdate()) - year(i.BIRTHDAY)) between  @age_beg and @age_end
) x
where (1=1)

".$uch_w."
".$sex."
$chk_status
".$q."
".$chk_red."

) y

";

//echo $sql;


        $query = $this->db_mssql->conn_id->query($sql);


        /*http://proft.me/2008/11/28/primery-ispolzovaniya-pdo/*/


        return $this->elex->result_array($query);
    }

    public function GetPatientsTotal($arg) {

        $lpu = (int)$arg['lpucode'];

        $params = $this->CreateFilter($arg,10,10);
        $uch_d = $params['uch_d'];
        $uch_w = $params['uch_w'];
        $sex = $params['sex'];
        $chk_status = $params['chk_status'];
        $chk_red = $params['chk_red'];
        if($chk_red!='') $chk_red=' and '.$chk_red;
        $q = $params['q'];
        $fio = $params['fio'];
        $error_code = $params['error_code'];
      //  $error_code = $params['error_code'];




        $sql="
declare @month_beg int = ".$arg['month_beg'].";
declare @month_end int = ".$arg['month_end'].";
declare @age_beg int = ".$arg['age_beg'].";
declare @age_end int = ".$arg['age_end'].";
declare @drcode varchar(8);
$uch_d

declare @year int = 3;
declare @lpu int = ".$lpu.";


select count(*) cc
from(
select *,
case when drcode is null or speccode is null then 1 else 0 end as error
from
(select  year(getdate()) - year(i.BIRTHDAY) as vozr,
 ROW_NUMBER() over(order by i.surname) as rn,

 null as user_id,


 2017 as  disp_year,
 1 as disp_type,
 i.lpuchief as disp_lpu,
 year(getdate()) - year(i.BIRTHDAY) as  age,

 i.lpubase,
 i.lpubase_u,
 i.type_u as typeui,

 i. enp,


(select count(*) from [OMS].[dbo].[OMSC_INSURED_SREZ]
where d_fin is null
  and lpuchief = @lpu
  and (year(getdate()) - year(i.BIRTHDAY)) % 3 = 0
  and year(getdate()) - year(i.BIRTHDAY) >=21
".$uch_w."
  ) as kol,


  (select top 1 drcode
      from aktpak.[dbo].akpc_tmodoc
	  where d_fin is null

		and DBSOURCE = 'D'

		and isnull(LPUTER_U,0) = isnull(i.lpubase_u,0)
		and isnull(LPUTER,0) = isnull(i.lpubase,0)
		and isnull(type_u,0) = isnull(i.type_u,0)
      order by drcode
      )  as drcode,
  (select top 1 speccode
      from aktpak.[dbo].akpc_tmodoc
	  where d_fin is null

		and DBSOURCE = 'D'

		and isnull(LPUTER_U,0) = isnull(i.lpubase_u,0)
		and isnull(LPUTER,0) = isnull(i.lpubase,0)
		and isnull(type_u,0) = isnull(i.type_u,0)
      order by drcode
      )  as speccode,

  i.surname as surname1, i.name as name1, i.secname as secname1, i.birthday as birthday1

  ,dp.[status],
  pld.NAME
  , i.SEX sex
  ,dp.[disp_quarter]
  ,e.error_code
from [OMS].[dbo].[OMSC_INSURED_SREZ] i


left join ( select * ,
            ROW_NUMBER() over(partition by enp  order by id desc) as nom
            from [DISP_WEB].[dbo].[disp_plan]) dp on ((dp.enp=i.ENP) and (nom = 1))

left join [POLYCLINIC_2010].[dbo].[POLM_LPU_DISTRICTS] pld
on (pld.NUM = i.LPUBASE_U)and(pld.LPUCODE = i.LPUBASE)and(pld.D_FIN is null) and i.type_u = pld.typedistrict

left join (select disp_plan_id, error_code,
           ROW_NUMBER() over(partition by disp_plan_id  order by id desc) as nom
		   from  [DISP_WEB].[dbo].[tfoms_errors]) e

on dp.id = e.disp_plan_id and e.nom = 1

   left join [DISP_WEB].[dbo].[tfoms_errors_descriptions] as  te
on te.error_code = e.error_code

where i.d_fin is null
  and i.lpuchief = @lpu
  and (year(getdate()) - year(i.BIRTHDAY)) % 3 = 0
  and year(getdate()) - year(i.BIRTHDAY) >= 21
  and month(i.birthday) between @month_beg and @month_end
  and (year(getdate()) - year(i.BIRTHDAY)) between  @age_beg and @age_end
  ".$fio."


) x
where (1=1)
".$uch_w."
".$sex."
$chk_status
".$q."
".$chk_red."
  ".$error_code."


) y

";






        $query = $this->db_mssql->conn_id->query($sql);
        /*http://proft.me/2008/11/28/primery-ispolzovaniya-pdo/*/

        $res = $this->elex->result_array($query);

        return (int)$res[0]['cc'];
    }

    /*выдает докторов в лпу*/
    function GetLPUDoctors($lpucode) {
        $lpucode = (int)$lpucode;
        $sql = "
    select * from [AKTPAK].[dbo].[AKPC_DOCTORS] d
    where (d.LPUWORK = ".$lpucode.")AND(d.D_FIN is null)and(d.DBSOURCE = 'D') order by d.SURNAME;";
        $query = $this->db_mssql->conn_id->query($sql);
        return $this->elex->result_array($query);
    }

    /*выдает участки в лпу*/
    function GetLPUuch($lpucode,$drcode='') {
        $lpucode = (int)$lpucode;
        if($drcode==''){
            $sql="
        select [NUM] as num_uch from [POLYCLINIC_2010].[dbo].[POLM_LPU_DISTRICTS] pld
where (pld.D_FIN is null)and((pld.LPUCODE =".$lpucode.")or(pld.LPUCHIEF=".$lpucode."))
        ";
        }
        else{
            $sql="SELECT d2.LPUTER_U as num_uch
  FROM [DISP_WEB].[dbo].[users] u2
  join  [AKTPAK].[dbo].[AKPC_TMODOC] d2 on u2.drcode = d2.DRCODE
  where (d2.D_FIN is null)and (u2.lpucode = ".$lpucode.") and (u2.drcode = '". mb_convert_encoding($drcode,"Windows-1251","UTF-8")."')";

        }
        $query = $this->db_mssql->conn_id->query($sql);
        return $this->elex->result_array($query);
    }

    /*выдает участки в лпу*/
    function GetDspPlanForYear($lpucode,$year) {
        $lpucode = (int)$lpucode;
        $year = (int)$year;
        $sql = "
    SELECT top 1 *
  FROM [DISP_WEB].[dbo].[plan_mzso] plan_m where
  (plan_m.lpucode = ".$lpucode.") and (plan_m.year = ".$year.")
  order by id desc
  ";
        $query = $this->db_mssql->conn_id->query($sql);
        return $this->elex->row_array($query);
    }


    public function GetPatientByEnp($enp) {

        $sql="SELECT *
          FROM [OMS].[dbo].[OMSC_INSURED] p

          where (p.ENP = '".$enp."') and (p.D_FIN is null)";

        $query = $this->db_mssql->conn_id->query($sql);
        return $this->elex->row_array($query);
    }

    public function InsertPatientStatus($arg) {
        /*конвертируем в cp1251*/
        foreach($arg as $key=>$v){
            $arg[$key] = mb_convert_encoding($arg[$key],"Windows-1251","UTF-8");
        }

        $now = date('Y-m-d H:i:s');
        if(!isset($arg['stage_1_result'])) $arg['stage_1_result']='';
        if(!isset($arg['stage_2_result'])) $arg['stage_2_result']='';
        if(!isset($arg['disp_start'])) $arg['disp_start']='';
        if(!isset($arg['refusal_reason'])) $arg['refusal_reason']='';
        if(!isset($arg['speccode'])) $arg['speccode']='';
        if(!isset($arg['age'])) $arg['age']='';
        if(!isset($arg['disp_lpu'])) $arg['disp_lpu']='';
        if(!isset($arg['disp_type'])) $arg['lgg_code']=1;
        if(!isset($arg['disp_quarter'])) $arg['disp_quarter']='';
        if(!isset($arg['disp_year'])) $arg['disp_year']='';
        if(!isset($arg['guid'])) $arg['guid']='';
        if(!isset($arg['lgg_code'])) $arg['lgg_code']='';
        if(!isset($arg['date_planning'])) $arg['date_planning']='';
        if(!isset($arg['disp_final'])) $arg['disp_final']='';

        $sql="
set dateformat ymd;

INSERT INTO [DISP_WEB].[dbo].[disp_plan]
           ([insert_date]
           ,[enp]
           ,[status]
           ,[guid]
           ,[disp_year]
           ,[disp_quarter]
           ,[disp_type]
           ,[disp_lpu]
           ,[age]
           ,[lgg_code]
           ,[drcode]
           ,[speccode]
           ,[refusal_reason]
           ,[disp_start]
           ,[stage_1_result]
           ,[stage_2_result]
           ,[disp_final]
           ,[deleted])
           OUTPUT INSERTED.id
     VALUES
           (
           '".$now."'
           ,'".$arg['enp']."'
           ,'".$arg['status']."'
          ,'".$arg['guid']."'
          ,'".$arg['disp_year']."'
          ,'".$arg['disp_quarter']."'
          ,'".$arg['disp_type']."'
          ,'".$arg['disp_lpu']."'
          ,'".$arg['age']."'
          ,'".$arg['lgg_code']."'
          ,'".$arg['drcode']."'
          ,'".$arg['speccode']."'
          ,'".$arg['refusal_reason']."'
          ,'".$arg['disp_start']."'
          ,'".$arg['stage_1_result']."'
          ,'".$arg['stage_2_result']."'
          ,'".$arg['disp_final']."'
          ,'0');
";

        $query = $this->db_mssql->conn_id->query($sql);
        $res = $this->elex->row_array($query);
        return $res['id'];

    }


    public function GetPatientStatus($enp) {
        $sql="SELECT TOP 1 [id]
      ,[insert_date]
      ,[enp]
      ,[status]
      ,[guid]
      ,[disp_year]
      ,[disp_quarter]
      ,[disp_type]
      ,[disp_lpu]
      ,[age]
      ,[lgg_code]
      ,[drcode]
      ,[speccode]
      ,[refusal_reason]
      ,[disp_start]
      ,[stage_1_result]
      ,[stage_2_result]
      ,[deleted]
  FROM [DISP_WEB].[dbo].[disp_plan] p

  where p.enp = '".$enp."' order by id desc";
        $query = $this->db_mssql->conn_id->query($sql);
        return $this->elex->row_array($query);
    }

    public function CheckAllFromFilter($arg) {

        $rows = $this->GetPatientsAll($arg);
        foreach($rows as $row){

            $arg1 = array();
            $arg1['enp'] = $row['enp'];
            $arg1['status'] = $arg['status'];
            $arg1['disp_year'] = $arg['disp_year'];
            $arg1['disp_quarter'] = $this->GeQuarterByDate($row['birthday1']);
            $arg1['disp_type'] = 1;
            $arg1['disp_lpu'] = $arg['user']['lpucode'];
            $arg1['age'] = 1;
            $arg1['lgg_code'] = 1;
            $arg1['drcode'] = 1;
            $arg1['refusal_reason'] = 1;
            $arg1['disp_start'] = '';
            $arg1['stage_1_result'] = '';
            $arg1['stage_2_result'] = '';
            $arg1['guid'] = '';
            $arg1['speccode'] = '';

            $this->InsertPatientStatus($arg1);
        }
    }

    public function GeQuarterByDate($date){
        $month = (int)date('m',strtotime($date));
        if(($month>0)and($month<4)) return 1;
        if(($month>3)and($month<7)) return 2;
        if(($month>6)and($month<10)) return 3;
        if($month>9) return 4;
    }


    public function GetCountPatientsInPlan($user,$year){

        $sql="
         select sum([status]) as kol,
        sum(case when [disp_quarter] = 1 then 1 else 0 end) as kol1,
	    sum(case when [disp_quarter] = 2 then 1 else 0 end) as kol2,
	    sum(case when [disp_quarter] = 3 then 1 else 0 end) as kol3,
	    sum(case when [disp_quarter] = 4 then 1 else 0 end) as kol4
        from
         (SELECT status, disp_quarter, enp, id,
               row_number() over (partition  by enp order by id desc) as rn
          FROM [DISP_WEB].[dbo].[disp_plan] p
          where (disp_year = ".$year.")
          and (p.disp_lpu = ".$user['lpucode']." )
          ) x
          where rn = 1 and status = 1
        ";

        $sql="
                select sum([status]) as kol,
        sum(case when [disp_quarter] = 1 then 1 else 0 end) as kol1,
	    sum(case when [disp_quarter] = 2 then 1 else 0 end) as kol2,
	    sum(case when [disp_quarter] = 3 then 1 else 0 end) as kol3,
	    sum(case when [disp_quarter] = 4 then 1 else 0 end) as kol4
        from
         (SELECT status, disp_quarter, dp.enp, id,
               row_number() over (partition  by dp.enp order by id desc) as rn,
	     (select top 1 drcode
          from aktpak..akpc_tmodoc
	      where d_fin is null
		  and DBSOURCE = 'D'
		  and isnull(LPUTER_U,0) = isnull(i.lpubase_u,0)
		  and isnull(LPUTER,0) = isnull(i.lpubase,0)
		  and isnull(type_u,0) = isnull(i.type_u,0)
          order by drcode
          )  as drcode

          FROM [DISP_WEB].[dbo].[disp_plan] dp
		  join oms..OMSC_INSURED_SREZ i on dp.enp=i.ENP
          where (disp_year = 2017)
          and (dp.disp_lpu = ".$user['lpucode']." )
		  and (status = 1)

          ) x

          where (rn = 1)and (drcode is not null)

        ";

        $query = $this->db_mssql->conn_id->query($sql);
        return $this->elex->row_array($query);
    }

    public function InsertUploadStatus($arg){
        $now = date('Y-m-d H:i:s');
        $sql="
set dateformat ymd;
        INSERT INTO [DISP_WEB].[dbo].[upload_erzl]
           ([lpu]
           ,[filename]
           ,[upload_date]
           ,[status]
           ,[year]

           )
     VALUES
           (".$arg['lpu']."
           ,'".$arg['filename']."'
           ,'".$now."'
           ,1
           ,".$arg['year']."
           )
        ";

        $this->db_mssql->conn_id->query($sql);
    }


    public function InsertPlan($arg){

        $sql="
        INSERT INTO [DISP_WEB].[dbo].[plan_mzso]
           ([year]
           ,[lpucode]
           ,[plan_count])
     VALUES
           (".$arg['year']."
           ,".$arg['lpucode']."
           ,".$arg['plan_count'].")
        ";
        $this->db_mssql->conn_id->query($sql);
    }


    public function CheckLoadPlans($lpu,$year){
        $lpu = (int)$lpu;
        $year = (int)$year;
        $sql="
        SELECT count(*) cc
  FROM [DISP_WEB].[dbo].[upload_erzl] p
  where (p.lpu = ".$lpu.")and(p.[status]=2)and(p.[year]=".$year.")
        ";

        $query = $this->db_mssql->conn_id->query($sql);
        $res = $this->elex->row_array($query);

        if((int)$res['cc']>0) return true;else return false;
    }

    public function GetLoadPlans($lpu,$year){
        $lpu = (int)$lpu;
        $year = (int)$year;
        $sql="
        SELECT top 1 *
  FROM [DISP_WEB].[dbo].[upload_erzl] p
  where (p.lpu = ".$lpu.")and(p.[status]=2)and(p.[year]=".$year.") order by id desc
        ";

        $query = $this->db_mssql->conn_id->query($sql);
        return $this->elex->row_array($query);


    }


    public function GetGuidByEnp($enp){
        return  $this->tfoms->GUID();;
    }

    public function Get_date_planning($year,$disp_quarter){

        if($disp_quarter==1) return $year.'-01-01';
        if($disp_quarter==2) return $year.'-04-01';
        if($disp_quarter==3) return $year.'-07-01';
        if($disp_quarter==4) return $year.'-10-01';
    }

    /*вставляет ошики от тфомс кот полученны после отправки на ихний сервис*/
    public function InsertTfomsErrors($disp_plan_id,$arg){
        $arg['message'] =  mb_convert_encoding($arg['message'],"Windows-1251","UTF-8");
        $now = date('Y-m-d H:i:s');
        $sql="
set dateformat ymd;
INSERT INTO [DISP_WEB].[dbo].[tfoms_errors]
           (
           [send_date]
           ,[enp]
           ,[error_code]
           ,[message]
           ,[disp_plan_id])
           OUTPUT INSERTED.id
     VALUES
           (
           '".$now."'
           ,".$arg['enp']."
           ,".$arg['error_code']."
           ,'".$arg['message']."'
           ,".$disp_plan_id."
          )
        ";

        $query = $this->db_mssql->conn_id->query($sql);
        $res = $this->elex->row_array($query);
        return $res['id'];

    }

    public function GetLpuP($lpuchief){
        $lpuchief=(int)$lpuchief;
        $sql="select lpubase
        from [oms].[dbo].OMSC_INSURED_SREZ
        where lpuchief = ".$lpuchief."
        group by lpubase";
        $query = $this->db_mssql->conn_id->query($sql);
        return $this->elex->result_array($query);


    }


    public function InsertTfomsErrorDescr($arg){
        $arg['description'] = mb_convert_encoding($arg['description'],"Windows-1251","UTF-8");
        $sql="
set dateformat ymd;
INSERT INTO [DISP_WEB].[dbo].[tfoms_errors_descriptions]
           (
          [error_code]
           ,[description]
           )
           OUTPUT INSERTED.id
     VALUES
           (
           ".$arg['error_code']."
           ,'".$arg['description']."'
          )
        ";

        $query = $this->db_mssql->conn_id->query($sql);
        $res = $this->elex->row_array($query);
        return $res['id'];
    }

    public function GetTfomsErrorsList(){
        $sql="select *
        from [DISP_WEB].[dbo].[tfoms_errors_descriptions]
         order by error_code ";
        $query = $this->db_mssql->conn_id->query($sql);
        return $this->elex->result_array($query);
    }


    public function GetUserWithTfoms(){
        $sql="SELECT  [id]
              ,[username]
              ,[password]
              ,[lpucode]
              ,[group]
              ,[fullname]
              ,[description]
              ,[DRCODE]
              ,[tfoms_user_id]
              ,[tfoms_password]
              ,[tfoms_username]
              ,[tfoms_date_planning]
          FROM [DISP_WEB].[dbo].[users]

          where tfoms_username is not null";
        $query = $this->db_mssql->conn_id->query($sql);
        return $this->elex->result_array($query);
    }

    public function GetLastDspStatus($enp){
        $sql="select top 1 * from [DISP_WEB].[dbo].[disp_plan] p
        where p.enp = '".$enp."'
 order by id desc";
        $query = $this->db_mssql->conn_id->query($sql);
        return $this->elex->row_array($query);
    }


    public function PrepareTfoms($lpu){
        $sql="



DECLARE	@return_value int;

EXEC	@return_value = [DISP_WEB].[dbo].[UpdateDispplan]
		@chief = ". $lpu.",
		@year = 2017;

SELECT	'Return Value' = @return_value;
            ";
        echo $sql;
        $this->db_mssql->conn_id->query($sql);

    }


    public function test11(){
        $sql="


declare @month_beg int = 1;
declare @month_end int = 12;
declare @age_beg int = 21;
declare @age_end int = 99;
declare @drcode varchar(8);


declare @year int = 3;
declare @lpu int = 1402;


select *
from(
select *, ROW_NUMBER() over(order by surname1) as rn,
case when drcode is null or speccode is null then 1 else 0 end as error
from
(select  year(getdate()) - year(i.BIRTHDAY) as vozr,


 null as user_id,


 2017 as  disp_year,
 1 as disp_type,
 i.lpuchief as disp_lpu,
 year(getdate()) - year(i.BIRTHDAY) as  age,

 i.lpubase,
 i.lpubase_u,
 i.type_u as typeui,

 i. enp,


(select count(*) from [OMS].[dbo].[OMSC_INSURED_SREZ]
where d_fin is null
  and lpuchief = @lpu
  and (year(getdate()) - year(i.BIRTHDAY)) % 3 = 0
  and year(getdate()) - year(i.BIRTHDAY) >=21

  ) as kol,


  (select top 1 drcode
      from aktpak.[dbo].akpc_tmodoc
	  where d_fin is null

		and DBSOURCE = 'D'

		and isnull(LPUTER_U,0) = isnull(i.lpubase_u,0)
		and isnull(LPUTER,0) = isnull(i.lpubase,0)
		and isnull(type_u,0) = isnull(i.type_u,0)
      order by drcode
      )  as drcode,
  (select top 1 speccode
      from aktpak.[dbo].akpc_tmodoc
	  where d_fin is null

		and DBSOURCE = 'D'

		and isnull(LPUTER_U,0) = isnull(i.lpubase_u,0)
		and isnull(LPUTER,0) = isnull(i.lpubase,0)
		and isnull(type_u,0) = isnull(i.type_u,0)
      order by drcode
      )  as speccode,

  i.surname as surname1, i.name as name1, i.secname as secname1, i.birthday as birthday1

  ,dp.[status],
  pld.NAME
  , i.SEX sex
  ,dp.[disp_quarter]
  ,e.error_code
    ,te.[description] error_code_description
   ,dp.[disp_start]
   ,dp.[stage_1_result]
   ,dp.[stage_2_result]
   ,dp.[refusal_reason]
   ,dp.[lgg_code]
   ,dp.[disp_final]
from [OMS].[dbo].[OMSC_INSURED_SREZ] i


left join ( select * ,
            ROW_NUMBER() over(partition by enp  order by id desc) as nom
            from [DISP_WEB].[dbo].[disp_plan])
       dp on ((dp.enp=i.ENP) and (nom = 1))

left join [POLYCLINIC_2010].[dbo].[POLM_LPU_DISTRICTS] pld
on (pld.NUM = i.LPUBASE_U)and(pld.LPUCODE = i.LPUBASE)and(pld.D_FIN is null) and i.type_u = pld.typedistrict



left join (select disp_plan_id, error_code,
           ROW_NUMBER() over(partition by disp_plan_id  order by id desc) as nom
		   from  [DISP_WEB].[dbo].[tfoms_errors]) e

on dp.id = e.disp_plan_id and e.nom = 1

		   left join [DISP_WEB].[dbo].[tfoms_errors_descriptions] as  te
on te.error_code = e.error_code

where i.d_fin is null
  and i.lpuchief = @lpu
  and (year(getdate()) - year(i.BIRTHDAY)) % 3 = 0
  and year(getdate()) - year(i.BIRTHDAY) >= 21
  and month(i.birthday) between @month_beg and @month_end
  and (year(getdate()) - year(i.BIRTHDAY)) between  @age_beg and @age_end


) x
where (1=1)





and(error_code = 13)

) y
where  (rn between 0 and 30) order by rn
        ";
        $query = $this->db_mssql->conn_id->query($sql);

        /*http://proft.me/2008/11/28/primery-ispolzovaniya-pdo/*/
        return ['sql'=>$sql,'a'=>$this->elex->result_array($query)];

    }
}

