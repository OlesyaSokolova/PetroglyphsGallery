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
        </div>
    </div>
</div>

<p>
    <?= $petroglyph->description ?>
</p>
<p>
    ключевые слова: //$petroglyph->getTags()...
</p>
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
            drawingImage.src = <?= "\"" . Petroglyph::PATH_STORAGE . Petroglyph::PATH_DRAWINGS . '/' . "\""; ?> + drawings[i].image;
            drawingsImages.push(drawingImage);
        }
        //console.log(drawingsImages);
        canvas.width = originalImage.width
        canvas.height = originalImage.height

        originalImage.onload = function () {
            ctx.drawImage(this, 0, 0);
            for (let i = 0; i < drawingsImages.length; i++) {
                ctx.drawImage(drawingsImages[i], 0, 0, this.width, this.height);
            }
        };

        var ALL_NODES,
            classNameContainer = 'container-petroglyph',
            classNameCanvas = 'canvas-petroglyph';

        ALL_NODES = $('.petroglyph');
        ALL_NODES.children('.' + classNameContainer).children('.' + classNameCanvas).append(initLayersSettings());
    }

function initLayersSettings() {
    var supermenu = $('<div class="btn-group btn-group-sm container-supermenu" role="toolbar"></div>');
    var drawings = <?= $petroglyph->settings ?>.drawings
    if (Array.isArray(drawings)) {
        var inputAlpha = '<div id="rt_popover">';
        for (var i = 0; i < drawings.length; i++) {
            if (typeof drawings[i].layerParams.alpha != 'undefined') {
                alphaValue = drawings[i].layerParams.alpha;
            } else {
                alphaValue = 1;
            }
            inputAlpha += (i + 1)
                + ' : <input type=\'range\' id=\'' + i + '\' class=\'alpha-value\' step=\'0.05\' min=\'-1\' max=\'1\' value=\'' + alphaValue + '\'>'
                + '<button value="' + i + '" class="btn menu-object cp-button" data-menu="layer_pallete" data-html="true" data-container="#rt_popover"'
                + 'data-toggle="popover" data-placement="bottom"><i class="fas fa-palette"></i></button>' + '<br>';
        }
        inputAlpha += '</div>';

        //rt_popover = $(inputAlpha);
        var rt = $('<button id="rt" title="Overlays" class="btn btn-secondary" data-menu="reconstruction-tools" data-html="true" data-container=".container-supermenu"' +
            'data-toggle="popover" data-placement="right">LAYERS</button>');
        var classNameContainer = 'container-petroglyph'
        $(document).ready(function(){
            // Enable popovers everywhere
            $('[data-toggle="popover"]').popover({
                content: function() {
                    return '<div id="rt_popover" style="width: 200px">' + inputAlpha + '</div>';;
                }
            });
        });
        /*$('.' + classNameContainer)
            .on('click', '.btn-secondary', function () {
                switch ($(this).attr('data-menu')) {
                    case 'reconstruction-tools':
                        //TODO: add option to close it!!
                        //object.option.rt = !object.option.rt;
                        //if (object.option.rt) {
                        $(this).popover({
                            content: function(){
                                var test = content
                                return test;
                                //return '<div id="rt_popover" style="width: 200px">' + inputAlpha + '</div>';
                            }
                        });
                        $(this).popover('show');
                        /!*if($('#mt').hasClass('active')) {
                            //object.option.mt = false;
                            mt_popover.html($('#mt_popover').html());
                            $('#mt').popover('destroy');
                            buttonActive($('#mt'), false);
                        }*!/
                        /!*} else {
                            rt_popover.html($('#rt_popover').html());
                            $(this).popover('destroy');
                        }*!/
                        //buttonActive($(this), object.option.rt);
                        buttonActive($(this), true);
                        break;

                }
            });*/
        supermenu.append(rt);
        return supermenu;
    }
}


function buttonActive(element, value) {
    if (value) {
        element.addClass('active');
    } else {
        element.removeClass('active');
    }
}
</script>
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
