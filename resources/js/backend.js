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