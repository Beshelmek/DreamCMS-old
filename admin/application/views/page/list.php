<div class="box box-info">
    <div class="box-header with-border">
        <h3 class="box-title">Список страниц</h3>

        <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
            </button>
            <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
        </div>
    </div>
    <!-- /.box-header -->
    <div class="box-body">
        <div class="table-responsive">
            <table class="table no-margin">
                <thead>
                <tr>
                    <th>URL</th>
                    <th>Заголовок</th>
                    <th>Время</th>
                    <th>Действия</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach($pages as $value): ?>
                    <tr>
                        <td><a href="/page/<?=$value['id']?>"><?=$value['id']?></a></td>
                        <td><?=$value['title']?></td>
                        <td><?=date('d-m-Y H:i:s', $value['time'])?></td>
                        <td><div class="btn-group">
                                <a href="<?=site_url('page/edit/' . $value['id'])?>" class="btn btn-default"><i class="fa fa-pencil"></i></a>
                                <a href="<?=site_url('page/delete/' . $value['id'])?>" class="btn btn-default"><i class="fa fa-trash"></i></a>
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
        <a href="<?=site_url('page/create')?>" class="btn btn-sm btn-info btn-flat pull-left">Создать страницу</a>
    </div>
    <!-- /.box-footer -->
</div>
