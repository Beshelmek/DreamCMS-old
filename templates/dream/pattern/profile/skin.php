<style>
    .skin-block {
        float: left;
        padding: 10px;
        border: 1px solid #DDDDDD;
        margin-right: 29px;
        margin-bottom: 15px;
    }
</style>
<div class="card card-block">
    <h4 class="card-title">Загрузка скина</h4>
    <span>Загрузить:</span><br>
    <form enctype="multipart/form-data" action="/profile/upload" method="post">
        <?=$fcsrf?>
        <div class="row">
            <fieldset class="form-group pull-left" style="margin-left: 1rem;">
                <input name="type" value="skin" type="radio" id="skin">
                <label for="skin">Скин</label>
                &nbsp;&nbsp;
                <input name="type" value="cloak" type="radio" id="cloak">
                <label for="cloak">Плащ</label>
            </fieldset>
            <button type="submit" class="btn btn-primary pull-right">Загрузить</button>
        </div>



        <div class="file-field">
            <div class="btn btn-primary btn-sm">
                <span>Выберите файл</span>
                <input type="file" name="userfile" accept="image/png">
            </div>
            <div class="file-path-wrapper">
                <input class="file-path validate" type="text" placeholder="Выберите файл">
            </div>
        </div>
    </form>
</div>

<div class="card card-block">
    <h4 class="card-title">Выбрать из галереи:</h4>
    <span>Загрузить:</span><br>
    <?php foreach($list as $skin): ?>
        <div class="skin-block">
            <center><img src="/skin/catalog/<?=$skin?>"></center></br>
            <a href="/skin/set/<?=$skin?>" class="btn btn-primary">Установить</a>
        </div>
    <?php endforeach; ?>
</div>

