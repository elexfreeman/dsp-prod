<div class="login-form-bg">
<div class="container">

    <?php echo form_open("auth/login");?>
    <div class="panel  panel-primary login-form">
        <div class="panel-heading">
            <h3 class="panel-title">Индивидуальная программа реабилитации и абилитации инвалида (ребенка инвалида)</h3>
        </div>


        <div class="panel-body">
            <div class="form-group">
                <label for="exampleInputEmail1">Логин</label>
                <input type="text" class="form-control" id="login" name="username" placeholder="Ваш код ЛПУ" required>
            </div>
            <div class="form-group">
                <label for="exampleInputPassword1">Пароль</label>
                <input type="password" class="form-control" id="password" name="password" placeholder="пароль" required>
            </div>

            <button type="submit" class="btn btn-default">Войти</button>
        </div>
        <div class="panel-footer"><a href="http://medlan.samara.ru">© МИАЦ</a><br>
            Все права защищены 2016</div>
    </div>
    </form>
</div>
</div>