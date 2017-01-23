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
            <h1 class="page-header text-overflow">Добавление пользователя</h1>
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
                            <h3 class="panel-title">Введите логин и пароль</h3>
                        </div>

                        <!--Block Styled Form -->
                        <!--===================================================-->
                        <form id="search_form_1" method="post">
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label class="control-label">Логин:</label>
                                            <?php echo $login;?>
                                        </div>
                                    </div>

                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label class="control-label">Пароль:</label>
                                            <?php echo $password;?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="panel-footer text-right">
                                <button class="btn btn-info" type="submit" id="search-button">Добавить</button>
                            </div>
                        </form>
                        <!--===================================================-->
                        <!--End Block Styled Form -->

                    </div>
                </div>



            </div>
        </div>
    </div>
</div>


