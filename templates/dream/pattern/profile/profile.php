<style>
    .chat_text {
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

<div class="row center-on-small-only">
    <div class="col-lg-12 col-md-12">
        <div class="col-md-2">
            <div class="avatar">
                <img src="/skin/get/<?=$userinfo['uuid']?>">
            </div>
        </div>

        <div class="col-md-10">
            <h4><?=$userinfo['login']?></h4>
            <h5><?=$profile['maxgroup']?></h5>
            <table class="table table-sm">
                <tbody>
                <tr>
                    <td>EMail:</td>
                    <td><?=$userinfo['email']?></td>
                </tr>
                <tr>
                    <td>У вас:</td>
                    <td><?=$userinfo['realmoney']?> руб. и <?=$userinfo['money']?> монет</td>
                </tr>
                <? if (isset($profile['inviter'])):?>
                    <tr>
                        <td>Вас пригласил:</td>
                        <td><?=$profile['inviter']?></td>
                    </tr>
                <? endif;?>
                <tr>
                    <td>Дата регистрации:</td>
                    <td><?=$profile['reg_time']?></td>
                </tr>
                <tr>
                    <td>Последняя активность:</td>
                    <td><?=$profile['last_time']?></td>
                </tr>

                </tbody>
            </table>

            <? if (count($profile['usergroups']) > 0):?>
                <table class="table">
                    <thead>
                    <tr>
                        <th>Сервер</th>
                        <th>Привилегия</th>
                        <th>Дата окончания</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($profile['usergroups'] as $group): ?>
                        <tr class="table-warning">
                            <td><?=$group['server']?></td>
                            <td><?=$group['group']?></td>
                            <td><?=date('d-m-Y', $group['expire'])?></td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            <? endif;?>
        </div>
    </div>
</div>

<hr>

<ul class="nav nav-tabs tabs-3 primary-color" role="tablist">
    <li class="nav-item">
        <a class="nav-link active" data-toggle="tab" href="#panel1" role="tab">Покупка групп</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" data-toggle="tab" href="#panel2" role="tab">Настройки чата</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" data-toggle="tab" href="#panel3" role="tab">Доп. возможности</a>
    </li>
</ul>

<!-- Tab panels -->
<div class="tab-content card">

    <div class="tab-pane fade in active" id="panel1" role="tabpanel">
        <h2 class="heading-md">Список донат групп</h2>
        <p>Здесь вы можете купить донат группу</p>
        <hr>
        <? if ($dbconfig->global_donate):?>
            <div class="row">
                <?php foreach ($profile['groups'] as $group): ?>
                    <div class="col-lg-3 col-md-12">
                        <div class="card pricing-card">
                            <div class="price header blue">
                                <h1><?=$group['price']?></h1>
                                <div class="version">
                                    <h5><?=$group['name']?></h5>
                                </div>
                            </div>
                            <div class="card-block striped">
                                <button onclick="ajaxAction('/profile/buygroup', {group: '<?=$group['name']?>', server: 'all'})" class="btn btn-primary waves-effect waves-light">Купить</button>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

        <? else:?>
        <?php foreach ($profile['servers'] as $server): ?>
                <div class="row">
                    <h3 style="margin-left: 1rem;"><?=$server['name']?></h3>
                    <?php foreach ($profile['groups'] as $group): ?>
                        <div class="col-lg-3 col-md-12">
                            <div class="card pricing-card">
                                <div class="price header blue">
                                    <h1><?=$group['price']?></h1>
                                    <div class="version">
                                        <h5><?=$group['name']?></h5>
                                    </div>
                                </div>
                                <div class="card-block striped">
                                    <button onclick="ajaxAction('/profile/buygroup', {group: '<?=$group['name']?>', server: '<?=$server['name']?>'})" class="btn btn-primary waves-effect waves-light">Купить</button>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
                <hr>
            <?php endforeach; ?>
        <? endif;?>

    </div>

    <div class="tab-pane fade" id="panel2" role="tabpanel">
        <h2 class="heading-md">Настройки чата</h2>
        <p>Здесь вы можете сменить префикс и цвет ника</p>
        <br>
        <div class="row">
            <div class="col-md-6">
                <form id="form-prefix" class="md-form col-md-12">
                    <?=$fcsrf?>
                    <br>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="md-form">
                                <i class="fa fa-pencil prefix"></i>
                                <input id="prefix" type="text" name="prefix" maxlength="10" value="" onkeyup="$('#prefix-text').text('[' + $(this).val() + ']');">
                                <label for="prefix">Префикс</label>
                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-md-12">
                            <select class="mdb-select" onchange="setColor('prefix-text', $(this).val());" name="pcolor">
                                <?=$color_opt?>
                            </select>
                            <label>Цвет префикса</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <select class="mdb-select" onchange="setColor('username-text', $(this).val());" name="ncolor">
                                <?=$color_opt?>
                            </select>
                            <label>Цвет ника</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <select class="mdb-select" onchange="setColor('message-text', $(this).val());" name="mcolor">
                                <?=$color_opt?>
                            </select>
                            <label>Цвет сообщения</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <select class="mdb-select" name="server">
                                <?=$server_opt?>
                            </select>
                            <label>Сервер</label>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <a onclick="ajaxAction('/profile/prefix', $('#form-prefix').serializeArray())" class="btn btn-primary" data-toggle="tooltip" data-placement="top" title="Цена: 50 руб. Бесплатно для Deluxe и выше.">
                                Сохранить
                            </a>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-md-6">
                <hr>
                <div class="row">
                    <div class="chat_text">
                        <p>
                            <span id="prefix-text">[Deluxe]</span>
                            <span id="username-text"><?=$userinfo['login']?></span>:
                            <span id="message-text">Всем привет :)</span>
                        </p>
                    </div>
                </div>
                <hr>
            </div>
        </div>
    </div>

    <div class="tab-pane fade" id="panel3" role="tabpanel">
        <h2 class="heading-md">Обмен валюты</h2>
        <p>Здесь вы можете обменять донат валюту на игровую.</p>
        <br>
        <form class="form-horizontal" id="form-exchange">
            <?=$fcsrf?>
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
                    <a class="btn btn-primary" type="submit" onclick="ajaxAction('/profile/exchange', $('#form-exchange').serializeArray())">Обменять</a>
                </div>
            </div>
        </form>
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

    $("#money").keyup(function() {
        var n = parseInt($(this).val());
        if(isNaN(n)) {
            $("#monets").val("Ошибка");
        } else {
            $("#monets").val(n.toFixed() * 100);
        }

    });
</script>