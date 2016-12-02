<div class="panel panel-profile profile">
    <div class="panel-heading overflow-h">
        <h2 class="panel-title heading-sm">
            Топ активных
        </h2>
    </div>
    <div class="panel-body">
        <div class="col-md-12">
            <table class="table table-striped">
                <thead>
                <tr>
                    <th>Игрок</th>
                    <th>Кол-во часов в игре</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach($players as $golos): ?>
                    <tr>
                        <td><?=$golos['username']?></td>
                        <td><?=$golos['playtime']?> ч.</td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>