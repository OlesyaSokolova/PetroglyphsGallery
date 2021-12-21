<?php

use app\assets\ViewAsset;
use app\models\Petroglyph;

if(!empty($petroglyph)) {
    $this->title = "Редактирование: ".$petroglyph->name;
    $originalImageSrc = "\"" . Petroglyph::PATH_STORAGE.Petroglyph::PATH_IMAGES.'/'.$petroglyph->image . "\"";
    $drawingPathPrefix = "\"" . Petroglyph::PATH_STORAGE . Petroglyph::PATH_DRAWINGS . '/' . "\"";

    $script = <<< JS
    originalImageSrc = $originalImageSrc
    settings = $petroglyph->settings
    drawingPathPrefix =  $drawingPathPrefix
   
    prepareEditablePetroglyph()

JS;

    ViewAsset::register($this);
    $this->registerJs($script, yii\web\View::POS_READY);
} ?>

<h1><?=$this->title?>
</h1>
<p>
    <?php if (Yii::$app->user->can('updatePost',
        ['petroglyph' => $petroglyph])):?>
        <button type="button" class="btn btn-primary" id="save-button">Сохранить</button>
    <?php endif; ?>
</p>

<form>
    <div class="form-group">
        <label for="name">Название экспоната: </label>
        <input type="text" class="form-control" id="name" value=" <?= $petroglyph->name ?>">
    </div>
</form>



<div class="box" style="
    display: flex
">
    <!--<div class="box" id="instruments">
        //сетка/список с инструментами
    </div>-->

    <div class="container-petroglyph" data-state="static">
        <div class="canvas-petroglyph">
            <canvas id="petroglyphCanvas">
            </canvas>
        </div>

        <form>
            <div class="form-group">
                <label for="mainDesc">Основное описание:</label>
                <textarea class="form-control" id="mainDesc" rows="10"><?= $petroglyph->description ?>"</textarea>
            </div>
        </form>
    </div>


    <div id="layers" class = "layers-class" style="
        padding-left: 20px;">
    </div>
</div>

<!--<p>
    ключевые слова: //$petroglyph->getTags()...
</p>-->
<!--<p>
    ФИО автора: //$petroglyph->getAuthor()...
</p>-->

<!--<div id="rt_popover" style="width: 200px"><div id="rt_popover">1 : <input type='range' id='0' class='alpha-value' step='0.05' min='-1' max='1' value='0.5'><button value="0" class="btn menu-object cp-button" data-menu="layer_pallete" data-html="true" data-container="#rt_popover"data-toggle="popover" data-placement="bottom"><i class="fas fa-palette"></i></button><br>2 : <input type='range' id='1' class='alpha-value' step='0.05' min='-1' max='1' value='0.6'><button value="1" class="btn menu-object cp-button" data-menu="layer_pallete" data-html="true" data-container="#rt_popover"data-toggle="popover" data-placement="bottom"><i class="fas fa-palette"></i></button><br>3 : <input type='range' id='2' class='alpha-value' step='0.05' min='-1' max='1' value='0.8656377'><button value="2" class="btn menu-object cp-button" data-menu="layer_pallete" data-html="true" data-container="#rt_popover"data-toggle="popover" data-placement="bottom"><i class="fas fa-palette"></i></button><br></div></div>
--><?php /*if ($categoryId): */?><!--
    <div class="clearfix">
        <?php /*if ($objectPrev): */?>
            <?php /*= Html::a('<i class="fas fa-backward"></i> ' . $objectPrev->name, ['/object/view', 'categoryId' => $categoryId, 'id' => $objectPrev->link], ['class' => 'pull-left btn btn-default']) */?>
        <?php /*endif; */?>
        <?php /*if ($objectNext): */?>
            <?php /*= Html::a($objectNext->name . ' <i class="fas fa-forward"></i>', ['/object/view', 'categoryId' => $categoryId, 'id' => $objectNext->link], ['class' => 'pull-right btn btn-default']) */?>
        <?php /*endif; */?>
    </div>
--><?php /*endif; */?>
