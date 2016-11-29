<div class="headline headline-md">
    <h3 id="tonews"><?=$thread['name']?></h3>
    <a class="btn btn-info pull-right" href="/forum/create_topic/<?=$thread['id']?>">Создать топик</a>
</div>

<?php foreach($thread['topics'] as $topic): ?>
    <div class="col-md-12">
            <div class="panel panel-default" style="margin-bottom: 10px;">
                <div class="panel-body" style="padding: 10px;">
                    <a href="/forum/topic/<?=$topic['id']?>"><?=$topic['name']?></a>
                    <div class="pull-right">

                        <?php if ($topic['active'] == 1): ?>
                            <a ajax-url="true" href="/forum/topic/<?=$topic['id']?>" class="btn btn-info btn-xs" type="button" style="padding: 1px 5px;"><?=$topic['msg_count']?></a>
                        <?php endif; ?>
                        <?php if ($topic['active'] == 0): ?>
                            <a ajax-url="true" href="/forum/topic/<?=$topic['id']?>" class="btn btn-xs" type="button" style="padding: 1px 5px;"><?=$topic['msg_count']?></a>
                        <?php endif; ?>

                        <?php if ($isadmin || $topic['author'] == $uuid): ?>
                            <a onclick="ajaxAction('/forum/topic/<?=$topic['id']?>/delete', {<?=$csrf['name']?>: '<?=$csrf['hash']?>'})" class="btn btn-danger btn-xs" style="padding: 1px 5px;">Удалить</a>
                        <?php endif; ?>

                        <?php if ($isadmin): ?>
                            <?php if ($topic['active'] == 1): ?>
                                <a onclick="ajaxAction('/forum/topic/<?=$topic['id']?>/close', {<?=$csrf['name']?>: '<?=$csrf['hash']?>'})" class="btn btn-info btn-xs" style="padding: 1px 5px;">Закрыть</a>
                            <?php endif; ?>

                            <?php if ($topic['active'] == 0): ?>
                                <a onclick="ajaxAction('/forum/topic/<?=$topic['id']?>/open', {<?=$csrf['name']?>: '<?=$csrf['hash']?>'})" class="btn btn-info btn-xs" style="padding: 1px 5px;">Открыть</a>
                            <?php endif; ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
    </div>
<?php endforeach; ?>
