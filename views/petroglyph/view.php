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

    <div style="padding-left: 20px; margin-right: 20px" id="layers" class = "layers-class">
    </div>

    <div id = "description">
        <p>
            <?= $petroglyph->description ?>
        </p>
    </div>

</div>

<p>
    ключевые слова: //$petroglyph->getTags()...
</p>
<p>
    ФИО автора: //$petroglyph->getAuthor()...
</p>
<script type="text/javascript">
    window.onload = function() {

        originalImageSrc = <?= "\"" . Petroglyph::PATH_STORAGE.Petroglyph::PATH_IMAGES.'/'.$petroglyph->image . "\"" ?>;
        settings = <?= $petroglyph->settings ?>;

        originalImage = new Image();
        originalImage.src = originalImageSrc;

        var drawingsImages = initDrawingsArray(jsonSettings = settings)
        var originalImageCtx = drawOriginalImage(originalImage)
        addImagesToContext(imagesArray = drawingsImages, contextToDrawOn = originalImageCtx)
        initLayersSettings(jsonSettings = settings)
        //addSettingsToUrl()

        classNameContainer = 'layers-class'

        function updateAllLayers() {
            var originalImageCtx = drawOriginalImage(originalImage)
            addImagesToContext(imagesArray = drawingsImages, contextToDrawOn = originalImageCtx)
        }

        $('.' + classNameContainer)
            .on('input change', '.alpha-value', function () {
                $(this).attr('value', $(this).val());
                var newAlpha = parseFloat($(this).val());
                var drawingImageId = parseInt($(this).attr('id'));
                drawingsImages[drawingImageId].alpha = newAlpha;
                //updateQueryStringParameters("alpha", newAlpha);
                updateAllLayers()
            });
        $('.' + classNameContainer)
            .on('input change', '.color-value', function () {
                $(this).attr('value', $(this).val());
                var newColor = $(this).val();
                var drawingImageId = parseInt($(this).attr('id'));
                drawingsImages[drawingImageId].color = newColor;
               // updateQueryStringParameters("color", newColor);
                //putValuesToQuery
                drawImage(imageWithSettings = drawingsImages[drawingImageId], contextToDrawOn = originalImageCtx)
            });

        $('.' + classNameContainer)
            .on('click', '.menu-object', function () {
            var currentDataMenu = $(this).attr('data-menu')
           switch (currentDataMenu) {
                case 'layer_pallete':
                    break;
            }
        });
    }
//TODO: pass associative array to the function
   /* function putValuesToQuery(associativeArray){
        $queries = array(
            "settings" => associativeArray
        );
        $queryString = http_build_query($queries);
        //header(window.location.href.$queryString);
        window.history.pushState(window.location.href.$queryString);
    }*/

    function updateQueryStringParameter(key, value) {
        uri = window.location.href
        var re = new RegExp("([?&])" + key + "=.*?(&|$)", "i");
        var separator = uri.indexOf('?') !== -1 ? "&" : "?";
        if (uri.match(re)) {
            uri = uri.replace(re, '$1' + key + "=" + value + '$2');
        }
        else {
            uri += (separator + key + "=" + value);
        }
        window.history.pushState("", "Page Title Here", uri);
    }
    //You can reload the url like so
    //var newUrl = updateQueryStringParameter(window.location.href,"some_param","replaceValue");
function drawImage(imageWithSettings, contextToDrawOn) {
    if (imageWithSettings.image.complete && imageWithSettings.image.naturalHeight !== 0) {

        //1. create virtual canvas and context for current image
        var canvas = document.createElement('canvas');
        var context = canvas.getContext('2d');

        //2. set size of contextToDrawOn for the canvas
        canvas.width = contextToDrawOn.canvas.width
        canvas.height = contextToDrawOn.canvas.height

        //3. set alpha channel for current image

        context.globalAlpha = imageWithSettings.alpha;

        //4. fill the context with color of current image
        context.clearRect(0, 0, canvas.width, canvas.height);
        context.drawImage(imageWithSettings.image, 0, 0, canvas.width, canvas.height)
        context.fillStyle = imageWithSettings.color;
        context.globalCompositeOperation = "source-in";
        context.fillRect(0, 0, canvas.width, canvas.height);
        context.globalCompositeOperation = "source-over";

        //5. render virtual canvases on contextToDrawOn
        contextToDrawOn.drawImage(canvas, 0, 0, canvas.width, canvas.height);
    }
}
function initDrawingsArray(jsonSettings) {
    var drawingsJson = jsonSettings.drawings;
    var drawingsImages = []
    for (let i = 0; i < drawingsJson.length; i++) {
        drawingImage = new Image();
        drawingImage.src = <?= "\"" . Petroglyph::PATH_STORAGE . Petroglyph::PATH_DRAWINGS . '/' . "\""; ?> + drawingsJson[i].image;
        alpha = parseFloat(drawingsJson[i].layerParams.alpha)
        color = drawingsJson[i].layerParams.color

        drawingsImages.push({"image": drawingImage, "alpha": alpha, "color": color});
    }
    return drawingsImages
}

function drawOriginalImage(originalImage) {

    var canvas = document.getElementById('petroglyphCanvas')
    canvas.width = originalImage.width
    canvas.height = originalImage.height

    originalImageCtx = canvas.getContext('2d');
    originalImageCtx.drawImage(originalImage, 0, 0);

    return originalImageCtx
}

function addImagesToContext(imagesArray, contextToDrawOn) {
    for (let i = 0; i < imagesArray.length; i++) {
        drawImage(imagesArray[i], contextToDrawOn)
    }
}

function initLayersSettings(jsonSettings) {
/*
    var supermenu = $('<div class="btn-group btn-group-sm container-supermenu" role="toolbar"></div>');
*/
    var drawings = jsonSettings.drawings
    if (Array.isArray(drawings)) {
        var inputAlpha = '<div id="drawings" style="width: 200px">';
        for (var i = 0; i < drawings.length; i++) {
            if (typeof drawings[i].layerParams.alpha != 'undefined') {
                alphaValue = drawings[i].layerParams.alpha;
                colorValue = drawings[i].layerParams.color;
            } else {
                alphaValue = 1;
            }
            inputAlpha += '<div style="border:1px solid black">';

            inputAlpha += (drawings[i].layerParams.title)//TODO: LAYER TITLE!!!!
                + ' : <input type=\'range\' name="alphaChannel" id=\'' + i + '\' class=\'alpha-value\' step=\'0.02\' min=\'0\' max=\'1\' value=\'' + alphaValue + '\' oninput=\"this.nextElementSibling.value = this.value\">'
                + '<output>' + alphaValue + '</output>'
                + '<br>'
                + '<label for="drawingColor">Color:</label>'
                + '<input type="color" id=\'' + i + '\' class =\'color-value\' value=\'' + colorValue + '\' name="drawingColor"></button>' + '<br>';
            inputAlpha += '</div>';
        }
        inputAlpha += '</div>';
        var layersDiv = document.getElementById("layers");
        layersDiv.innerHTML = inputAlpha
    }
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
