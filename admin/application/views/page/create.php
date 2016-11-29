<div class="box box-warning">
    <div class="box-header with-border">
        <h3 class="box-title">Создание страницы</h3>
    </div>
    <!-- /.box-header -->
    <div class="box-body">
        <form method="post" action="<?=site_url('page/save')?>">
            <!-- text input -->
            <div class="form-group">
                <label>URL</label>
                <input type="text" class="form-control" name="id" placeholder="Введите ID \ ссылку страницы" >
            </div>

            <div class="form-group">
                <label>Заголовок</label>
                <input type="text" class="form-control" name="title" placeholder="Заголовок">
            </div>


            <div class="form-group">
                <textarea name="short" id="short">
                    Краткая новость
                </textarea>
            </div>

            <div class="form-group">
                <label>Имеет параметры</label>
                <input type="number" max="1" min="0" class="form-control" name="parametered" placeholder="0 или 1">
            </div>

            <button type="submit" class="btn btn-primary">Отправить</button>
        </form>
    </div>
    <!-- /.box-body -->
</div>
<script>
    CKEDITOR.replace('short');
</script>