<div class="col-md-3">
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">Данные</h3>
        </div>
        <!-- /.box-header -->
        <!-- form start -->
        <form role="form">
            <div class="box-body">
                <div class="form-group">
                    <label for="world">Мир</label>
                    <input type="number" class="form-control" id="world" placeholder="0" value="<?=$info['Dimension']?>">
                </div>
                <div class="form-group">
                    <label for="coord-x">Координаты</label>
                    <input type="number" class="form-control" id="coord-x" placeholder="0" value="<?=$info['Pos'][0]?>">
                    <input type="number" class="form-control" id="coord-y" placeholder="0" value="<?=$info['Pos'][1]?>">
                    <input type="number" class="form-control" id="coord-z" placeholder="0" value="<?=$info['Pos'][2]?>">
                </div>
            </div>

            <div class="box-footer">
                <button id="submit" class="btn btn-primary">Сохранить изменения</button>
            </div>
        </form>
    </div>

</div>
<div class="col-md-9">
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">Инвентарь</h3>
        </div>
            <div class="box-body">
                <div class="row" style="margin: 0">
                    <div class="slot" slot="103"></div>
                    <div class="slot" slot="102"></div>
                    <div class="slot" slot="101"></div>
                    <div class="slot" slot="100"></div>
                </div>
                <br>
                <div class="row" style="margin: 0">
                <?php $i = 9; print_r($info['Inventory']);
                while($i <= 17): ?>
                    <div class="slot" slot="<?=$i?>"></div>
                <? $i++ ?>
                <?php endwhile; ?>
                </div>
                <br>
                <div class="row" style="margin: 0">
                    <?php $i = 18;
                    while($i <= 26): ?>
                        <div class="slot" slot="<?=$i?>"></div>
                        <? $i++ ?>
                    <?php endwhile; ?>
                </div>
                <br>
                <div class="row" style="margin: 0">
                    <?php $i = 27;
                    while($i <= 35): ?>
                        <div class="slot" slot="<?=$i?>"></div>
                        <? $i++ ?>
                    <?php endwhile; ?>
                </div>
                <br>
                <div class="row" style="margin: 0">
                    <div class="slot" slot="0"></div>
                    <div class="slot" slot="1"></div>
                    <div class="slot" slot="2"></div>
                    <div class="slot" slot="3"></div>
                    <div class="slot" slot="4"></div>
                    <div class="slot" slot="5"></div>
                    <div class="slot" slot="6"></div>
                    <div class="slot" slot="7"></div>
                    <div class="slot" slot="8"></div>
                </div>
            </div>

            <div class="box-footer">
                <button id="clearinv" class="btn btn-primary">Отчистить инвентарь</button>
            </div>
        </form>
    </div>
</div>
<style>
.slot{
    border: gray solid 1px;
    float: left;
    width: 32px;
    height: 32px;
    margin-left: 5px;
    background: gray;
}
</style>