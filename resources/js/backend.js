$(function () {
    $('#image_select .image-grid').click(function(){
        console.log("click");
        $('.image-grid').removeClass('selected');
        $(this).addClass('selected');
        $('input[name=image]').val($(this).data('id'));
    });

    if (typeof $().DataTable === "function")
        $('.data-table').DataTable({
            'language': {
                "sEmptyTable":      "Keine Daten in der Tabelle vorhanden",
                "sInfo":            "_START_ bis _END_ von _TOTAL_ Einträgen",
                "sInfoEmpty":       "Keine Daten vorhanden",
                "sInfoFiltered":    "(gefiltert von _MAX_ Einträgen)",
                "sInfoPostFix":     "",
                "sInfoThousands":   ".",
                "sLengthMenu":      "_MENU_ Einträge anzeigen",
                "sLoadingRecords":  "Wird geladen ..",
                "sProcessing":      "Bitte warten ..",
                "sSearch":          "",
                "sSearchPlaceholder": "Suchen",
                "sZeroRecords":     "Keine Einträge vorhanden",
                "oPaginate": {
                    "sFirst":       "Erste",
                    "sPrevious":    "Zurück",
                    "sNext":        "Nächste",
                    "sLast":        "Letzte"
                },
                "oAria": {
                    "sSortAscending":  ": aktivieren, um Spalte aufsteigend zu sortieren",
                    "sSortDescending": ": aktivieren, um Spalte absteigend zu sortieren"
                },
                "select": {
                    "rows": {
                        "_": "%d Zeilen ausgewählt",
                        "0": "",
                        "1": "1 Zeile ausgewählt"
                    }
                },
                "buttons": {
                    "print":    "Drucken",
                    "colvis":   "Spalten",
                    "copy":     "Kopieren",
                    "copyTitle":    "In Zwischenablage kopieren",
                    "copyKeys": "Taste <i>ctrl</i> oder <i>\u2318</i> + <i>C</i> um Tabelle<br>in Zwischenspeicher zu kopieren.<br><br>Um abzubrechen die Nachricht anklicken oder Escape drücken.",
                    "copySuccess": {
                        "_": "%d Spalten kopiert",
                        "1": "1 Spalte kopiert"
                    }
                }
            }
        });

    if (typeof sortable === "function")
        sortable('.sortable', {
            items: ':not(.disabled)',
            forcePlaceholderSize: true,
            placeholderClass: 'sortable-placeholder',
            hoverClass: 'hover'
        });

    $('#save_survey').click(function(){
        let form = $("#form");
        var i = 1;
        // Set correct index values
        form.children().each(function(index, elem){
            $(elem).find("input[name=index]").val(i++);
        });
        var data = [];
        form.find("form").each(function(index, elem){
            let d = $(elem).serializeArray();
            let e = {};
            for (let i = 0; i < d.length; i++) {
                e[decodeURIComponent(d[i]["name"])] = decodeURIComponent(d[i]["value"]);
            }
            data[data.length] = e;
        });
        $('#hidden_form_data').val(JSON.stringify(data));
        $('#hidden_form').submit();
    });

    $('.typebutton').click(function () {
        $.get({
            url: "../ajax/formelements/" + $(this).data('type') + "/settings",
            success: function (data) {
                $('<form class="sortable-item">' + data + '</form>').appendTo('#form');
            }
        });
    });

    $('.delete-element').click(function () {
        $('<input type="hidden" name="deleted" value="1">').appendTo($(this).parent());
        $(this).closest(".sortable-item").hide();
    });

    $('#drop_changes').click(function () {
        location = location.href;
    });
});

$(function(){

    // Date Graph
    if (typeof date_graph_data !== 'undefined')
    {
        let x = [], y = [];

        for (let i = 0; i < date_graph_data.length; i++) {
            x[x.length] = date_graph_data[i][x];
            y[y.length] = date_graph_data[i][y];
        }

        new Chartist.Line('#date_graph', {
            series: [
                {
                    name: 'Activity',
                    data: date_graph_data
                }
            ]
        }, {
            showArea: true,
            axisX: {
                type: Chartist.FixedScaleAxis,
                divisor: 5,
                labelInterpolationFnc: function (value) {
                    return moment(value).format('D.M');
                }
            },
            axisY: {
                low: 0,
                onlyInteger: true,
                type: Chartist.AutoScaleAxis
            },
            plugins: [
                Chartist.plugins.ctAxisTitle({
                    axisX: {
                        axisTitle: 'Datum',
                        axisClass: 'ct-axis-title',
                        offset: {
                            x: 0,
                            y: 15
                        },
                        textAnchor: 'middle'
                    },
                    axisY: {
                        axisTitle: 'Beantwortete Fragen',
                        axisClass: 'ct-axis-title',
                        offset: {
                            x: 0,
                            y: -10
                        },
                        textAnchor: 'middle',
                        flipTitle: false
                    }
                })
            ]
        });
    }

    // Participation Graph
    if (typeof Chartist !== "undefined")
    {
        new Chartist.Pie('#participation_graph', {
            labels: ['Nicht beantwortet', 'Beantwortet'],
            series: participaton_graph
        }, {
            labelOffset: 0,
            labelDirection: 'explode',
            labelInterpolationFnc: function(val) {
                return val;
            }
        });
    }

    if (typeof graph_data !== "undefined")
    for (let p in graph_data) {
        let info = graph_data[p];
        if (info.type === "gauge") {

            new Chartist.Pie(p, info.data, {
                total: info.total
            });

        } else if (info.type === "line") {

            new Chartist.Line(p, info.data, {
                lineSmooth: Chartist.Interpolation.cardinal({
                    fillHoles: true,
                }),
                axisX: {
                    type: Chartist.AutoScaleAxis
                },
                axisY: {
                    low: 0,
                    onlyInteger: true,
                    type: Chartist.AutoScaleAxis
                }
            });

        }
    }

});