<style>
    .item-block {
        width: 140px;
        text-align: center;
        border: 1px solid #DDDDDD;
        padding: 10px;
        float: left;
        margin: 10px;
    }
</style>
<div class="panel panel-profile profile">
    <div class="panel-heading overflow-h">
        <h2 class="panel-title heading-sm"><?=$stitle?></h2>
    </div>
    <div class="panel-body tab-v1">
        <div class="lead">
            <a ajax-url="true" href="/shop" class="btn-u">Назад</a>
        </div>
        <div class="row">
            <div class="alert alert-info">
                <h3>Как получить предметы?</h3>
                Команда '/cart all' выдаст Вам все предметы из корзины, которые присутствуют на этом сервере. Вы можете не волноваться, предметы с других серверов не пропадут!
            </div>
        </div>
        <div class="row">
        <?php foreach($items as $item): ?>
            <div class="item-block">
                <div class="row"><span><?=$item['sname']?></span></div>
                <div class="row"><img src="<?=$item['image']?>" width="100px" height="100px"></div>
                <div class="row"><span><?=$item['count']?> шт.</span></div>
            </div>
        <?php endforeach; ?>
        </div>
    </div>
</div>