<div class="box box-info">
    <div class="box-header with-border">
        <h3 class="box-title">Список серверов с PermissionEx</h3>

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
                    <th>База данных</th>
                    <th>Действия</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach($servers as $server): ?>
                    <tr>
                        <td><?=$server['name']?></td>
                        <td><?=strtolower($server['name'])?></td>
                        <td>
                            <div class="btn-group">
                                <a href="<?=site_url('permissions/edit/' . $server['name'])?>" class="btn btn-default"><i class="fa fa-pencil"></i></a>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <!-- /.table-responsive -->
    </div>
    <!-- /.box-body -->
    <div class="box-footer clearfix">
        <a href="<?=site_url('permissions/sync')?>" class="btn btn-sm btn-info btn-flat pull-left">Синхронизировать с HiTech</a>
    </div>
    <!-- /.box-footer -->
</div>
