<?php
/**
 * Created by PhpStorm.
 * User: cod_llo
 * Date: 11.03.16
 * Time: 18:11
 * Главная страница
 */

?>
<div class="boxed">

    <!--CONTENT CONTAINER-->
    <!--===================================================-->
    <div id="content-container">

        <!--Page Title-->
        <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
        <div id="page-title">
            <h1 class="page-header text-overflow">ЛПУ <?php echo $auth->login; ?></h1>
        </div>
        <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
        <!--End page title-->


        <!--Page content-->
        <!--===================================================-->
        <div id="page-content">

            <div class="row">

                <div class="col-sm-12">
                    <div class="panel">
                        <div class="panel-heading">
                            <h3 class="panel-title">Фильтр</h3>
                        </div>

                        <!--Block Styled Form -->
                        <!--===================================================-->
                        <form id="search_form_1">
                            <div class="panel-body">

                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label class="control-label">Дата загрузки с:</label>
                                            <input type="text" class="form-control hasDatepicker2" name="datel_1">
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label">Дата загрузки по:</label>
                                            <input type="text" class="form-control hasDatepicker2" name="datel_2">
                                        </div>
                                    </div>
                                </div>


                                <div class="row">
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label class="control-label">ФИО/СНИЛС/Адрес регистрации</label>
                                            <input type="text" class="form-control" id="search_string" name="search_string">
                                        </div>
                                    </div>

                                    <div class="col-sm-2">
                                        <div class="form-group">
                                            <label class="control-label">Дата выдачи с:</label>
                                            <input type="text" class="form-control hasDatepicker2" name="dateload1">
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label">Дата выдачи по:</label>
                                            <input type="text" class="form-control hasDatepicker2" name="dateload2">
                                        </div>
                                    </div>
                                    <?php if($auth->login=='admin'){ ?>
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label class="control-label">ЛПУ</label>
                                                <select class="form-control" name="lpu">
                                                    <option value="" selected></option>
                                                    <option value="-">ПУСТО!!!</option>
                                                    <?php
                                                    foreach($users as $user)
                                                    {
                                                        ?>
                                                        <option value="<?php echo $user['login']; ?>"><?php echo $user['login']; ?></option>
                                                        <?php
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                    <?php  } ?>
                                </div>
                            </div>
                            <div class="panel-footer text-right">

                                <button  class="btn btn-pink" type="button"  onclick="location.reload();">Сбросить фильтр</button>
                                <button style="margin-left: 30px" class="btn btn-info" type="button" id="search-button">Поиск</button>
                            </div>
                        </form>
                        <!--===================================================-->
                        <!--End Block Styled Form -->

                    </div>
                </div>

                <div class="col-sm-12">
                    <div class="panel">
                        <div class="panel-heading">
                            <h3 class="panel-title">Список пациентов прикрепленных к Вашему ЛПУ:</h3>
                        </div>


                        <!--Hover Rows-->
                        <!--===================================================-->
                        <div class="panel-body ajax">
                            <table class="table table-hover table-vcenter">
                                <thead>
                                <tr>
                                    <th class="text-center">Дата выдачи</th>
                                    <th>Фамили</th>
                                    <th>Имя</th>
                                    <th>Отчество</th>
                                    <th class="text-center">Дата рождения</th>
                                    <th>Адрес регистрации</th>
                                    <th class="text-center">СНИЛС</th>
                                    <th class="text-center">ЛПУ</th>
                                    <?php if($auth->login!='admin'){ ?>
                                    <th></th>
                                    <?php } ?>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                foreach ($patients as $patient) {
                                    ?>
                                    <tr>
                                        <td><?php
                                            $ProtocolDate = strtotime( $patient['ProtocolDate'] );
                                            $ProtocolDate = date( 'd.m.Y', $ProtocolDate );
                                            echo $ProtocolDate;
                                            ?>
                                        </td>
                                        <td>
                                            <a href="<?php echo site_url('/patient/show'); ?>/<?php echo $patient['id']; ?>"><span
                                                    class="text-semibold"><?php echo $patient['LastName']; ?></span></a>
                                        </td>
                                        <td>
                                            <a href="<?php echo site_url('/patient/show'); ?>/<?php echo $patient['id']; ?>"><span
                                                    class="text-semibold"><?php echo $patient['FirstName']; ?></span></a>
                                        </td>
                                        <td>
                                            <a href="<?php echo site_url('/patient/show'); ?>/<?php echo $patient['id']; ?>"><span
                                                    class="text-semibold"><?php echo $patient['SecondName']; ?></span></a>
                                        </td>
                                        <td class="text-center">
                                            <?php
                                            $patient['BirthDate'] = strtotime($patient['BirthDate']);
                                            $patient['BirthDate'] = date('d.m.Y', $patient['BirthDate']);
                                            echo $patient['BirthDate']; ?>
                                        </td>
                                        <td><?php echo $patient['RegAddress']; ?></td>
                                        <td class="text-center"><?php echo $patient['SNILS']; ?></td>
                                        <td class="text-center"><?php echo $patient['LPUCODE'];
                                            if(!$auth->login=='admin')
                                            {
                                                ?>
                                                <a href="<?php echo site_url('patient/edit/'.$patient['id']);  ?>" class="btn btn-info" type="button" id="search-button">Изменить</a>
                                                <?php
                                            }
                                            ?></td>

                                        <?php if($auth->login!='admin'){ ?>
                                            <td>
                                                <?php if(strlen($patient['f_date'])<3) { ?>
                                                <button onclick="ToWork(<?php echo $patient['id']; ?>)" class="btn btn-info" type="button" >В работе</button>
                                                <?php }else{ echo $patient['f_date'];} ?>
                                            </td>
                                        <?php } ?>
                                    </tr>
                                    <?php
                                }

                                ?>


                                </tbody>
                            </table>
                        </div>
                        <!--===================================================-->
                        <!--End Hover Rows-->

                    </div>
                </div>
                <!-- Modal -->
                <div class="modal fade" id="ModalToWork" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <form method="post">
                                <input type="hidden" name="patient_id" value="0" id="f_patient_id">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    <h4 class="modal-title " id="modal-bron-title">Работа с ИПРА в МО</h4>
                                </div>
                                <div class="modal-body " id="modal-born-body">

                                    <div class="form-group">
                                        <label class="control-label">Дата разработки ИПРА в МО:</label>
                                        <input required type="date" class="form-control" id="f_date" name="f_date">
                                    </div>

                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-info" >Исполнить</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


