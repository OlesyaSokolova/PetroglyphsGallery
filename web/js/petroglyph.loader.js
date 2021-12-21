function prepareView() {
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
            var drawingImageId = parseInt($(this).attr('id'));
            drawingsImages[drawingImageId].alpha = newAlpha;
            updateAllLayers(drawingsImages)
            updateOneQueryParameter(jsonSettings = settings, layerId = drawingImageId, key = "alpha", newValue = newAlpha);
        })
        .on('input change', '.color-value', function () {
            $(this).attr('value', $(this).val());
            var newColor = $(this).val();
            var drawingImageId = parseInt($(this).attr('id'));
            drawingsImages[drawingImageId].color = newColor;
            updateAllLayers()
            updateOneQueryParameter(jsonSettings = settings, layerId = drawingImageId, key = "color", newValue = newColor);
        });

    if (settings.drawings.length !== 0) {
        var descriptionDiv = document.getElementById('description');
        descriptionDiv.innerText = settings.drawings[0].layerParams.description;
        document.getElementById('layer_' + 0).style.background = "#d6d5d5";
    }
}

function initLayersSettings(jsonSettings) {
    var drawings = jsonSettings.drawings
    if (Array.isArray(drawings)) {
        var inputAlpha = '<div id="drawings" style="width: 200px">';
        for (let i = 0; i < drawings.length; i++) {
            if (typeof drawings[i].layerParams.alpha != 'undefined') {
                alphaValue = drawings[i].layerParams.alpha;
                colorValue = drawings[i].layerParams.color;
            } else {
                alphaValue = 1;
            }
            var currentId = "layer_" + i;
            inputAlpha += '<div id=\'' + currentId + '\' style="border:1px solid black">';


            inputAlpha += (drawings[i].layerParams.title) + '<br>'
                + '<input type=\'range\' name="alphaChannel" id=\'' + i + '\' class=\'alpha-value\' step=\'0.02\' min=\'0\' max=\'1\' value=\'' + alphaValue + '\' oninput=\"this.nextElementSibling.value = this.value\">'
                + '<output>' + alphaValue + '</output>'
                + '<br>'
                + '<label for="drawingColor">Color:</label>'
                + '<input type="color" id=\'' + i + '\' class =\'color-value\' value=\'' + colorValue + '\' name="drawingColor"></button>' + '<br>';
            inputAlpha += '</div>';
        }
        inputAlpha += '</div>';
        var layersDiv = document.getElementById("layers");
        layersDiv.innerHTML = inputAlpha

        var descriptionDiv = document.getElementById('description');
        for (let i = 0; i < drawings.length; i++) {
            document.getElementById('layer_' + i)
                .addEventListener('click', function (event) {
                    descriptionDiv.innerText = drawings[i].layerParams.description
                    this.style.background = "#d6d5d5";

                    function clearOtherLayersDivs(i) {
                        for (let j = 0; j < drawings.length; j++) {
                            if(i !== j) {
                                document.getElementById('layer_' + j).style.background = "#ffffff";
                            }
                        }
                    }

                    clearOtherLayersDivs(i)
                });
        }
    }
}

