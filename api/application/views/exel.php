<?php

header("Pragma: public");
header("Expires: 0");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
header("Cache-Control: private", false);
header("Content-Type: application/x-msexcel");
header("Content-Disposition: attachment; filename=patients.csv;");
header("Content-Transfer-Encoding:­ cp1251");


echo "ЛПУ прикрепления;Наименование участка;Участок;Тип участка;Код врача;Специальность врача;Фамилия;Имя;Отчество;Возраст;Дата рождения;Пол;ЕНП;ЛПУ;Квартал;Тип диспансеризации;Год.;"." \n";
 foreach($patients['rows'] as $row){
    echo iconv('UTF-8', 'CP1251',$row['lpubase']).';';; ;
    echo iconv('UTF-8', 'CP1251',$row['NAME']).';';; ;
    echo iconv('UTF-8', 'CP1251',$row['lpubase_u']).';';; ;
    echo iconv('UTF-8', 'CP1251',$row['typeui']).';';; ;
    echo iconv('UTF-8', 'CP1251',$row['drcode']).';';; ;
    echo iconv('UTF-8', 'CP1251',$row['speccode']).';';; ;
    echo iconv('UTF-8', 'CP1251',$row['surname1']).';';; ;
    echo iconv('UTF-8', 'CP1251',$row['name1']).';';; ;
    echo iconv('UTF-8', 'CP1251',$row['secname1']).';';; ;
    echo iconv('UTF-8', 'CP1251',$row['age']).';';; ;
    echo iconv('UTF-8', 'CP1251',$row['birthday1']).';';; ;
    echo iconv('UTF-8', 'CP1251',$row['sex']).';';; ;
    echo iconv('UTF-8', 'CP1251',$row['enp']).';';; ;
    echo iconv('UTF-8', 'CP1251',$row['disp_lpu']).';';; ;
    echo iconv('UTF-8', 'CP1251',$row['disp_quarter']).';';; ;
    echo iconv('UTF-8', 'CP1251',$row['disp_type']).';';; ;
    echo iconv('UTF-8', 'CP1251',$row['disp_year']).';';; ;
     echo "\n";
 }


