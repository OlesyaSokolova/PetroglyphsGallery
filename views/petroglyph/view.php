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

    <div id = "description">
        <p>
            <?= $petroglyph->description ?>
        </p>
    </div>

</div>

<p>
    ключевые слова: //$petroglyph->getTags()...
</p>
<script type="text/javascript">
    window.onload = function() {
        petroglyphLayers = {
            originalImageSrc: <?= "\"" . Petroglyph::PATH_STORAGE.Petroglyph::PATH_IMAGES.'/'.$petroglyph->image . "\"" ?>,
            settings: <?= $petroglyph->settings ?>,
        }
        var drawingsImages = initDrawingsArray(jsonSettings = petroglyphLayers.settings)
        var originalImageCtx = drawOriginalImage(originalImageSrc = petroglyphLayers.originalImageSrc)
        addImagesToContext(imagesArray = drawingsImages, contextToAddImages = originalImageCtx)
        //test(drawingsImages)
        //loadOriginalImageWithDrawings(drawingsImages)
        initLayersSettings(jsonSettings = petroglyphLayers.settings)
        classNameContainer = 'layers-class'
        $('.' + classNameContainer)
            .on('input change', '.alpha-value', function () {
                $(this).attr('value', $(this).val());
                var newAlpha = parseFloat($(this).val());
                var drawingImageId = parseInt($(this).attr('id'));
                drawingsImages[drawingImageId].layerParams.alpha = newAlpha;
                //TODO: define the function
                //redrawDrawings(drawingsImages)
            });
        //add color listener on change

        $('.' + classNameContainer)
            .on('click', '.menu-object', function () {
            var currentDataMenu = $(this).attr('data-menu')
           switch (currentDataMenu) {
                case 'layer_pallete':
                    break;
            }
        });
    }


function initDrawingsArray(jsonSettings) {
    var drawingsJson = jsonSettings.drawings;
    var drawingsImages = []
    for (let i = 0; i < drawingsJson.length; i++) {
        drawingImage = new Image;
        drawingImage.src = <?= "\"" . Petroglyph::PATH_STORAGE . Petroglyph::PATH_DRAWINGS . '/' . "\""; ?> + drawingsJson[i].image;
        alpha = drawingsJson[i].layerParams.alpha
        color = drawingsJson[i].layerParams.color
        drawingsImages.push({"image": drawingImage, "alpha": alpha, "color": color});
    }
    return drawingsImages
}

function drawOriginalImage(originalImageSrc) {
    originalImage = new Image;
    originalImage.src = originalImageSrc;

    var canvas = document.getElementById('petroglyphCanvas')
    canvas.width = originalImage.width
    canvas.height = originalImage.height

    originalImageCtx = canvas.getContext('2d');
    originalImageCtx.drawImage(originalImage, 0, 0);

    return originalImageCtx
}

function test(imagesArray) {
    /* using canvas from DOM */
    var domCanvas = document.getElementById('petroglyphCanvas');
    var domContext = domCanvas.getContext('2d');
    //domContext.fillRect(50,50,150,50);

    /* virtual canvase 1 - not appended to the DOM */
    var canvas = document.createElement('canvas');
    var ctx = canvas.getContext('2d');
    ctx.fillStyle = imagesArray[0].color
    ctx.drawImage(imagesArray[0].image, 0, 0, 200, 200)
    //ctx.fillRect(50,50,150,150);

    /* virtual canvase 2 - not appended to the DOM */
    var canvas2 = document.createElement('canvas')
    var ctx2 = canvas2.getContext('2d');
    ctx2.fillStyle = imagesArray[1].color
    ctx2.drawImage(imagesArray[1].image, 0, 0, 200, 200)

    var canvas3 = document.createElement('canvas')
    var ctx3 = canvas3.getContext('2d');
    ctx3.fillStyle = imagesArray[2].color
    ctx3.drawImage(imagesArray[2].image, 0, 0, 200, 200)
    //ctx2.fillRect(50,50,100,50)

    /* render virtual canvases on DOM canvas */
    domContext.drawImage(canvas, 0, 0, 200, 200);
    domContext.drawImage(canvas2, 0, 0, 200, 200);
    domContext.drawImage(canvas3, 0, 0, 200, 200);
}
function addImagesToContext(imagesArray, contextToAddImages) {
    for (let i = 0; i < imagesArray.length; i++) {
        if (imagesArray[i].image.complete && imagesArray[i].image.naturalHeight !== 0 && typeof imagesArray[i].ctx === 'undefined') {

            var domCanvas = document.getElementById('petroglyphCanvas');
            var domContext = domCanvas.getContext('2d');
            //domContext.fillRect(50,50,150,50);

            /* virtual canvase 1 - not appended to the DOM */
            var canvas = document.createElement('canvas');
            var ctx = canvas.getContext('2d');
            canvas.width = domCanvas.width
            canvas.height = domCanvas.height
            ctx.clearRect(0, 0, canvas.width, canvas.height);
            ctx.drawImage(imagesArray[i].image, 0, 0, canvas.width, canvas.height)
            ctx.fillStyle = imagesArray[i].color;
            ctx.globalCompositeOperation = "source-in";
            ctx.fillRect(0, 0, canvas.width, canvas.height);
            ctx.globalCompositeOperation = "source-over";
            //ctx.fillStyle = imagesArray[i].color
            ctx.globalAlpha = imagesArray[i].alpha;

            //ctx.fillRect(50,50,150,150);

            /* render virtual canvases on DOM canvas */
            domContext.drawImage(canvas, 0, 0, canvas.width, canvas.height);
           /* var canvas = document.createElement('canvas');
            var ctx = canvas.getContext('2d');
            ctx.canvas.width = contextToAddImages.canvas.width;
            ctx.canvas.height = contextToAddImages.canvas.height;
            ctx.fillStyle = imagesArray[i].color;
            ctx.drawImage(imagesArray[i].image, 0, 0);

            contextToAddImages.globalAlpha = imagesArray[i].alpha;
            //6. render virtual canvases on contextToAddImages
            contextToAddImages.drawImage(canvas, 0, 0, contextToAddImages.canvas.width, contextToAddImages.canvas.height);
            //contextToAddImages.drawImage(imagesArray[i].image, 0, 0, contextToAddImages.canvas.width, contextToAddImages.canvas.height);*/

            //1. create virtual canvas for each image
            /*var canvas = document.createElement('canvas');
            imagesArray[i].ctx = canvas.getContext('2d');

            //2. set size of contextToAddImages (size of original image)
            imagesArray[i].ctx.canvas.width = contextToAddImages.canvas.width;
            imagesArray[i].ctx.canvas.height = contextToAddImages.canvas.height;

            //3. draw image for each virtual canvas
            imagesArray[i].ctx.drawImage( imagesArray[i].image, 0, 0);

            //4. fill each image with its color
            imagesArray[i].ctx.clearRect(0, 0, imagesArray[i].ctx.canvas.width, imagesArray[i].ctx.canvas.height);
            imagesArray[i].ctx.fillStyle = imagesArray[i].color;
            imagesArray[i].ctx.globalCompositeOperation = "source-in";
            imagesArray[i].ctx.fillRect(0, 0, imagesArray[i].ctx.canvas.width, imagesArray[i].ctx.canvas.height);
            imagesArray[i].ctx.globalCompositeOperation = "source-over";
            imagesArray[i].currentColor = imagesArray[i].color;

            //5. set alpha channel for each image
            contextToAddImages.globalAlpha = imagesArray[i].alpha;

            //6. render virtual canvases on contextToAddImages
            contextToAddImages.drawImage(imagesArray[i].ctx.canvas, 0, 0);*/
    }
           /* var canvas = document.createElement('canvas');
            imagesArray[i].ctx = canvas.getContext('2d');
            imagesArray[i].ctx.canvas.width = contextToAddImages.canvas.width;
            imagesArray[i].ctx.canvas.height = contextToAddImages.canvas.height;
            imagesArray[i].ctx.drawImage(imagesArray[i].image, 0, 0);

            var coloredCanvas = document.createElement('canvas');
            imagesArray[i].coloredCtx = coloredCanvas.getContext('2d');
            let coloredCtx = imagesArray[i].coloredCtx;
            coloredCtx.canvas.width = canvasWidth;
            coloredCtx.canvas.height = canvasHeight;
            coloredCtx.clearRect(0, 0, coloredCtx.canvas.width, coloredCtx.canvas.height);
            coloredCtx.drawImage(imagesArray[i].ctx.canvas, 0, 0);
            if (typeof imagesArray[i].color === 'string') {
                coloredCtx.fillStyle = imagesArray[i].color;
                coloredCtx.globalCompositeOperation = "source-in";
                coloredCtx.fillRect(0, 0, coloredCtx.canvas.width, coloredCtx.canvas.height);
                coloredCtx.globalCompositeOperation = "source-over";
                imagesArray[i].currentColor = imagesArray[i].color;
            }
        }
    }
    //2d. For each drawing: if color changed - redraw drawings[i].coloredCtx
    for (let i = 0; i < imagesArray.length; i++) {
        if (imagesArray[i].ctx && typeof imagesArray[i].color === 'string' &&
            (typeof imagesArray[i].currentColor == "undefined" || imagesArray[i].currentColor != imagesArray[i].color))
        {
            let coloredCtx = imagesArray[i].coloredCtx;
            coloredCtx.clearRect(0, 0, coloredCtx.canvas.width, coloredCtx.canvas.height);
            coloredCtx.drawImage(imagesArray[i].ctx.canvas, 0, 0);
            coloredCtx.fillStyle = imagesArray[i].color;
            coloredCtx.globalCompositeOperation = "source-in";
            coloredCtx.fillRect(0, 0, coloredCtx.canvas.width, coloredCtx.canvas.height);
            coloredCtx.globalCompositeOperation = "source-over";
            imagesArray[i].currentColor = imagesArray[i].color;
        }

        for (let i = 0; i < imagesArray.length; i++) {
            if (imagesArray[i].alpha > 0) {
                if (typeof drawingsImages[i].coloredCtx != 'undefined' ) {
                    originalImageCtx.globalAlpha = imagesArray[i].alpha;
                    originalImageCtx.drawImage(imagesArray[i].coloredCtx.canvas, 0, 0);
                }
            }
        }*/
    }
}
function loadOriginalImageWithDrawings(drawingsImages) {

    originalImage = new Image;
    originalImage.src = petroglyphLayers.originalImageSrc;
    var drawings = petroglyphLayers.settings.drawings;

    /*var canvas = document.getElementById("petroglyphCanvas");
    ctx = canvas.getContext("2d");*/
    originalImageCtx = document.getElementById('petroglyphCanvas').getContext('2d');
    /*canvas.width = originalImage.width
    canvas.height = originalImage.height*/

    for (let i = 0; i < drawings.length; i++) {
        drawingImage = new Image;
        drawingImage.src = <?= "\"" . Petroglyph::PATH_STORAGE . Petroglyph::PATH_DRAWINGS . '/' . "\""; ?> + drawings[i].image;
        alpha = drawings[i].layerParams.alpha
        color = drawings[i].layerParams.color
        drawingsImages.push({"image": drawingImage, "alpha": alpha, "color": color});
    }

    originalImage.onload = function () {
        originalImageCtx.canvas.width = originalImage.width
        originalImageCtx.canvas.height = originalImage.height
        originalImageCtx.drawImage(this, 0, 0);
        //redrawDrawings(drawingsImages, originalImageCtx, originalImage.width, originalImage.height)
        /*for (let i = 0; i < drawingsImages.length; i++) {
            ctx.drawImage(drawingsImages[i].image, 0, 0, this.width, this.height);
            ctx.globalAlpha = drawingsImages[i].alpha;
            /!*if (typeof drawingsImages[i].color === 'string') {
                ctx.fillStyle = drawings[i].color;
                ctx.globalCompositeOperation = "source-in";
                ctx.fillRect(0, 0, ctx.canvas.width, ctx.canvas.height);
                ctx.globalCompositeOperation = "source-over";
            }*!/
        }*/
    };
}

function redrawDrawings(drawingsImages, originalImageCtx, canvasWidth, canvasHeight) {
    //2c. For each drawing: if loaded - create drawings[i].ctx canvas with drawing image
    // and drawings[i].coloredCtx with colored drawing image
    for (let i = 0; i < drawingsImages.length; i++) {
        if (drawingsImages[i].image.complete && drawingsImages[i].image.naturalHeight !== 0 && typeof drawingsImages[i].ctx === 'undefined')
        {
            var canvas = document.createElement('canvas');
            drawingsImages[i].ctx = canvas.getContext('2d');
            drawingsImages[i].ctx.canvas.width = canvasWidth;
            drawingsImages[i].ctx.canvas.height = canvasHeight;
            drawingsImages[i].ctx.drawImage(drawingsImages[i].image, 0, 0);

            var coloredCanvas = document.createElement('canvas');
            drawingsImages[i].coloredCtx = coloredCanvas.getContext('2d');
            let coloredCtx = drawingsImages[i].coloredCtx;
            coloredCtx.canvas.width = canvasWidth;
            coloredCtx.canvas.height = canvasHeight;
            coloredCtx.clearRect(0, 0, coloredCtx.canvas.width, coloredCtx.canvas.height);
            coloredCtx.drawImage(drawingsImages[i].ctx.canvas, 0, 0);
            if (typeof drawingsImages[i].color === 'string') {
                coloredCtx.fillStyle = drawingsImages[i].color;
                coloredCtx.globalCompositeOperation = "source-in";
                coloredCtx.fillRect(0, 0, coloredCtx.canvas.width, coloredCtx.canvas.height);
                coloredCtx.globalCompositeOperation = "source-over";
                drawingsImages[i].currentColor = drawingsImages[i].color;
            }
        }
    }
    //2d. For each drawing: if color changed - redraw drawings[i].coloredCtx
    for (let i = 0; i < drawingsImages.length; i++) {
        if (drawingsImages[i].ctx && typeof drawingsImages[i].color === 'string' &&
            (typeof drawingsImages[i].currentColor == "undefined" || drawingsImages[i].currentColor != drawingsImages[i].color))
        {
            let coloredCtx = drawingsImages[i].coloredCtx;
            coloredCtx.clearRect(0, 0, coloredCtx.canvas.width, coloredCtx.canvas.height);
            coloredCtx.drawImage(drawingsImages[i].ctx.canvas, 0, 0);
            coloredCtx.fillStyle = drawingsImages[i].color;
            coloredCtx.globalCompositeOperation = "source-in";
            coloredCtx.fillRect(0, 0, coloredCtx.canvas.width, coloredCtx.canvas.height);
            coloredCtx.globalCompositeOperation = "source-over";
            drawingsImages[i].currentColor = drawingsImages[i].color;
        }

        for (let i = 0; i < drawingsImages.length; i++) {
            if (drawingsImages[i].alpha > 0) {
                if (typeof drawingsImages[i].coloredCtx != 'undefined' ) {
                    originalImageCtx.globalAlpha = drawingsImages[i].alpha;
                    originalImageCtx.drawImage(drawingsImages[i].coloredCtx.canvas, 0, 0);
                }
            }
        }

    }
    /*var canvas = document.getElementById("petroglyphCanvas");
    ctx = canvas.getContext("2d");
    for (let i = 0; i < drawingsImages.length; i++) {
        ctx.drawImage(drawingsImages[i].image, 0, 0, this.width, this.height);
        ctx.globalAlpha = drawingsImages[i].alpha;
        ctx.fillStyle = drawingsImages[i].color;
    }*/
}
function initLayersSettings(jsonSettings) {
/*
    var supermenu = $('<div class="btn-group btn-group-sm container-supermenu" role="toolbar"></div>');
*/
    var drawings = jsonSettings.drawings
    if (Array.isArray(drawings)) {
        var inputAlpha = '<div id="rt_popover">';
        for (var i = 0; i < drawings.length; i++) {
            if (typeof drawings[i].layerParams.alpha != 'undefined') {
                alphaValue = drawings[i].layerParams.alpha;
                colorValue = drawings[i].layerParams.color;
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
