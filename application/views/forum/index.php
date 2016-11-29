<div class="headline headline-md">
    <h3 id="tonews">Форум</h3>
</div>

<?php foreach($threads as $category=>$threads): ?>
    <div class="col-md-12">
        <h3><?=$category?></h3>
        <?php foreach($threads as $thread): ?>
            <div class="panel panel-default" style="margin-bottom: 10px;">
                <div class="panel-body" style="padding: 10px;">
                    <a href="/forum/thread/<?=$thread['id']?>"><?=$thread['name']?></a>
                    <div class="pull-right">
                        <a ajax-url="true" href="/forum/thread/<?=$thread['id']?>" class="btn btn-info btn-xs" type="button" style="padding: 1px 5px;"><?=$thread['topic_count']?></a></div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
<?php endforeach; ?>
