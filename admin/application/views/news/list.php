<div class="box box-info">
    <div class="box-header with-border">
        <h3 class="box-title">Список новостей</h3>

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
                    <th>Активна</th>
                    <th>Автор</th>
                    <th>Время</th>
                    <th>Действия</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach($news as $value): ?>
                <tr>
                    <td><a href="/news/view/<?=$value['id']?>"><?=$value['id']?></a></td>
                    <td><?=$value['title']?></td>
                    <?php if ($value['active'] == 1): ?>
                        <td><span class="label label-success">Активна</span></td>
                    <?php else: ?>
                        <td><span class="label label-error">В ожидании</span></td>
                    <?php endif; ?>
                    <td><?=$value['author']?></td>
                    <td><?=date('d-m-Y H:i:s', $value['time'])?></td>
                    <td><div class="btn-group">
                            <a href="<?=site_url('news/edit/' . $value['id'])?>" class="btn btn-default"><i class="fa fa-pencil"></i></a>
                            <a href="<?=site_url('news/delete/' . $value['id'])?>" class="btn btn-default"><i class="fa fa-trash"></i></a>
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
        <a href="<?=site_url('news/create')?>" class="btn btn-sm btn-info btn-flat pull-left">Создать новость</a>
    </div>
    <!-- /.box-footer -->
</div>
