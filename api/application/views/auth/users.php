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

            <!--Searchbox-->
            <div class="searchbox">
                <div class="input-group custom-search-form">
                    <input type="text" class="form-control" placeholder="Поиск..">
							<span class="input-group-btn">
								<button class="text-muted" type="button"><i class="fa fa-search"></i></button>
							</span>
                </div>
            </div>
        </div>
        <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
        <!--End page title-->


        <!--Breadcrumb-->
        <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
        <ol class="breadcrumb">
            <li><a href="/">Рабочий стол</a></li>

        </ol>
        <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
        <!--End breadcrumb-->




        <!--Page content-->
        <!--===================================================-->
        <div id="page-content">

            <div class="row">

              <div class="col-sm-6">
                  <div class="panel">
                      <div class="panel-heading">
                          <h3 class="panel-title">Список пользователей:</h3>
                      </div>
                      <div class="panel-body">
                      <a href="<?php echo site_url('auth/adduser'); ?>" class="btn btn-info" type="button" id="search-button">Добавить пользователя</a>
                      </div>
                      <!--Hover Rows-->
                      <!--===================================================-->
                      <div class="panel-body">
                          <table class="table table-hover table-vcenter">
                              <thead>
                              <tr>
                                  <th>id</th>
                                  <th>Login</th>
                                  <th>Password</th>

                              </tr>
                              </thead>
                              <tbody>
                              <?php
                              foreach ($users as $user)
                              {
                               ?><a href="<?php echo site_url('auth/users/'.$user['id']) ?>">
                                  <tr>
                                      <td>
                                          <a href="<?php echo site_url('auth/users/'.$user['id']) ?>">
                                          <span class="text-semibold"><?php echo $user['id']; ?></span>
                                          </a>
                                      </td>
                                      <td>
                                          <a href="<?php echo site_url('auth/users/'.$user['id']) ?>">
                                          <span class="text-semibold"><?php echo $user['login']; ?></span>
                                          </a>
                                      </td>
                                      <td>
                                          <span class="text-semibold"><?php echo $user['password']; ?></span>
                                      </td>
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

            </div>
        </div>
    </div>
</div>


