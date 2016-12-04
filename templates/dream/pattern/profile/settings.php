<h2>Настройки</h2>

<ul class="nav nav-tabs tabs-3 blue" role="tablist">
    <li class="nav-item">
        <a class="nav-link active" data-toggle="tab" href="#panel1" role="tab">Основное</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" data-toggle="tab" href="#panel2" role="tab">Безопасность</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" data-toggle="tab" href="#panel3" role="tab">Доп. авторизация</a>
    </li>
</ul>

<div class="tab-content card">
    <div class="tab-pane fade in active" id="panel1" role="tabpanel">
        <br>
        <form id="form-profile">
            <input type="hidden" name="<?=$csrf['name'];?>" value="<?=$csrf['hash'];?>" />
            <div class="form-vertical">
                <div class="row">
                    <div class="col-md-8">
                        <div class="md-form">
                            <i class="fa fa-user prefix"></i>
                            <input type="text" maxlength="18" class="form-control" name="name">
                            <label for="form2">Имя:</label>
                        </div>

                        <select class="mdb-select" name="gender">
                            <option value="not_stated" disabled selected>Выберите пол</option>
                            <option value="male">Мужской</option>
                            <option value="female">Женский</option>
                        </select>
                    </div>
                </div> <!-- /.row -->
                <hr>
                <a onclick="ajaxAction('/profile/save', $('#form-profile').serializeArray())" class="btn btn-primary">Сохранить</a>
            </div> <!-- /.col-md-12 -->
        </form>
    </div>

    <div class="tab-pane fade" id="panel2" role="tabpanel">
        <br>
        <form id="form-savepass" class="form-horizontal" style="margin-top: 10px;">
            <input type="hidden" name="<?=$csrf['name'];?>" value="<?=$csrf['hash'];?>" />
            <div class="form-vertical no-margin">
                <div class="row">
                    <div class="col-md-8">
                        <div class="md-form">
                            <i class="fa fa-envelope-o prefix"></i>
                            <input type="email" maxlength="64" class="form-control" id="email" name="email">
                            <label for="email">Почта:</label>
                        </div>

                        <div class="md-form">
                            <i class="fa fa-unlock-alt prefix"></i>
                            <input type="password" maxlength="32" class="form-control" id="newpass" name="newpass">
                            <label for="newpass">Новый пароль:</label>
                        </div>

                        <div class="md-form">
                            <i class="fa fa-unlock-alt prefix"></i>
                            <input type="password" maxlength="32" class="form-control" id="rnewpass" name="rnewpass">
                            <label for="rnewpass">Повторите новый пароль:</label>
                        </div>

                        <div class="md-form">
                            <i class="fa fa-keyboard-o prefix"></i>
                            <input type="password" maxlength="32" class="form-control" id="pass" name="pass" required>
                            <label for="rnewpass">Текущий пароль:</label>
                        </div>

                        <div class="md-form">
                            <div class="g-recaptcha" data-sitekey="6Lcz2BATAAAAAPHlYDchnmwwNtIG0JbM3IJNkTl7"></div>
                        </div>

                    </div>
                </div> <!-- /.row -->
                <hr>
                <div class="form-actions">
                    <a onclick="ajaxAction('/auth/change_password', $('#form-savepass').serializeArray())" class="btn btn-primary">Сохранить</a>
                </div>
            </div> <!-- /.col-md-12 -->
        </form>
    </div>

    <div class="tab-pane fade" id="panel3" role="tabpanel">
        <br>
        <form id="form-ga-auth" class="form-horizontal" style="margin-top: 10px;">
            <input type="hidden" name="<?=$csrf['name'];?>" value="<?=$csrf['hash'];?>" />
            <div class="form-vertical no-margin">
                <? if (isset($user['ga_secret']) && !empty($user['ga_secret'])):?>
                    <div class="row">
                        <div class="alert alert-info">
                            <h1>Двухэтапная авторизация</h1>
                            <p>Сейчас, для того, что бы войти в ваш аккаунт, вам необходимо ввести код из приложения Goggle Authentificator. Код изменяется каждые 30 секунд. Никто кроме вас не сможет получить доступ к аккаунту даже если Ваш пароль украдут.</p>
                        </div>
                        <div class="col-md-6">
                            <center>
                                <img src="https://chart.googleapis.com/chart?chs=250x250&chld=M|0&cht=qr&chl=<?=urlencode('otpauth://totp/' . $user['login'] . '@dreamcraft.su?secret=' . $user['ga_secret']) ?>">
                            </center>
                        </div>
                        <div class="col-md-6">
                            <div class="block-blockquote">
                                <br>
                                Войдите в приложение и отсканируйте этот бар-код, он автоматически добавит ваш аккаунт в защиту!
                                <br>
                                <br>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="form-actions">
                        <a id="ga-disable" class="btn btn-primary" onclick="ajaxAction('/auth/ga_auth/disable', $('#form-ga-auth').serialize());">Отключить защиту</a>
                    </div>
                <? else:?>
                    <div class="row">
                        <div class="alert alert-info">
                            <h1>Двухэтапная авторизация</h1>
                            <p>Двухэтапная авторизация - дополнительная проверка владельца аккаунта. Если активировать защиту, то при входе на сайт, вы должны будете вводить код из приложения Google Authentificator (доступен на все платформы в т.ч Android и iOS).
                                <br>
                                <br>Что бы активировать защиту, вам нужно:
                                <br>1. Скачать приложение <a href="https://support.google.com/accounts/answer/1066447?hl=ru">Google Authentificator</a>
                                <br>2. Отсканировать бар-код в приложении (или ввести вручную <b><?=$ga_temp?></b>)
                                <br>3. Ввести цифровой пароль из приложения и нажать кнопку включения
                            </p>
                        </div>
                        <div class="col-md-6">
                            <center>
                                <img src="https://chart.googleapis.com/chart?chs=250x250&chld=M|0&cht=qr&chl=<?=urlencode('otpauth://totp/' . $user['login'] . '@dreamcraft.su?secret=' . $ga_temp) ?>">
                            </center>
                        </div>
                    </div>
                    <hr>
                    <div class="col-xs-6">
                        <input type="number" name="ga_code" class="form-control" maxlength="6" value="">
                    </div>
                    <div class="form-actions">
                        <a id="ga-enable" class="btn btn-primary" onclick="ajaxAction('/auth/ga_auth/enable', $('#form-ga-auth').serialize());">Включить защиту</a>
                    </div>
                <? endif;?>
            </div> <!-- /.col-md-12 -->
        </form>
    </div>
</div>