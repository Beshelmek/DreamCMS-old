<style>
    .item-block {
        width: 140px;
        height: 240px;
        text-align: center;
        border: 1px solid #DDDDDD;
        padding: 10px;
        float: left;
        margin-right: 2.83%;
        margin-bottom: 15px;
    }
</style>
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
        <?php if ($discount == true): ?>
            <?php foreach($items as $item): ?>
                <div class="item-block">
                    <span class="item-category" hidden style="visibility: hidden; display: none;"><?=$item['category']?></span>
                    <div class="row"><span class="item-name"><?=$item['sname']?></span></div>
                    <div class="row"><img src="<?=$item['image']?>" width="100px" height="100px"></div>
                    <div class="row"><span style="color: red; text-decoration: line-through;"><?=$item['oldprice']?></span> <span><?=$item['price']?> руб\шт</span></div>
                    <div class="row"><span style="color: red; text-decoration: line-through;"><?=$item['olddprice']?></span> <span><?=$item['dprice']?> дрим\шт</span></div>
                    <div class="row"><a  ajax-url="true" href="/shop/<?=$shop?>/<?=$item['id']?>" class="btn-u">Купить</a></div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <?php foreach($items as $item): ?>
                <div class="item-block">
                    <span class="item-category" hidden style="visibility: hidden; display: none;"><?=$item['category']?></span>
                    <div class="row"><span class="item-name"><?=$item['sname']?></span></div>
                    <div class="row"><img src="<?=$item['image']?>" width="100px" height="100px"></div>
                    <div class="row"><span><?=$item['price']?> руб.\шт</span></div>
                    <div class="row"><span><?=$item['dprice']?> дрим.\шт</span></div>
                    <div class="row"><a  ajax-url="true" href="/shop/<?=$shop?>/<?=$item['id']?>" class="btn-u">Купить</a></div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>

    </div>
</div>
<script>
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
    })
</script>