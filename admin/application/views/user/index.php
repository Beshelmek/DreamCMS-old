<div class="box box-warning">
    <div class="box-header with-border">
        <h3 class="box-title">Поиск игрока</h3>
    </div>
    <!-- /.box-header -->
    <div class="box-body">
            <div class="form-group">
                <label>Логин</label>
                <input type="text" class="form-control" id="login" placeholder="Введите логин игрока" >
            </div>
            <button id="submit" class="btn btn-primary">Отправить</button>
    </div>
</div>
<script>
    $('#submit').click(function(){
        window.location.href = '<?=site_url('user')?>' + '/edit/' + $('#login').val();
    });
</script>