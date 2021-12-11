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
    /*.petroglyph {
        float:left; !* Выравнивание по левому краю *!
        margin: 7px 20px 7px 0; !* Отступы вокруг картинки *!
    }*/

    .box {
        display: flex;
        justify-content: space-between;
    }

</style>


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


<div class="box">
    <div class="container-petroglyph" data-state="static">
        <div class="canvas-petroglyph">
            <canvas id="petroglyphCanvas">
            </canvas>
        </div>
    </div>

    <div id="layers" class = "layers-class">
    </div>

    <div id="color-palette">
    </div>
    <p>
        <?= $petroglyph->description ?>
    </p>
</div>
<p>
    ключевые слова: //$petroglyph->getTags()...
</p>
<script type="text/javascript">
    window.onload = function() {
        var drawingsImages = []
        loadOriginalImageWithDrawings(drawingsImages)
        initLayersSettings()
        classNameContainer = 'layers-class'
        $('.' + classNameContainer)
            .on('input change', '.alpha-value', function () {
                $(this).attr('value', $(this).val());
                var newAlpha = parseFloat($(this).val());
                var drawingImageId = parseInt($(this).attr('id'));
                drawingsImages[drawingImageId].alpha = newAlpha;
                //TODO: define the function
                redrawDrawings(drawingsImages)
                //var test2 = 5+5
                //var test = drawings[parseInt($(this).attr('id'))].alpha = parseFloat($(this).val());
                //t.redrawTexture();
            });
        //add color listener on change

        $('.' + classNameContainer)
            .on('click', '.menu-object', function () {
            var currentDataMenu = $(this).attr('data-menu')
           switch (currentDataMenu) {
                case 'layer_pallete':
                   //get value from color input
                    /*var test = 5+5
                    /!*var active_state = !$(this).hasClass('active');
                    $(".cp-button").removeClass('active');
                    if (active_state) {
                        $(this).addClass('active');
                        currentDrawingId = $(this).val();
                        $('#color').show();
                        if (typeof drawings[currentDrawingId].color != 'undefined' && drawings[currentDrawingId].color !== null)
                            cp.setHex(drawings[currentDrawingId].color);
                    } else $('#color').hide();*!/
                    break;*/
            }
        });
       /* $('.layers')
            .on('input change', '.alpha-value', function () {
                $(this).attr('value', $(this).val());
                console.log("hello" + parseFloat($(this).val()))
                //drawings[parseInt($(this).attr('id'))].alpha = parseFloat($(this).val());
                //t.redrawTexture();
            })*/


    }



function loadOriginalImageWithDrawings(drawingsImages) {
    petroglyphLayers = {
        originalImageSrc: <?= "\"" . Petroglyph::PATH_STORAGE.Petroglyph::PATH_IMAGES.'/'.$petroglyph->image . "\"" ?>,
        settings: <?= $petroglyph->settings ?>,
    }


    originalImage = new Image;
    originalImage.src = petroglyphLayers.originalImageSrc;
    var drawings = petroglyphLayers.settings.drawings;

    var canvas = document.getElementById("petroglyphCanvas");
    ctx = canvas.getContext("2d");

    for (let i = 0; i < drawings.length; i++) {
        drawingImage = new Image;
        drawingImage.src = <?= "\"" . Petroglyph::PATH_STORAGE . Petroglyph::PATH_DRAWINGS . '/' . "\""; ?> + drawings[i].image;
        drawingsImages.push(drawingImage);
    }
    canvas.width = originalImage.width
    canvas.height = originalImage.height

    originalImage.onload = function () {
        ctx.drawImage(this, 0, 0);
        for (let i = 0; i < drawingsImages.length; i++) {
            //ctx.drawImage(drawingsImages[i], 0, 0, this.width, this.height);
            ctx.drawImage(drawingsImages[i], 0, 0, this.width, this.height);
            //ctx.globalAlpha = 0.2;
        }
    };
}
function initLayersSettings() {
/*
    var supermenu = $('<div class="btn-group btn-group-sm container-supermenu" role="toolbar"></div>');
*/
    var drawings = <?= $petroglyph->settings ?>.drawings
    if (Array.isArray(drawings)) {
        var inputAlpha = '<div id="rt_popover">';
        for (var i = 0; i < drawings.length; i++) {
            if (typeof drawings[i].layerParams.alpha != 'undefined') {
                alphaValue = drawings[i].layerParams.alpha;
                //colorValue = drawings[i].layerParams.color;
                colorValue = "#868686"
            } else {
                alphaValue = 1;
            }

           inputAlpha += (i + 1)
                + ' : <input type=\'range\' id=\'' + i + '\' class=\'alpha-value\' step=\'0.05\' min=\'-1\' max=\'1\' value=\'' + alphaValue + '\'>'
                + '<button value="' + i + '" class="btn menu-object cp-button" data-menu="layer_pallete" data-html="true" data-container="#rt_popover"'
                + 'data-toggle="popover" data-placement="bottom">'
                + '<label for="drawingColor">Color:</label>'
                + '<input type="color" value=\'' + colorValue + '\' id="drawingColor"></button>' + '<br>';
        }
        inputAlpha += '</div>';
        var layersDiv = document.getElementById("layers");
        layersDiv.innerHTML = '<div id="rt_popover" style="width: 200px">' + inputAlpha + '</div>'
    }
}

function redrawPetroglyph() {

}

</script>
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
