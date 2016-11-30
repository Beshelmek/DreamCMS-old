<div style="" class="headline headline-md">
    <h3 style="color: white" id="tonews">Новости</h3>&nbsp;&nbsp;&nbsp;
    <h3 style="color: white" id="tovk">ВКонтакте</h3>
</div>

<script>
    $('#tovk').css('border', '0');
    $('#vk-container').hide();
    $('#vk_news').hide();

    $('#tovk').click(function(){
        $('#tonews').css('border', '0');
        $('#tovk').css('border-bottom', '2px solid #3498db');
        $('#news-container').hide();
        $('#vk-container').show();
        $('#vk_news').show();
    });
    $('#tonews').click(function(){
        $('#tovk').css('border', '0');
        $('#tonews').css('border-bottom', '2px solid #3498db');
        $('#vk-container').hide();
        $('#news-container').show();
        $('#vk_news').hide();
    });
</script>

<div id="vk-container">
    <script type="text/javascript" src="//vk.com/js/api/openapi.js?121"></script>

    <!-- VK Widget -->
    <div id="vk_news"></div>
    <script type="text/javascript">
        VK.Widgets.Group("vk_news", {mode: 2, width: "845", height: "2000"}, 87133189);
        $('#vk-container').hide();
        $('#vk_news').hide();
    </script>
</div>

<div id="news-container">
    <?php foreach($news as $value): ?>
    <div class="news">
        <div class="news-header">
            <h2>
                <a  ajax-url="true" href="/news/<?=$value['id']?>"><?=$value['title']?></a>
            </h2>
        </div>
        <div class="news-body">
            <img src="<?=$value['img']?>" style="width: 100%; padding: 10px; margin-bottom: 10px;">
            <?=$value['short']?>
        </div>
        <div class="news-footer">
            <a  ajax-url="true" class="btn-u btn-u-small" href="/news/<?=$value['id']?>">Просмотреть новость <i class="fa fa-arrow-right"></i></a>
            <ul class="list-unstyled list-inline pull-right" style="margin-top: 5px;">
                <li>
                    <a ajax-url="true"  href="/user/<?=$value['author']?>"> <i class="fa fa-user"></i>  <?=$value['author']?></a> |
                </li>
                <li>
                    <i class="fa fa-calendar"></i>  <?=date('d-m-Y в H:i', $value['time'])?> |
                </li>
            </ul>
        </div>
    </div>
    <?php endforeach; ?>
</div>
