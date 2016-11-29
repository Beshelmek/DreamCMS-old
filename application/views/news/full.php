<div class="headline headline-md"><h3>Новости</h3></div>

<div class="news">
    <div class="news-header">
        <h2>
            <a  ajax-url="true"  href="/news/<?=$id?>"><?=$title?></a>
        </h2>
    </div>
    <div class="news-body">
        <?=$short?>
    </div>
    <div class="news-footer">
        <a ajax-url="true"  class="btn-u btn-u-small" href="/">Назад <i class="fa fa-arrow-right"></i></a>
        <ul class="list-unstyled list-inline pull-right" style="margin-top: 5px;">
            <li>
                <a  ajax-url="true" href="/user/<?=$author?>"> <i class="fa fa-user"></i>  <?=$author?></a> |
            </li>
            <li>
                <i class="fa fa-calendar"></i>  <?=date('d-m-Y в H:i', $time)?> |
            </li>
        </ul>
    </div>
</div>
