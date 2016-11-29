<div class="box">
    <div class="box-header">
        <h3 class="box-title">Список предметов</h3>&nbsp&nbsp&nbsp
        <a class="btn btn-success" href="<?=site_url('shop/add/' . $server)?>">Создать предмет</a>
    </div>

    <div class="box-body no-padding">
        <table class="table table-striped">
            <tbody>
            <tr>
                <th style="width: 10px">#</th>
                <th>Название</th>
                <th>ID предмета</th>
                <th>Цена в руб.</th>
                <th>Цена в дрим.</th>
                <th>Картинка</th>
                <th>Действия</th>
            </tr>
            <?php foreach($items as $item): ?>
                <tr>
                    <td><?=$item['id']?></td>
                    <td><?=$item['name']?></td>
                    <td><?=$item['item_id']?></td>
                    <td><?=$item['price']?></td>
                    <td><?=$item['dprice']?></td>
                    <td><?=$item['image']?></td>
                    <td>
                        <div class="btn-group">
                            <a href="<?=site_url('shop/item/' . $item['server']  .'/'. $item['id'])?>" class="btn-sm btn-default"><i class="fa fa-pencil"></i></a>
                            <a href="<?=site_url('shop/item/' . $item['server']  .'/'. $item['id'])?>" class="btn-sm btn-default"><i class="fa fa-trash"></i></a>
                        </div>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <!-- /.box-body -->
</div>