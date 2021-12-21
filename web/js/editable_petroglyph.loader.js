function prepareEditablePetroglyph() {
    //1. check if url params are not the same as params from db and update them if necessary
    putSettingsAsQueryParameters(settings);

    //2. put settings (= some from url + some from db) to url
    updateAllQueryParameters(settings)

    originalImage = new Image();
    originalImage.src = originalImageSrc;

    var drawingsImages = initDrawingsArray(jsonSettings = settings)
    var originalImageCtx = drawOriginalImage(originalImage)
    addImagesToContext(imagesArray = drawingsImages, contextToDrawOn = originalImageCtx)
    initLayersSettings(jsonSettings = settings)

    classNameContainer = 'layers-class'

    $('.' + classNameContainer)
        .on('input change', '.alpha-value', function () {
            $(this).attr('value', $(this).val());
            var newAlpha = parseFloat($(this).val());
            var drawingImageId = parseInt(($(this).attr('id')).split('_')[1]);
            drawingsImages[drawingImageId].alpha = newAlpha;
            updateAllLayers()
            updateOneQueryParameter(jsonSettings = settings, layerId = drawingImageId, key = "alpha", newValue = newAlpha);
        })

        .on('input change', '.color-value', function () {
            $(this).attr('value', $(this).val());
            var newColor = $(this).val();
            var drawingImageId = parseInt(($(this).attr('id')).split('_')[1]);
            drawingsImages[drawingImageId].color = newColor;
            updateAllLayers()
            updateOneQueryParameter(jsonSettings = settings, layerId = drawingImageId, key = "color", newValue = newColor);
        })

        .on('input change', '.title-value', function () {
            $(this).attr('value', $(this).val());
            var newTitle = $(this).val();
            var titleId = parseInt(($(this).attr('id')).split('_')[1]);
            var titleLabel = document.getElementById("descLabel_" + titleId)
            titleLabel.innerText= newTitle + ':';
        });

    var saveButton = document.getElementById("save-button");
    saveButton.addEventListener('click', function (event) {
        for (let i = 0; i < settings.drawings.length; i++) {
            settings.drawings[i].layerParams.title = document.getElementById("title_" + i).value;
            settings.drawings[i].layerParams.alpha = document.getElementById('alpha_' + i).value;
            settings.drawings[i].layerParams.color = document.getElementById('color_' + i).value;
            settings.drawings[i].layerParams.description = document.getElementById('desc_' + i).value;
        }
        mainDescription = document.getElementById('mainDesc').textContent;
        name = document.getElementById('name').value;

        var newData = {
            id: petroglyphId,
            newName: name,
            newDescription: mainDescription,
            newSettings: settings,
        };
        $.ajax({
            type: "POST",
            url: "/petroglyphs/web/index.php/petroglyph/save",
            data: {params: JSON.stringify(newData)},
            success: function (data) {;
                location.href = "http://localhost/petroglyphs/web/index.php/petroglyph/view?id=" + petroglyphId
            },
            error: function (xhr, status, error) {
                alert("Произошла ошибка при сохранении данных:" + xhr);
            }
        });
    })
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
