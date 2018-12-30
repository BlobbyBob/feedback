$(function(){
    $("input[type=checkbox]").on('change', function (e) {
        let hid = $("#"+$(this).attr('id')+"-hid");
        if ($(this).is(":checked")) {
            hid.removeAttr("name");
        } else {
            hid.attr("name", $(this).attr("name"));
        }
    });
});

////////////////
// Pagination //
////////////////

var cur_page = 1;
var tot_page;
var animation_time = 900;
$(function () {
    tot_page = parseInt($('#tot_page').text());
    $('#prev').click(function () {
        cur_page--;
        refreshPagination();
    });
    $('#next').click(function () {
        cur_page++;
        refreshPagination();
    });
    refreshPagination();
});

function refreshPagination() {
    if (cur_page < 1) cur_page = 1;
    if (cur_page > tot_page) cur_page = tot_page;
    var active_page = $('.pagewrapper[data-active=1]').first().data('page');
    if (cur_page != active_page) {
        var oldp = $('.pagewrapper[data-page=' + active_page + ']');
        var newp = $('.pagewrapper[data-page=' + cur_page + ']');
        var spacer = $('#spacer');
        oldp.attr('data-active', '0');
        newp.attr('data-active', '1');
        spacer.css({height: oldp.height()}).animate({
            height: ((oldp.height() - newp.height() > 0) ? "-" : "+") + "=" + Math.abs(oldp.height() - newp.height())
        }, animation_time, function () {
            spacer.css({height: 0});
        });
        oldp.css({position: 'absolute', top: 0, left: 0}).animate({
            left: (cur_page < active_page ? "+" : "-") + "=" + ($(oldp).width()),
            opacity: 0
        }, animation_time, function () {
            $(this).css({left: 0, opacity: 1, display: 'none', position: 'relative'});
        });
        newp.css({
            left: (cur_page < active_page ? -1 : +1) * $(newp).width(),
            opacity: 0,
            display: 'block',
            top: 0,
            position: 'absolute'
        }).animate({
            left: (cur_page < active_page ? "+" : "-") + "=" + $(newp).width(),
            opacity: 1
        }, animation_time, function () {
            $(this).css({position: 'relative'});
        });


    }
    if (cur_page == 1)
        $('#prev').attr('disabled', 'disabled');
    else
        $('#prev').removeAttr('disabled');
    if (cur_page == tot_page)
        $('#next').attr('disabled', 'disabled');
    else
        $('#next').removeAttr('disabled');
    $('#cur_page').text(cur_page);
    $('#progressbar').css('width', $('.pagewrapper[data-page=' + cur_page + ']').data('progress') + "%");
}
