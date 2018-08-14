$(function () {

    // Reset inputs
    $('#colors').val('');
    $('.big-color.selected').each(function () {
        var colors = $('#colors');
        colors.val(colors.val() + $(this).data('value') + ',');
    });
    $('#ropes').val('');
    $('.zone.active').each(function () {
        var ropes = $('#ropes');
        var zone = $(this);
        if (zone.attr('id') === 'zone3-4') {
            ropes.val(ropes.val() + '03,04,');
        } else {
            ropes.val(ropes.val() + zone.attr('id').replace('zone', '') + ',');
        }
    });

    $("#filter-grade").slider({
        'tooltip': 'hide'
    }).on('slide', function (e) {
        $('#filter-grade-range').html(roman(e.value[0]) + ' - ' + roman(e.value[1]));
        applyFilter();
    });

    $('#filter-colors > .big-color').click(function () {
        var colors = $('#colors');
        if ($(this).hasClass('selected')) {
            $(this).removeClass('selected');
            colors.val(colors.val().replace($(this).data('value') + ',', ''));
        } else {
            $(this).addClass('selected');
            colors.val(colors.val() + $(this).data('value') + ',');
        }
        applyFilter();
    });

    $('#filter-ropes .clickzone').click(function () {
        var zone = $('#' + $(this).attr('id').replace('click', ''));
        var ropes = $('#ropes');
        if (zone.hasClass('active')) {
            zone.removeClass('active');
            if (zone.attr('id') === 'zone3-4') {
                ropes.val(ropes.val().replace('03,', '').replace('04,', ''));
            } else {
                ropes.val(ropes.val().replace(zone.attr('id').replace('zone', '') + ',', ''));
            }
        } else {
            zone.addClass('active');
            if (zone.attr('id') === 'zone3-4') {
                ropes.val(ropes.val() + '03,04,');
            } else {
                ropes.val(ropes.val() + zone.attr('id').replace('zone', '') + ',');
            }
        }
        applyFilter();
    });

});

function roman(n) {
    switch (n) {
        case 1:
            return 'I';
        case 2:
            return 'II';
        case 3:
            return 'III';
        case 4:
            return 'IV';
        case 5:
            return 'V';
        case 6:
            return 'VI';
        case 7:
            return 'VII';
        case 8:
            return 'VIII';
        case 9:
            return 'IX';
        case 10:
            return 'X';
    }
    return n;
}

function applyFilter() {
    var grade = $('#filter-grade').val().split(',');
    var colors = $('#colors').val().split(',');
    var ropes = $('#ropes').val().split(',');
    $(".route").each(function () {
        var info = $(this).data('sort');
        if (info.grade >= grade[0] && info.grade <= grade[1] &&
            colors.indexOf(info.color) != -1 &&
            ropes.indexOf(formatNumber(info.rope, 2)) != -1) {
            $(this).show();
        } else {
            $(this).hide();
        }
    });
}

function formatNumber(num, length) {
    var r = "" + num;
    while (r.length < length) {
        r = "0" + r;
    }
    return r;
}