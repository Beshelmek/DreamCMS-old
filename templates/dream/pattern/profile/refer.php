<div class="panel panel-profile profile">
    <div class="panel-heading overflow-h">
        <h2 class="panel-title heading-sm">
            Реферальная система
        </h2>
    </div>
    <div class="panel-body">
        <div class="well well-lg userinfo">Добро пожаловать в реферальную систему! Реферальная система позволяет Вам получать бонусы за каждого приглашенного игрока. Для этого, отправьте игроку которого вы хотите пригласить ссылку которую вы видите ниже, и если игрок перейдет по ней и зарегистрируется в течении суток, вы увидите его в таблице. Так же, за каждый голос игрока за проект, вы будете получать +10% от его голоса. А если же этот игрок захочет пополнить свой счет, вы получите +15% от его доната! Так же, после того как игрок проведет онлайн в игре более 3-ех суток, вы автоматически получите 5000 дримов!</div>
        <hr>
        <h3>Ваша реферальная ссылка:</h3>
        <input type="text" value="https://dreamcraft.su/s?p=<?=$userinfo['login']?>" class="input-lg" style="width: 100%" onclick="this.select();" readonly></br>
        </br>
        <h3>Список приглашенных игроков:</h3>
        <div class="col-md-12">
            <table class="table table-striped">
                <thead>
                <tr>
                    <th>Ник</th>
                    <th>Дата регистрации</th>
                    <th>Голосов</th>
                    <th>Подтвержден</th>
                </tr>
                </thead>
                <tbody>
                <?php if ($players): ?>
                    <?foreach($players as $player):?>
                        <th><?=$player['login']?></th>
                        <th><?=date('d-m-Y H:i', $player['reg_time'])?></th>
                        <th><?=$player['golos']?></th>
                        <?php if ($player['verified'] == 1): ?>
                            <th style="color: green;">Да</th>
                        <?php else:?>
                            <th style="color: red;">Нет</th>
                        <?php endif;?>
                    <?endforeach;?>
                <?php else:?>
                    <th>Вы еще не приглашали игроков</th>
                    <th></th>
                    <th></th>
                    <th></th>
                <?php endif;?>
                </tbody>
            </table>
        </div>
    </div>
</div>