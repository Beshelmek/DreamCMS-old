</div>

<div class="col-lg-3 col-md-3 col-sm-4">
    <div class="panel panel-profile profile">
        <div class="panel-heading overflow-h">
            <?php if (!$logged): ?>
                <h2 class="panel-title heading-sm pull-left">Авторизация</h2>
            <?php else: ?>
                <h2 class="panel-title heading-sm pull-left">Профиль</h2>
            <?php endif; ?>
        </div>
        <div class="panel-body">
            <?php if (!$logged): ?>
                <div class="tab-v1">
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="#login" data-toggle="tab">Вход</a></li>
                        <li><a href="#register" data-toggle="tab">Регистрация</a></li>
                    </ul>
                    <div class="tab-content">
                        </br>
                        <div class="tab-pane active" id="login">
                            <form id="auth-login" class="form-horizontal">
                                <input type="hidden" name="<?=$csrf['name'];?>" value="<?=$csrf['hash'];?>" />
                                <div class="form-group">
                                    <label class="col-md-3 control-label">Логин</label>
                                    <div class="col-md-9">
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="fa fa-user"></i></span>
                                            <input placeholder="Логин" class="form-control" name="login" type="text" value="">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-3 control-label">Пароль</label>
                                    <div class="col-md-9">
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                                            <input placeholder="Пароль" class="form-control" name="pass" type="password" value="">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-11 col-md-offset-1">
                                        <a id="auth-login-btn" class="btn btn-primary">Вход</a>
                                        <a class="btn btn-link" href="/auth/sendpass">Забыли пароль?</a>
                                    </div>
                                </div>
                            </form>
                        </div>

                        <div class="tab-pane" id="register">
                            <form id="auth-reg" class="form-horizontal">
                                <input type="hidden" name="<?=$csrf['name'];?>" value="<?=$csrf['hash'];?>" />
                                <div class="form-group">
                                    <label class="col-md-3 control-label">Логин</label>
                                    <div class="col-md-9">
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="fa fa-user"></i></span>
                                            <input placeholder="Логин" class="form-control" name="login" type="text" value="">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-3 control-label">Пароль</label>
                                    <div class="col-md-9">
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                                            <input placeholder="Пароль" class="form-control" name="pass" type="password" value="">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-3 control-label">Повтор</label>
                                    <div class="col-md-9">
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                                            <input placeholder="Пароль" class="form-control" name="rpass" type="password" value="">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div id="g-recaptcha" class="g-recaptcha" data-sitekey="6Lcz2BATAAAAAPHlYDchnmwwNtIG0JbM3IJNkTl7" style="transform: scale(0.75);
    -webkit-transform: scale(0.75);
    transform-origin: 0 0;
    -webkit-transform-origin: 0 0;
    margin-left: 16px;"></div>
                                </div>
                                <div class="form-group" style="margin-top: -20px;
    margin-bottom: 0px;">
                                    <div class="col-md-10 col-md-offset-1">
                                        <a id="reg-login-btn" style="width: 100%" class="btn btn-primary">Регистрация</a>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            <?php else: ?>
                <ul class="list-unstyled panel-menu">
                    <li class="text-center">
                        <img src="/skin/head/<?=$userinfo['login']?>" alt="<?=$userinfo['login']?>" class="img-thumbnail"/>
                    </li>
                    <li>
                        Добро пожаловать, <?=$userinfo['login']?>
                    </li>
                    <li>
                        Ваш баланс: <span class="pull-right"><?=$userinfo['money']?> монет</span>
                    </li>
                    <li>
                        &nbsp;<span class="pull-right"><?=$userinfo['realmoney']?> рублей</span>
                    </li>
                    <li>
                        <a href="#donate" data-toggle="modal" data-target="#modal_donate"><i class="fa fa-plus"></i>Пополнить счёт</a>
                    </li>
                    <li>
                        <a ajax-url="true" href="/vk"><i class="fa fa-vk"></i>Привязать ВКонтакте</a>
                    </li>
                    <li>
                        <a ajax-url="true" href="/profile"><i class="fa fa-user"></i>Личный кабинет</a>
                    </li>
                    <li>
                        <a ajax-url="true" href="/refer"><i class="fa fa-money"></i>Реферальная система</a>
                    </li>
                    <li>
                        <a ajax-url="true" href="/shop"><i class="fa fa-shopping-cart"></i>Магазин блоков</a>
                    </li>
                    <li>
                        <a ajax-url="true"  href="/skin"><i class="fa fa-male"></i>Сменить скин</a>
                    </li>
                    <li>
                        <a ajax-url="true" href="/settings"><i class="fa fa-cog"></i>Настройки</a>
                    </li>
                    <li>
                        <a href="/auth/logout" ><i class="fa fa-sign-out"></i>Выйти</a>
                    </li>
                </ul>
            <?php endif; ?>
        </div>
    </div>
    <!--<div class="panel-heading-v2 overflow-h">
        <h2 class="heading-xs pull-left"><i class="fa fa-bar-chart-o"></i> Мониторинг</h2>
        <a href="#" id="refresh_monitoring" class="pull-right"><h2 class="heading-xs"><i class="fa fa-refresh"></i></h2></a>
    </div>-->

    <div class="panel panel-profile profile">
        <div class="panel-heading overflow-h">
            <h2 class="panel-title heading-sm pull-left">Получить кейс в игре</h2>
        </div>
        <div class="panel-body">
            <center><p>Голосуйте за нас и получайте кейсы!</p></center>
            <div class="col-sm-12">
                <a href="http://topcraft.ru/servers/4972/" target="_blank"><img src="http://topcraft.ru/media/projects/4972/tops.png"></a>
                <a class="pull-right" href="http://mcrate.su/rate/5966" target="_blank"><img src="http://mcrate.su/bmini.png"></a>
            </div>
            </br></br>
            <div class="col-sm-12">
                <a href="https://fairtop.in/project/1018" target="_blank"><img src="https://fairtop.in/counter/4/1018.png"></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <a href="https://mctop.su/rating/project/819" class="btn btn-primary btn-large" style="width: 88px">MCTop</a>
            </div>
        </div>
    </div>

    <div class="panel panel-profile profile">
        <div class="panel-heading overflow-h">
            <h2 class="panel-title heading-sm pull-left">Мониторинг</h2>
        </div>
        <div class="panel-body">
            <?=$monitoring?>
        </div>
    </div>

    <script type="text/javascript" src="//vk.com/js/api/openapi.js?121"></script>

    <div class="panel panel-profile profile">
        <div class="panel-body">
            <div id="vk_side"></div>
            <script type="text/javascript">
                VK.Widgets.Group("vk_side", {mode: 2, width: "230", height: "400", color1: 'FFFFFF', color2: '585F69', color3: '3498db'}, 87133189);
            </script>
        </div>
    </div>

    <div class="panel panel-profile profile">
        <div class="panel-body" style="height: 450px">
            <a class="twitter-timeline" href="https://twitter.com/DreamCraft_su" data-widget-id="715157373376135168">Твиты от @DreamCraft_su</a>
            <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+"://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
        </div>
    </div>
</div>
</div>
</div>
<!--=== End Container ===-->
<div class="modal fade" id="modal_donate" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title">Пополнение счёта</h4>
            </div>
            <div class="modal-body" style="padding-bottom: 0px;">
                <div class="row">
                    <div class="tab-v1">
                        <ul class="nav nav-justified nav-tabs">
                            <li class="active"><a aria-expanded="false" data-toggle="tab" href="#unitpay">UnitPay</a></li>
                        </ul>
                        <div class="tab-content">
                            <div id="unitpay" class="profile-edit tab-pane fade active in">
                                <div class="col-md-12">
                                    <form class="form-horizontal" action="https://unitpay.ru/pay/39791-30737" style="margin:10px">
                                        <h2 class="heading-md">Мы принимаем:</h2>
                                        <p>Visa, MasterCard, ЯндексДеньги, Qiwi и множество других систем.</p>
                                        <div class="form-group">
                                            <label class="col-md-2 control-label">Сумма</label>
                                            <div class="col-md-10">
                                                <div class="input-group">
                                                    <span class="input-group-addon"><i class="fa fa-rub"></i></span>
                                                    <input placeholder="Сумма" class="form-control" pattern="\d*" required="" name="sum" type="text" value="320">
                                                </div>
                                            </div>
                                        </div>
                                        <input type="hidden" name="account" value="<?=$uuid?>">
                                        <input type="hidden" name="desc" value="Пополнение счета игрока <?=$login?>">
                                        <input class="btn" type="submit" value="Пополнить счёт">
                                        </br>
                                        </br>
                                        <h2 class="heading-md">WebMoney:</h2>
                                        <p>Для того, что бы пополнить счет через WebMoney, обратитесь к <a href="https://vk.com/votyakov1404">администратору</a> с примечанием "WebMoney"</p>
                                    </form>
                                    </br>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--=== Copyright ===-->
<div class="copyright">
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <p>
                    2016 © DreamCraft.Su. Все права защищены ООО "Куб"
                </p>
            </div>
            <div class="pull-right" style="margin-top: 5px;">
                <img src="https://www.megastock.ru/doc/Logo/acc_blue_on_transp_ru.png">
            </div>
            <div class="pull-right">
                <a href="https://metrika.yandex.ru/stat/?id=35221570&amp;from=informer" target="_blank" rel="nofollow"><img src="https://informer.yandex.ru/informer/35221570/3_0_535353FF_333333FF_1_pageviews" style="width:88px; height:31px; border:0;" alt="Яндекс.Метрика" title="Яндекс.Метрика: данные за сегодня (просмотры, визиты и уникальные посетители)" onclick="try{Ya.Metrika.informer({i:this,id:35221570,lang:'ru'});return false}catch(e){}" /></a> <!-- /Yandex.Metrika informer --> <!-- Yandex.Metrika counter --> <script type="text/javascript"> (function (d, w, c) { (w[c] = w[c] || []).push(function() { try { w.yaCounter35221570 = new Ya.Metrika({ id:35221570, clickmap:true, trackLinks:true, accurateTrackBounce:true, webvisor:true }); } catch(e) { } }); var n = d.getElementsByTagName("script")[0], s = d.createElement("script"), f = function () { n.parentNode.insertBefore(s, n); }; s.type = "text/javascript"; s.async = true; s.src = "https://mc.yandex.ru/metrika/watch.js"; if (w.opera == "[object Opera]") { d.addEventListener("DOMContentLoaded", f, false); } else { f(); } })(document, window, "yandex_metrika_callbacks"); </script> <noscript><div><img src="https://mc.yandex.ru/watch/35221570" style="position:absolute; left:-9999px;" alt="" /></div></noscript> <!-- /Yandex.Metrika counter -->
            </div>
        </div>
    </div>
</div>

<script type="text/javascript" src="//vk.com/js/api/openapi.js?127"></script>

<!-- VK Widget -->
<div id="vk_community_messages"></div>
<script type="text/javascript">
    VK.Widgets.CommunityMessages("vk_community_messages", 87133189, {});
</script>
<!--=== End Copyright ===-->
</div>
<script src="/assets/js/bootstrap.min.js"></script>
<script src="/assets/js/main.js?v=4.1"></script>
</body>
</html>