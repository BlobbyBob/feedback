// Collapsable sidebar
$(document).ready(function () {
    // $("#sidebar").mCustomScrollbar({
    //     theme: "minimal"
    // });

    $('#dismiss').on('click', function () {
        $('#sidebar').removeClass('active');
    });

    $('#sidebarCollapse').on('click', function () {
        $('#sidebar').toggleClass('active');
        $('.collapse.in').toggleClass('in');
        $('a[aria-expanded=true]').attr('aria-expanded', 'false');
    });
});