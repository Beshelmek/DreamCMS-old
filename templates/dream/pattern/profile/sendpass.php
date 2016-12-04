<div class="card">
    <div class="card-header danger-color-dark white-text">
        Восстановление пароля
    </div>
    <div class="card-block">
        <form id="form-sendpass" class="form-horizontal" method="post">
            <?=$fcsrf?>

            <div class="row">
                <div class="col-md-12">
                    <div class="md-form">
                        <i class="fa fa-user prefix"></i>
                        <input id="email" type="text" name="email" maxlength="64">
                        <label for="email">Почта или логин</label>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div id="g-recaptcha" class="g-recaptcha" data-sitekey="6Lcz2BATAAAAAPHlYDchnmwwNtIG0JbM3IJNkTl7"></div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <a onclick="ajaxAction('/auth/sendpassword', $('#form-sendpass').serializeArray())" class="btn btn-primary">
                        Выслать ссылку
                    </a>
                </div>
            </div>
        </form>
    </div>
</div>