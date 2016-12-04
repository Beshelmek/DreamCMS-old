<div class="modal fade modal-ext" id="modal-register" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h3><i class="fa fa-user"></i> Регистрация:</h3>
            </div>
            <div class="modal-body">
                <form id="auth-register">
                    <?=$fcsrf?>
                    <div class="md-form">
                        <i class="fa fa-user prefix"></i>
                        <input type="text" name="login" id="form2" class="form-control">
                        <label for="form2">Ваш логин</label>
                    </div>

                    <div class="md-form">
                        <i class="fa fa-envelope prefix"></i>
                        <input type="text" name="email" id="form2" class="form-control">
                        <label for="form2">Ваша почта</label>
                    </div>

                    <div class="md-form">
                        <i class="fa fa-lock prefix"></i>
                        <input type="password" name="pass" id="form3" class="form-control">
                        <label for="form3">Ваш пароль</label>
                    </div>

                    <div class="md-form">
                        <i class="fa fa-lock prefix"></i>
                        <input type="password" name="rpass" id="form4" class="form-control">
                        <label for="form4">Повторите пароль</label>
                    </div>

                    <div class="md-form">
                        <div id="g-recaptcha" class="g-recaptcha" data-sitekey="6Lcz2BATAAAAAPHlYDchnmwwNtIG0JbM3IJNkTl7"></div>
                    </div>
                </form>

                <div class="text-xs-center">
                    <!--<fieldset class="form-group">
                        <input type="checkbox" id="checkbox1" name="autoenter" checked>
                        <label for="checkbox1">Войти автоматически</label>
                    </fieldset>-->

                    <button class="btn btn-primary btn-lg" onclick="ajaxAction('/auth/register', $('#auth-register').serializeArray())">Зарегистрироваться</button>
                </div>
            </div>
        </div>
    </div>
</div>

</div>
    <div class="col-md-4">
        <?if($logged): ?>
            <div class="card-wrapper">
                <div id="card-1" class="card-rotating">
                    <div class="face front">
                        <div class="avatar" style="border-radius: 0"><img src="/skin/head/<?=$userinfo['uuid']?>/120">
                        </div>
                        <div class="card-block">
                            <h4><?=$userinfo['login']?></h4>
                            <ul class="list-unstyled panel-menu">
                                <div class="list-group">
                                    <a href="#" class="list-group-item active">У вас: <?=$userinfo['realmoney']?> руб. и <?=$userinfo['money']?> монет</a>

                                    <a href="#" type="button" data-toggle="modal" data-target="#donate-modal" class="list-group-item">
                                        <i class="fa fa-plus"></i> Пополнить счет
                                    </a>
                                    <?if($userinfo['vk_uid'] == 0):?>
                                        <a href="/vk" class="list-group-item"><i class="fa fa-vk"></i> Привязать ВКонтакте</a>
                                    <? endif;?>
                                    <a href="/profile" class="list-group-item"><i class="fa fa-user"></i> Личный кабинет</a>
                                    <a href="/refer" class="list-group-item"><i class="fa fa-group"></i> Реферальная система</a>
                                    <a href="/shop" class="list-group-item"><i class="fa fa-shopping-cart"></i> Магазин блоков</a>
                                    <a href="/skin" class="list-group-item"><i class="fa fa-male"></i> Сменить скин</a>
                                    <a href="/settings" class="list-group-item"><i class="fa fa-gear"></i> Настройки</a>
                                    <a href="/auth/logout" class="list-group-item"><i class="fa fa-sign-out"></i> Выйти</a>
                                </div>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        <? else:?>
            <div class="card">
                <div class="card-block">
                    <form id="auth-login" class="form-horizontal">
                        <?=$fcsrf?>
                        <div class="form-header primary-color darken-4">
                            <h3><i class="fa fa-lock"></i> Вход:</h3>
                        </div>
                        <div class="md-form">
                            <i class="fa fa-user prefix"></i>
                            <input type="text" id="login" name="login" class="form-control">
                            <label for="login">Логин или почта</label>
                        </div>
                        <div class="md-form">
                            <i class="fa fa-lock prefix"></i>
                            <input type="password" id="password" name="pass" class="form-control">
                            <label for="password">Пароль</label>
                        </div>
                        <div class="text-xs-center">
                            <a class="btn btn-primary" onclick="ajaxAction('/auth/login', $('#auth-login').serializeArray())">Войти</a>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <div class="options">
                        <p>Еще не игрок?<a href="/page/start"> Начать!</a></p>
                        <p>Забыли <a href="/auth/sendpass">пароль?</a></p>
                    </div>
                </div>
            </div>
        <? endif;?>


        <hr>

        <div class="widget-wrapper">
            <h4>Мониторинг:</h4>
            <div class="card">
                <div class="card-block">
                    <?=$monitoring?>
                </div>
            </div>
        </div>

    </div>
</div>
</div>
<!--/.Content-->



<!--Footer-->
<footer class="page-footer center-on-small-only">
    <!--Copyright-->
    <div class="footer-copyright">
        <div class="container-fluid">
            © 2016 Copyright: <a href="/"><?=$stitle?></a>
        </div>
    </div>
    <!--/.Copyright-->

</footer>
<!--/.Footer-->


<!-- SCRIPTS -->
<!-- Bootstrap tooltips -->
<script type="text/javascript" src="<?=$tpl?>/js/tether.min.js"></script>

<!-- Bootstrap core JavaScript -->
<script type="text/javascript" src="<?=$tpl?>/js/bootstrap.min.js"></script>

<!-- MDB core JavaScript -->
<script type="text/javascript" src="<?=$tpl?>/js/mdb.min.js?v=111"></script>

<!-- Core CMS script -->
<script type="text/javascript" src="<?=$tpl?>/js/main.js?v=<?=$version?>"></script>

<div class="hiddendiv common"></div>
</body>
</html>