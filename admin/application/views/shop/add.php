<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title">Создание предмета</h3>
    </div>
    <form role="form" method="post" action="<?=site_url('shop/create/' . $server)?>">
        <div class="box-body">
            <div class="form-group">
                <label>Название</label>
                <input type="text" class="form-control" name="name" placeholder="Название предмета">
            </div>
            <div class="form-group">
                <label>Картинка</label>
                <input type="text" class="form-control" name="image" placeholder="Точное название КАК В ИГРЕ!">
            </div>
            <div class="form-group">
                <label>ID предмета</label>
                <input type="text" class="form-control" name="item_id" placeholder="ID предмета вида 228:1337">
            </div>
            <div class="form-group">
                <label>Цена в руб.</label>
                <input type="text" class="form-control" name="price" placeholder="Цена: например 0.14">
            </div>
            <div class="form-group">
                <label>Цена в дрим.</label>
                <input type="text" class="form-control" name="dprice" placeholder="Цена: например 228">
            </div>
        </div>
        <!-- /.box-body -->

        <div class="box-footer">
            <button type="submit" class="btn btn-primary">Добавить</button>
        </div>
    </form>
</div>