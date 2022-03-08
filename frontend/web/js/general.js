function addOverLayer(id) {
    let overLayer = document.createElement("div");
    overLayer.id = id;
    overLayer.innerHTML = '<div onclick="this.closest(\'.overlayer\').remove()" class="overlayer-bg">&nbsp;</div>'
    overLayer.classList.add('overlayer');
    document.body.after(overLayer);
    return overLayer;
}

function removeById(id) {
    let elem = document.getElementById(id);
    elem.parentNode.removeChild(elem);
}

function sendAjaxByGet(url, requestData) {
    return $.ajax({
        url: url,
        method: 'get',
        type: 'get',
        data: requestData,
        async: false,
        contentType: "application/json; charset=utf-8",
        dataType: "json",
    });
}

function buildOverLayerForm(url, data = {},  id = '') {
    let request = sendAjaxByGet(url, data);
    request.then(function(response) {
        if(response.html) {
            let newOverLayer = addOverLayer(id);
            newOverLayer.innerHTML = newOverLayer.innerHTML + response.html;
        }
    });
}

function createAlert(content, type = 'info') {
    let alertsStack = document.getElementById('alertsStack');
    let newAlert = document.createElement("div");
    newAlert.classList.add('alert');
    newAlert.classList.add('alert-' + type);
    newAlert.style.transition = '0.5s ease';
    newAlert.style.opacity = '0';
    newAlert.style.width = '100%';
    newAlert.innerHTML = content;
    alertsStack.append(newAlert);
    setTimeout(function() {
        newAlert.style.opacity = '1';
    }, 10);
    setTimeout(function() {
        removeAlert(newAlert);
    }, 5000);
    return newAlert;
}

function removeAlert(alert) {
    alert.style.opacity = '0';
    setTimeout(function() {
        alert.style.height = '0';
    }, 500);
    setTimeout(function() {
        alert.parentNode.removeChild(alert);
    }, 1000);
}

