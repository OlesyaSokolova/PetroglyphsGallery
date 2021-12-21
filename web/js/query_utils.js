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
                window.history.pushState("", uri);
            }
        }
    }
}
function updateOneQueryParameter(jsonSettings, layerId, key, value) {

    jsonSettings.drawings[layerId].layerParams[key] = value.toString()
    updateAllQueryParameters(jsonSettings)
}

function putSettingsAsQueryParameters(settings) {
    let params = (new URL(document.location.href)).searchParams;
    const keysToUpdateValue = ["alpha", "color"];
    for (let i = 0; i < settings.drawings.length; i++) {
        for(let j = 0; j < keysToUpdateValue.length; j++) {
            var specialKey = "drawings_" + i + "_layerParams_" + keysToUpdateValue[j];
            var value = params.get(specialKey)
            if(value != null) {
                settings.drawings[i].layerParams[keysToUpdateValue[j]] = decodeURIComponent(value)
            }
        }
    }
}
