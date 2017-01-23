<?php
/**
 * Created by PhpStorm.
 * User: cod_llo
 * Date: 11.03.16
 * Time: 18:11
 * Главная страница
 */

?>

<div class="boxed" ng-app="EvnApp" ng-controller="addCtrl" >

    <!--Small Bootstrap Modal-->
    <!--===================================================-->
    <div id="modealError" class="modal fade" tabindex="-1">
        <div class="modal-dialog modal-sm animated bounceIn">
            <div class="modal-content">
                <div class="modal-header">
                    <button class="close" data-dismiss="modal"><span>&times;</span></button>
                    <h4 class="modal-title" id="mySmallModalLabel">Ошибка сохранения! Нужно заполнить следующие поля:</h4>
                </div>
                <div class="modal-body">
                    <p ng-bind="modalError"></p>
                </div>
                <div class="modal-footer">
                    <button data-dismiss="modal" class="btn btn-default" type="button">Закрыть</button>

                </div>
            </div>
        </div>
    </div>
    <!--===================================================-->
    <!--End Small Bootstrap Modal-->
    <input type="hidden" id="patient_id" value="<?php echo $patient['id'];?>">
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
            <li>
                <a href="<?php echo site_url('patient/show/'.$patient['id']); ?>"><?php echo $patient['LastName']; ?> <?php echo $patient['FirstName']; ?> <?php echo $patient['SecondName'];?></a>
            </li>
            <li>Добавить мероприятие ИПРА</li>

        </ol>
        <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
        <!--End breadcrumb-->


        <!--Page content-->
        <!--===================================================-->
        <div id="page-content">
        <div class="row">
            <div class="col-md-12 col-lg-6">
                <div class="panel">
                    <div class="panel-heading">
                        <h3 class="panel-title">Добавление мероприятия ИПРА</h3>
                    </div>

                    <!--Horizontal Form-->
                    <!--===================================================-->
                    <form class="form-horizontal" name="s_form" role="form">
                        <div class="panel-body">
                            <h4 class="text-info">Мероприятие</h4>
                            <hr>
                            <div class="form-group">
                                <label class="col-sm-3 control-label" for="rhb_evnt">Тип мероприятия</label>
                                <div class="col-sm-9">
                                    <select class="form-control"
                                            ng-change="update_rhb_type()"
                                            ng-options="opt.id as opt.name for opt in res.data.rhb_type"
                                            ng-model="formInfo.typeid">

                                    </select>

                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label" for="rhb_type">Подтип мероприятия</label>
                                <div class="col-sm-9">
                                    <select class="form-control"
                                            ng-options="opt.id as opt.name for opt in rhb_evnt_data.rhb_evnt"
                                            ng-model="formInfo.evntid">

                                    </select>

                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label" for="name">Название мероприятия (если нет в списке)</label>
                                <div class="col-sm-9">
                                    <input type="text" id="name" ng-model="formInfo.name" class="form-control">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label" for="dt_exc">Дата выполнения мероприятия</label>
                                <div class="col-sm-9">
                                    <input type="text" id="dt_exc" ng-model="formInfo.dt_exc" class="form-control hasDatepicker2">
                                </div>
                            </div>
                            <br>
                            <h4 class="text-mint">Исполнитель</h4>
                            <div class="form-group">
                                <label class="col-sm-3 control-label" for="exc_name">Полное наименование</label>
                                <div class="col-sm-9">
                                    <input type="text" id="exc_name" ng-model="formInfo.lpu.exc_name" class="form-control">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label" for="exc_scode">Краткое наименование</label>
                                <div class="col-sm-9">
                                    <input type="text" id="exc_scode" ng-model="formInfo.lpu.exc_scode" class="form-control">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label" for="exc_inn">ИНН</label>
                                <div class="col-sm-9">
                                    <input type="text" id="exc_inn" ng-model="formInfo.lpu.exc_inn" class="form-control">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label" for="exc_ogrn">ОГРН</label>
                                <div class="col-sm-9">
                                    <input type="text" id="exc_ogrn" ng-model="formInfo.lpu.exc_ogrn" class="form-control">
                                </div>
                            </div>
                            <br>
                            <h4 class="text-mint">Результат выполнения</h4>
                            <hr>
                            <div class="form-group">
                                <label class="col-sm-3 control-label" for="rhb_res"></label>
                                <div class="col-sm-9">
                                    <label class="form-radio form-normal active form-text form-danger">
                                        <input type="radio" ng-model="formInfo.rhb_res" name="resid" value="1"> Выполненно
                                    </label>
                                    <label class="form-radio form-normal active form-text form-danger">
                                        <input type="radio" ng-model="formInfo.rhb_res" name="resid" value="0"> Не выполненно
                                    </label>

                                    <div ng-show="formInfo.rhb_res==0" style="margin-top: 20px">
                                        <label class="control-label text-bold" >Укажите причину</label>
                                        <label class="form-radio form-normal active form-text form-danger">
                                            <input type="radio" ng-model="formInfo.rhb_res_no" name="resid_no" value="2"> Инвалид (ребенок-инвалид) либо законный (уполномоченный) представитель не обратился в соответствующий орган государственной власти, орган местного самоуправления, организацию независимо от организационно-правовых форм за предоставлением мероприятий, предусмотренных ИПРА инвалида (ИПРА ребенка-инвалида)
                                        </label>
                                        <label class="form-radio form-normal active form-text form-danger">
                                            <input type="radio" ng-model="formInfo.rhb_res_no" name="resid_no" value="3"> Инвалид (ребенок-инвалид) либо законный (уполномоченный) представитель отказался от того или иного вида, формы и объема мероприятий, предусмотренных ИПРА инвалида (ИПРА ребенка-инвалида)
                                        </label>
                                        <label class="form-radio form-normal active form-text form-danger">
                                            <input type="radio" ng-model="formInfo.rhb_res_no" name="resid_no" value="4"> Инвалид (ребенок-инвалид) либо законный (уполномоченный) представитель отказался от реализации ИПРА инвалида (ИПРА ребенка-инвалида) в целом
                                        </label>
                                        <label class="form-radio form-normal active form-text form-danger">
                                            <input type="radio" ng-model="formInfo.rhb_res_no" name="resid_no" value="5"> Причины неисполнения мероприятий, предусмотренных ИПРА инвалида (ИПРА ребенка-инвалида), при согласии инвалида (ребенка-инвалида) либо законного (уполномоченного) представителя на их реализацию
                                        </label>

                                    </div>

                                </div>
                            </div>

                        </div>
                        <div class="panel-footer text-right">

                            <button class="btn btn-info" type="submit" ng-click="m_save()">Сохранить</button>

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

