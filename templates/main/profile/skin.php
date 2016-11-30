<style>
    .skin-block {
        float: left;
        padding: 10px;
        border: 1px solid #DDDDDD;
        margin-right: 29px;
        margin-bottom: 15px;
    }
    a.btn-u.skin-setup {
        margin-top: 10px;
    }
</style>
<div class="panel panel-profile profile">
    <div class="panel-heading overflow-h">
        <h2 class="panel-title heading-sm">
            Загрузка скина\плаща
        </h2>
    </div>
    <div class="panel-body" style="border-bottom: solid 3px #f7f7f7;">
        <form enctype="multipart/form-data" action="/profile/upload" method="post">
            <input type="hidden" name="<?=$csrf['name'];?>" value="<?=$csrf['hash'];?>" />
            <span>Загрузить:</span><Br>
            <input type="radio" name="type" value="skin"> Скин<Br>
            <input type="radio" name="type" value="cloak"> Плащ<Br><Br>

            <input type="file" name="userfile" accept="image/png"><Br>
            <button type="submit" class="btn-u">Загрузить</button>
        </form>
    </div>
    <div class="panel-body">
        <h3>Выбрать из галереи:</h3>
        <?php foreach($list as $skin): ?>
            <div class="skin-block">
                <img src="/skin/catalog/<?=$skin?>"></br>
                <a href="/skin/set/<?=$skin?>" class="btn-u skin-setup">Установить</a>
            </div>
        <?php endforeach; ?>
    </div>
</div>