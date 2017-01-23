


<!-- BACKGROUND IMAGE -->
<!--===================================================-->
<div id="bg-overlay" class="bg-img img-balloon"></div>


<!-- HEADER -->
<!--===================================================-->
<div class="cls-header cls-header-lg">
  <div class="cls-brand">
    <a class="box-inline" href="index.html">
      <!-- <img alt="Nifty Admin" src="img/logo.png" class="brand-icon"> -->
      <span class="brand-title"><?php echo lang('login_heading');?></span>
    </a>
  </div>
</div>
<!--===================================================-->


<!-- LOGIN FORM -->
<!--===================================================-->
<div class="cls-content cls-container">
  <div class="cls-content-sm panel">
    <div class="panel-body">
      <p class="pad-btm">Войдите в свой акаунт</p>
      <?php echo form_open("auth/login");?>
        <div class="form-group">
          <div class="input-group">
            <div class="input-group-addon"><i class="fa fa-user"></i></div>
            <?php echo form_input($identity);?>
          </div>
        </div>
        <div class="form-group">
          <div class="input-group">
            <div class="input-group-addon"><i class="fa fa-asterisk"></i></div>
            <?php echo form_input($password);?>
          </div>
        </div>
        <div class="row">
          <div class="col-xs-8 text-left checkbox">
            <label class="form-checkbox form-icon">
              <input type="checkbox" name="remember" value="1" id="remember"> Запомнить меня
            </label>
          </div>
          <div class="col-xs-4">
            <div class="form-group text-right">
              <button class="btn btn-success text-uppercase" type="submit">Войти</button>
            </div>
          </div>
        </div>
        <div class="mar-btm"><em>- или -</em></div>
        <button class="btn btn-primary btn-lg btn-block" type="button">
          Подать заявку на использование
        </button>

      <?php echo form_close();?>
    </div>
  </div>
  <div class="pad-ver">
    <a href="#" class="btn-link mar-rgt">Условия использования</a>
    <a href="#" class="btn-link mar-lft">Политика конфиденциальности</a>
  </div>
</div>
<!--===================================================-->


