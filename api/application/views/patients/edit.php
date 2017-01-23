<div class="boxed">

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
            <li><?php echo $xml->Person->FIO->LastName; ?> <?php echo $xml->Person->FIO->FirstName; ?> <?php echo $xml->Person->FIO->SecondName; ?></li>

        </ol>
        <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
        <!--End breadcrumb-->


        <!--Page content-->
        <!--===================================================-->
        <div id="page-content">

            <div class="row">

                <div class="col-sm-6">
                    <form method="post">
                    <div class="panel">
                        <div class="panel-heading">
                            <h3 class="panel-title">
                                Пациент: <?php echo $xml->Person->FIO->LastName; ?> <?php echo $xml->Person->FIO->FirstName; ?>
                                <?php echo $xml->Person->FIO->SecondName; ?>
                            </h3>
                        </div>
                        <div class="panel-body">
                                    <div class="form-group">
                                        <label class="control-label">ЛПУ</label>
                                        <select class="form-control" name="lpu">
                                            <option value="" selected></option>
                                            <option value="-">ПУСТО!!!</option>
                                            <?php
                                            foreach($users as $user)
                                            {
                                                ?>
                                                <option
                                                    <?php
                                                    if($user['login']==$patient['LPUCODE']) echo " selected ";
                                                    ?>
                                                    value="<?php echo $user['login']; ?>"><?php echo $user['login']; ?></option>
                                                <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                        </div>
                        <div class="panel-footer text-right">
                            <button style="margin-left: 30px" class="btn btn-info" type="submit" id="search-button">Изменить</button>
                        </div>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>