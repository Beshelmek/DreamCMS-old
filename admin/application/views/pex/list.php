<div class="box box-info">
    <div class="box-header with-border">
        <h3 class="box-title">Список прав</h3>

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
                    <th>Имя</th>
                    <th>Право</th>
                    <th>Действия</th>
                </tr>
                </thead>
                <tbody id="pex-list">
                <?php foreach($pexlist as $value): ?>
                    <tr>
                        <td><?=$value['name']?></td>
                        <td><?=$value['permission']?></td>
                        <td><div class="btn-group">
                                <a class="btn btn-default pex-delete" id="<?=$value['id']?>" server="<?=$server?>"><i class="fa fa-trash"></i></a>
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
        <input type="text" id="add-group" placeholder="Группа" size="36" server="<?=$server?>">
        <input type="text" id="add-pex" placeholder="Право" size="120">
        <a class="btn btn-sm btn-info btn-flat" id="add-btn">Добавить PEX</a>
    </div>
    <!-- /.box-footer -->
</div>
<script>
    $('body').on('click', '.btn.btn-default.pex-delete', function(event) {
        var btn = this;
        $.ajax({
            type: "POST",
            url: "/admin/index.php?/permissions/remove",
            data: {id: $(btn).attr('id'), server: $(btn).attr('server')},
            success: function(data){
                console.log(data['msg']);
                if(data['type'] == 'success'){
                    alertify.success(data['msg']);
                    $(btn).parent("div.btn-group").parent("td").parent("tr").fadeOut("slow");
                }else{
                    alertify.error(data['msg']);
                }
            },
            dataType: "json"
        });
    });

    $('a#add-btn').on('click', function(event)
    {
        event.preventDefault();
        $.ajax({
            type: "POST",
            url: "/admin/index.php?/permissions/add",
            data: {server: $('#add-group').attr('server'), group: $('#add-group').val(), perm: $('#add-pex').val()},
            success: function(data){
                console.log(data['msg']);
                if(data['type'] == 'success'){
                    alertify.success(data['msg']);
                    $('#pex-list').append('<tr><td>' + $('#add-group').val() + '</td> <td>' + $('#add-pex').val() + '</td> <td><div class="btn-group"> <a class="btn btn-default pex-delete" id="' + data['id'] +  '" server="<?=$server?>"><i class="fa fa-trash"></i></a></div></td></tr>');
                }else{
                    alertify.error(data['msg']);
                }
            },
            dataType: "json"
        });
    });

</script>