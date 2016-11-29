<div class="box">
    <div class="box-header">
        <h3 class="box-title">Список предметов</h3>&nbsp&nbsp&nbsp
    </div>

    <div class="box-body no-padding">
        <table class="table table-striped">
            <tbody>
            <tr>
                <th style="width: 10px">#</th>
                <th>Название</th>
                <th>TypeID</th>
                <th>Metadata</th>
                <th style="width: 20%">Крат. имя</th>
                <th>Рубли</th>
                <th>Дримы</th>
            </tr>
            <?php foreach($items as $item): ?>
                <tr>
                    <td><?=$item['id']?></td>
                    <td><?=$item['dname']?></td>
                    <td><?=$item['type']?></td>
                    <td><?=$item['damage']?></td>
                    <td><input style="width: 100%" type="text" mytype="sname" item-id="<?=$item['id']?>" class="editor" value="<?=$item['sname']?>" placeholder="<?=$item['sname']?>"></td>
                    <td><input style="width: 100%" type="number" mytype="price" item-id="<?=$item['id']?>" class="editor" value="<?=$item['price']?>" placeholder="<?=$item['price']?>"></td>
                    <td><input style="width: 100%" type="number" mytype="dprice" item-id="<?=$item['id']?>" class="editor" value="<?=$item['dprice']?>" placeholder="<?=$item['price']?>"></td>
                    <td><select size="1" item-id="<?=$item['id']?>" mytype="category" class="editor">
                            <option selected value="<?=$item['category']?>"><?=$item['category']?></option>
                            <option value="ic2">IC2</option>
                            <option value="buildcraft">BuildCraft</option>
                            <option value="forestry">Forestry</option>
                            <option value="classic">Classic</option>
                        </select>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <!-- /.box-body -->
</div>

<script>
    $(".editor").change(function(){
        var id = $(this).attr('item-id');
        var type = $(this).attr('mytype');
        var value = $(this).val();
        $.ajax({
            type: "POST",
            url: "/admin/index.php?/shop/edit_item",
            data: {id: id, type: type, value: value},
            success: function(data){
                console.log(data['msg']);
                if(data['type'] == 'success'){
                    alertify.success(data['msg']);
                }else{
                    alertify.error(data['msg']);
                }
            },
            dataType: "json"
        });
    });
</script>