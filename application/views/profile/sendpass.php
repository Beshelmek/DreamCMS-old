<div class="panel panel-profile profile col-md-6 col-md-offset-4">
    <div class="panel-heading overflow-h">
        <h2 class="heading-sm panel-title">Восстановление пароля</h2>
    </div>
    <div class="panel-body">
        <form id="form-auth-sendpass" class="form-horizontal">
            <input type="hidden" name="<?=$csrf['name'];?>" value="<?=$csrf['hash'];?>" />

            <div class="form-group">
                <label class="col-md-4 control-label">Почта или логин</label>
                <div class="col-md-6">
                    <input type="email" class="form-control" name="email" value="">
                </div>
            </div>

            <div class="form-group">
                <div id="g-recaptcha" class="g-recaptcha" data-sitekey="6Lcz2BATAAAAAPHlYDchnmwwNtIG0JbM3IJNkTl7"></div>
            </div>

            <div class="form-group">
                <div class="col-md-6 col-md-offset-4">
                    <a id="btn-auth-sendpass" class="btn btn-primary">
                        Выслать ссылку на сброс пароля
                    </a>
                </div>
            </div>
        </form>
    </div>
</div>