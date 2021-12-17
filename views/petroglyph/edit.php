<?php

use app\models\Petroglyph;
use yii\helpers\Html;

if(!empty($petroglyph)) {
    $this->title = "Редактирование";
} ?>
<style>
    h1 {
        margin-top: 30px;
        margin-bottom: 30px;
    }

    .box {
        display: flex;
    }

</style>

<h1> <?= $this->title ?>
</h1>

<label for="name">Название экспоната:</label>
<input type="text" id="name" value=" <?= $petroglyph->name ?>"/>

<p>
    <?php if (Yii::$app->user->can('updatePost',
        ['petroglyph' => $petroglyph])):?>
        <button type="button" class="btn btn-outline-secondary" id="save-button">Сохранить</button>
    <?php endif; ?>
</p>


<div class="box">
    <div style="padding-right: 20px;" class="box" id="instruments">
        //сетка/список с инструментами
    </div>

    <div class="container-petroglyph" data-state="static">
        <div class="canvas-petroglyph">
            <canvas id="petroglyphCanvas">
            </canvas>
        </div>
    </div>

    <div style="padding-left: 20px; margin-right: 20px" id="layers" class = "layers-class">
    </div>

    <div id="description">
    </div>

</div>

<div id="mainDesc" contenteditable="true" style="border:1px solid black; margin-top: 20px">
    <?= $petroglyph->description ?>
</div>

<p>
    ключевые слова: //$petroglyph->getTags()...
</p>
<p>
    ФИО автора: //$petroglyph->getAuthor()...
</p>
<script type="text/javascript">

    function updateSettingsWithUrlParameters(settings) {
        let params = (new URL(document.location.href)).searchParams;
        const keysToUpdateValue = ["alpha", "color"];
        for (let i = 0; i < settings.drawings.length; i++) {
            for(let j = 0; j < keysToUpdateValue.length; j++) {
                var specialKey = "drawings_" + i + "_layerParams_" + keysToUpdateValue[j];
                var value = params.get(specialKey)
                if(value != null) {
                    settings.drawings[i].layerParams[keysToUpdateValue[j]] = decodeURIComponent(value)
                }
                else {
                }
            }
        }
    }

    window.onload = function() {

        originalImageSrc = <?= "\"" . Petroglyph::PATH_STORAGE.Petroglyph::PATH_IMAGES.'/'.$petroglyph->image . "\"" ?>;
        settings = <?= $petroglyph->settings ?>;

        //1. check if url params are not the same as params from db and update them if necessary
        updateSettingsWithUrlParameters(settings);

        //2. put settings (= some from url + some from db) to url
        updateAllQueryParameters(settings)

        originalImage = new Image();
        originalImage.src = originalImageSrc;

        var drawingsImages = initDrawingsArray(jsonSettings = settings)
        var originalImageCtx = drawOriginalImage(originalImage)
        addImagesToContext(imagesArray = drawingsImages, contextToDrawOn = originalImageCtx)
        initLayersSettings(jsonSettings = settings)

        classNameContainer = 'layers-class'

        var saveButton = document.getElementById("save-button");
        saveButton.addEventListener('click', function (event) {
            for (let i = 0; i < settings.drawings.length; i++) {
                settings.drawings[i].layerParams.title = document.getElementById("title_" +i).value;
                settings.drawings[i].layerParams.alpha = document.getElementById('alpha_' + i).value;
                settings.drawings[i].layerParams.color = document.getElementById('color_' + i).value;
                settings.drawings[i].layerParams.description = document.getElementById('desc_' + i).value;
            }
            mainDescription = document.getElementById('mainDesc').value

    /* @property int id
* @property string name
* @property string description //description of petroglyph
* @property string image //link to an original image
* @property string settings */
    var data = [];
    data.push({ Company: "Microsoft", Location: "Redmond" , Total:123 });
    data.push({ Company: "UrbanScience", Location:"Detroit", Total:456 });

    $.ajax({
        type: "POST",
        url: '@Url.Action("ExportCalgary")',
        data: JSON.stringify(data),
        contentType: "application/json",
        success: function(data) {
            console.log("data :", data);
            // Do something with the response
        },
        error: function() {
            alert('Failed');
        }
    });
});

function updateAllLayers() {
    var originalImageCtx = drawOriginalImage(originalImage)
    addImagesToContext(imagesArray = drawingsImages, contextToDrawOn = originalImageCtx)
}

$('.' + classNameContainer)
    .on('input change', '.alpha-value', function () {
        $(this).attr('value', $(this).val());
        var newAlpha = parseFloat($(this).val());
        var drawingImageId = parseInt(($(this).attr('id')).split('_')[1]);
        drawingsImages[drawingImageId].alpha = newAlpha;
        updateAllLayers()
        updateQueryStringParameter(jsonSettings = settings, layerId = drawingImageId, key = "alpha", newValue = newAlpha);
    })

    .on('input change', '.color-value', function () {
        $(this).attr('value', $(this).val());
        var newColor = $(this).val();
        var drawingImageId = parseInt(($(this).attr('id')).split('_')[1]);
        drawingsImages[drawingImageId].color = newColor;
        updateAllLayers()
        updateQueryStringParameter(jsonSettings = settings, layerId = drawingImageId, key = "color", newValue = newColor);
    })

    .on('input change', '.title-value', function () {
        $(this).attr('value', $(this).val());
        var newTitle = $(this).val();
        var titleId = parseInt(($(this).attr('id')).split('_')[1]);
        var titleLabel = document.getElementById("descLabel_" + titleId)
        titleLabel.innerText= newTitle + ':';
});
}

function updateAllQueryParameters(jsonSettings) {
const keysToUpdateValue = ["alpha", "color"];
var drawings = jsonSettings.drawings;
for (let i = 0; i < drawings.length; i++) {
    var layerParams = drawings[i].layerParams
    for (var key in layerParams) {
        if(keysToUpdateValue.includes(key)) {
            var specialKey = "drawings_" + i + "_layerParams_" + key;
            uri = window.location.href
            var re = new RegExp("([?&])" + specialKey + "=.*?(&|$)", "i");
            var separator = uri.indexOf('?') !== -1 ? "&" : "?";
            if (uri.match(re)) {
                uri = uri.replace(re, '$1' + specialKey + "=" + encodeURIComponent(layerParams[key]) + '$2');
            } else {
                uri += (separator + specialKey + "=" + encodeURIComponent(layerParams[key]));
            }
            window.history.pushState("", "Page Title Here", uri);
        }
    }
}
}

function updateQueryStringParameter(jsonSettings, layerId, key, value) {

jsonSettings.drawings[layerId].layerParams[key] = value.toString()
updateAllQueryParameters(jsonSettings)
}

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
        var drawings = jsonSettings.drawings
        if (Array.isArray(drawings)) {
            var drawingsDescriptions = '';
            var inputAlpha = '<div id="drawings" style="width: 200px">';
            for (let i = 0; i < drawings.length; i++) {
                if (typeof drawings[i].layerParams.alpha != 'undefined') {
                    alphaValue = drawings[i].layerParams.alpha;
                    colorValue = drawings[i].layerParams.color;
                } else {
                    alphaValue = 1;
                }
                var layerId = "layer_" + i;
                inputAlpha += '<div id=\'' + layerId + '\' style="border:1px solid black">';

                var titleId = "title_" + i;
                var alphaId = "alpha_" + i;
                var colorId = "color_" + i;

                inputAlpha += '<input type="text" style="width: 200px" id=\'' + titleId + '\' class=\'title-value\' value=\'' + (drawings[i].layerParams.title) + '\'/>'
                    + '<br>'
                    + '<input type=\'range\' name="alphaChannel" id=\'' + alphaId + '\' class=\'alpha-value\' step=\'0.02\' min=\'0\' max=\'1\' value=\'' + alphaValue + '\' oninput=\"this.nextElementSibling.value = this.value\">'
                    + '<output>' + alphaValue + '</output>'
                    + '<br>'
                    + '<label for="drawingColor">Color:</label>'
                    + '<input type="color" id=\'' + colorId + '\' class =\'color-value\' value=\'' + colorValue + '\' name="drawingColor"></button>' + '<br>';
                inputAlpha += '</div>';

                var descId = "desc_" + i;
                var descLabelId = "descLabel_" + i;
                drawingsDescriptions += (
                    '<label for=\'' + descId + '\' id=\'' + descLabelId + '\'>'+ (drawings[i].layerParams.title) + ':' + '</label><br>'
                    + '<textarea id=\'' + descId + '\' style="width: 500px" >'
                + drawings[i].layerParams.description
                +'</textarea>'
                + '<br>')
            }

            inputAlpha += '</div>';
            var layersDiv = document.getElementById("layers");
            layersDiv.innerHTML = inputAlpha

            var descriptions = document.getElementById('description');
            descriptions.innerHTML = drawingsDescriptions
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
