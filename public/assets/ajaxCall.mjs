export default function sendAjaxCall (url, method, dataType, data, success, error) {
    $.ajax({
        url: url,
        method: method,
        dataType: dataType,
        data: data,
        success: success,
        error: error,
    });
}