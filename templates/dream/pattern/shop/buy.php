<div class="modal-body">
    <center>
        <div class="card card-cascade narrower">
            <div class="view overlay hm-white-slight" style="background-color: white;margin-top: -20px;width: 100px;">
                <img src="<?=$item['image']?>" class="img-fluid" alt="">
                <a>
                    <div class="mask waves-effect waves-light"></div>
                </a>
            </div>
            <div class="card-block text-xs-center">
                <h4 class="card-title"><strong><a><?=$item['dname']?></a></strong></h4>

                <p class="card-text">Что бы получить предмет в игре, введите команду /cart gui<br>или /cart all что бы получить все покупки.</p>

                <div class="card-footer">
                    <span class="left"><?=$item['price']?> руб/шт.<br><?=$item['dprice']?> монет/шт.</span>
                    <span class="right">
                        <select class="mdb-select" id="block-from">
                            <option value="0" selected disabled>Выберите кошелек</option>
                            <option value="1">Рубли</option>
                            <option value="2">Монеты</option>
                        </select>
                    </span>
                </div>
                <hr>
                <div class="row">
                    <h4>Выберите кол-во:</h4>
                    <form class="range-field">
                        <input type="range" id="block-count" min="1" max="64" value="1"/>
                    </form>
                </div>
            </div>
        </div>
    </center>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
    <button type="button" class="btn btn-primary" onclick="ajaxAction('/shop/buy', {id: '<?=$item['id']?>', from: $('#block-from').val(), shop: '<?=$item['shop']?>', count: $('#block-count').val()})">Купить</button>
</div>
<script>
    $('.mdb-select').material_select();
</script>