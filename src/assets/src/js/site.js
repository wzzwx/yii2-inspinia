inspinaMenu = {
    markActive: function () {
        var key = location.pathname.split("/")[2], id;
        if (!(id = key)) {
            id = 'default';
        }
        var pos = $("#" + id);
        if (!pos[0]) {
            return;
        }
        for (; pos.attr('id') !== 'side-menu' && !pos.is('body'); pos = pos.parent()) {
            if (pos.is('li'))
                pos.addClass('active');
            if (pos.is('ul'))
                pos.addClass('in');
        }
    }
};
$(document).ready(function () {
    if (Cookies.get('inspinia_mini_navbar') == 1) {
        $('body').addClass('mini-navbar');
    }

    $('.navbar-minimalize').click(function () {
        if ($("body").hasClass("mini-navbar")) {
            Cookies.set('inspinia_mini_navbar', 1, {expires: 365, path: '/'});
        } else {
            Cookies.set('inspinia_mini_navbar', 0, {expires: 365, path: '/'});
        }
    });

    $('#crud-datatable-pjax').on('pjax:end', function () {
        $('[data-toggle="tooltip"]').tooltip();
        $('[data-toggle="popover"]').popover();
        return false;
    });

    $("nav .navbar-top-links").hover(
        function () {
            $(".dropdown-toggle", $(this)).dropdown("toggle");
        },
        function () {
            $(this).click();
        });
    inspinaMenu.markActive();
});
