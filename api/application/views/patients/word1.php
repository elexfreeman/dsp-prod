<?php
/*
header('Content-Type: text/html; charset=windows-1251');
header('P3P: CP="NOI ADM DEV PSAi COM NAV OUR OTRo STP IND DEM"');
header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
header('Cache-Control: no-store, no-cache, must-revalidate');
header('Cache-Control: post-check=0, pre-check=0', FALSE);
header('Pragma: no-cache');
header('Content-transfer-encoding: binary');
header('Content-Disposition: attachment; filename=list.xls');
header('Content-Type: application/x-unknown');
*/

?>

<!DOCTYPE html>

    <meta http-equiv=Content-Type content="text/html; charset=windows-1251">
    <meta name=Generator content="Microsoft Word 12 (filtered)">
    <style>
        <!--
        /* Font Definitions */
        @font-face {
            font-family: "Cambria Math";
            panose-1: 2 4 5 3 5 4 6 3 2 4;
        }

        @font-face {
            font-family: Calibri;
            panose-1: 2 15 5 2 2 2 4 3 2 4;
        }

        @font-face {
            font-family: Tahoma;
            panose-1: 2 11 6 4 3 5 4 4 2 4;
        }

        /* Style Definitions */
        p.MsoNormal, li.MsoNormal, div.MsoNormal {
            margin-top: 0cm;
            margin-right: 0cm;
            margin-bottom: 10.0pt;
            margin-left: 0cm;
            line-height: 115%;
            font-size: 11.0pt;
            font-family: "Calibri", "sans-serif";
        }

        a:link, span.MsoHyperlink {
            color: blue;
            text-decoration: underline;
        }

        a:visited, span.MsoHyperlinkFollowed {
            color: purple;
            text-decoration: underline;
        }

        p.MsoAcetate, li.MsoAcetate, div.MsoAcetate {
            mso-style-link: "Текст выноски Знак";
            margin: 0cm;
            margin-bottom: .0001pt;
            font-size: 8.0pt;
            font-family: "Tahoma", "sans-serif";
        }

        p.ConsPlusNormal, li.ConsPlusNormal, div.ConsPlusNormal {
            mso-style-name: ConsPlusNormal;
            margin: 0cm;
            margin-bottom: .0001pt;
            text-autospace: none;
            font-size: 11.0pt;
            font-family: "Calibri", "sans-serif";
        }

        p.ConsPlusNonformat, li.ConsPlusNonformat, div.ConsPlusNonformat {
            mso-style-name: ConsPlusNonformat;
            margin: 0cm;
            margin-bottom: .0001pt;
            text-autospace: none;
            font-size: 10.0pt;
            font-family: "Courier New";
        }

        span.a {
            mso-style-name: "Текст выноски Знак";
            mso-style-link: "Текст выноски";
            font-family: "Tahoma", "sans-serif";
        }

        span.block {
            mso-style-name: block;
        }

        .MsoPapDefault {
            margin-bottom: 10.0pt;
            line-height: 115%;
        }

        @page Section1 {
            size: 595.25pt 841.9pt;
            margin: 2.0cm 42.5pt 2.0cm 2.0cm;
        }

        div.Section1 {
            page: Section1;
        }

        -->
    </style>

</head>

<body lang=RU link=blue vlink=purple>

<div class=Section1>

    <p class=ConsPlusNormal style='text-align:justify'><span lang=EN-US>&nbsp;</span></p>

    <p class=ConsPlusNonformat style='text-align:justify'>&nbsp;</p>

    <p class=ConsPlusNonformat align=center style='text-align:center'>
        <?php echo mb_convert_encoding($xml->Buro->OrgName,  "Windows-1251","utf-8"); ?>
    </p>

    <p class=ConsPlusNonformat align=center style='text-align:center'><span
            style='font-family:"Times New Roman","serif"'>_______________________________________________________________________</span>
    </p>

    <p class=ConsPlusNonformat align=center style='text-align:center'><span
            style='font-family:"Times New Roman","serif"'>(наименование федерального государственного учреждения</span></p>

    <p class=ConsPlusNonformat align=center style='text-align:center'><span
            style='font-family:"Times New Roman","serif"'>медико-социальной экспертизы)</span></p>

    <p class=ConsPlusNonformat align=center style='text-align:center'><span
            style='font-family:"Times New Roman","serif"'>&nbsp;</span></p>

    <p class=ConsPlusNonformat align=center style='text-align:center'><b><span
                style='font-family:"Times New Roman","serif"'>Индивидуальная программа</span></b></p>

    <p class=ConsPlusNonformat align=center style='text-align:center'><b><span
                style='font-family:"Times New Roman","serif"'>реабилитации или абилитации
инвалида, выдаваемая федеральными</span></b></p>

    <p class=ConsPlusNonformat align=center style='text-align:center'><b><span
                style='font-family:"Times New Roman","serif"'>государственными учреждениями
медико-социальной экспертизы</span></b></p>

    <p class=ConsPlusNonformat align=center style='text-align:center'><span
            style='font-family:"Times New Roman","serif"'>&nbsp;</span></p>

    <p class=ConsPlusNonformat align=center style='text-align:center'><span
            style='font-family:"Times New Roman","serif"'>ИПРА инвалида N <?php echo $xml->Number; ?>
            к протоколу проведения</span></p>

    <p class=ConsPlusNonformat align=center style='text-align:center'><span
            style='font-family:"Times New Roman","serif"'>медико-социальной экспертизы гражданина N <?php echo $xml->ProtocolNum; ?> от <?php
             $ProtocolDate = strtotime( $xml->ProtocolDate );
            $ProtocolDate = date( 'd.m.Y', $ProtocolDate );
            echo $ProtocolDate; ?> г.</p>

    <p class=ConsPlusNonformat style='text-align:justify'>&nbsp;</p>

    <p class=ConsPlusNonformat style='font-family:
"Times New Roman","serif";text-align:justify;'>1. Дата разработки ИПРА инвалида: <?php
        $DevelopDate = strtotime( $xml->DevelopDate );
        $DevelopDate = date( 'd.m.Y', $DevelopDate );
        echo $DevelopDate; ?>
    </p>

    <p class=ConsPlusNonformat style='text-align:justify'>&nbsp;</p>

    <p class=ConsPlusNonformat style='text-align:justify'><b><span
                style='font-family:"Times New Roman","serif"'>Общие данные об инвалиде</span></b></p>

    <p class=ConsPlusNonformat style='text-align:justify'><span style='font-family:
"Times New Roman","serif"'>&nbsp;</span></p>

    <p class=ConsPlusNonformat style='text-align:justify'><span style='font-family:
"Times New Roman","serif"'>2. Фамилия, имя, отчество (при наличии): <?php
            echo mb_convert_encoding($xml->Person->FIO->LastName,  "Windows-1251","utf-8");
             ?>
            <?php
            echo mb_convert_encoding($xml->Person->FIO->FirstName,  "Windows-1251","utf-8");
             ?>
        <?php echo mb_convert_encoding($xml->Person->FIO->SecondName,  "Windows-1251","utf-8") ; ?></p>

    <p class=ConsPlusNonformat style='text-align:justify'>
        <span style='font-family:
"Times New Roman","serif"'>3. Дата рождения: <?php
            $BirthDate = strtotime( $xml->BirthDate );
            $BirthDate = date( 'd.m.Y', $BirthDate );
            echo $BirthDate; ?> <span >день ________ месяц прописью____ год ________</span></span></p>

    <p class=ConsPlusNonformat style='text-align:justify'><span style='font-family:
"Times New Roman","serif"'>4. Возраст (число полных лет): <?php echo $xml->Person->Age; ?></p>

    <p class=ConsPlusNormal style='text-align:justify'><span style='font-family:
"Times New Roman","serif"'>&nbsp;</span></p>

    <table class=MsoNormalTable border=1 cellspacing=0 cellpadding=0
           style='margin-left:3.1pt;border-collapse:collapse;border:none'>
        <tr>
            <td width=57 valign=top style='width:42.5pt;border:none;border-right:solid windowtext 1.0pt;
  padding:5.1pt 3.1pt 5.1pt 3.1pt'>
                <p class=ConsPlusNormal>&nbsp;</p>
            </td>
            <td width=200 colspan=3 valign=top style='width:150.0pt;border-top:solid windowtext 1.0pt;
  border-left:none;border-bottom:none;border-right:solid windowtext 1.0pt;
  padding:5.1pt 3.1pt 5.1pt 3.1pt'>
                <p class=ConsPlusNormal>&nbsp;</p>
            </td>
            <td width=201 colspan=3 valign=top style='width:150.5pt;border-top:solid windowtext 1.0pt;
  border-left:none;border-bottom:none;border-right:solid windowtext 1.0pt;
  padding:5.1pt 3.1pt 5.1pt 3.1pt'>
                <p class=ConsPlusNormal>&nbsp;</p>
            </td>
        </tr>
        <tr>
            <td width=57 valign=top style='width:42.5pt;border:none;border-right:solid windowtext 1.0pt;
  padding:5.1pt 3.1pt 5.1pt 3.1pt'>
                <p class=ConsPlusNormal>5. Пол:</p>
            </td>
            <td width=43 valign=top style='width:32.4pt;border:none;border-right:solid windowtext 1.0pt;
  padding:5.1pt 3.1pt 5.1pt 3.1pt'>
                <p class=ConsPlusNormal>5.1.</p>
            </td>
            <td width=16 valign=top style='width:12.0pt;border:solid windowtext 1.0pt;
  border-left:none;padding:5.1pt 3.1pt 5.1pt 3.1pt'>
                <p class=ConsPlusNormal><?php if ($xml->Person->IsMale == 'true') echo 'X'; ?></p>
            </td>
            <td width=141 valign=top style='width:105.6pt;border:none;border-right:solid windowtext 1.0pt;
  padding:5.1pt 3.1pt 5.1pt 3.1pt'>
                <p class=ConsPlusNormal>мужской</p>
            </td>
            <td width=43 valign=top style='width:32.4pt;border:none;border-right:solid windowtext 1.0pt;
  padding:5.1pt 3.1pt 5.1pt 3.1pt'>
                <p class=ConsPlusNormal>5.2.</p>
            </td>
            <td width=16 valign=top style='width:12.0pt;border:solid windowtext 1.0pt;
  border-left:none;padding:5.1pt 3.1pt 5.1pt 3.1pt'>
                <p class=ConsPlusNormal><?php if ($xml->Person->IsMale == 'false') echo 'X'; ?></p>
            </td>
            <td width=141 valign=top style='width:106.1pt;border:none;border-right:solid windowtext 1.0pt;
  padding:5.1pt 3.1pt 5.1pt 3.1pt'>
                <p class=ConsPlusNormal>женский</p>
            </td>
        </tr>
        <tr>
            <td width=57 valign=top style='width:42.5pt;border:none;border-right:solid windowtext 1.0pt;
  padding:5.1pt 3.1pt 5.1pt 3.1pt'>
                <p class=ConsPlusNormal>&nbsp;</p>
            </td>
            <td width=200 colspan=3 valign=top style='width:150.0pt;border-top:none;
  border-left:none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  padding:5.1pt 3.1pt 5.1pt 3.1pt'>
                <p class=ConsPlusNormal>&nbsp;</p>
            </td>
            <td width=201 colspan=3 valign=top style='width:150.5pt;border-top:none;
  border-left:none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  padding:5.1pt 3.1pt 5.1pt 3.1pt'>
                <p class=ConsPlusNormal>&nbsp;</p>
            </td>
        </tr>
        <tr height=0>
            <td width=57 style='border:none'></td>
            <td width=43 style='border:none'></td>
            <td width=16 style='border:none'></td>
            <td width=141 style='border:none'></td>
            <td width=43 style='border:none'></td>
            <td width=16 style='border:none'></td>
            <td width=141 style='border:none'></td>
        </tr>
    </table>

    <p class=ConsPlusNormal style='text-align:justify'><span style='font-family:
"Times New Roman","serif"'>&nbsp;</span></p>

    <p class=ConsPlusNonformat style='text-align:justify'><span style='font-family:
"Times New Roman","serif"'>6. Гражданство:</span></p>

    <p class=ConsPlusNormal style='text-align:justify'>&nbsp;</p>

    <table class=MsoNormalTable border=1 cellspacing=0 cellpadding=0
           style='margin-left:3.1pt;border-collapse:collapse;border:none'>
        <tr>
            <td width=215 colspan=3 valign=top style='width:161.15pt;border-top:solid windowtext 1.0pt;
  border-left:solid windowtext 1.0pt;border-bottom:none;border-right:none;
  padding:5.1pt 3.1pt 5.1pt 3.1pt'>
                <p class=ConsPlusNormal>&nbsp;</p>
            </td>
            <td width=214 colspan=3 valign=top style='width:160.65pt;border:none;
  border-top:solid windowtext 1.0pt;padding:5.1pt 3.1pt 5.1pt 3.1pt'>
                <p class=ConsPlusNormal>&nbsp;</p>
            </td>
            <td width=215 colspan=3 valign=top style='width:161.15pt;border-top:solid windowtext 1.0pt;
  border-left:none;border-bottom:none;border-right:solid windowtext 1.0pt;
  padding:5.1pt 3.1pt 5.1pt 3.1pt'>
                <p class=ConsPlusNormal>&nbsp;</p>
            </td>
        </tr>
        <tr>
            <td width=36 valign=top style='width:27.0pt;border-top:none;border-left:solid windowtext 1.0pt;
  border-bottom:none;border-right:solid windowtext 1.0pt;padding:5.1pt 3.1pt 5.1pt 3.1pt'>
                <p class=ConsPlusNormal>6.1.</p>
            </td>
            <td width=19 valign=top style='width:14.5pt;border:solid windowtext 1.0pt;
  border-left:none;padding:5.1pt 3.1pt 5.1pt 3.1pt'>
                <p class=ConsPlusNormal><?php
                    /*Россия*/
                    if($xml->Person->Citizenship->Id==1) echo 'X';
                    ?></p>
            </td>
            <td width=160 valign=top style='width:119.65pt;border:none;padding:5.1pt 3.1pt 5.1pt 3.1pt'>
                <p class=ConsPlusNormal>гражданин</p>
            </td>
            <td width=37 valign=top style='width:28.1pt;border:none;border-right:solid windowtext 1.0pt;
  padding:5.1pt 3.1pt 5.1pt 3.1pt'>
                <p class=ConsPlusNormal>6.2.</p>
            </td>
            <td width=18 valign=top style='width:13.25pt;border:solid windowtext 1.0pt;
  border-left:none;padding:5.1pt 3.1pt 5.1pt 3.1pt'>
                <p class=ConsPlusNormal><?php

                    if($xml->Person->Citizenship->Id==2) echo 'X';
                    ?></p>
            </td>
            <td width=159 valign=top style='width:119.3pt;border:none;padding:5.1pt 3.1pt 5.1pt 3.1pt'>
                <p class=ConsPlusNormal>гражданин</p>
            </td>
            <td width=42 valign=top style='width:31.15pt;border:none;border-right:solid windowtext 1.0pt;
  padding:5.1pt 3.1pt 5.1pt 3.1pt'>
                <p class=ConsPlusNormal>6.3.</p>
            </td>
            <td width=16 valign=top style='width:11.9pt;border:solid windowtext 1.0pt;
  border-left:none;padding:5.1pt 3.1pt 5.1pt 3.1pt'>
                <p class=ConsPlusNormal><?php

                    if($xml->Person->Citizenship->Id==3) echo 'X';
                    ?></p>
            </td>
            <td width=157 valign=top style='width:118.1pt;border:none;border-right:solid windowtext 1.0pt;
  padding:5.1pt 3.1pt 5.1pt 3.1pt'>
                <p class=ConsPlusNormal>лицо без</p>
            </td>
        </tr>
        <tr>
            <td width=215 colspan=3 valign=top style='width:161.15pt;border-top:none;
  border-left:solid windowtext 1.0pt;border-bottom:solid windowtext 1.0pt;
  border-right:none;padding:5.1pt 3.1pt 5.1pt 3.1pt'>
                <p class=ConsPlusNormal>Российской Федерации</p>
            </td>
            <td width=214 colspan=3 valign=top style='width:160.65pt;border:none;
  border-bottom:solid windowtext 1.0pt;padding:5.1pt 3.1pt 5.1pt 3.1pt'>
                <p class=ConsPlusNormal>иностранного государства, находящийся на территории
                    Российской Федерации</p>
            </td>
            <td width=215 colspan=3 valign=top style='width:161.15pt;border-top:none;
  border-left:none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  padding:5.1pt 3.1pt 5.1pt 3.1pt'>
                <p class=ConsPlusNormal>гражданства, находящееся на территории Российской
                    Федерации</p>
            </td>
        </tr>
        <tr height=0>
            <td width=36 style='border:none'></td>
            <td width=19 style='border:none'></td>
            <td width=160 style='border:none'></td>
            <td width=37 style='border:none'></td>
            <td width=18 style='border:none'></td>
            <td width=159 style='border:none'></td>
            <td width=42 style='border:none'></td>
            <td width=16 style='border:none'></td>
            <td width=157 style='border:none'></td>
        </tr>
    </table>

    <p class=ConsPlusNormal style='text-align:justify'>&nbsp;</p>

    <p class=ConsPlusNonformat style='text-align:justify'><span style='font-family:
"Times New Roman","serif"'>
7.  Адрес места жительства (при  отсутствии  места жительства  указываетсяадрес <br>
места  пребывания,  фактического проживания на территории Российской Федерации,  место<br>
нахождения  пенсионного  дела инвалида,  выехавшего  напостоянное  место  жительства за <br>
пределы Российской Федерации) (указываемое</span></p>

    <p class=ConsPlusNonformat style='text-align:justify'><span style='font-family:
"Times New Roman","serif"'>подчеркнуть):</span></p>

    <p class=ConsPlusNonformat style='text-align:justify'><span style='font-family:
"Times New Roman","serif"'>7.1. государство: ______________</span></p>

    <p class=ConsPlusNonformat style='text-align:justify'><span style='font-family:
"Times New Roman","serif"'>7.2. почтовый индекс: ________________</span></p>

    <p class=ConsPlusNonformat style='text-align:justify'><span style='font-family:
"Times New Roman","serif"'>7.3. субъект Российской Федерации: _______________</span></p>

    <p class=ConsPlusNonformat style='text-align:justify'><span style='font-family:
"Times New Roman","serif"'>7.4. район: ____________</span></p>

    <p class=ConsPlusNormal style='text-align:justify'>&nbsp;</p>

    <table class=MsoNormalTable border=0 cellspacing=0 cellpadding=0
           style='margin-left:3.1pt;border-collapse:collapse'>
        <tr>
            <td width=214 valign=top style='width:160.5pt;border:none;border-right:solid windowtext 1.0pt;
  padding:5.1pt 3.1pt 5.1pt 3.1pt'>
                <p class=ConsPlusNormal><span style='font-family:"Times New Roman","serif"'>7.5.
  населенный пункт (7.5.1.</span></p>
            </td>
            <td width=15 valign=top style='width:11.2pt;border:solid windowtext 1.0pt;
  border-left:none;padding:5.1pt 3.1pt 5.1pt 3.1pt'>
                <p class=ConsPlusNormal><span style='font-family:"Times New Roman","serif"'>&nbsp;</span></p>
            </td>
            <td width=202 valign=top style='width:151.15pt;border:none;border-right:solid windowtext 1.0pt;
  padding:5.1pt 3.1pt 5.1pt 3.1pt'>
                <p class=ConsPlusNormal><span style='font-family:"Times New Roman","serif"'>городское
  поселение 7.5.2.</span></p>
            </td>
            <td width=15 valign=top style='width:11.2pt;border:solid windowtext 1.0pt;
  border-left:none;padding:5.1pt 3.1pt 5.1pt 3.1pt'>
                <p class=ConsPlusNormal><span style='font-family:"Times New Roman","serif"'>&nbsp;</span></p>
            </td>
            <td width=199 valign=top style='width:148.9pt;border:none;padding:5.1pt 3.1pt 5.1pt 3.1pt'>
                <p class=ConsPlusNormal><span style='font-family:"Times New Roman","serif"'>сельское
  поселение): ____</span></p>
            </td>
        </tr>
    </table>

    <p class=ConsPlusNormal style='text-align:justify'><span style='font-family:
"Times New Roman","serif"'>&nbsp;</span></p>

    <p class=ConsPlusNonformat style='text-align:justify'><span style='font-family:
"Times New Roman","serif"'>7.6. улица: ____________________________</span></p>

    <p class=ConsPlusNonformat style='text-align:justify'><span style='font-family:
"Times New Roman","serif"'>7.7. дом/корпус/строение: ___/___/______</span></p>

    <p class=ConsPlusNonformat style='text-align:justify'><span style='font-family:
"Times New Roman","serif"'>7.8. квартира: _________</span></p>

    <p class=ConsPlusNormal style='text-align:justify'><span style='font-family:
"Times New Roman","serif"'>&nbsp;</span></p>

    <table class=MsoNormalTable border=1 cellspacing=0 cellpadding=0
           style='margin-left:3.1pt;border-collapse:collapse;border:none'>
        <tr>
            <td width=322 valign=top style='width:241.7pt;border:none;border-right:solid windowtext 1.0pt;
  padding:5.1pt 3.1pt 5.1pt 3.1pt'>
                <p class=ConsPlusNormal><span style='font-family:"Times New Roman","serif"'>8.
  Лицо без определенного места жительства</span></p>

            </td>
            <td width=15 valign=top style='width:11.2pt;border:solid windowtext 1.0pt;
  border-left:none;padding:5.1pt 3.1pt 5.1pt 3.1pt'>
                <p class=ConsPlusNormal><span style='font-family:"Times New Roman","serif"'><?php
                        if ($xml->Person->HasNoLivingAddress == 'true') echo "X";
                        ?>
                    </span></p>
            </td>
        </tr>
    </table>

    <p class=ConsPlusNormal style='text-align:justify'>&nbsp;</p>

    <p class=ConsPlusNonformat style='text-align:justify'><span style='font-family:
"Times New Roman","serif"'>
9.  Наименование территориального органа Пенсионного  фонда  Российской Федерации,<br>
осуществляющего  пенсионное обеспечение инвалида, выехавшего напостоянное жительство<br>
за пределы Российской Федерации _____________________</span></p>

    <p class=ConsPlusNonformat style='text-align:justify'>&nbsp;</p>

    <p class=ConsPlusNonformat style='text-align:justify'><span style='font-family:
"Times New Roman","serif"'>10.  Место  постоянной  регистрации (при 
совпадении  реквизитов  с  местомжительства данный пункт не заполняется):</span></p>

    <p class=ConsPlusNonformat style='text-align:justify'><span style='font-family:
"Times New Roman","serif"'>
            10.1. государство:
            <?php echo mb_convert_encoding($xml->Person->RegAddress->Fields->Country,  "Windows-1251","utf-8"); ?></span></p>

    <p class=ConsPlusNonformat style='text-align:justify'><span style='font-family:
"Times New Roman","serif"'>
            10.2. почтовый индекс: <?php echo mb_convert_encoding($xml->Person->RegAddress->Fields->ZipCode,  "Windows-1251","utf-8");; ?></span></p>

    <p class=ConsPlusNonformat style='text-align:justify'>
        <span style='font-family:
"Times New Roman","serif"'>
            10.3. субъект Российской Федерации:

            <?php echo  mb_convert_encoding($xml->Person->RegAddress->Fields->TerritorySubjectName,  "Windows-1251","utf-8"); ?></span>
    </p>

    <p class=ConsPlusNonformat style='text-align:justify'>
        <span lang=EN-US style='font-family:"Times New Roman","serif"'>10.4. </span>
        <span
            style='font-family:"Times New Roman","serif"'>район: <?php echo mb_convert_encoding($xml->Person->RegAddress->Fields->CityDistrict,  "Windows-1251","utf-8"); ?></span>
    </p>

    <p class=ConsPlusNonformat style='text-align:justify'>
        <span lang=EN-US style='font-family:"Times New Roman","serif"'>10.5.  населенный пункт: <?php echo  mb_convert_encoding($xml->Person->RegAddress->Fields->Place,  "Windows-1251","utf-8"); ?></span>
     </p>

    <p class=ConsPlusNonformat style='text-align:justify'>
        <span lang=EN-US style='font-family:"Times New Roman","serif"'>10.6. </span>
        <span style='font-family:"Times New Roman","serif"'>улица: <?php echo mb_convert_encoding($xml->Person->RegAddress->Fields->Street,  "Windows-1251","utf-8"); ?></span>
    </p>

    <p class=ConsPlusNonformat style='text-align:justify'>
        <span lang=EN-US style='font-family:"Times New Roman","serif"'>10.7. </span>
        <span style='font-family:"Times New Roman","serif"'>дом/корпус/строение: <?php echo mb_convert_encoding($xml->Person->RegAddress->Fields->House,  "Windows-1251","utf-8"); ?></span>

    </p>

    <p class=ConsPlusNonformat style='text-align:justify'>
        <span style='font-family:"Times New Roman","serif"'>10.8. квартира:
            <?php echo mb_convert_encoding($xml->Person->RegAddress->Fields->Appartment,  "Windows-1251","utf-8"); ?></span></p>

    <p class=ConsPlusNonformat style='text-align:justify'><span style='font-family:
"Times New Roman","serif"'>&nbsp;</span></p>

    <table class=MsoNormalTable border=1 cellspacing=0 cellpadding=0
           style='margin-left:3.1pt;border-collapse:collapse;border:none'>
        <tr>
            <td width=278 valign=top style='width:208.8pt;border:none;border-right:solid windowtext 1.0pt;
  padding:5.1pt 3.1pt 5.1pt 3.1pt'>
                <p class=ConsPlusNormal><span style='font-family:"Times New Roman","serif"'>11.
  Лицо без постоянной регистрации</span></p>


            </td>
            <td width=14 valign=top style='width:10.5pt;border:solid windowtext 1.0pt;
  border-left:none;padding:5.1pt 3.1pt 5.1pt 3.1pt'>
                <p class=ConsPlusNormal><span style='font-family:"Times New Roman","serif"'><?php if ($xml->Person->HasNoRegAddress == 'true') echo "X"; ?></span></p>
            </td>
        </tr>
    </table>

    <p class=ConsPlusNormal style='text-align:justify'>&nbsp;</p>

    <p class=ConsPlusNonformat style='text-align:justify'><span style='font-family:
"Times New Roman","serif"'>12. Контактная информация:</span></p>

    <p class=ConsPlusNonformat style='text-align:justify'>
        <span style='font-family:
"Times New Roman","serif"'>12.1. контактные телефоны:  <?php echo $xml->Person->Phones->Phone; ?></span>
    </p>

    <p class=ConsPlusNonformat style='text-align:justify'><span style='font-family:
"Times New Roman","serif"'>12.2. адрес электронной почты: <?php echo $xml->Person->Email; ?> </p>

    <p class=ConsPlusNonformat style='text-align:justify'><span style='font-family:
"Times New Roman","serif"'>13. Страховой номер индивидуального лицевого счета:
            <?php echo $xml->Person->SNILS; ?>
    </p>

    <p class=ConsPlusNonformat style='text-align:justify'><span style='font-family:
"Times New Roman","serif"'>14.  Документ,  удостоверяющий   личность  инвалида 
(указать  наименование документа):
            <br><?php echo mb_convert_encoding($xml->Person->IdentityDoc->Title,  "Windows-1251","utf-8") ; ?>, серия:
            <?php echo $xml->Person->IdentityDoc->Series ; ?>, номер:
            <?php echo mb_convert_encoding($xml->Person->IdentityDoc->Number,  "Windows-1251","utf-8") ; ?>, кем выдан:
            <?php echo mb_convert_encoding($xml->Person->IdentityDoc->Issuer,  "Windows-1251","utf-8") ; ?>, дата выдачи:
            <?php
            $IssueDate = strtotime($xml->Person->IdentityDoc->IssueDate );
            $IssueDate = date( 'd.m.Y', $IssueDate );
            echo $IssueDate ; ?>


    </p>

    <p class=ConsPlusNonformat style='text-align:justify'><span style='font-family:
"Times New Roman","serif"'>&nbsp;</span></p>

    <p class=ConsPlusNonformat style='text-align:justify'><span style='font-family:
"Times New Roman","serif"'>15.  Фамилия,  имя,  отчество  (при  наличии) 
законного  (уполномоченного)</span></p>

    <p class=ConsPlusNonformat style='text-align:justify'><span style='font-family:
"Times New Roman","serif"'>представителя инвалида (нужное подчеркнуть):</span></p>

    <p class=ConsPlusNonformat style='text-align:justify'><span style='font-family:
"Times New Roman","serif"'>___________________________________________________________________________</span></p>

    <p class=ConsPlusNonformat style='text-align:justify'><span style='font-family:
"Times New Roman","serif"'>    (заполняется при наличии законного
(уполномоченного) представителя)</span></p>

    <p class=ConsPlusNonformat style='text-align:justify'><span style='font-family:
"Times New Roman","serif"'>15.1.  документ,   удостоверяющий  полномочия 
законного  (уполномоченного)</span></p>

    <p class=ConsPlusNonformat style='text-align:justify'><span style='font-family:
"Times New Roman","serif"'>представителя (нужное подчеркнуть) (указать
наименование документа):</span></p>

    <p class=ConsPlusNonformat style='text-align:justify'><span style='font-family:
"Times New Roman","serif"'>______________________ серия ___________ N _________
кем выдан ____________</span></p>

    <p class=ConsPlusNonformat style='text-align:justify'><span style='font-family:
"Times New Roman","serif"'>когда выдан _______________________________________________________________</span></p>

    <p class=ConsPlusNonformat style='text-align:justify'><span style='font-family:
"Times New Roman","serif"'>15.2.  документ,   удостоверяющий   личность  
законного  (уполномоченного)</span></p>

    <p class=ConsPlusNonformat style='text-align:justify'><span style='font-family:
"Times New Roman","serif"'>представителя (нужное подчеркнуть) (указать
наименование документа):</span></p>

    <p class=ConsPlusNonformat style='text-align:justify'><span style='font-family:
"Times New Roman","serif"'>______________________ серия ___________ N _________
кем выдан ____________</span></p>

    <p class=ConsPlusNonformat style='text-align:justify'><span style='font-family:
"Times New Roman","serif"'>когда выдан
_______________________________________________________________</span></p>

    <p class=ConsPlusNonformat style='text-align:justify'><span style='font-family:
"Times New Roman","serif"'>16. Показания к проведению реабилитационных или
абилитационных мероприятий:</span></p>

    <p class=ConsPlusNormal style='text-align:justify'>&nbsp;</p>

    <table class=MsoNormalTable border=1 cellspacing=0 cellpadding=0 width=643
           style='width:17.0cm;margin-left:3.1pt;border-collapse:collapse;border:none'>
        <tr>
            <td width=265 valign=top style='width:7.0cm;border:solid windowtext 1.0pt;
  padding:5.1pt 3.1pt 5.1pt 3.1pt'>
                <p class=ConsPlusNormal align=center style='text-align:center'><span
                        style='font-family:"Times New Roman","serif"'>Перечень ограничений основных
  категорий жизнедеятельности</span></p>
            </td>
            <td width=378 valign=top style='width:10.0cm;border:solid windowtext 1.0pt;
  border-left:none;padding:5.1pt 3.1pt 5.1pt 3.1pt'>
                <p class=ConsPlusNormal align=center style='text-align:center'><span
                        style='font-family:"Times New Roman","serif"'>Степень ограничения (1, 2, 3)</span></p>
            </td>
        </tr>
        <tr>
            <td width=265 valign=top style='width:7.0cm;border:solid windowtext 1.0pt;
  border-top:none;padding:5.1pt 3.1pt 5.1pt 3.1pt'>
                <p class=ConsPlusNormal><span style='font-family:"Times New Roman","serif"'>способности
  к самообслуживанию:</span></p>
            </td>
            <td width=378 valign=top style='width:10.0cm;border-top:none;border-left:
  none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;text-align: center;
  padding:5.1pt 3.1pt 5.1pt 3.1pt'>
                <?php if((int)$xml->LifeRestrictions->SelfCare<4) echo $xml->LifeRestrictions->SelfCare;   ?>
            </td>
        </tr>
        <tr>
            <td width=265 valign=top style='width:7.0cm;border:solid windowtext 1.0pt;
  border-top:none;padding:5.1pt 3.1pt 5.1pt 3.1pt'>
                <p class=ConsPlusNormal><span style='font-family:"Times New Roman","serif"'>способности
  к передвижению:</span></p>
            </td>
            <td width=378 valign=top style='width:10.0cm;border-top:none;border-left:
  none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;;text-align: center;
  padding:5.1pt 3.1pt 5.1pt 3.1pt'>
                <?php if((int)$xml->LifeRestrictions->Moving<4) echo $xml->LifeRestrictions->Moving;   ?>
            </td>
        </tr>
        <tr>
            <td width=265 valign=top style='width:7.0cm;border:solid windowtext 1.0pt;
  border-top:none;padding:5.1pt 3.1pt 5.1pt 3.1pt'>
                <p class=ConsPlusNormal><span style='font-family:"Times New Roman","serif"'>способности
  к ориентации:</span></p>
            </td>
            <td width=378 valign=top style='width:10.0cm;border-top:none;border-left:
  none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;text-align: center;
  padding:5.1pt 3.1pt 5.1pt 3.1pt'>
                <?php if((int)$xml->LifeRestrictions->Orientation<4) echo $xml->LifeRestrictions->Orientation;   ?>
            </td>
        </tr>
        <tr>
            <td width=265 valign=top style='width:7.0cm;border:solid windowtext 1.0pt;
  border-top:none;padding:5.1pt 3.1pt 5.1pt 3.1pt'>
                <p class=ConsPlusNormal><span style='font-family:"Times New Roman","serif"'>способности
  к общению:</span></p>
            </td>
            <td width=378 valign=top style='width:10.0cm;border-top:none;border-left:
  none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;text-align: center;
  padding:5.1pt 3.1pt 5.1pt 3.1pt'>
                <?php if((int)$xml->LifeRestrictions->Communication<4) echo $xml->LifeRestrictions->Communication;   ?>
            </td>
        </tr>
        <tr>
            <td width=265 valign=top style='width:7.0cm;border:solid windowtext 1.0pt;
  border-top:none;padding:5.1pt 3.1pt 5.1pt 3.1pt'>
                <p class=ConsPlusNormal><span style='font-family:"Times New Roman","serif"'>способности
  к обучению:</span></p>
            </td>
            <td width=378 valign=top style='width:10.0cm;border-top:none;border-left:
  none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;text-align: center;
  padding:5.1pt 3.1pt 5.1pt 3.1pt'>
                <?php if((int)$xml->LifeRestrictions->Learn<4) echo $xml->LifeRestrictions->Learn;   ?>
            </td>
        </tr>
        <tr>
            <td width=265 valign=top style='width:7.0cm;border:solid windowtext 1.0pt;
  border-top:none;padding:5.1pt 3.1pt 5.1pt 3.1pt'>
                <p class=ConsPlusNormal><span style='font-family:"Times New Roman","serif"'>способности
  к трудовой деятельности:</span></p>
            </td>
            <td width=378 valign=top style='width:10.0cm;border-top:none;border-left:
  none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;text-align: center;
  padding:5.1pt 3.1pt 5.1pt 3.1pt'>
                <?php if((int)$xml->LifeRestrictions->Work<4) echo $xml->LifeRestrictions->Work;   ?>
            </td>
        </tr>
        <tr>
            <td width=265 valign=top style='width:7.0cm;border:solid windowtext 1.0pt;
  border-top:none;padding:5.1pt 3.1pt 5.1pt 3.1pt'>
                <p class=ConsPlusNormal><span style='font-family:"Times New Roman","serif"'>способности
  к контролю за своим поведением:</span></p>
            </td>
            <td width=378 valign=top style='width:10.0cm;border-top:none;border-left:
  none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;text-align: center;
  padding:5.1pt 3.1pt 5.1pt 3.1pt'>
                <?php if((int)$xml->LifeRestrictions->BehaviorControl<4) echo $xml->LifeRestrictions->BehaviorControl;   ?>
            </td>
        </tr>
    </table>

    <p class=ConsPlusNormal style='text-align:justify'><span lang=EN-US>&nbsp;</span></p>

    <p class=ConsPlusNonformat style='text-align:justify'><span style='font-family:
"Times New Roman","serif"'>17. ИПРА  инвалида  разработана  впервые,  повторно 
(нужное   подчеркнуть)</span></p>

    <p class=ConsPlusNonformat style='text-align:justify;'><span
            style='font-family:"Times New Roman","serif"'>на срок до:
        <?php

        $PeriodTo = strtotime( $xml->MedSection->EventGroups->Group->PeriodTo );
        $PeriodTo = date( 'd.m.Y', $PeriodTo );
        echo $PeriodTo;
        ?></p>

    <p class=ConsPlusNonformat style='text-align:justify'><span style='font-family:
"Times New Roman","serif"'>___________________________________________________________________________</span></p>

    <p class=ConsPlusNonformat style='text-align:justify'><span style='font-family:
"Times New Roman","serif"'>  (после предлога &quot;до&quot; указывается первое
число месяца, следующего за теммесяцем, на который назначено
переосвидетельствование, и год,на который назначено очередное переосвидетельствование,                    
либо делается запись &quot;бессрочно&quot;)</span></p>

    <p class=ConsPlusNonformat style='text-align:justify;'><span
            style='font-family:"Times New Roman","serif"'>18. Дата выдачи ИПРА инвалида  <?php

            $IssueDate = strtotime( $xml->MedSection->EventGroups->Group->IssueDate );
            $IssueDate = date( 'd.m.Y', $IssueDate );
            echo $IssueDate;
            ?> день ___
месяц прописью____ год ________</span></p>

    <p class=ConsPlusNonformat style='text-align:justify'><span style='font-family:
"Times New Roman","serif"'>&nbsp;</span></p>

    <p class=ConsPlusNonformat align=center style='text-align:center'><b><span
                style='font-family:"Times New Roman","serif"'>Мероприятия медицинской
реабилитации или абилитации</span></b></p>

    <p class=ConsPlusNormal style='text-align:justify'>&nbsp;</p>

    <table class=MsoNormalTable border=1 cellspacing=0 cellpadding=0
           style='margin-left:3.1pt;border-collapse:collapse;border:none'>
        <tr>
            <td width=272 colspan=3 valign=top style='width:203.9pt;border:solid windowtext 1.0pt;
  padding:5.1pt 3.1pt 5.1pt 3.1pt'>
                <p class=ConsPlusNormal align=center style='text-align:center'><span
                        style='font-family:"Times New Roman","serif"'>Заключение о нуждаемости (ненуждаемости)
  в проведении мероприятий медицинской реабилитации или абилитации</span></p>
            </td>
            <td width=188 valign=top style='width:141.35pt;border:solid windowtext 1.0pt;
  border-left:none;padding:5.1pt 3.1pt 5.1pt 3.1pt'><?php echo $xml->MedSection->EventGroups->Group->Need; ?>
                <p class=ConsPlusNormal align=center style='text-align:center'><span
                        style='font-family:"Times New Roman","serif"'>Срок исполнения заключения о
  нуждаемости в проведении мероприятий медицинской реабилитации или абилитации</span></p>
            </td>
            <td width=182 valign=top style='width:136.7pt;border:solid windowtext 1.0pt;
  border-left:none;padding:5.1pt 3.1pt 5.1pt 3.1pt'>
                <p class=ConsPlusNormal align=center style='text-align:center'><span
                        style='font-family:"Times New Roman","serif"'>Исполнитель заключения о
  нуждаемости в проведении мероприятий медицинской реабилитации или абилитации</span></p>
            </td>
        </tr>
        <tr>
            <td width=643 colspan=5 valign=top style='width:17.0cm;border:solid windowtext 1.0pt;
  border-top:none;padding:5.1pt 3.1pt 5.1pt 3.1pt'>
                <p class=ConsPlusNormal align=center style='text-align:center'><span
                        style='font-family:"Times New Roman","serif"'>Медицинская реабилитация</span></p>
            </td>
        </tr>
        <tr>
            <td width=272 colspan=3 valign=top style='width:203.9pt;border-top:none;
  border-left:solid windowtext 1.0pt;border-bottom:none;border-right:solid windowtext 1.0pt;
  padding:5.1pt 3.1pt 5.1pt 3.1pt'>
                <p class=ConsPlusNormal><span style='font-family:"Times New Roman","serif"'>&nbsp;</span></p>
            </td>
            <td width=188 valign=top style='width:141.35pt;border:none;border-right:solid windowtext 1.0pt;
  padding:5.1pt 3.1pt 5.1pt 3.1pt'>
                <p class=ConsPlusNormal><span style='font-family:"Times New Roman","serif"'>&nbsp;</span></p>
            </td>
            <td width=182 valign=top style='width:136.7pt;border:none;border-right:solid windowtext 1.0pt;
  padding:5.1pt 3.1pt 5.1pt 3.1pt'>
                <p class=ConsPlusNormal><span style='font-family:"Times New Roman","serif"'>&nbsp;</span></p>
            </td>
        </tr>
        <tr>
            <td width=12 valign=top style='width:9.3pt;border-top:none;border-left:solid windowtext 1.0pt;
  border-bottom:none;border-right:solid windowtext 1.0pt;padding:5.1pt 3.1pt 5.1pt 3.1pt'>
                <p class=ConsPlusNormal><span style='font-family:"Times New Roman","serif"'>&nbsp;</span></p>
            </td>
            <td width=17 valign=top style='width:12.6pt;border:solid windowtext 1.0pt;
  border-left:none;padding:5.1pt 3.1pt 5.1pt 3.1pt'>
                <p class=ConsPlusNormal><span style='font-family:"Times New Roman","serif"'><?php
                        if($xml->MedSection->EventGroups->Group->Need=='true') echo 'X'; ?></span></p>
            </td>
            <td width=243 valign=top style='width:182.0pt;border:none;border-right:solid windowtext 1.0pt;
  padding:5.1pt 3.1pt 5.1pt 3.1pt'>
                <p class=ConsPlusNormal><span style='font-family:"Times New Roman","serif"'>Нуждается</span></p>
            </td>
            <td width=188 valign=top style='width:141.35pt;border:none;border-right:solid windowtext 1.0pt;
  padding:5.1pt 3.1pt 5.1pt 3.1pt'>
                <?php

                if($xml->MedSection->EventGroups->Group->Need=='true')
                {
                    $PeriodTo = strtotime( $xml->MedSection->EventGroups->Group->PeriodTo );
                    $PeriodTo = date( 'd.m.Y', $PeriodTo );

                    $PeriodFrom = strtotime( $xml->MedSection->EventGroups->Group->PeriodFrom );
                    $PeriodFrom = date( 'd.m.Y', $PeriodFrom );
                    echo "с ".$PeriodTo." по ".$PeriodFrom;
                }
                ?>

            </td>
            <td width=182 valign=top style='width:136.7pt;border:none;border-right:solid windowtext 1.0pt;
  padding:5.1pt 3.1pt 5.1pt 3.1pt'><?php
                if($xml->MedSection->EventGroups->Group->Need=='true') echo mb_convert_encoding($xml->MedSection->EventGroups->Group->Executor,  "Windows-1251","utf-8"); ?>

            </td>
        </tr>
        <tr>
            <td width=272 colspan=3 valign=top style='width:203.9pt;border:solid windowtext 1.0pt;
  border-top:none;padding:5.1pt 3.1pt 5.1pt 3.1pt'>
                <p class=ConsPlusNormal><span style='font-family:"Times New Roman","serif"'>&nbsp;</span></p>
            </td>
            <td width=188 valign=top style='width:141.35pt;border-top:none;border-left:
  none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  padding:5.1pt 3.1pt 5.1pt 3.1pt'>
                <p class=ConsPlusNormal>
                    <?php

                    if($xml->MedSection->EventGroups->Group->Need=='false') echo 'X'; ?>

                </p>
            </td>
            <td width=182 valign=top style='width:136.7pt;border-top:none;border-left:
  none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  padding:5.1pt 3.1pt 5.1pt 3.1pt'>
                <p class=ConsPlusNormal><span style='font-family:"Times New Roman","serif"'>&nbsp;</span></p>
            </td>
        </tr>
        <tr>
            <td width=272 colspan=3 valign=top style='width:203.9pt;border-top:none;
  border-left:solid windowtext 1.0pt;border-bottom:none;border-right:solid windowtext 1.0pt;
  padding:5.1pt 3.1pt 5.1pt 3.1pt'>
                <p class=ConsPlusNormal><span style='font-family:"Times New Roman","serif"'>&nbsp;</span></p>
            </td>
            <td width=188 valign=top style='width:141.35pt;border:none;border-right:solid windowtext 1.0pt;
  padding:5.1pt 3.1pt 5.1pt 3.1pt'>
                <p class=ConsPlusNormal><span style='font-family:"Times New Roman","serif"'>&nbsp;</span></p>
            </td>
            <td width=182 valign=top style='width:136.7pt;border:none;border-right:solid windowtext 1.0pt;
  padding:5.1pt 3.1pt 5.1pt 3.1pt'>
                <p class=ConsPlusNormal><span style='font-family:"Times New Roman","serif"'>&nbsp;</span></p>
            </td>
        </tr>
        <tr>
            <td width=12 valign=top style='width:9.3pt;border-top:none;border-left:solid windowtext 1.0pt;
  border-bottom:none;border-right:solid windowtext 1.0pt;padding:5.1pt 3.1pt 5.1pt 3.1pt'>
                <p class=ConsPlusNormal><span style='font-family:"Times New Roman","serif"'>&nbsp;</span></p>
            </td>
            <td width=17 valign=top style='width:12.6pt;border:solid windowtext 1.0pt;
  border-left:none;padding:5.1pt 3.1pt 5.1pt 3.1pt'>
                <p class=ConsPlusNormal><span style='font-family:"Times New Roman","serif"'>&nbsp;</span></p>
            </td>
            <td width=243 valign=top style='width:182.0pt;border:none;border-right:solid windowtext 1.0pt;
  padding:5.1pt 3.1pt 5.1pt 3.1pt'>
                <p class=ConsPlusNormal><span style='font-family:"Times New Roman","serif"'>Не
  нуждается</span></p>
            </td>
            <td width=188 valign=top style='width:141.35pt;border:none;border-right:solid windowtext 1.0pt;
  padding:5.1pt 3.1pt 5.1pt 3.1pt'>
                <p class=ConsPlusNormal><span style='font-family:"Times New Roman","serif"'>&nbsp;</span></p>
            </td>
            <td width=182 valign=top style='width:136.7pt;border:none;border-right:solid windowtext 1.0pt;
  padding:5.1pt 3.1pt 5.1pt 3.1pt'>
                <p class=ConsPlusNormal><span style='font-family:"Times New Roman","serif"'>&nbsp;</span></p>
            </td>
        </tr>
        <tr>
            <td width=272 colspan=3 valign=top style='width:203.9pt;border:solid windowtext 1.0pt;
  border-top:none;padding:5.1pt 3.1pt 5.1pt 3.1pt'>
                <p class=ConsPlusNormal>&nbsp;</p>
            </td>
            <td width=188 valign=top style='width:141.35pt;border-top:none;border-left:
  none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  padding:5.1pt 3.1pt 5.1pt 3.1pt'>
                <p class=ConsPlusNormal>&nbsp;</p>
            </td>
            <td width=182 valign=top style='width:136.7pt;border-top:none;border-left:
  none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  padding:5.1pt 3.1pt 5.1pt 3.1pt'>
                <p class=ConsPlusNormal>&nbsp;</p>
            </td>
        </tr>
        <tr>
            <td width=643 colspan=5 valign=top style='width:17.0cm;border:solid windowtext 1.0pt;
  border-top:none;padding:5.1pt 3.1pt 5.1pt 3.1pt'>
                <p class=ConsPlusNormal align=center style='text-align:center'><span
                        style='font-family:"Times New Roman","serif"'>Реконструктивная хирургия</span></p>
            </td>
        </tr>
        <tr>
            <td width=272 colspan=3 valign=top style='width:203.9pt;border-top:none;
  border-left:solid windowtext 1.0pt;border-bottom:none;border-right:solid windowtext 1.0pt;
  padding:5.1pt 3.1pt 5.1pt 3.1pt'>
                <p class=ConsPlusNormal><span style='font-family:"Times New Roman","serif"'>&nbsp;</span></p>
            </td>
            <td width=188 valign=top style='width:141.35pt;border:none;border-right:solid windowtext 1.0pt;
  padding:5.1pt 3.1pt 5.1pt 3.1pt'>
                <p class=ConsPlusNormal><span style='font-family:"Times New Roman","serif"'>&nbsp;</span></p>
            </td>
            <td width=182 valign=top style='width:136.7pt;border:none;border-right:solid windowtext 1.0pt;
  padding:5.1pt 3.1pt 5.1pt 3.1pt'>
                <p class=ConsPlusNormal>&nbsp;</p>
            </td>
        </tr>
        <tr>
            <td width=12 valign=top style='width:9.3pt;border-top:none;border-left:solid windowtext 1.0pt;
  border-bottom:none;border-right:solid windowtext 1.0pt;padding:5.1pt 3.1pt 5.1pt 3.1pt'>
                <p class=ConsPlusNormal><span style='font-family:"Times New Roman","serif"'>&nbsp;</span></p>
            </td>
            <td width=17 valign=top style='width:12.6pt;border:solid windowtext 1.0pt;
  border-left:none;padding:5.1pt 3.1pt 5.1pt 3.1pt'>
                <p class=ConsPlusNormal><span style='font-family:"Times New Roman","serif"'>&nbsp;</span></p>
            </td>
            <td width=243 valign=top style='width:182.0pt;border:none;border-right:solid windowtext 1.0pt;
  padding:5.1pt 3.1pt 5.1pt 3.1pt'>
                <p class=ConsPlusNormal><span style='font-family:"Times New Roman","serif"'>Нуждается</span></p>
            </td>
            <td width=188 valign=top style='width:141.35pt;border:none;border-right:solid windowtext 1.0pt;
  padding:5.1pt 3.1pt 5.1pt 3.1pt'>
                <p class=ConsPlusNormal><span style='font-family:"Times New Roman","serif"'>&nbsp;</span></p>
            </td>
            <td width=182 valign=top style='width:136.7pt;border:none;border-right:solid windowtext 1.0pt;
  padding:5.1pt 3.1pt 5.1pt 3.1pt'>
                <p class=ConsPlusNormal>&nbsp;</p>
            </td>
        </tr>
        <tr>
            <td width=272 colspan=3 valign=top style='width:203.9pt;border:solid windowtext 1.0pt;
  border-top:none;padding:5.1pt 3.1pt 5.1pt 3.1pt'>
                <p class=ConsPlusNormal><span style='font-family:"Times New Roman","serif"'>&nbsp;</span></p>
            </td>
            <td width=188 valign=top style='width:141.35pt;border-top:none;border-left:
  none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  padding:5.1pt 3.1pt 5.1pt 3.1pt'>
                <p class=ConsPlusNormal><span style='font-family:"Times New Roman","serif"'>&nbsp;</span></p>
            </td>
            <td width=182 valign=top style='width:136.7pt;border-top:none;border-left:
  none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  padding:5.1pt 3.1pt 5.1pt 3.1pt'>
                <p class=ConsPlusNormal>&nbsp;</p>
            </td>
        </tr>
        <tr>
            <td width=272 colspan=3 valign=top style='width:203.9pt;border-top:none;
  border-left:solid windowtext 1.0pt;border-bottom:none;border-right:solid windowtext 1.0pt;
  padding:5.1pt 3.1pt 5.1pt 3.1pt'>
                <p class=ConsPlusNormal><span style='font-family:"Times New Roman","serif"'>&nbsp;</span></p>
            </td>
            <td width=188 valign=top style='width:141.35pt;border:none;border-right:solid windowtext 1.0pt;
  padding:5.1pt 3.1pt 5.1pt 3.1pt'>
                <p class=ConsPlusNormal><span style='font-family:"Times New Roman","serif"'>&nbsp;</span></p>
            </td>
            <td width=182 valign=top style='width:136.7pt;border:none;border-right:solid windowtext 1.0pt;
  padding:5.1pt 3.1pt 5.1pt 3.1pt'>
                <p class=ConsPlusNormal>&nbsp;</p>
            </td>
        </tr>
        <tr>
            <td width=12 valign=top style='width:9.3pt;border-top:none;border-left:solid windowtext 1.0pt;
  border-bottom:none;border-right:solid windowtext 1.0pt;padding:5.1pt 3.1pt 5.1pt 3.1pt'>
                <p class=ConsPlusNormal><span style='font-family:"Times New Roman","serif"'>&nbsp;</span></p>
            </td>
            <td width=17 valign=top style='width:12.6pt;border:solid windowtext 1.0pt;
  border-left:none;padding:5.1pt 3.1pt 5.1pt 3.1pt'>
                <p class=ConsPlusNormal><span style='font-family:"Times New Roman","serif"'></span></p>
            </td>
            <td width=243 valign=top style='width:182.0pt;border:none;border-right:solid windowtext 1.0pt;
  padding:5.1pt 3.1pt 5.1pt 3.1pt'>
                <p class=ConsPlusNormal><span style='font-family:"Times New Roman","serif"'>Не
  нуждается</span></p>
            </td>
            <td width=188 valign=top style='width:141.35pt;border:none;border-right:solid windowtext 1.0pt;
  padding:5.1pt 3.1pt 5.1pt 3.1pt'>
                <p class=ConsPlusNormal><span style='font-family:"Times New Roman","serif"'>&nbsp;</span></p>
            </td>
            <td width=182 valign=top style='width:136.7pt;border:none;border-right:solid windowtext 1.0pt;
  padding:5.1pt 3.1pt 5.1pt 3.1pt'>
                <p class=ConsPlusNormal>&nbsp;</p>
            </td>
        </tr>
        <tr>
            <td width=272 colspan=3 valign=top style='width:203.9pt;border:solid windowtext 1.0pt;
  border-top:none;padding:5.1pt 3.1pt 5.1pt 3.1pt'>
                <p class=ConsPlusNormal><span style='font-family:"Times New Roman","serif"'>&nbsp;</span></p>
            </td>
            <td width=188 valign=top style='width:141.35pt;border-top:none;border-left:
  none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  padding:5.1pt 3.1pt 5.1pt 3.1pt'>
                <p class=ConsPlusNormal><span style='font-family:"Times New Roman","serif"'>&nbsp;</span></p>
            </td>
            <td width=182 valign=top style='width:136.7pt;border-top:none;border-left:
  none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  padding:5.1pt 3.1pt 5.1pt 3.1pt'>
                <p class=ConsPlusNormal>&nbsp;</p>
            </td>
        </tr>
        <tr>
            <td width=643 colspan=5 valign=top style='width:17.0cm;border:solid windowtext 1.0pt;
  border-top:none;padding:5.1pt 3.1pt 5.1pt 3.1pt'>
                <p class=ConsPlusNormal align=center style='text-align:center'><span
                        style='font-family:"Times New Roman","serif"'>Протезирование и ортезирование</span></p>
            </td>
        </tr>
        <tr>
            <td width=272 colspan=3 valign=top style='width:203.9pt;border-top:none;
  border-left:solid windowtext 1.0pt;border-bottom:none;border-right:solid windowtext 1.0pt;
  padding:5.1pt 3.1pt 5.1pt 3.1pt'>
                <p class=ConsPlusNormal><span style='font-family:"Times New Roman","serif"'>&nbsp;</span></p>
            </td>
            <td width=188 valign=top style='width:141.35pt;border:none;border-right:solid windowtext 1.0pt;
  padding:5.1pt 3.1pt 5.1pt 3.1pt'>
                <p class=ConsPlusNormal><span style='font-family:"Times New Roman","serif"'>&nbsp;</span></p>
            </td>
            <td width=182 valign=top style='width:136.7pt;border:none;border-right:solid windowtext 1.0pt;
  padding:5.1pt 3.1pt 5.1pt 3.1pt'>
                <p class=ConsPlusNormal>&nbsp;</p>
            </td>
        </tr>
        <tr>
            <td width=12 valign=top style='width:9.3pt;border-top:none;border-left:solid windowtext 1.0pt;
  border-bottom:none;border-right:solid windowtext 1.0pt;padding:5.1pt 3.1pt 5.1pt 3.1pt'>
                <p class=ConsPlusNormal><span style='font-family:"Times New Roman","serif"'>&nbsp;</span></p>
            </td>
            <td width=17 valign=top style='width:12.6pt;border:solid windowtext 1.0pt;
  border-left:none;padding:5.1pt 3.1pt 5.1pt 3.1pt'>
                <p class=ConsPlusNormal><span style='font-family:"Times New Roman","serif"'>&nbsp;</span></p>
            </td>
            <td width=243 valign=top style='width:182.0pt;border:none;border-right:solid windowtext 1.0pt;
  padding:5.1pt 3.1pt 5.1pt 3.1pt'>
                <p class=ConsPlusNormal><span style='font-family:"Times New Roman","serif"'>Нуждается</span></p>
            </td>
            <td width=188 valign=top style='width:141.35pt;border:none;border-right:solid windowtext 1.0pt;
  padding:5.1pt 3.1pt 5.1pt 3.1pt'>
                <p class=ConsPlusNormal><span style='font-family:"Times New Roman","serif"'>&nbsp;</span></p>
            </td>
            <td width=182 valign=top style='width:136.7pt;border:none;border-right:solid windowtext 1.0pt;
  padding:5.1pt 3.1pt 5.1pt 3.1pt'>
                <p class=ConsPlusNormal>&nbsp;</p>
            </td>
        </tr>
        <tr>
            <td width=272 colspan=3 valign=top style='width:203.9pt;border:solid windowtext 1.0pt;
  border-top:none;padding:5.1pt 3.1pt 5.1pt 3.1pt'>
                <p class=ConsPlusNormal><span style='font-family:"Times New Roman","serif"'>&nbsp;</span></p>
            </td>
            <td width=188 valign=top style='width:141.35pt;border-top:none;border-left:
  none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  padding:5.1pt 3.1pt 5.1pt 3.1pt'>
                <p class=ConsPlusNormal><span style='font-family:"Times New Roman","serif"'>&nbsp;</span></p>
            </td>
            <td width=182 valign=top style='width:136.7pt;border-top:none;border-left:
  none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  padding:5.1pt 3.1pt 5.1pt 3.1pt'>
                <p class=ConsPlusNormal>&nbsp;</p>
            </td>
        </tr>
        <tr>
            <td width=272 colspan=3 valign=top style='width:203.9pt;border-top:none;
  border-left:solid windowtext 1.0pt;border-bottom:none;border-right:solid windowtext 1.0pt;
  padding:5.1pt 3.1pt 5.1pt 3.1pt'>
                <p class=ConsPlusNormal><span style='font-family:"Times New Roman","serif"'>&nbsp;</span></p>
            </td>
            <td width=188 valign=top style='width:141.35pt;border:none;border-right:solid windowtext 1.0pt;
  padding:5.1pt 3.1pt 5.1pt 3.1pt'>
                <p class=ConsPlusNormal><span style='font-family:"Times New Roman","serif"'>&nbsp;</span></p>
            </td>
            <td width=182 valign=top style='width:136.7pt;border:none;border-right:solid windowtext 1.0pt;
  padding:5.1pt 3.1pt 5.1pt 3.1pt'>
                <p class=ConsPlusNormal>&nbsp;</p>
            </td>
        </tr>
        <tr>
            <td width=12 valign=top style='width:9.3pt;border-top:none;border-left:solid windowtext 1.0pt;
  border-bottom:none;border-right:solid windowtext 1.0pt;padding:5.1pt 3.1pt 5.1pt 3.1pt'>
                <p class=ConsPlusNormal><span style='font-family:"Times New Roman","serif"'>&nbsp;</span></p>
            </td>
            <td width=17 valign=top style='width:12.6pt;border:solid windowtext 1.0pt;
  border-left:none;padding:5.1pt 3.1pt 5.1pt 3.1pt'>
                <p class=ConsPlusNormal><span style='font-family:"Times New Roman","serif"'></span></p>
            </td>
            <td width=243 valign=top style='width:182.0pt;border:none;border-right:solid windowtext 1.0pt;
  padding:5.1pt 3.1pt 5.1pt 3.1pt'>
                <p class=ConsPlusNormal><span style='font-family:"Times New Roman","serif"'>Не
  нуждается</span></p>
            </td>
            <td width=188 valign=top style='width:141.35pt;border:none;border-right:solid windowtext 1.0pt;
  padding:5.1pt 3.1pt 5.1pt 3.1pt'>
                <p class=ConsPlusNormal><span style='font-family:"Times New Roman","serif"'>&nbsp;</span></p>
            </td>
            <td width=182 valign=top style='width:136.7pt;border:none;border-right:solid windowtext 1.0pt;
  padding:5.1pt 3.1pt 5.1pt 3.1pt'>
                <p class=ConsPlusNormal>&nbsp;</p>
            </td>
        </tr>
        <tr>
            <td width=272 colspan=3 valign=top style='width:203.9pt;border:solid windowtext 1.0pt;
  border-top:none;padding:5.1pt 3.1pt 5.1pt 3.1pt'>
                <p class=ConsPlusNormal><span style='font-family:"Times New Roman","serif"'>&nbsp;</span></p>
            </td>
            <td width=188 valign=top style='width:141.35pt;border-top:none;border-left:
  none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  padding:5.1pt 3.1pt 5.1pt 3.1pt'>
                <p class=ConsPlusNormal><span style='font-family:"Times New Roman","serif"'>&nbsp;</span></p>
            </td>
            <td width=182 valign=top style='width:136.7pt;border-top:none;border-left:
  none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  padding:5.1pt 3.1pt 5.1pt 3.1pt'>
                <p class=ConsPlusNormal>&nbsp;</p>
            </td>
        </tr>
        <tr>
            <td width=643 colspan=5 valign=top style='width:17.0cm;border:solid windowtext 1.0pt;
  border-top:none;padding:5.1pt 3.1pt 5.1pt 3.1pt'>
                <p class=ConsPlusNormal align=center style='text-align:center'><span
                        style='font-family:"Times New Roman","serif"'>Санаторно-курортное лечение</span></p>

                <p class=ConsPlusNormal align=center style='text-align:center'><span
                        style='font-family:"Times New Roman","serif"'>(предоставляется в рамках
  оказания государственной социальной помощи в виде набора социальных услуг)</span></p>
            </td>
        </tr>
        <tr>
            <td width=272 colspan=3 valign=top style='width:203.9pt;border-top:none;
  border-left:solid windowtext 1.0pt;border-bottom:none;border-right:solid windowtext 1.0pt;
  padding:5.1pt 3.1pt 5.1pt 3.1pt'>
                <p class=ConsPlusNormal><span style='font-family:"Times New Roman","serif"'>&nbsp;</span></p>
            </td>
            <td width=188 valign=top style='width:141.35pt;border:none;border-right:solid windowtext 1.0pt;
  padding:5.1pt 3.1pt 5.1pt 3.1pt'>
                <p class=ConsPlusNormal><span style='font-family:"Times New Roman","serif"'>&nbsp;</span></p>
            </td>
            <td width=182 valign=top style='width:136.7pt;border:none;border-right:solid windowtext 1.0pt;
  padding:5.1pt 3.1pt 5.1pt 3.1pt'>
                <p class=ConsPlusNormal>&nbsp;</p>
            </td>
        </tr>
        <tr>
            <td width=12 valign=top style='width:9.3pt;border-top:none;border-left:solid windowtext 1.0pt;
  border-bottom:none;border-right:solid windowtext 1.0pt;padding:5.1pt 3.1pt 5.1pt 3.1pt'>
                <p class=ConsPlusNormal><span style='font-family:"Times New Roman","serif"'>&nbsp;</span></p>
            </td>
            <td width=17 valign=top style='width:12.6pt;border:solid windowtext 1.0pt;
  border-left:none;padding:5.1pt 3.1pt 5.1pt 3.1pt'>
                <p class=ConsPlusNormal><span style='font-family:"Times New Roman","serif"'>&nbsp;</span></p>
            </td>
            <td width=243 valign=top style='width:182.0pt;border:none;border-right:solid windowtext 1.0pt;
  padding:5.1pt 3.1pt 5.1pt 3.1pt'>
                <p class=ConsPlusNormal><span style='font-family:"Times New Roman","serif"'>Нуждается</span></p>
            </td>
            <td width=188 valign=top style='width:141.35pt;border:none;border-right:solid windowtext 1.0pt;
  padding:5.1pt 3.1pt 5.1pt 3.1pt'>
                <p class=ConsPlusNormal><span style='font-family:"Times New Roman","serif"'>&nbsp;</span></p>
            </td>
            <td width=182 valign=top style='width:136.7pt;border:none;border-right:solid windowtext 1.0pt;
  padding:5.1pt 3.1pt 5.1pt 3.1pt'>
                <p class=ConsPlusNormal>&nbsp;</p>
            </td>
        </tr>
        <tr>
            <td width=272 colspan=3 valign=top style='width:203.9pt;border:solid windowtext 1.0pt;
  border-top:none;padding:5.1pt 3.1pt 5.1pt 3.1pt'>
                <p class=ConsPlusNormal><span style='font-family:"Times New Roman","serif"'>&nbsp;</span></p>
            </td>
            <td width=188 valign=top style='width:141.35pt;border-top:none;border-left:
  none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  padding:5.1pt 3.1pt 5.1pt 3.1pt'>
                <p class=ConsPlusNormal><span style='font-family:"Times New Roman","serif"'>&nbsp;</span></p>
            </td>
            <td width=182 valign=top style='width:136.7pt;border-top:none;border-left:
  none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  padding:5.1pt 3.1pt 5.1pt 3.1pt'>
                <p class=ConsPlusNormal>&nbsp;</p>
            </td>
        </tr>
        <tr>
            <td width=272 colspan=3 valign=top style='width:203.9pt;border-top:none;
  border-left:solid windowtext 1.0pt;border-bottom:none;border-right:solid windowtext 1.0pt;
  padding:5.1pt 3.1pt 5.1pt 3.1pt'>
                <p class=ConsPlusNormal><span style='font-family:"Times New Roman","serif"'>&nbsp;</span></p>
            </td>
            <td width=188 valign=top style='width:141.35pt;border:none;border-right:solid windowtext 1.0pt;
  padding:5.1pt 3.1pt 5.1pt 3.1pt'>
                <p class=ConsPlusNormal><span style='font-family:"Times New Roman","serif"'>&nbsp;</span></p>
            </td>
            <td width=182 valign=top style='width:136.7pt;border:none;border-right:solid windowtext 1.0pt;
  padding:5.1pt 3.1pt 5.1pt 3.1pt'>
                <p class=ConsPlusNormal>&nbsp;</p>
            </td>
        </tr>
        <tr>
            <td width=12 valign=top style='width:9.3pt;border-top:none;border-left:solid windowtext 1.0pt;
  border-bottom:none;border-right:solid windowtext 1.0pt;padding:5.1pt 3.1pt 5.1pt 3.1pt'>
                <p class=ConsPlusNormal><span style='font-family:"Times New Roman","serif"'>&nbsp;</span></p>
            </td>
            <td width=17 valign=top style='width:12.6pt;border:solid windowtext 1.0pt;
  border-left:none;padding:5.1pt 3.1pt 5.1pt 3.1pt'>
                <p class=ConsPlusNormal><span style='font-family:"Times New Roman","serif"'></span></p>
            </td>
            <td width=243 valign=top style='width:182.0pt;border:none;border-right:solid windowtext 1.0pt;
  padding:5.1pt 3.1pt 5.1pt 3.1pt'>
                <p class=ConsPlusNormal><span style='font-family:"Times New Roman","serif"'>Не
  нуждается</span></p>
            </td>
            <td width=188 valign=top style='width:141.35pt;border:none;border-right:solid windowtext 1.0pt;
  padding:5.1pt 3.1pt 5.1pt 3.1pt'>
                <p class=ConsPlusNormal><span style='font-family:"Times New Roman","serif"'>&nbsp;</span></p>
            </td>
            <td width=182 valign=top style='width:136.7pt;border:none;border-right:solid windowtext 1.0pt;
  padding:5.1pt 3.1pt 5.1pt 3.1pt'>
                <p class=ConsPlusNormal>&nbsp;</p>
            </td>
        </tr>
        <tr>
            <td width=272 colspan=3 valign=top style='width:203.9pt;border:solid windowtext 1.0pt;
  border-top:none;padding:5.1pt 3.1pt 5.1pt 3.1pt'>
                <p class=ConsPlusNormal>&nbsp;</p>
            </td>
            <td width=188 valign=top style='width:141.35pt;border-top:none;border-left:
  none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  padding:5.1pt 3.1pt 5.1pt 3.1pt'>
                <p class=ConsPlusNormal>&nbsp;</p>
            </td>
            <td width=182 valign=top style='width:136.7pt;border-top:none;border-left:
  none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  padding:5.1pt 3.1pt 5.1pt 3.1pt'>
                <p class=ConsPlusNormal>&nbsp;</p>
            </td>
        </tr>
    </table>

    <p class=ConsPlusNormal style='text-align:justify'>&nbsp;</p>

    <p class=ConsPlusNonformat style='text-align:justify'><span style='font-family:
"Times New Roman","serif"'>Прогнозируемый результат:
            <br>восстановление  нарушенных  функций 
            <?php
                if(isset($xml->MedSection->PrognozResult->FuncRecovery))
                {
                        if($xml->MedSection->PrognozResult->FuncRecovery->Id=='1') echo '(<span style="text-decoration:underline">полностью</span>, частично)';
                        if($xml->MedSection->PrognozResult->FuncRecovery->Id=='2') echo '(полностью, <span style="text-decoration:underline">частично</span>)';
                }

            else
            {
                echo '(полностью,частично)';
            }

?>
;
    <br>
         достижение компенсации утраченных либо формированиеотсутствующих функций  <?php
            if(isset($xml->MedSection->PrognozResult->FuncCompensation))
            {
                if($xml->MedSection->PrognozResult->FuncCompensation->Id=='1') echo '(<span style="text-decoration:underline">полностью</span>, частично)';
                if($xml->MedSection->PrognozResult->FuncCompensation->Id=='2') echo '(полностью, <span style="text-decoration:underline">частично</span>)';
            }

            else
            {
                echo '(полностью,частично)';
            }

            ?><br>(нужное подчеркнуть)

    </p>





    <p class=ConsPlusNormal style='text-align:justify'>&nbsp;</p>

    <p class=ConsPlusNonformat align=center style='text-align:center'><b><span
                style='font-family:"Times New Roman","serif"'>Виды помощи, оказываемые инвалиду
в преодолении барьеров,</span></b></p>

    <p class=ConsPlusNonformat align=center style='text-align:center'><b><span
                style='font-family:"Times New Roman","serif"'>мешающих получению им услуг на
объектах социальной, инженерной</span></b></p>

    <p class=ConsPlusNonformat align=center style='text-align:center'><b><span
                style='font-family:"Times New Roman","serif"'>и транспортной инфраструктур
наравне с другими лицами,</span></b></p>

    <p class=ConsPlusNonformat align=center style='text-align:center'><b><span
                style='font-family:"Times New Roman","serif"'>организациями, предоставляющими
услуги населению</span></b></p>

    <p class=ConsPlusNonformat style='text-align:justify'>&nbsp;</p>



<?php
foreach($xml->RequiredHelp->HelpItems->HelpItem as $HelpItem)
{
    ?>
    <p class=ConsPlusNonformat style='text-align:justify'><span style='font-family:
"Times New Roman","serif"'><?php echo $HelpItem->HelpCategory->Id; ?>.  
            <?php echo mb_convert_encoding($HelpItem->HelpCategory->Value,  "Windows-1251","utf-8"); ?></span></p>



    <table class=MsoNormalTable border=1 cellspacing=0 cellpadding=0
           style='margin-left:3.1pt;border-collapse:collapse;border:none'>
        <tr>
            <td width=19 valign=top style='width:14.2pt;border:solid windowtext 1.0pt;
  padding:5.1pt 3.1pt 5.1pt 3.1pt'>
                <p class=ConsPlusNormal><span lang=EN-US style='font-family:"Times New Roman","serif"'><?php if($HelpItem->Need=='true') echo 'X' ?></span></p>
            </td>
            <td width=253 valign=top style='width:189.7pt;border:none;padding:5.1pt 3.1pt 5.1pt 3.1pt'>
                <p class=ConsPlusNormal><span style='font-family:"Times New Roman","serif"'>Нуждается</span></p>
            </td>
        </tr>
    </table>

    <p class=ConsPlusNormal style='text-align:justify'><span style='font-family:
"Times New Roman","serif"'>&nbsp;</span></p>

    <table class=MsoNormalTable border=1 cellspacing=0 cellpadding=0
           style='margin-left:3.1pt;border-collapse:collapse;border:none'>
        <tr>
            <td width=19 valign=top style='width:14.2pt;border:solid windowtext 1.0pt;
  padding:5.1pt 3.1pt 5.1pt 3.1pt'>
                <p class=ConsPlusNormal><span style='font-family:"Times New Roman","serif"'><?php if($HelpItem->Need=='false') echo 'X' ?></span></p>
            </td>
            <td width=253 valign=top style='width:189.7pt;border:none;padding:5.1pt 3.1pt 5.1pt 3.1pt'>
                <p class=ConsPlusNormal><span style='font-family:"Times New Roman","serif"'>Не нуждается</span></p>
            </td>
        </tr>
    </table>

    <p class=ConsPlusNormal style='text-align:justify'><span style='font-family:
"Times New Roman","serif"'>&nbsp;</span></p>


    <?php
}

?>

    <p class=ConsPlusNormal style='text-align:justify'><span style='font-family:
"Times New Roman","serif"'>&nbsp;</span></p>

    <p class=ConsPlusNonformat style='text-align:justify'><span style='font-family:
"Times New Roman","serif"'>6.  Иная  необходимая  инвалиду  помощь  в 
преодолении  барьеров, мешающих получению им услуг наравне с другими лицами
(вписать): <?php echo mb_convert_encoding($xml->RequiredHelp->OtherHelp,  "Windows-1251","utf-8"); ?></span></p>

    <p class=ConsPlusNonformat style='text-align:justify'><span  style='font-family:"Times New Roman","serif"'> ____________________</span></p>

    <p class=ConsPlusNonformat style='text-align:justify'><span style='font-family:
"Times New Roman","serif"'>&nbsp;</span></p>

    <p class=ConsPlusNonformat style='text-align:justify'><span style='font-family:
"Times New Roman","serif"'>    Примечания:  1.  Исполнителем  заключения  о 
нуждаемости  в проведении реабилитационных     или     абилитационных    
мероприятий     (проведения реабилитационных    или    абилитационных  
мероприятий)   по   направлению реабилитации   или  абилитации  указываются 
региональное  отделение  Фондасоциального  страхования  Российской Федерации;
орган исполнительной властисубъекта Российской Федерации в соответствующей
сфере деятельности: в сфересоциальной  защиты  населения;  сфере охраны
здоровья; сфере образования; вобласти  содействия  занятости  населения;  в
области физической культуры испорта;  фамилия,  имя,  отчество (при наличии)
инвалида (его законного или уполномоченного представителя).</span></p>

    <p class=ConsPlusNonformat style='text-align:justify'><span style='font-family:
"Times New Roman","serif"'>    2.   Сроки   исполнения   заключения   о  
нуждаемости   в   проведении реабилитационных     или     абилитационных    
мероприятий     (проведения реабилитационных  или  абилитационных  мероприятий) 
должны соответствовать сроку, на который разработана ИПРА инвалида.</span></p>

    <p class=ConsPlusNonformat style='text-align:justify'><span style='font-family:
"Times New Roman","serif"'>    3.  В случае вынесения заключения о ненуждаемости
инвалида в проведении реабилитационных   или   абилитационных   мероприятий  
срок  исполнения  иисполнитель данного заключения не указываются.</span></p>

    <p class=ConsPlusNonformat style='text-align:justify'><span style='font-family:
"Times New Roman","serif"'>&nbsp;</span></p>

    <p class=ConsPlusNonformat style='text-align:justify'><span style='font-family:
"Times New Roman","serif"'>С содержанием ИПРА инвалидасогласен         
___________________________________</span></p>

    <p class=ConsPlusNonformat style='text-align:justify'><span style='font-family:
"Times New Roman","serif"'> ___________________________________</span></p>

    <p class=ConsPlusNonformat style='text-align:justify'><span style='font-family:
"Times New Roman","serif"'>(подпись инвалида или его законного  (фамилия,инициалы) (уполномоченного) представителя) (нужное подчеркнуть)</span></p>

    <p class=ConsPlusNonformat style='text-align:justify'><span style='font-family:
"Times New Roman","serif"'>&nbsp;</span></p>

    <p class=ConsPlusNonformat style='text-align:justify'><span style='font-family:
"Times New Roman","serif"'>Руководитель бюро (главного бюро, Федерального бюро) медико-социальной экспертизы (уполномоченный заместитель руководителя главного бюро),</span></p>

    <p class=ConsPlusNonformat style='text-align:justify'><span style='font-family:
"Times New Roman","serif"'>(Федерального бюро) </span></p>

    <p class=ConsPlusNonformat align=right style='text-align:right'><span
            lang=EN-US style='font-family:"Times New Roman","serif";background:yellow'>&lt;FIOHead&gt;&lt;ct:LastName&gt;</span><span
            style='font-family:"Times New Roman","serif";background:yellow'>В</span><span
            lang=EN-US style='font-family:"Times New Roman","serif";background:yellow'>&lt;/ct:LastName&gt;&lt;ct:FirstName&gt;</span><span
            style='font-family:"Times New Roman","serif";background:yellow'>Н</span><span
            lang=EN-US style='font-family:"Times New Roman","serif";background:yellow'>&lt;/ct:FirstName&gt;</span></p>

    <p class=ConsPlusNonformat align=right style='text-align:right'><span
            lang=EN-US style='font-family:"Times New Roman","serif";background:yellow'>&lt;ct:SecondName&gt;</span><span
            style='font-family:"Times New Roman","serif";background:yellow'>Пунина</span><span
            lang=EN-US style='font-family:"Times New Roman","serif";background:yellow'>&lt;/ct:SecondName&gt;&lt;/FIOHead&gt;</span>
    </p>

    <p class=ConsPlusNonformat style='text-align:justify'><span style='font-family:
"Times New Roman","serif"'>(подпись)      (фамилия, инициалы)</span></p>

    <p class=ConsPlusNonformat style='text-align:justify'><span style='font-family:
"Times New Roman","serif"'>&nbsp;</span></p>

    <p class=ConsPlusNonformat style='text-align:justify'><span style='font-family:
"Times New Roman","serif"'>М.П.</span></p>

    <p class=ConsPlusNormal style='text-align:justify'><span style='font-family:
"Times New Roman","serif"'>&nbsp;</span></p>

    <p class=ConsPlusNormal style='text-align:justify'><span style='font-family:
"Times New Roman","serif"'>&nbsp;</span></p>

</div>

</body>

</html>
