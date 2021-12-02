<?php

use app\models\Petroglyph;
use yii\helpers\Html;

if(!empty($petroglyph)) {
    $this->title = $petroglyph->name;
    //$this->params['breadcrumbs'][] = $this->title;
} ?>
<style>
    h1 {
        margin-top: 30px;
        margin-bottom: 30px;
    }
    .petroglyph-image {
        float:left; /* Выравнивание по левому краю */
        margin: 7px 20px 7px 0; /* Отступы вокруг картинки */
    }
</style>
<?php
?>

<script type="text/javascript">
    window.onload = function() {
        petroglyphLayers = {
            originalImageSrc: <?= "\"" . Petroglyph::PATH_STORAGE.Petroglyph::PATH_IMAGES.'/'.$petroglyph->image . "\"" ?>,
            settings: <?= $petroglyph->settings ?>,
        }
        var canvas = document.getElementById("petroglyphCanvas");
        ctx = canvas.getContext("2d");
        originalImage = new Image;
        originalImage.src = petroglyphLayers.originalImageSrc;
        var drawings = petroglyphLayers.settings.drawings;
        var drawingsImages = []
        for (let i = 0; i < drawings.length; i++) {
            drawingImage = new Image;
            drawingImage.src = <?= "\"" . Petroglyph::PATH_STORAGE . Petroglyph::PATH_DRAWINGS . '/' . "\""; ?> + drawings[i];
            drawingsImages.push(drawingImage);
        }
        console.log(drawingsImages);
        canvas.width = originalImage.width
        canvas.height = originalImage.height

        originalImage.onload = function () {
            ctx.drawImage(this, 0, 0);
            for (let i = 0; i < drawingsImages.length; i++) {
                  ctx.drawImage(drawingsImages[i], 0, 0, this.width, this.height);
            }
        };
    }
</script>
<h1><?= $this->title ?></h1>
<p>
    <?php if (Yii::$app->user->can('updatePost',
        ['petroglyph' => $petroglyph])):?>

        <?= Html::a(Yii::t('app', 'Редактировать'),
            ['/petroglyph/edit', 'id' => $petroglyph->id],
            ['class' => 'btn btn-outline-secondary',
                'name' => 'edit-button',]) ?>

        <?= Html::a(Yii::t('app', 'Удалить'),
            ['/petroglyph/delete', 'id' => $petroglyph->id],
            ['class' => 'btn btn-outline-secondary',
                'name' => 'delete-button',]) ?>

    <?php endif; ?>
</p>
<div class="petroglyph-image">
    <?= Html::img(Petroglyph::PATH_STORAGE.Petroglyph::PATH_IMAGES.'/'.$petroglyph->image, ['class' => 'img-fluid mb-4']) ?>
</div>

<div class="pull-left petroglyph">
    <div class="container-petroglyph" data-state="static">
        <div class="canvas-petroglyph">
            <canvas id="petroglyphCanvas">
            </canvas>
            <button id="rt" title="Overlays" class="btn menu-object" data-menu="reconstruction-tools" data-html="true" data-container=".container-supermenu-object" data-toggle="popover" data-placement="bottom"><i class="fas fa-atlas fa-2x" style="color:green; background-color: black"></i></button>
            <div class="btn-toolbar container-menu-object" role="toolbar"><div class="btn-group btn-group-sm submenu" role="group"><button title="Wireframe" class="btn menu-object" data-menu="wire-frame"><i class="fas fa-globe"></i></button><button title="Background" style="background-color: black" class="btn menu-object cp-button" data-menu="background"><i class="fas fa-palette"></i></button><button title="Autorotation on" class="btn menu-object" data-menu="rotate"><i class="fas fa-sync-alt"></i></button><button title="Share" class="btn menu-object" data-menu="share"><i class="fas fa-share-alt"></i></button><button title="Ruler" class="btn menu-object ruler" data-menu="ruler"><i class="fas fa-ruler"></i></button><button id="lit-btn" title="Light" class="btn menu-object" data-menu="light"><i class="fas fa-lightbulb"></i></button><button id="tex-btn" title="Disable Texture" class="btn menu-object" data-menu="texture-disable"><i class="fas fa-image"></i></button><button title="Rotate Model" class="btn menu-object" data-menu="rotate90"><i class="fas fa-sync-alt"></i></button><button title="Grid on" class="btn menu-object" data-menu="grid"><i class="fas fa-th-large"></i></button><button title="Orthographer" class="btn menu-object orthographer" data-menu="toggle-orthographer"><i class="fas fa-camera"></i></button><button title="Switch Camera" class="btn menu-object cam-switch-btn" data-menu="switch-camera"><i class="fas fa-eye"></i></button></div><div class="btn-group btn-group-sm" role="group"><button title="Options" class="btn menu-object" data-menu="submenu"><i class="fas fa-cog"></i></button><button title="Fullscreen" class="btn menu-object" data-menu="full-screen"><i class="fas fa-expand"></i></button><button title="Reset camera" class="btn menu-object cam-reset-btn" data-menu="reset-camera"><i class="fas fa-redo"></i></button></div></div>
        </div>
    </div>
</div>

<p>
    <?= $petroglyph->description ?>
</p>
<p>
    ключевые слова: //$petroglyph->getTags()...
</p>

<?php /*if ($categoryId): */?><!--
    <div class="clearfix">
        <?php /*if ($objectPrev): */?>
            <?php /*= Html::a('<i class="fas fa-backward"></i> ' . $objectPrev->name, ['/object/view', 'categoryId' => $categoryId, 'id' => $objectPrev->link], ['class' => 'pull-left btn btn-default']) */?>
        <?php /*endif; */?>
        <?php /*if ($objectNext): */?>
            <?php /*= Html::a($objectNext->name . ' <i class="fas fa-forward"></i>', ['/object/view', 'categoryId' => $categoryId, 'id' => $objectNext->link], ['class' => 'pull-right btn btn-default']) */?>
        <?php /*endif; */?>
    </div>
--><?php /*endif; */?>
