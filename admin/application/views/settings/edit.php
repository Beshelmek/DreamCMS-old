<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title">Основные настройки</h3>
    </div>
        <div class="box-body">
            <table class="table table-bordered">
                <tbody><tr>
                    <th>#</th>
                    <th>Название</th>
                    <th>Значение</th>
                    <th>Тип</th>
                    <th>Описание</th>
                    <th></th>
                </tr>
            <?php
            foreach ($config as $key=>$var){
                $type = $var['type'];
                $sort = $var['sort'];
                $value = $var['value'];
                $desc = $var['desc'];
                if(is_array($value)) $value=json_encode($value);
                echo "<tr>
                    <th>$sort</th>
                    <th>$key</th>
                    <th>$value</th>
                    <th>$type</th>
                    <th>$desc</th>
                    <th><button key='$key' id='remove' class='btn btn-block btn-default btn-xs'><i class='fa fa-trash'></i></button></th>
                </tr>";
            }
            ?>
                </tbody>
            </table>
            <div class="box-footer">
                <div class="form-group">
                    <div class="col-xs-3">
                        <label>Выберите тип</label>
                        <select id="form-type" class="form-control">
                            <option value="header">Заголовок</option>
                            <option value="array">Массив</option>
                            <option value="boolean">True\False</option>
                            <option value="int">Число</option>
                            <option value="option">Опциональный выбор</option>
                        </select>
                    </div>
                    <div class="col-xs-1">
                        <label>Введите номер</label>
                        <input id="form-sort" type="number" placeholder="sort" value="-1" class="form-control">
                    </div>
                    <div class="col-xs-2">
                        <label>Введите имя</label>
                        <input id="form-key" type="text" placeholder="key" class="form-control">
                    </div>
                    <div class="col-xs-3">
                        <label>Введите описание</label>
                        <input id="form-desc" type="text" placeholder="desc" class="form-control">
                    </div>
                    <div class="col-xs-3">
                        <label>Введите значение</label>
                        <input id="form-value" type="text" placeholder="value" class="form-control">
                    </div>
                    <div class="col-xs-1">
                        <label> &nbsp;</label>
                        <button id='create' class='btn btn-primary btn-block btn-default'>Создать</button>
                    </div>
                </div>
            </div>
</div>
<script>
    $('button#remove').click(function (e) {
        e.preventDefault();
        var element = $(this);
        ajaxAction('settings/edit/remove', {key: element.attr('key')});
    });
    $('button#create').click(function (e) {
        e.preventDefault();
        var element = $(this);
        ajaxAction('settings/edit/create', {sort: $('#form-sort').val(), key: $('#form-key').val(), type: $('#form-type').val(), desc: $('#form-desc').val(), value: $('#form-value').val()});
    });
</script>
