<div class="panel panel-profile profile col-md-6 col-md-offset-4">
    <div class="panel-heading overflow-h">
        <h2 class="heading-sm panel-title">Двухэтапная аутентификация</h2>
    </div>
    <div class="panel-body">
        <form id="form-ga-auth" class="form-horizontal" method="post">
            <input type="hidden" name="<?=$csrf['name'];?>" value="<?=$csrf['hash'];?>" />

            <div class="form-group">
                <label class="col-md-4 control-label">Введите код из приложения</label>
                <div class="col-md-6">
                    <input type="ga_code" class="form-control" name="ga_code" value="">
                </div>
            </div>

            <div class="form-group">
                <div id="g-recaptcha" class="g-recaptcha" data-sitekey="6Lcz2BATAAAAAPHlYDchnmwwNtIG0JbM3IJNkTl7"></div>
            </div>

            <div class="form-group">
                <div class="col-md-6 col-md-offset-4">
                    <button type="submit" class="btn btn-primary">
                        Войти
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>