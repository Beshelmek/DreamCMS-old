<div class="box box-info">
    <div class="box-header with-border">
        <h3 class="box-title">Список серверов с магазином</h3>

        <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
            </button>
        </div>
    </div>
    <!-- /.box-header -->
    <div class="box-body">
        <div class="table-responsive">
            <table class="table no-margin">
                <thead>
                <tr>
                    <th>Сервер</th>
                    <th>Таблица</th>
                    <th>Действия</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach($servers as $server): ?>
                    <tr>
                        <td><?=$server['name']?></td>
                        <td><?=strtolower('dc_shop_' . $server['name'])?></td>
                        <td>
                            <div class="btn-group">
                                <a href="<?=site_url('shop/server/' . $server['name'])?>" class="btn btn-default"><i class="fa fa-pencil"></i></a>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <!-- /.table-responsive -->
    </div>
</div>
