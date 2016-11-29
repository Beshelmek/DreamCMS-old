<style>
    .chat_text {
        position: absolute;
        bottom: 45px;
        left: 0px;
        z-index: 25;
        color: #fff;
        background-color: rgba(0,0,0,0.4);
        width: 100%;
    }
    .chat_text p{
        color: #fff;
        padding: 3px;
        margin: 0px;
    }
    .input-group {
        width: 100%;
    }
</style>

<div class="panel panel-profile profile">
    <div class="panel-heading overflow-h">
        <h2 class="panel-title heading-sm">
            Пользователь: <?=$profile?>
            <span class="user-online tt"></span>
        </h2>
    </div>
    <div class="panel-body">
        <div class="row">
            <div class="col-md-3" style="height: 100%;">
                <div class="alert" style="height: 100%;">
                    <center><img src="/skin/get/<?=$profile?>"></center>
                </div>
            </div>
            <div class="col-md-9" style="height: 100%;">
                <div class="well well-lg userinfo">
                    <ul>
                        <li>
                            <div class="info">Ваша почта:</div><?= $email ?>
                        </li>
                        <li>
                            <div class="info">У вас:</div><?= $money ?> дримов и <?= $realmoney ?> монет
                        </li>
                        <li>
                            <div class="info">Дата регистрации:</div><?= $reg_time ?>
                        </li>
                        <li>
                            <div class="info">Игрок который пригласил вас:</div><?= $byurl ?>
                        </li>
                        <?php foreach ($user_groups as $group): ?>
                            <li>
                                <div class="info">Ваш статус на сервере <?= $group['server'] ?>:</div><?= $group['group'] ?>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
        </div>

        <div class="row tab-v1">
            <ul class="nav nav-justified nav-tabs">
                <li class="active"><a aria-expanded="true" data-toggle="tab" href="#groups">Покупка групп</a></li>
                <li><a aria-expanded="false" data-toggle="tab" href="#chat">Настройки чата</a></li>
                <li><a aria-expanded="false" data-toggle="tab" href="#extra">Дополнительные возможности</a></li>
            </ul>
            <div class="tab-content">
                <div id="groups" class="profile-edit tab-pane fade active in">
                    <h2 class="heading-md">Список донат групп</h2>
                    <p>Здесь вы можете купить донат группу</p>
                    <?php foreach ($groups as $group): ?>
                        <div class="col-md-12">
                        <h3><?=$group['name']?></h3>
                        <div class="panel  panel-default ">
                            <div class="panel-body tt" data-original-title="" title="">
                                &nbsp;&nbsp; Цена:
                                <?=$group['price']?> рублей
                                /
                                30 дней
                                <div class="pull-right">
                                    <a  ajax-url="true"  href="/page/groups" class="btn btn-info btn-xs" type="button" style="padding: 1px 5px;"> Подробнее </a>
                                    =
                                    <button class="btn btn-success btn-xs" id="buy-group-btn" <?=$csrf['name'];?>="<?=$csrf['hash'];?>" group="<?=$group['name']?>" server="all" style="padding: 1px 5px;"> Купить </button>
                                </div>
                            </div>
                        </div>
                        </div>
                    <?php endforeach; ?>
                </div>
                <div id="chat" class="profile-edit tab-pane fade">
                    <h2 class="heading-md">Настройка чата</h2>
                    <p>Здесь вы можете установить цвет ника, префикса и сам префикс</p>
                    <div class="row">
                        <div class="col-md-6">
                            <form id="form-prefix" class="form-horizontal col-md-12">
                                <input type="hidden" name="<?=$csrf['name'];?>" value="<?=$csrf['hash'];?>" />
                                <div class="form-group">
                                    <label class="col-md-3 control-label">Префикс</label>
                                    <div class="col-md-9">
                                        <div class="input-group">
                                            <input onkeyup="$('#prefix').text('[' + $(this).val() + ']');" class="form-control" name="prefix" type="text" maxlength="10" value="">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-3 control-label">Цвет префикса</label>
                                    <div class="col-md-9">
                                        <div class="input-group">
                                            <select class="form-control" onchange="setColor('prefix', $(this).val());" name="pcolor">
                                                <option value="">Не выбран</option>
                                                <option value="1">Синий</option>
                                                <option value="2">Зеленый</option>
                                                <option value="3">Бирюзовый</option>
                                                <option value="5">Фиолетовый</option>
                                                <option value="6">Золотой</option>
                                                <option value="7">Серебряный</option>
                                                <option value="8">Серый</option>
                                                <option value="9">Индиго</option>
                                                <option value="a">Салатовый</option>
                                                <option value="b">Голубой</option>
                                                <option value="c">Красный</option>
                                                <option value="d">Розовый</option>
                                                <option value="e">Желтый</option>
                                                <option value="f">Белый</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-3 control-label">Цвет ника</label>
                                    <div class="col-md-9">
                                        <div class="input-group">
                                            <select class="form-control" onchange="setColor('username', $(this).val());" name="ncolor">
                                                <option value="">Не выбран</option>
                                                <option value="1">Синий</option>
                                                <option value="2">Зеленый</option>
                                                <option value="3">Бирюзовый</option>
                                                <option value="5">Фиолетовый</option>
                                                <option value="6">Золотой</option>
                                                <option value="7">Серебряный</option>
                                                <option value="8">Серый</option>
                                                <option value="9">Индиго</option>
                                                <option value="a">Салатовый</option>
                                                <option value="b">Голубой</option>
                                                <option value="c">Красный</option>
                                                <option value="d">Розовый</option>
                                                <option value="e">Желтый</option>
                                                <option value="f">Белый</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-3 control-label">Цвет сообщения</label>
                                    <div class="col-md-9">
                                        <div class="input-group">
                                            <select class="form-control" onchange="setColor('message', $(this).val());" name="mcolor">
                                                <option value="">Не выбран</option>
                                                <option value="1">Синий</option>
                                                <option value="2">Зеленый</option>
                                                <option value="3">Бирюзовый</option>
                                                <option value="5">Фиолетовый</option>
                                                <option value="6">Золотой</option>
                                                <option value="7">Серебряный</option>
                                                <option value="8">Серый</option>
                                                <option value="9">Индиго</option>
                                                <option value="a">Салатовый</option>
                                                <option value="b">Голубой</option>
                                                <option value="c">Красный</option>
                                                <option value="d">Розовый</option>
                                                <option value="e">Желтый</option>
                                                <option value="f">Белый</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-3 control-label">Сервер</label>
                                    <div class="col-md-9">
                                        <div class="input-group">
                                            <select class="form-control" name="server">
                                                <?=$server_opt?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="col-md-6">
                            <div id="slider" class="carousel slide" data-ride="carousel" data-interval="4000">
                                <div class="carousel-inner">
                                    <div class="chat_text">
                                        <p>
                                            <span id="prefix">[Deluxe]</span>
                                            <span id="username"><?=$profile?></span>:
                                            <span id="message">Всем привет :)</span>
                                        </p>
                                    </div>
                                    <div class="item">
                                        <img src="https://dreamcraft.su/img.php?url=http:/minevel.aniriax.com/assets/img/chat/1.jpg">
                                    </div>
                                    <div class="item"><img src="https://dreamcraft.su/img.php?url=http:/minevel.aniriax.com/assets/img/chat/2.jpg"></div><div class="item"> <img src="https://dreamcraft.su/img.php?url=http:/minevel.aniriax.com/assets/img/chat/3.jpg"></div><div class="item active"> <img src="https://dreamcraft.su/img.php?url=http:/minevel.aniriax.com/assets/img/chat/4.jpg"></div><div class="item"> <img src="https://dreamcraft.su/img.php?url=http:/minevel.aniriax.com/assets/img/chat/5.jpg"></div><div class="item"> <img src="https://dreamcraft.su/img.php?url=http:/minevel.aniriax.com/assets/img/chat/6.jpg"></div><div class="item"> <img src="https://dreamcraft.su/img.php?url=http:/minevel.aniriax.com/assets/img/chat/7.jpg"></div><div class="item"> <img src="https://dreamcraft.su/img.php?url=http:/minevel.aniriax.com/assets/img/chat/8.jpg"></div><div class="item"> <img src="https://dreamcraft.su/img.php?url=http:/minevel.aniriax.com/assets/img/chat/9.jpg"></div><div class="item"> <img src="https://dreamcraft.su/img.php?url=http:/minevel.aniriax.com/assets/img/chat/10.jpg"></div><div class="item"> <img src="https://dreamcraft.su/img.php?url=http:/minevel.aniriax.com/assets/img/chat/11.jpg"></div><div class="item"> <img src="https://dreamcraft.su/img.php?url=http:/minevel.aniriax.com/assets/img/chat/12.jpg"></div><div class="item"> <img src="https://dreamcraft.su/img.php?url=http:/minevel.aniriax.com/assets/img/chat/13.jpg"></div><div class="item"> <img src="https://dreamcraft.su/img.php?url=http:/minevel.aniriax.com/assets/img/chat/14.jpg"></div><div class="item"> <img src="https://dreamcraft.su/img.php?url=http:/minevel.aniriax.com/assets/img/chat/15.jpg"></div><div class="item"> <img src="https://dreamcraft.su/img.php?url=http:/minevel.aniriax.com/assets/img/chat/16.jpg"></div><div class="item"> <img src="https://dreamcraft.su/img.php?url=http:/minevel.aniriax.com/assets/img/chat/17.jpg"></div><div class="item"> <img src="https://dreamcraft.su/img.php?url=http:/minevel.aniriax.com/assets/img/chat/18.jpg"></div><div class="item"> <img src="https://dreamcraft.su/img.php?url=http:/minevel.aniriax.com/assets/img/chat/19.jpg"></div><div class="item"> <img src="https://dreamcraft.su/img.php?url=http:/minevel.aniriax.com/assets/img/chat/20.jpg"></div><div class="item"> <img src="https://dreamcraft.su/img.php?url=http:/minevel.aniriax.com/assets/img/chat/21.jpg"></div><div class="item"> <img src="https://dreamcraft.su/img.php?url=http:/minevel.aniriax.com/assets/img/chat/22.jpg"></div><div class="item"> <img src="https://dreamcraft.su/img.php?url=http:/minevel.aniriax.com/assets/img/chat/23.jpg"></div><div class="item"> <img src="https://dreamcraft.su/img.php?url=http:/minevel.aniriax.com/assets/img/chat/24.jpg"></div></div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <a class="btn-u" id="prefix-btn">Сохранить</a>
                                </div>
                                <div class="col-md-6">
                                    <span class="label label-success">Цена: 50 рублей, бесплатно для Deluxe</span>
                                </div>
                            </div>
                            <script>
                                for(var i = 2; i <= 24; i++) {
                                    var slides = "<div class=\"item\"> <img src=\"https://dreamcraft.su/img.php?url=http:/minevel.aniriax.com/assets/img/chat/" + i + ".jpg\"></div>";
                                    $("#slider .carousel-inner").append(slides);
                                }
                            </script>
                        </div>

                    </div>
                </div>
                <div id="extra" class="profile-edit tab-pane fade">
                    <h2 class="heading-md">Обмен валюты</h2>
                    <p>Здесь вы можете обменять донат валюту на игровую.&nbsp;
                        <span class="text-info">Курс обмена 1 к 100</span>
                    </p>

                    <form class="form-horizontal" id="form-exchange">
                        <input type="hidden" name="<?=$csrf['name'];?>" value="<?=$csrf['hash'];?>" />
                        <div class="row">
                            <div class="col-md-8">
                                <div class="col-md-5">
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-ruble"></i></span>
                                        <input class="form-control tt" title="" data-placement="bottom" type="text" name="count" id="money" value="1" data-original-title="Донат валюта">
                                    </div>
                                </div>
                                <div class="pull-left" style="margin-top:5px;"><i class="fa fa-arrow-right fa-lg"></i></div>
                                <div class="col-md-5">
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-diamond"></i></span>
                                        <input class="form-control tt" title="" data-placement="bottom" type="text" name="monets" id="monets" value="100" data-original-title="Монеты" readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <a class="btn btn-u" type="submit" id="exchange-btn">Обменять</a>
                            </div>
                        </div>
                    </form>
                    </br>
                    </br>
                    <h2 class="heading-md">Разбан</h2>
                    <p>Здесь вы можете приобрести разбан, если были заблокированы</p>
                    <div class="col-md-12">
                        <table class="table table-striped">
                            <thead>
                            <tr>
                                <th>Сервер</th>
                                <th>Статус</th>
                                <th>Причина</th>
                                <th>Действия</th>
                            </tr>
                            </thead>
                            <tbody>
                            <!-- Тут будут баны игрока! -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function setColor(item, val){
        item = $('#' + item);
        var s = "1px 1px 0 ";
        switch(val) {
            case "0": item.css({
                "color": "#000000",
                "text-shadow": s + "#000000"
            });
                break;
            case "1": item.css({
                "color": "#0000AA",
                "text-shadow": s + "#00002A"
            });
                break;
            case "2": item.css({
                "color": "#00AA00",
                "text-shadow": s + "#002A00"
            });
                break;
            case "3": item.css({
                "color": "#00AAAA",
                "text-shadow": s + "#002A2A"
            });
                break;
            case "4": item.css({
                "color": "#AA0000",
                "text-shadow": s + "#2A0000"
            });
                break;
            case "5": item.css({
                "color": "#AA00AA",
                "text-shadow": s + "#2A002A"
            });
                break;
            case "6": item.css({
                "color": "#FFAA00",
                "text-shadow": s + "#2A2A00"
            });
                break;
            case "7": item.css({
                "color": "#AAAAAA",
                "text-shadow": s + "#2A2A2A"
            });
                break;
            case "8": item.css({
                "color": "#555555",
                "text-shadow": s + "#151515"
            });
                break;
            case "9": item.css({
                "color": "#5555FF",
                "text-shadow": s + "#15153F"
            });
                break;
            case "a": item.css({
                "color": "#55FF55",
                "text-shadow": s + "#153F15"
            });
                break;
            case "b": item.css({
                "color": "#55FFFF",
                "text-shadow": s + "#153F3F"
            });
                break;
            case "c": item.css({
                "color": "#FF5555",
                "text-shadow": s + "#3F1515"
            });
                break;
            case "d": item.css({
                "color": "#FF55FF",
                "text-shadow": s + "#3F153F"
            });
                break;
            case "e": item.css({
                "color": "#FFFF55",
                "text-shadow": s + "#3F3F15"
            });
                break;
            case "f": item.css({
                "color": "#FFFFFF",
                "text-shadow": s + "#3F3F3F"
            });
                break;
            default: item.css({
                "color": "#FFF",
                "text-shadow": s + "#3F3F3F"
            });
        }
    }
    $(function(){
    });


    $("#money").keyup(function() {
        var n = parseInt($(this).val());
        if(isNaN(n)) {
            $("#monets").val("Ошибка");
        } else {
            $("#monets").val(n.toFixed() * 100);
        }

    });
</script>