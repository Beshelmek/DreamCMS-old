    <div class="headline headline-md"><h3><?=$topic['name']?></h3></div>
    <div class="news-comments">
        <?php foreach($topic['messages'] as $message): ?>
        <form id="forum-comment-<?=$message['id']?>" class="sky-form comment-style">
            <input type="hidden" name="<?=$csrf['name'];?>" value="<?=$csrf['hash'];?>" />
            <input type="hidden" name="message_id" value="<?=$message['id']?>" />
            <div class="row blog-comments margin-bottom-30" id="comment_<?=$message['id']?>">
                <div class="col-sm-2 sm-margin-bottom-40 text-center">
                    <a href="/profile/<?=$message['author']?>">
                        <img class="img-circle" src="/skin/head/<?=$message['author_l']?>">
                    </a>
                </div>
                <div class="col-sm-10">
                    <div class="comments-itself">
                        <h4>
                            <a href="/profile/<?=$message['author']?>"><?=$message['author_l']?></a>
                            <span><?=date('d.m.Y в H:i:s', $message['date'])?></span>
                        </h4>
                        <p style="word-wrap: break-word;"><?=str_replace(array("\r\n", "\n", "\r"), "<br>", $message['message'])?></p>
                        <div class="row pull-right" style="margin-top: -8px;">
                            <a class="fa fa-trash" onclick="ajaxAction('/forum/delete/message', $('#forum-comment-<?=$message['id']?>').serialize());"></a>
                        </div>
                    </div>
                </div>
            </div>
        </form>
        <?php endforeach; ?>
    </div>
    <? if($topic['active'] == 1):?>
        <div class="panel-body">
            <form id="forum-comment" class="sky-form comment-style">
                <input type="hidden" name="<?=$csrf['name'];?>" value="<?=$csrf['hash'];?>"/>
                <fieldset>
                    <div class="sky-space-30">
                        <div>
                            <textarea rows="6" name="message" placeholder="Ваш ответ тут..." class="form-control"></textarea>
                        </div>
                    </div>

                </fieldset>
            </form>
            <p>
                <a onclick="ajaxAction('/forum/message/<?=$topic['id']?>', $('#forum-comment').serialize())" class="btn-u">Добавить комментарий</a>
            </p>
        </div>
    <? endif;?>
