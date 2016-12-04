<style>
    .item-block {
        width: 160px;
        height: 240px;
        text-align: center;
        border: 1px solid #DDDDDD;
        padding: 10px;
        float: left;
        margin-right: 2.83%;
        margin-bottom: 15px;
    }
</style>

<div class="modal fade" id="block-modal" tabindex="-1" role="dialog" aria-labelledby="block-label" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="block-label">Покупка блока</h4>
            </div>
            <div id="block-ajax">
                <div class="modal-body">
                    <center>
                        <div class="preloader-wrapper big active">
                            <div class="spinner-layer spinner-blue-only">
                                <div class="circle-clipper left">
                                    <div class="circle"></div>
                                </div><div class="gap-patch">
                                    <div class="circle"></div>
                                </div><div class="circle-clipper right">
                                    <div class="circle"></div>
                                </div>
                            </div>
                        </div>
                    </center>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="panel panel-profile profile">
    <div class="panel-heading overflow-h">
        <div class="row">
            <h2 class="panel-title heading-sm" style="float: left; max-width: 30%; margin-left: 15px;"><?=$stitle?></h2>
            <input style="    width: 50%;
    padding-left: 10px;
    margin-left: 20px;" type="text" id="shop-search" placeholder="Поиск по товарам (введите от 3 символов и ввод)">
            <select style="width: 20%;" size="1" mytype="category" class="editor">
                <option value="all" selected>Все предметы</option>
                <option value="classic">Classic</option>
                <option value="ic2">IC2</option>
                <option value="buildcraft">BuildCraft</option>
                <option value="forestry">Forestry</option>
                <option value="thaumcraft">Thaumcraft</option>
                <option value="divinerpg">DivineRPG</option>
            </select>
        </div>
    </div>
    <div class="panel-body tab-v1">

            <?php foreach($items as $item): ?>
                <div class="item-block">
                    <span class="item-category" hidden style="visibility: hidden; display: none;"><?=$item['category']?></span>
                    <div class="row"><span class="item-name"><?=$item['sname']?></span></div>
                    <div class="row"><img class="lazy" data-original="<?=$item['image']?>" width="100px" height="100px"></div>
                <?php if ($discount == true || $item['discount'] == true): ?>
                    <div class="row"><span style="color: red; text-decoration: line-through;"><?=$item['oldprice']?></span> <span><?=$item['price']?> руб\шт</span></div>
                    <div class="row"><span style="color: red; text-decoration: line-through;"><?=$item['olddprice']?></span> <span><?=$item['dprice']?> дрим\шт</span></div>
                <?php else: ?>
                    <div class="row"><span><?=$item['price']?> руб.\шт</span></div>
                    <div class="row"><span><?=$item['dprice']?> дрим.\шт</span></div>
                <?php endif; ?>
                    <div class="row"><a block-id="<?=$item['id']?>" block-shop="<?=$shop?>" data-toggle="modal" data-target="#block-modal" class="btn btn-primary">Купить</a></div>
                </div>
            <?php endforeach; ?>
    </div>
</div>
<script>
    $('#block-modal').on('show.bs.modal', function (e) {
        var btn = e.relatedTarget;
        var id = $(btn).attr('block-id');
        var shop = $(btn).attr('block-shop');

        setTimeout(function () {
            $.post("/shop/" + shop + "/" + id, function( data ) {
                $("#block-ajax").html(data);
            });
        }, 1000);
    });

    $('#block-modal').on('hide.bs.modal', function (e) {
        $("#block-ajax").html('<div class="modal-body"> <center> <div class="preloader-wrapper big active"> <div class="spinner-layer spinner-blue-only"> <div class="circle-clipper left"> <div class="circle"></div> </div><div class="gap-patch"> <div class="circle"></div> </div><div class="circle-clipper right"><div class="circle"></div> </div> </div> </div> </center> </div> <div class="modal-footer"> <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button> </div>');
    });



    $("#shop-search").change(function(){
        var find = $(this).val();
        $(".item-block").hide();
        $(".item-name").each(function(i) {
            var text = $(this).text();
            if(text.toLowerCase().includes(find.toLowerCase())){
                $(this).parent().parent().show();
            }
        });
    });

    $(".editor").change(function(){
        var find = $(this).val();
        if(find == 'all') {
            $(".item-block").show();
        }else{
            $(".item-block").hide();
            $(".item-category").each(function(i) {
                var text = $(this).text();
                if(text.toLowerCase().includes(find.toLowerCase())){
                    $(this).parent().show();
                }
            });
        }
    });

    $("img.lazy").lazyload({
        effect : "fadeIn",
        threshold : 300
    });
</script>