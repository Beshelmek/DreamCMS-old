<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title">Основные настройки</h3>
    </div>
    <form role="form" id="settings-form" method="post">
        <?=$fcsrf?>
        <div class="box-body">
        <?php
        foreach ($config as $key=>$var){
            $type = $var['type'];
            $value = $var['value'];
            $desc = $var['desc'];
            switch ($var['type']):
                case "string":
                    echo "<label for='$key'>$desc</label>
                          <input class='form-control' id='$key' name='$key' type='text' placeholder='$value' value='$value'>";
                    break;
                case "text":
                    echo "<label for='$key'>$desc</label>
                          <textarea class='form-control' id='$key' name='$key' placeholder='$value'>$value</textarea>";
                    break;
                case "header":
                    echo "<hr>
                          <h3>$value</h3>
                          <h6>$desc</h6>";
                    break;
                case "int":
                    echo "<label for='$key'>$desc</label>
                          <input class='form-control' id='$key' name='$key' type='number' placeholder='$value' value='$value'>";
                    break;
                case "boolean":
                    $checked = '';
                    if($value) $checked = 'checked';
                    echo "<div class='checkbox'>
                            <label>
                              <input name='$key' type='checkbox' {$checked}>
                              $desc
                            </label>
                          </div>";
                    break;
                case "option":
                    echo "<label>$desc</label>";
                    foreach ($value as $option){
                        $checked = '';
                        if($option['checked']) $checked = 'checked';
                        $name = $option['name'];
                        $text = $option['text'];
                        echo "<div class='radio'>
                            <label>
                              <input type='radio' name='$key' id='$key' value='$name' $checked>
                              $text
                            </label>
                          </div>";
                    }
                    break;
                case "array":
                    echo "<label for='$key'>$desc</label>
                          <select multiple class='form-control' id='$key' name='{$key}[]'>";
                    foreach($value as $option){
                        echo "<option value='$option'>$option</option>";
                    }
                    echo "</select>";
                    echo "<div class='input-group input-group-sm'>
                           <input type='text' id='input-add-{$key}' class='form-control'>
                             <span class='input-group-btn'>
                               <button id='button-add-{$key}' class='btn btn-info btn-flat'>Добавить значение</button>
                             </span>
                          </div>";
                    echo "<script>
                    $('#button-add-{$key}').click(function(e) {
                        e.preventDefault();
                        $('select#{$key}').append($('<option>', {
                             value:  $('#input-add-{$key}').val(),
                             text: $('#input-add-{$key}').val()
                        }));
                    });
                    
                    </script>";
                    break;

            endswitch;
        }
        ?>
        <div class="box-footer">
            <button id="sumbit-btn" class="btn btn-primary">Сохранить</button>
        </div>
    </form>
</div>
<script>
$('html').keyup(function(e){
    if(e.keyCode == 46 || e.keyCode == 8) {
        e.preventDefault();
        $('select option:selected').remove();
    }
});
$('#sumbit-btn').click(function (e) {
    e.preventDefault();
    $('select option').prop('selected', true);
    ajaxAction('settings/save', $('#settings-form').serialize());
});
</script>
