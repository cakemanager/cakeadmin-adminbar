$(document).ready(function () {

    $('body').prepend('<nav class="adminbar-top"></nav>');

    $.post(__admin_bar_base_url + "admin_bar/admin_bar/index", {
        request: __admin_bar_url
    })
        .done(function (data) {
            $('.adminbar-top').prepend(data);
        });
});