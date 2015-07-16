$(document).ready(function () {
    console.log(
        'ready'
    );

    $.post(__admin_bar_base_url + "admin_bar/admin_bar/index", {
        request: __admin_bar_url
    })
        .done(function (data) {
            $('body').prepend(data);
        });
});