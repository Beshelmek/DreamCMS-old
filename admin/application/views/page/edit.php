<div class="box box-warning">
    <div class="box-header with-border">
        <h3 class="box-title">Редактирование страницы</h3>
    </div>
    <!-- /.box-header -->
    <div class="box-body">
        <form method="post" action="<?=site_url('page/save')?>">
            <!-- text input -->
            <div class="form-group">
                <label>URL</label>
                <input type="text" class="form-control" name="id" placeholder="Введите ID \ ссылку новости" value="<?=$page['id']?>" disabled>
            </div>
            <input type="hidden" name="id" value="<?=$page['id']?>">
            <div class="form-group">
                <label>Заголовок</label>
                <input type="text" class="form-control" name="title" placeholder="Заголовок" value="<?=$page['title']?>">
            </div>

            <div class="form-group">
                <textarea name="short">
                    <?=$page['short']?>
                </textarea>
                <div id="dshort" style="width: 100%; height: 550px;">
                    <?=$page['short']?>
                </div>
            </div>

            <div class="form-group">
                <label>Имеет параметры</label>
                <input type="number" max="1" min="0" class="form-control" name="parametered" placeholder="0 или 1" value="<?=$page['parametered']?>">
            </div>

            <button type="submit" class="btn btn-primary">Отправить</button>
        </form>
    </div>
    <!-- /.box-body -->
</div>
<script src="/assets/js/ace/ace.js" type="text/javascript" charset="utf-8"></script>
<script>
    var editor = ace.edit("dshort");
    var textarea = $('textarea[name="short"]');
    textarea.hide();
    editor.getSession().setValue(textarea.val());
    editor.getSession().setMode("ace/mode/html");
    editor.setTheme("ace/theme/monokai");
    editor.getSession().on('change', function(){
        textarea.val(editor.getSession().getValue());
    });
</script>