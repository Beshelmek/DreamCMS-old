<div class="panel panel-profile profile">
    <div class="panel-heading overflow-h">
        <h2 class="panel-title heading-sm">
            Топ голосующих
        </h2>
    </div>
    <div class="panel-body">
        <div class="col-md-12">
            <table class="table table-striped">
                <thead>
                <tr>
                    <th>Игрок</th>
                    <th>Количество</th>
                    <th>Последний раз</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach($players as $golos): ?>
                    <tr>
                        <td><?=$golos['login']?></td>
                        <td><?=$golos['count']?></td>
                        <td><?=$golos['last_time']?></td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>