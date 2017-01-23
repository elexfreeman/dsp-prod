<?php
/**
 * Created by PhpStorm.
 * User: cod_llo
 * Date: 11.03.16
 * Time: 18:11
 * Главная страница
 */

?>

<div class="boxed" >

    <!--CONTENT CONTAINER-->
    <!--===================================================-->
    <div id="content-container">

        <!--Page Title-->
        <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
        <div id="page-title">
            <h1 class="page-header text-overflow">ЛПУ <?php echo $user; ?></h1>

        </div>
        <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
        <!--End page title-->


        <!--Breadcrumb-->
        <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
        <ol class="breadcrumb">
            <li><a href="<?php echo $main_page_link; ?>">Рабочий стол</a></li>
            <li><?php echo $patient['LastName']; ?> <?php echo $patient['FirstName']; ?> <?php echo $patient['SecondName'];?></li>

        </ol>
        <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
        <!--End breadcrumb-->


        <!--Page content-->
        <!--===================================================-->
        <div id="page-content">
        <h1><?php echo $patient['LastName']; ?> <?php echo $patient['FirstName']; ?> <?php echo $patient['SecondName']; ?></h1>

            <div class="row">
                <div class="col-md-12 col-lg-8">
                    <div class="panel">
                        <div class="panel-heading">
                            <h3 class="panel-title">Выполнение мероприятий</h3>
                        </div>

                        <!-- Striped Table -->
                        <!--===================================================-->
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                    <tr>
                                        <th>№</th>
                                        <th>Тип</th>
                                        <th>Подтип</th>
                                        <th>Мероприятие</th>
                                        <th>Дата выполения</th>
                                        <th>Результат выполнения</th>
                                        <th></th>
                                        <th></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php foreach($prg_rhb as $p){ ?>
                                        <tr>
                                            <td><?php echo $p['id']; ?></td>
                                            <td><?php echo $p['rt_name']; ?></td>
                                            <td><?php echo $p['re_name']; ?></td>
                                            <td><?php echo $p['name']; ?></td>
                                            <td><?php echo $p['dt_exc']; ?></td>
                                            <td>
                                                <label class="form-checkbox form-icon form-primary form-text">
                                                    <input
                                                        <?php if($p['resid']==1) echo 'checked'; ?>
                                                        disabled type="checkbox"> Выполненно
                                                </label>
                                            </td>
                                            <td>
                                                <label class="form-checkbox form-icon form-danger form-text">
                                                    <input
                                                        <?php if($p['publish']==1) echo 'checked'; ?>
                                                        disabled type="checkbox"> Опубликовано
                                                </label>
                                            </td>
                                            <td><a
                                                    href="/patient/m_edit/<?php echo $patient_id; ?>/<?php echo $p['id']; ?>"
                                                    class="btn btn-default btn-icon icon-lg fa fa-edit"></a></td>

                                        </tr>
                                    <?php }?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <!--===================================================-->
                        <!-- End Striped Table -->
                        <div class="panel-footer text-right">
                            <?php if (isset($patient['xml_file'])){ ?>
                                <a id="demo-state-btn" href="<?php echo site_url('patient/m_add/'.$patient['id']) ?>"
                                   class="btn btn-lg btn-info" type="button">
                                    Добавить
                                </a>
                            <?php }?>
                        </div>

                    </div>
                </div>

            </div>

        <div class="row">
            <div class="col-sm-4">
                <div class="panel">
                    <div class="panel-heading">
                        <h3 class="panel-title">ИПРА <?php if(isset($xml)) echo $xml->Number; ?></h3>
                    </div>
                    <div class="panel-body">
                        <dl class="dl-horizontal">
                            <dt>Номер протокола:</dt>
                            <dd><?php if(isset($xml)) echo $xml->ProtocolNum; ?></dd>
                            <dt>Дата протокола:</dt>
                            <dd><?php if(isset($xml)) echo $xml->ProtocolDate; ?></dd>
                            <dt>Для ребенка</dt>
                            <dd><?php
                                if(isset($xml)) {
                                    if($xml->IsForChild=='true') echo 'Да';else echo 'Нет';
                                }

                                ?></dd>
                        </dl>
                    </div>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="panel">
                    <div class="panel-heading">
                        <h3 class="panel-title">Бюро</h3>
                    </div>
                    <div class="panel-body">
                        <dl class="dl-horizontal">
                            <dt>Номер:</dt>
                            <dd><?php if(isset($xml)) echo $xml->Buro->Number; ?></dd>
                            <dt>Наименование:</dt>
                            <dd><?php if(isset($xml)) echo $xml->Buro->OrgName; ?></dd>
                        </dl>
                    </div>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="panel">
                    <div class="panel-heading">
                        <h3 class="panel-title">Получатель</h3>
                    </div>
                    <div class="panel-body">
                        <dl class="dl-horizontal">
                            <dt>Наименование:</dt>
                            <dd><?php if(isset($xml)) echo $xml->Recipient->Name; ?></dd>
                            <dt>Адрес:</dt>
                            <dd><?php if(isset($xml)) echo $xml->Recipient->Address; ?></dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>

            <div class="row">


                <div class="col-sm-12">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <h3 class="panel-title">
                                Пациент: <?php echo $patient['LastName']; ?> <?php echo $patient['FirstName']; ?>
                                <?php echo $patient['SecondName']; ?>
                            </h3>
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="panel-info panel-bordered">
                                        <div class="panel-heading">
                                            <h3 class="panel-title">Основное</h3>
                                        </div>
                                        <div class="panel-body">
                                            <p>
                                                <b>Фамилия:</b> <?php echo $patient['LastName']; ?>
                                            </p>
                                            <p>
                                                <b>Имя:</b> <?php echo $patient['FirstName']; ?>
                                            </p>
                                            <p>
                                                <b>Отчество:</b> <?php echo $patient['SecondName']; ?>
                                            </p>
                                            <p>
                                                <?php
                                                $BirthDate = strtotime($patient['BirthDate'] );
                                                $BirthDate = date( 'd.m.Y', $BirthDate );?>
                                                <b>Дата рождения:</b> <?php echo $BirthDate; ?>
                                            </p>
                                            <p>
                                                <b>Телефон:</b> <?php echo $patient['Phone']; ?>
                                            </p>
                                            <p>
                                                <b>Пол:</b> <?php if ($patient['IsMale'] == 'true') echo 'Мужской'; else echo 'Женский'; ?>
                                            </p>

                                            <p>
                                                <b>Гражданство:</b> <?php echo $patient['Citizenship']; ?>
                                            </p>
                                            <p>
                                                <b>Адре регистрации:</b> <?php echo $patient['RegAddress_Place']; ?>
                                            </p>
                                            <div class="row top10">
                                                <div class="col-md-6">
                                                    <a href="<?php echo site_url('patient/word')."/".$patient_id; ?>"
                                                       class="btn btn-primary btn-labeled fa fa-print">Распечатать</a>
                                                </div>
                                                <div class="col-md-6">
                                                    <a  href="<?php echo site_url('patient/xml')."/".$patient_id; ?>"
                                                        class="btn btn-primary btn-labeled fa fa-file-excel-o">Скачать XML</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="panel panel-mint panel-bordered">
                                        <div class="panel-heading">
                                            <h3 class="panel-title">Документ: <?php echo $patient['IdentityDoc_Title']; ?></h3>
                                        </div>
                                        <div class="panel-body">
                                            <div class="row top10">
                                                <div class="col-md-6">
                                                    <b>Серия: </b><br><?php echo $patient['IdentityDoc_Series']; ?>
                                                </div>
                                                <div class="col-md-6">
                                                    <b>Номер: </b><br><?php echo $patient['IdentityDoc_Number']; ?>
                                                </div>
                                            </div>
                                            <div class="row top10">
                                                <div class="col-md-12"
                                                    ><b>Выдан: </b><?php echo $patient['IdentityDoc_Issuer']; ?>
                                                </div>
                                            </div>
                                            <div class="row top10">
                                                <div class="col-md-12">
                                                    <?php
                                                    $IssueDate='';
                                                    if(isset($patient['IdentityDoc_IssueDate']))
                                                    {
                                                        $IssueDate = strtotime($patient['IdentityDoc_IssueDate'] );
                                                        $IssueDate = date( 'd.m.Y', $IssueDate );
                                                    }
                                                    ?>
                                                    <b>Дата выдачи: </b><br><?php echo $IssueDate; ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="panel panel-success panel-bordered">
                                        <div class="panel-heading">
                                            <h3 class="panel-title">Врач</h3>
                                        </div>
                                        <div class="panel-body">
                                            <p>
                                                <b>ФИО:</b> <?php if(isset($xml)) echo $xml->FIOHead->SecondName;?> <?php if(isset($xml)) echo $xml->FIOHead->FirstName;?>. <?php if(isset($xml)) echo $xml->FIOHead->LastName;?>.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>



                        </div>
                    </div>
                </div>

            </div>

            <div class="row">
                <div class="col-sm-12">
                    <div class="panel">
                        <div class="panel-heading">
                            <h3 class="panel-title">Прикрепленные документы</h3>
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="panel-info panel-bordered">
                                        <div class="panel-heading">
                                            <h3 class="panel-title">Список</h3>
                                        </div>
                                        <div class="panel-body">
                                            <form class="form-horizontal" >
                                                <div class="panel-body">
                                                    <table class="table">
                                                        <thead>
                                                        <tr>
                                                            <th class="text-center">№</th>
                                                            <th>Дата:</th>
                                                            <th>Файл:</th>
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                        <?php if(isset($patient['files'])) { $n=1; foreach($patient['files'] as $f)
                                                        {
                                                            ?>
                                                            <tr>
                                                                <td class="text-center"><?php echo $n;?></td>
                                                                <td><?php echo $f['n_date'];?></td>
                                                                <td><a href="/files/<?php echo $f['file_name'];?>"><?php echo $f['file_name'];?></a></td>
                                                            </tr>
                                                            <?php
                                                            $n++;}}
                                                        ?>

                                                        </tbody>
                                                    </table>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="panel-info panel-bordered">
                                        <div class="panel-heading">
                                            <h3 class="panel-title">Прикрепить документы</h3>
                                        </div>

                                        <!--Horizontal Form-->
                                        <!--===================================================-->
                                        <form class="form-horizontal" method="post" enctype="multipart/form-data">
                                            <?php $k=validation_errors();
                                            if($k!='')
                                            {
                                                ?>
                                                <div class="alert alert-danger fade in">
                                                    <button class="close" data-dismiss="alert"><span>×</span></button>
                                                    <strong><?php echo $k; ?>
                                                </div>
                                                <?php
                                            }
                                            ?>


                                            <div class="panel-body">
                                                <div class="form-group">
                                                    <label class="col-sm-3 control-label" for="demo-hor-inputemail">Документы в zip архиве</label>
                                                    <div class="col-sm-9">
                                                        <input type="file" id="demo-hor-inputemail" class="form-control" required name="doc">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-md-3 control-label" for="demo-textarea-input">Описание:</label>
                                                    <div class="col-md-9">
                                                        <textarea id="demo-textarea-input"
                                                                  rows="9" name="description" required
                                                         class="form-control" placeholder="введите текст описания.."></textarea>
                                                    </div>
                                                </div>
                                                <div class="text-right">
                                                    <button class="btn btn-info" type="submit">Прикрепить</button>
                                                </div>
                                            </div>
                                        </form>
                                        <!--===================================================-->
                                        <!--End Horizontal Form-->

                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

            </div>

            <div class="row">
                <div class="col-sm-6">
                    <div class="panel panel-info">
                        <div class="panel-heading">
                            <h3 class="panel-title">Виды помощи:</h3>
                        </div>
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                    <tr>
                                        <th class="text-center">№</th>
                                        <th>Наименование</th>
                                        <th>Статус</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    if(isset($xml->RequiredHelp->HelpItems))
                                    {
                                        foreach($xml->RequiredHelp->HelpItems->HelpItem as $HelpItem)
                                        {
                                            ?>
                                            <tr>
                                                <td class="text-center"><?php echo $HelpItem->HelpCategory->Id; ?></td>
                                                <td><?php echo $HelpItem->HelpCategory->Value; ?><td>
                                                    <label class="form-checkbox form-icon form-danger form-text active">
                                                        <input type="checkbox" disabled
                                                               <?php if($HelpItem->Need=='true') echo " checked ";  ?>
                                                               > Назначено
                                                    </label>
                                                </td>
                                            </tr>
                                            <?php
                                        }
                                    }
                                    ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="panel panel-info">
                        <div class="panel-heading">
                            <h3 class="panel-title">Показания к проведению реабилитационных или абилитационных мероприятий:</h3>
                        </div>
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                    <tr>
                                        <th>Перечень ограничений основных категорий жизнедеятельности</th>
                                        <th>Степень ограничения (1, 2, 3)</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    if(isset($xml->LifeRestrictions))
                                    {
                                        ?>
                                        <tr>
                                            <td>способности к самообслуживанию:</td>
                                            <td class="text-center"><?php echo $xml->LifeRestrictions->SelfCare; ?><td>
                                        </tr>
                                        <tr>
                                                <td>способности к передвижению:</td>
                                                <td class="text-center"><?php echo $xml->LifeRestrictions->Moving; ?><td>
                                        </tr>
                                        <tr>
                                                <td>способности к ориентации:</td>
                                                <td class="text-center"><?php echo $xml->LifeRestrictions->Orientation; ?><td>
                                        </tr>
                                        <tr>
                                                <td>способности к общению:</td>
                                                <td class="text-center"><?php echo $xml->LifeRestrictions->Communication; ?><td>
                                        </tr>
                                        <tr>
                                                <td>способности к обучению:</td>
                                                <td class="text-center"><?php echo $xml->LifeRestrictions->Learn; ?><td>
                                        </tr>
                                        <tr>
                                                <td>способности к трудовой деятельности:</td>
                                                <td class="text-center"><?php echo $xml->LifeRestrictions->Work; ?><td>
                                        </tr>
                                        <tr>
                                                <td >способности к контролю за своим поведением:</td>
                                                <td class="text-center"><?php echo $xml->LifeRestrictions->BehaviorControl; ?><td>
                                        </tr>
                                    <?php }?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-6">
                    <div class="panel panel-info">
                        <div class="panel-heading">
                            <h3 class="panel-title">Мероприятия медицинской реабилитации или абилитации:</h3>
                        </div>
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                    <tr>
                                        <th class="text-center">№</th>
                                        <th>Наименование</th>
                                        <th>Дата</th>
                                        <th>Статус</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    $n = 36;
                                    $a=false;
                                    $a_date = '';
                                    if(isset($xml->MedSection->EventGroups->Group))
                                    {
                                        foreach($xml->MedSection->EventGroups->Group as $HelpItem)
                                        {
                                            if(($HelpItem->GroupType->Id==$n)and($HelpItem->Need=='true')) {
                                                $a=true;
                                                $a_date = $HelpItem->PeriodFrom.' - '.$HelpItem->PeriodTo;
                                            }
                                        }
                                    }
                                    ?>
                                    <tr>
                                        <td class="text-center"><?php echo $n; ?></td>
                                        <td>Протезирование и ортезирование</td>
                                        <td><?php echo $a_date;  ?><td>
                                            <label class="form-checkbox form-icon form-danger form-text active">
                                                <input type="checkbox" disabled
                                                    <?php if($a) echo " checked ";  ?>
                                                       > Нуждается
                                            </label>
                                        </td>
                                    </tr>

                                    <?php
                                    $n = 35;
                                    $a=false;
                                    $a_date = '';
                                    if(isset($xml->MedSection->EventGroups->Group))
                                    {
                                        foreach($xml->MedSection->EventGroups->Group as $HelpItem)
                                        {
                                            if(($HelpItem->GroupType->Id==$n)and($HelpItem->Need=='true')) {
                                                $a=true;
                                                $a_date = $HelpItem->PeriodFrom.' - '.$HelpItem->PeriodTo;
                                            }
                                        }
                                    }
                                    ?>
                                    <tr>
                                        <td class="text-center"><?php echo $n; ?></td>
                                        <td>Реконструктивная хирургия</td>
                                        <td><?php echo $a_date;  ?><td>
                                            <label class="form-checkbox form-icon form-danger form-text active">
                                                <input type="checkbox" disabled
                                                    <?php if($a) echo " checked ";  ?>
                                                       > Нуждается
                                            </label>
                                        </td>
                                    </tr>
                                    <?php
                                    $n = 34;
                                    $a=false;
                                    $a_date = '';
                                    if(isset($xml->MedSection->EventGroups->Group))
                                    {
                                        foreach($xml->MedSection->EventGroups->Group as $HelpItem)
                                        {
                                            if(($HelpItem->GroupType->Id==$n)and($HelpItem->Need=='true')) {
                                                $a=true;
                                                $a_date = $HelpItem->PeriodFrom.' - '.$HelpItem->PeriodTo;
                                            }
                                        }
                                    }
                                    ?>
                                    <tr>
                                        <td class="text-center"><?php echo $n; ?></td>
                                        <td>Медицинская реабилитация</td>
                                        <td><?php echo $a_date;  ?><td>
                                            <label class="form-checkbox form-icon form-danger form-text active">
                                                <input type="checkbox" disabled
                                                    <?php if($a) echo " checked ";  ?>  > Нуждается
                                            </label>
                                        </td>
                                    </tr>

                                    <?php
                                    $n = 37;
                                    $a=false;
                                    $a_date = '';
                                    if(isset($xml->MedSection->EventGroups->Group))
                                    {
                                        foreach($xml->MedSection->EventGroups->Group as $HelpItem)
                                        {
                                            if(($HelpItem->GroupType->Id==$n)and($HelpItem->Need=='true')) {
                                                $a=true;
                                                $a_date = $HelpItem->PeriodFrom.' - '.$HelpItem->PeriodTo;
                                            }
                                        }
                                    }
                                    ?>
                                    <tr>
                                        <td class="text-center"><?php echo $n; ?></td>
                                        <td>Санаторно-курортное лечение</td>
                                        <td><?php echo $a_date;  ?><td>
                                            <label class="form-checkbox form-icon form-danger form-text active">
                                                <input type="checkbox" disabled
                                                    <?php if($a) echo " checked ";  ?> > Нуждается
                                            </label>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="panel panel-info">
                        <div class="panel-heading">
                            <h3 class="panel-title">Прогноз:</h3>
                        </div>
                        <div class="panel-body">
                            <div class="pad-ver">
                                <?php
                                $p=0;
                                if(isset($xml->MedSection->PrognozResult))
                                {
                                    if(isset($xml->MedSection->PrognozResult->FuncRecovery->Id)) $p=2;
                                    if(isset($xml->MedSection->PrognozResult->FuncCompensation->Id)) $p=1;
                                }
                                ?>

                                <!--===================================================-->
                                <label class="form-radio form-normal form-primary form-text active">
                                    <input type="radio" name="cl-rd" <?php if($p==1) echo 'checked'; ?> value="1"> Полностью</label>
                                <label class="form-radio form-normal form-info form-text">
                                    <input type="radio" name="cl-rd" <?php if($p==2) echo 'checked'; ?> value="2"> Частично</label>
                                 <!--===================================================-->

                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!--<div class="row">
                <div class="col-sm-6">
                    <div class="panel panel-info">
                        <div class="panel-heading">
                            <h3 class="panel-title">Проф:</h3>
                        </div>
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                    <tr>
                                        <th class="text-center">№</th>
                                        <th>Наименование</th>
                                        <th>Дата</th>
                                        <th>Статус</th>
                                    </tr>
                                    </thead>
                                    <tbody>

                                    <tr>
                                        <td class="text-center">41</td>
                                        <td>Профессиональная ориентация, осуществляемая в органе службы занятости</td>
                                        <td><td>
                                            <label class="form-checkbox form-icon form-danger form-text active">
                                                <input type="checkbox" value="41" > Нуждается
                                            </label>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-center">42</td>
                                        <td>Содействие в трудоустройстве</td>
                                        <td><td>
                                            <label class="form-checkbox form-icon form-danger form-text active">
                                                <input type="checkbox"  value="42" > Нуждается
                                            </label>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-center">38</td>
                                        <td>Рекомендации по условиям организации обучения</td>
                                        <td><td>
                                            <label class="form-checkbox form-icon form-danger form-text active">
                                                <input type="checkbox"  value="38" > Нуждается
                                            </label>
                                        </td>
                                    </tr>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="panel panel-info">
                        <div class="panel-heading">
                            <h3 class="panel-title">Прогноз:</h3>
                        </div>
                        <div class="panel-body">
                            <div class="pad-ver">


                                <label class="form-radio form-normal form-primary form-text active">
                                    <input type="radio" name="cl-rd" <?php /*if($p==1) echo 'checked'; */?> value="1"> Полностью</label>
                                <label class="form-radio form-normal form-info form-text">
                                    <input type="radio" name="cl-rd" <?php /*if($p==2) echo 'checked'; */?> value="2"> Частично</label>


                            </div>
                        </div>
                    </div>
                </div>
            </div>-->


        </div>
    </div>
</div>


