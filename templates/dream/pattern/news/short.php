<?php foreach($news as $value): ?>
    <div class="post-wrapper">
        <h1 class="h1-responsive"><?=$value['title']?></h1>
        <h6>Написал <a href="/profile/<?=$value['author']?>"><?=$value['author']?></a>, <?=date('d-m-Y в H:i', $value['time'])?></h6>

        <br>

        <div class="view overlay hm-white-light z-depth-1-half">
            <img src="<?=$value['img']?>" class="img-fluid" alt="">
            <div class="mask waves-effect waves-light"></div>
        </div>

        <br>

        <p><?=$value['short']?></p>

        <button class="btn btn-primary waves-effect waves-light" href="/news/<?=$value['id']?>">Читать далее</button>
    </div>
    <hr>
<?php endforeach; ?>