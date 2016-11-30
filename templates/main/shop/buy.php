<div class="panel panel-profile profile">
    <div class="panel-heading overflow-h">
        <h2 class="panel-title heading-sm">Покупка предмета: <?=$item['dname']?></h2>
    </div>
    <div class="panel-body tab-v1">
            <div class="item-full">
                <div class="lead"><a ajax-url="true" href="/shop" class="btn-u">Назад</a></div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-lg-3 col-md-3 col-sm-4 text-center">
                                <img class="img-bordered" src="<?=$item['image']?>" alt="<?=$item['dname']?>">
                            </div>
                            <div class="col-lg-9 col-md-9 col-sm-8">
                                <div class="well well-lg userinfo">
                                    <form id="form-buy-item">
                                        <input type="hidden" name="<?=$csrf['name'];?>" value="<?=$csrf['hash'];?>" />
                                        <input type="hidden" name="id" value="<?=$item['id']?>" />
                                        <ul>
                                            <li>
                                                <div class="info">Название</div>
                                                <?=$item['sname']?>
                                            </li>
                                            <li>
                                                <div class="info">Количество</div>
                                                <input type="number" max="64" min="1" value="1" name="count">
                                            </li>
                                            <li>
                                                <a id="buy-item-btn" class="btn-u">Приобрести</a>
                                                <select name="from">
                                                    <option name="1" value="1">за рубли</option>
                                                    <option name="2" value="2">за дримы</option>
                                                </select>
                                            </li>
                                        </ul>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </div>
</div>