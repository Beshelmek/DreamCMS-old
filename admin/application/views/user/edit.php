<div class="row">
    <div class="col-md-3">
        <div class="box box-primary">
            <div class="box-body box-profile">
                <img class="profile-user-img img-responsive"
                     src="https://dreamcraft.su/skin/head/<?= $info['login'] ?>">

                <h3 class="profile-username text-center"><?= $info['login'] ?></h3>

                <p class="text-muted text-center">Игрок</p>

                <ul class="list-group list-group-unbordered">
                    <li class="list-group-item">
                        <b>Аккаунт VK</b> <a href="https://vk.com/id<?= $info['vk_uid'] ?>" class="pull-right">https://vk.com/id<?= $info['vk_uid'] ?></a>
                    </li>
                    <li class="list-group-item">
                        <b>UUID</b> <a class="pull-right"><?= $info['uuid'] ?></a>
                    </li>
                    <li class="list-group-item">
                        <b>IP регистрации</b> <a class="pull-right"><?= $info['reg_ip'] ?></a>
                    </li>
                    <li class="list-group-item">
                        <b>Дата регистрации</b> <a class="pull-right"><?= date("d.m.Y H:i:s", $info['reg_time']) ?></a>
                    </li>
                    <li class="list-group-item">
                        <b>Кол-во голосов за все время</b> <a class="pull-right"><?=$info['golos']?></a>
                    </li>
                    <li class="list-group-item">
                        <b>Подтвержденный (реф. система)</b> <a class="pull-right"><?=$info['verified']?></a>
                    </li>
                </ul>

                <a class="btn btn-danger btn-block" onclick="ajaxAction('/user/block', {uuid: '<?= $info['uuid'] ?>'})"><b>Закрыть все доступы</b></a>
            </div>
            <!-- /.box-body -->
        </div>
        <!-- /.box -->

        <!-- About Me Box -->
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Действия</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <ul class="list-group list-group-unbordered">
                    <h4>Выдача кейсов</h4>
                    <li class="list-group-item">
                        <div class="row" style="margin: 0;">
                            <input type="number" value="9000" class="col-md-3" id="case-id" style="min-height: 30px;margin-right: 15px;">
                            <input type="number" value="1" class="col-md-3" id="case-count" style="min-height: 30px;margin-right: 15px;">
                            <a onclick="ajaxAction('/user/cases', {id: $('#case-id').val(), count: $('#case-count').val(), uuid: '<?=$info['uuid']?>'})" class="btn btn-sm btn-primary col-md-4"><b>Выдать кейсы</b></a>
                        </div>
                    </li>
                    <h4>Выдача предметов</h4>
                    <li class="list-group-item">
                        <div class="row" style="margin: 0; margin-bottom: 10px;">
                            <input type="text" value="BEDROCK" class="col-md-8" id="item-name" style="min-height: 30px;margin-right: 15px;">
                            <input type="number" value="1" class="col-md-3" id="item-count" style="min-height: 30px;margin-right: 15px;">
                        </div>
                        <div class="row" style="margin: 0;">
                            <a style="width: 100%" onclick="ajaxAction('/user/giveitem', {id: $('#item-name').val(), count: $('#item-count').val(), uuid: '<?=$info['uuid']?>'})" class="btn btn-sm btn-primary"><b>Выдать предмет</b></a>
                        </div>
                    </li>
                    <h4>Выдача привилегий</h4>
                    <li class="list-group-item">
                        <div class="row" style="margin: 0; margin-bottom: 10px;">
                            <input type="text" placeholder="VIP\Premium\Deluxe\Ultima" class="col-md-8" id="group-name" style="min-height: 30px;margin-right: 15px;">
                            <input type="number" value="30" class="col-md-3" id="group-count" style="min-height: 30px;margin-right: 15px;">
                        </div>
                        <div class="row" style="margin: 0;">
                            Если группу нужно выдать навсегда, ставьте 0 дней.<br>
                            Если нужно забрать все привилегии, ставьте -1 дней.<br>
                            <br>
                        <a style="width: 100%" onclick="ajaxAction('/user/givegroup', {id: $('#group-name').val(), count: $('#group-count').val(), uuid: '<?=$info['uuid']?>'})" class="btn btn-sm btn-primary"><b>Выдать группу</b></a>
                        </div>

                    </li>
                    <li class="list-group-item">
                        <div class="row" style="margin: 0;">
                            <a style="width: 100%" onclick="ajaxAction('/user/gadisable', {uuid: '<?=$info['uuid']?>'})" class="btn btn-sm btn-primary"><b>Отключить двухэтап. авторизацию</b></a>
                        </div>
                    </li>
                    <li class="list-group-item">
                        <div class="row" style="margin: 0;">
                            <a style="width: 100%" onclick="ajaxAction('/user/verify', {uuid: '<?=$info['uuid']?>'})" class="btn btn-sm btn-primary"><b>Подтвердить игрока (реф. система)</b></a>
                        </div>
                    </li>
                    <li class="list-group-item">
                        <div class="row" style="margin: 0;">
                            <a style="width: 100%" onclick="ajaxAction('/user/clearkits', {uuid: '<?=$info['uuid']?>'})" class="btn btn-sm btn-danger"><b>Сбросить время всех китов</b></a>
                        </div>
                    </li>
                </ul>
            </div>
            <!-- /.box-body -->
        </div>

        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Серверная информация</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <ul class="list-group list-group-unbordered">
                    <?php foreach ($servers as $server): ?>
                        <li class="list-group-item">
                            <a href="<?= site_url('user/server') ?>/<?= $server ?>/<?= $info['login'] ?>"
                               class="btn btn-primary btn-block"><b><?= $server ?></b></a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
            <!-- /.box-body -->
        </div>
        <!-- /.box -->
    </div>
    <!-- /.col -->
    <div class="col-md-9">
        <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
                <li class="active"><a href="#settings" data-toggle="tab" aria-expanded="true">Редактирование</a></li>
                <li class=""><a href="#timeline" data-toggle="tab" aria-expanded="false">Действия</a></li>
            </ul>
            <div class="tab-content">
                <div class="tab-pane active" id="settings">
                    <form class="form-horizontal" method="post" action="<?=site_url('/user/save')?>">
                        <?=$fcsrf?>
                        <div class="form-group">
                            <label for="inputName" class="col-sm-2 control-label">Почта</label>

                            <div class="col-sm-10">
                                <input type="email" class="form-control" name="email" id="inputName"
                                       placeholder="<?= $info['email'] ?>" value="<?= $info['email'] ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputName" class="col-sm-2 control-label">Пароль</label>

                            <div class="col-sm-10">
                                <input type="email" class="form-control" name="password" id="inputName"
                                       placeholder="<?= $info['password'] ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputEmail" class="col-sm-2 control-label">Монеты</label>

                            <div class="col-sm-10">
                                <input name="money" type="number" class="form-control" id="inputEmail"
                                       placeholder="<?= $info['money'] ?>" value="<?= $info['money'] ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputName" class="col-sm-2 control-label">Реальные деньги</label>

                            <div class="col-sm-10">
                                <input name="realmoney" type="number" class="form-control" id="inputName"
                                       placeholder="<?= $info['realmoney'] ?>" value="<?= $info['realmoney'] ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputName" class="col-sm-2 control-label">Имя</label>

                            <div class="col-sm-10">
                                <input name="name" type="text" class="form-control" id="inputName"
                                       placeholder="<?= $info['name'] ?>" value="<?= $info['name'] ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-10">
                                <button type="submit" class="btn btn-danger">Сохранить</button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="tab-pane" id="timeline">
                    <!-- The timeline -->
                    <ul class="timeline timeline-inverse">
                        <?php foreach ($logs as $time => $actions): ?>
                            <li class="time-label">
                                <span class="bg-red">
                                  <?= $time ?>
                                </span>
                            </li>
                            <?php foreach ($actions as $action): ?>
                                <li>
                                    <i class="fa <?= $action['icon'] ?>"></i>

                                    <div class="timeline-item">
                                        <span class="time"><i class="fa fa-clock-o"></i> <?= $action['time'] ?></span>

                                        <h3 class="timeline-header"><?= $action['title'] ?></h3>

                                        <div class="timeline-body">
                                            <?= $action['body'] ?>
                                        </div>
                                        <div class="timeline-footer">
                                            <?= $action['footer'] ?>
                                        </div>
                                    </div>
                                </li>
                            <?php endforeach; ?>
                        <?php endforeach; ?>
                        <li>
                            <i class="fa fa-clock-o bg-gray"></i>
                        </li>
                    </ul>
                </div>
                <!-- /.tab-pane -->
            </div>
            <!-- /.tab-content -->
        </div>
        <!-- /.nav-tabs-custom -->
    </div>
    <!-- /.col -->
</div>