function Global() {
    var data = {
        'apiUrl': 'http://portal.netcastdigital.net/getInfo.php'
    };

    this.getApiUrl = function () {
        return data.apiUrl;
    };

    this.api = function (data, callback_success, callback_error, callback_complete) {
        var url = this.getApiUrl() + '?conf=myconf&max_users_msg=' + data.max;
        $.ajax({
            type: 'GET',
            url: url,
            crossDomain: false,
            cache: false
        }).success(function (data) {
            callback_success(data);
        }).error(function (xhr, status, error) {
            callback_error(xhr, status, error);
        }).complete(function () {
            callback_complete();
        });
    };
    
    this.apiGetHtmlContainer = function (callback_success, callback_error, callback_complete) {
        var url = this.getApiUrl() + '?conf=myconf&html_container=1';
        alert(url);
        $.ajax({
            type: 'GET',
            url: url,
            crossDomain: false,
            cache: false
        }).success(function (data) {
            callback_success(data);
        }).error(function (xhr, status, error) {
            callback_error(xhr, status, error);
        }).complete(function () {
            callback_complete();
        });
    };
}

var global = new Global();