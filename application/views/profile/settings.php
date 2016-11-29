<div class="panel panel-profile profile">
    <div class="panel-heading overflow-h">
        <h2 class="panel-title heading-sm"> Настройки </h2>
    </div>
    <div class="panel-body tab-v1">
        <ul class="nav nav-tabs">
            <li class="active"><a href="#main" data-toggle="tab" aria-expanded="true">Основное</a></li>
            <li class=""><a href="#security" data-toggle="tab" aria-expanded="false">Безопасность</a></li>
            <li class=""><a href="#auth" data-toggle="tab" aria-expanded="false">Защита аккаунта</a></li>
        </ul>
        <div class="tab-content">
            <div class="tab-pane active" id="main">
                <form id="form-profile" class="form-horizontal" style="margin-top: 10px;">
                    <input type="hidden" name="<?=$csrf['name'];?>" value="<?=$csrf['hash'];?>" />
                    <div class="form-vertical no-margin">
                        <div class="row">
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label class="col-md-4 control-label">Имя:</label>
                                    <div class="col-md-8"><input type="text" name="name" class="form-control" maxlength="18" value="" placeholder="Имя"></div>
                                </div>

                                <div class="form-group">
                                    <label class="col-md-4 control-label">Пол:</label>
                                    <div class="col-md-8">
                                        <select class="form-control" id="gender" name="gender">
                                            <option selected="" value="not_stated">Не указан</option>
                                            <option value="male">Мужской</option>
                                            <option value="female">Женский</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div> <!-- /.row -->
                        <hr>
                        <div class="form-actions">
                            <a id="profile-btn" class="btn btn-u pull-right">Сохранить</a>
                        </div>
                    </div> <!-- /.col-md-12 -->
                </form>
            </div> <!-- /#main -->

            <div class="tab-pane" id="security">
                <form id="form-savepass" class="form-horizontal" style="margin-top: 10px;">
                    <input type="hidden" name="<?=$csrf['name'];?>" value="<?=$csrf['hash'];?>" />
                    <div class="form-vertical no-margin">
                        <div class="row">
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label class="col-md-4 control-label">Почта</label>
                                    <div class="col-md-8">
                                        <input type="email" name="email" class="form-control" maxlength="64">
                                        <div class="help-block">Введите новую почту, если хотите изменить её.</div>
                                    </div>

                                </div>

                                <div class="form-group">
                                    <label class="col-md-4 control-label">Новый пароль:</label>
                                    <div class="col-md-8 new_psw"><input id="new_psw" type="password" name="newpass" class="form-control" maxlength="32" value="">
                                        <div class="help-block">Введите новый пароль, если хотите изменить его.</div></div>

                                </div>

                                <div class="form-group">
                                    <label class="col-md-4 control-label">Повторите новый пароль:</label>
                                    <div class="col-md-8"><input type="password" name="rnewpass" class="form-control" maxlength="32" value=""></div>
                                </div>


                                <div class="form-group">
                                    <label class="col-md-4 control-label">Текущий пароль:</label>
                                    <div class="col-md-8">
                                        <input type="password" name="pass" class="form-control" maxlength="32" value="" required="">
                                        <div class="help-block">Введите текущий пароль для сохранения настроек.</div>
                                    </div>
                                </div>

                                <div class="form-group" style="margin-left: 187px;">
                                    <div class="g-recaptcha" data-sitekey="6Lcz2BATAAAAAPHlYDchnmwwNtIG0JbM3IJNkTl7"></div>
                                </div>

                            </div>
                        </div> <!-- /.row -->
                        <hr>
                        <div class="form-actions">
                            <a id="savepass-btn" class="btn btn-u pull-right">Сохранить</a>
                        </div>
                    </div> <!-- /.col-md-12 -->
                </form>
            </div>

            <div class="tab-pane" id="auth">
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
                                <a id="ga-disable" class="btn btn-u pull-right" onclick="ajaxAction('/auth/ga_auth/disable', $('#form-ga-auth').serialize());">Отключить защиту</a>
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
                                <a id="ga-enable" class="btn btn-u" onclick="ajaxAction('/auth/ga_auth/enable', $('#form-ga-auth').serialize());">Включить защиту</a>
                            </div>
                        <? endif;?>
                    </div> <!-- /.col-md-12 -->
                </form>
            </div>
        </div> <!-- /.tab-content -->
    </div>
</div>