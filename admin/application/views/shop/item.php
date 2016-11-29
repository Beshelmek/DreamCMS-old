<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title">Редактирование предмета</h3>
    </div>
    <form role="form" method="post" action="<?=site_url('shop/edit/' . $item['server'] . '/'. $item['id'])?>">
        <div class="box-body">
            <div class="form-group">
                <label>Название</label>
                <input type="text" class="form-control" name="name" placeholder="<?=$item['name']?>" value="<?=$item['name']?>">
            </div>
            <div class="form-group">
                <label>Картинка</label>
                <input type="text" class="form-control" name="image" placeholder="<?=$item['image']?>" value="<?=$item['image']?>">
            </div>
            <div class="form-group">
                <label>ID предмета</label>
                <input type="text" class="form-control" name="item_id" placeholder="<?=$item['item_id']?>" value="<?=$item['item_id']?>">
            </div>
            <div class="form-group">
                <label>Цена в руб.</label>
                <input type="text" class="form-control" name="price" placeholder="<?=$item['price']?>" value="<?=$item['price']?>">
            </div>
            <div class="form-group">
                <label>Цена в дрим.</label>
                <input type="text" class="form-control" name="dprice" placeholder="<?=$item['dprice']?>" value="<?=$item['dprice']?>">
            </div>
        </div>
        <!-- /.box-body -->

        <div class="box-footer">
            <button type="submit" class="btn btn-primary">Изменить</button>
        </div>
    </form>
</div>