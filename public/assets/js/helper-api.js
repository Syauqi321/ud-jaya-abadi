function apiRequest(method, url, data, onSuccess, onError = function(){}) {
    let formData = new FormData();
    let contentType = false;
    let headers = {};

    try {
        headers = { Authorization: getAuthorization() };
    } catch (error) {
        // Jika terjadi error saat mengambil authorization, biarkan headers kosong
    }

    // Jika metode GET, tambahkan data sebagai query string ke URL
    if (method === 'GET') {
        const queryParams = new URLSearchParams(data).toString();
        url += '?' + queryParams;
    } else {
        // Jika bukan GET, proses data sesuai dengan kebutuhan (FormData atau URL encoded)
        for (let key in data) {
            if (data.hasOwnProperty(key)) {
                if (Array.isArray(data[key])) {
                    // Jika nilai adalah array
                    for (let i = 0; i < data[key].length; i++) {
                        formData.append(`${key}[${i}]`, data[key][i]);
                    }
                } else {
                    // Jika nilai bukan array
                    formData.append(key, data[key]);
                }
            }
        }

        if (method === 'PUT' || method === 'PATCH') {
            formData = new URLSearchParams(formData).toString();
            contentType = 'application/x-www-form-urlencoded';
        }
    }

    $.ajax({
        url: url,
        type: method,
        headers: headers,
        data: method === 'GET' ? null : formData,
        processData: false,
        contentType: contentType
    }).done(function (response) {
        onSuccess(response);
    }).fail(function (jqXHR, textStatus, errorThrown) {
        onError(jqXHR, textStatus, errorThrown);
    });
}

function setLoading(e, loading) {
    if (loading) {
        e.attr('data-text-old', e.text());
        e.html('<i class="fa fa-spinner fa-spin"></i>&nbsp;Loading...');
        e.addClass('disabled');
    } else {
        const text = e.attr('data-text-old');
        e.text(text);
        e.removeClass('disabled');
    }
}

function showMessage(type, message) {
    toastr.options = {
        "closeButton": false,
        "debug": false,
        "newestOnTop": false,
        "progressBar": true,
        "positionClass": "toast-top-right",
        "preventDuplicates": false,
        "onclick": null,
        "showDuration": "300",
        "hideDuration": "1000",
        "timeOut": "3500",
        "extendedTimeOut": "1000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut",
    };

    toastr[type](message);
}

function toIdr(number) {
    if(number == null){
        return 0;
    }
    return (number.toString().replace('.',',')).toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.');
}

function getBase64(file, storageKey) {
    var reader = new FileReader();
    reader.readAsDataURL(file);
    reader.onload = function () {
        sessionStorage.setItem(storageKey, reader.result);
    };
    reader.onerror = function (error) {
        console.log('Error: ', error);
    };
}

function encodeData(obj) {
    let jsonStr = JSON.stringify(obj);
    jsonStr = jsonStr
        .replace(/&/g, '&amp;')
        .replace(/'/g, '&#39;')
        .replace(/"/g, '&#34;')
        .replace(/</g, '&lt;')
        .replace(/>/g, '&gt;');

    return btoa(encodeURIComponent(jsonStr));
}

function decodeData(encodedStr) {
    let decodedStr = decodeURIComponent(atob(encodedStr));
    decodedStr = decodedStr
        .replace(/&gt;/g, '>')
        .replace(/&lt;/g, '<')
        .replace(/&#34;/g, `"`)
        .replace(/&#39;/g, `'`)
        .replace(/&amp;/g, '&');

    return JSON.parse(decodedStr);
}

