<div class="card">
    <div class="card-header danger-color-dark white-text">
        Двухэтапная аутентификация
    </div>
    <div class="card-block">
        <form id="form-ga-auth" class="form-horizontal" method="post">
            <?=$fcsrf?>

            <div class="row">
                <div class="col-md-12">
                    <div class="md-form">
                        <i class="fa fa-pencil prefix"></i>
                        <input id="ga_code" type="text" name="ga_code" maxlength="6">
                        <label for="ga_code">Код</label>
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
                    <button type="submit" class="btn btn-primary">
                        Войти
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>