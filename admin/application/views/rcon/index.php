<style>
    input { font-family: Consolas;font-size:110%; color:white;border: none;width: 100%; height: 30px; background: rgba(0,0,0,0.7); }
    .oner { background: url(http://a1star.com/images/star--background-seamless-repeating9.jpg); font-family: Consolas;color:white; padding: 0px; overflow: hidden;}
    .twor { color:white;background-color:rgba(0,0,0,0.65); height: 400px; width: 100%;overflow-y: auto; }
</style>
<?php foreach($servers as $server): ?>
    <div class="box box-default collapsed-box">
        <div class="box-header with-border">
            <h3 class="box-title"><?=$server?></h3>

            <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i>
                </button>
            </div>
            <!-- /.box-tools -->
        </div>
        <!-- /.box-header -->
        <div class="box-body" style="display: none;">
            <div class="oner">
                <div id="console-<?=$server?>" class="twor"></div>
                <input id="input-<?=$server?>" type="text">
            </div>

            <script>
                $('#input-<?=$server?>').focus().inputHistory(function(value) {
                    $('#console-<?=$server?>').html($('#console-<?=$server?>').html() + '<br><strong>&gt; ' + value + '</strong>');
                    $.post('/admin/index.php?/rcon', 'server=<?=$server?>&rcon=' + encodeURIComponent(value), function(data){$('#console-<?=$server?>').html($('#console-<?=$server?>').html() + '<br>' + data).animate({ scrollTop: $('#console')[0].scrollHeight}, 800); });
                });
                var value = 'mem';
                $('#console-<?=$server?>').html($('#console-<?=$server?>').html() + '<br><strong>&gt; ' + value + '</strong>');
                $.post('/admin/index.php?/rcon','server=<?=$server?>&rcon=' + encodeURIComponent(value), function(data){$('#console-<?=$server?>').html($('#console-<?=$server?>').html() + '<br>' + data).animate({ scrollTop: $('#console')[0].scrollHeight}, 800); });
                var value = 'list';
                $('#console-<?=$server?>').html($('#console-<?=$server?>').html() + '<br><strong>&gt; ' + value + '</strong>');
                $.post('/admin/index.php?/rcon','server=<?=$server?>&rcon=' + encodeURIComponent(value), function(data){$('#console-<?=$server?>').html($('#console-<?=$server?>').html() + '<br>' + data).animate({ scrollTop: $('#console')[0].scrollHeight}, 800); });

            </script>
        </div>
        <!-- /.box-body -->
    </div>

<?php endforeach; ?>