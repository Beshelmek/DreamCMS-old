<script src="//cloud.tinymce.com/4/tinymce.min.js"></script>
<? if($isadmin && false):?>
    <script>
        tinymce.init({
            selector: '#mytextarea'
        });
    </script>
<? endif;?>
<div class="row"><div class="headline headline-md"><h3>Создание топика</h3></div>
<p>Убедитесь, что вы правильно выбрали раздел</p></div>
<div class="row">
    <form method="post" class="form-horizontal" id="form_create">
        <input type="hidden" name="<?=$csrf['name'];?>" value="<?=$csrf['hash'];?>"/>
        <div class="form-group">
            <label class="col-md-1 control-label">Название</label>
            <div class="col-md-11">
                <div class="input-group">
                    <input class="form-control" name="name" type="text" maxlength="255" value="" width="100%">
                </div>
            </div>
        </div>

        <fieldset>
            <div class="sky-space-30">
                <div>
                    <textarea id="mytextarea" rows="6" name="message" placeholder="Ваше сообщение тут..." class="form-control"></textarea>
                </div>
            </div>
        </fieldset>
        </br>
        <a onclick="ajaxAction('/forum/create_topic/<?=$thread['id']?>', $('#form_create').serialize());" class="btn btn-info">Создать топик</a>

    </form>
</div>