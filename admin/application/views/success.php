<div class="box box-success box-solid">
    <div class="box-header with-border">
        <h3 class="box-title">Успешно</h3>

        <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
        </div>
        <!-- /.box-tools -->
    </div>
    <!-- /.box-header -->
    <div class="box-body">
        <?=$msg?></br></br>
        <?php if (isset($url)): ?>
            <a href="<?=site_url($url)?>" class="btn btn-block btn-warning btn-lg">ВЕРНУТЬСЯ НАЗАД</a>
        <?php else: ?>
            <a onclick="history.go(-3); return false;" class="btn btn-block btn-warning btn-lg">ВЕРНУТЬСЯ НАЗАД</a>
        <?php endif; ?>
    </div>

</div>