
declare @month_beg int = 1;
declare @month_end int = 12;
declare @age_beg int = 21;
declare @age_end int = 99;
declare @drcode varchar(8);


declare @year int = 3;
declare @lpu int = 502;
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
 

(select count(*) from oms..OMSC_INSURED_SREZ
where d_fin is null
  and lpuchief = @lpu
  and (year(getdate()) - year(i.BIRTHDAY)) % 3 = 0
  and year(getdate()) - year(i.BIRTHDAY) >=21
  
  ) as kol,


  (select top 1 drcode
      from aktpak..akpc_tmodoc
	  where d_fin is null

		and DBSOURCE = 'D'

		and isnull(LPUTER_U,0) = isnull(i.lpubase_u,0)
		and isnull(LPUTER,0) = isnull(i.lpubase,0)
		and isnull(type_u,0) = isnull(i.type_u,0)
      order by drcode
      )  as drcode,
  (select top 1 speccode
      from aktpak..akpc_tmodoc
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
from oms..OMSC_INSURED_SREZ i


left join ( select * ,
            ROW_NUMBER() over(partition by enp  order by id desc) as nom
            from [DISP_WEB]..disp_plan) dp on dp.enp=i.ENP and nom = 1

left join [POLYCLINIC_2010].[dbo].[POLM_LPU_DISTRICTS] pld
on (pld.NUM = i.LPUBASE_U)and(pld.LPUCODE = i.LPUBASE)and(pld.D_FIN is null)



where i.d_fin is null
  and i.lpuchief = @lpu
  and (year(getdate()) - year(i.BIRTHDAY)) % 3 = 0
  and year(getdate()) - year(i.BIRTHDAY) >= 21
  and month(i.birthday) between @month_beg and @month_end
  and (year(getdate()) - year(i.BIRTHDAY)) between  @age_beg and @age_end

-- and dp.[status] is not null
 
	-- having drcode = @drcode
) x
where  rn between 20 and 30
order by rn
