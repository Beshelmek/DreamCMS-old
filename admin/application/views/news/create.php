<div class="box box-warning">
    <div class="box-header with-border">
        <h3 class="box-title">Создание новости</h3>
    </div>
    <!-- /.box-header -->
    <div class="box-body">
        <form method="post" action="<?=site_url('news/save')?>">
            <!-- text input -->
            <div class="form-group">
                <label>URL</label>
                <input type="text" class="form-control" name="id" placeholder="Введите ID \ ссылку новости" >
            </div>

            <div class="form-group">
                <label>Заголовок</label>
                <input type="text" class="form-control" name="title" placeholder="Заголовок">
            </div>
            <div class="form-group">
                <label>Картинка</label>
                <input type="text" class="form-control" name="img" placeholder="Ссылка на изображение">
            </div>

            <div class="form-group">
                <textarea name="short" id="short">
                    Краткая новость
                </textarea>
            </div>
            <div class="form-group">
                <textarea name="full" id="full">
                    Полная новость
                </textarea>
            </div>

            <div class="form-group">
                <label>Активна</label>
                <input type="text" class="form-control" name="active" placeholder="1 или 0"">
            </div>

            <button type="submit" class="btn btn-primary">Отправить</button>
        </form>
    </div>
    <!-- /.box-body -->
</div>
<script>
    CKEDITOR.replace('short');
    CKEDITOR.replace('full');
</script>