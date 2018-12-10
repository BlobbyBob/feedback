<div class="content p-4 col">

    <h2 class="mb-4">Umfrage</h2>

    <div class="card mb-4 col-12">

        <div class="sortable">
            <div class="sortable-item">Item 1</div>
            <div class="sortable-item">Item 2</div>
            <div id="add_new" class="sortable-placeholder disabled" data-toggle="modal" data-target="#type_select">Neues Element hinzufügen</div>
        </div>

    </div>

</div>

<div class="modal fade" id="type_select" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Feldtyp auswählen</h5>
                <button type="button" class="close" aria-label="Close" data-dismiss="modal">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="buttons d-flex flex-wrap justify-content-center">
                    <div class="typebutton">
                        <img class="typeicon" src="<?= base_url('resources/img/text.jpg') ?>">
                        <div class="typename">Textfeld</div>
                    </div>
                    <div class="typebutton">
                        <img class="typeicon" src="<?= base_url('resources/img/textarea.jpg') ?>">
                        <div class="typename">Großes Textfeld</div>
                    </div>
                    <div class="typebutton">
                        <img class="typeicon" src="<?= base_url('resources/img/stars.jpg') ?>">
                        <div class="typename">Bewertung</div>
                    </div>
                    <div class="typebutton">
                        <img class="typeicon" src="<?= base_url('resources/img/checkbox.jpg') ?>">
                        <div class="typename">Checkbox</div>
                    </div>
                    <div class="typebutton">
                        <img class="typeicon" src="<?= base_url('resources/img/radio.jpg') ?>">
                        <div class="typename">Radio buttons</div>
                    </div>
                    <div class="typebutton">
                        <img class="typeicon" src="<?= base_url('resources/img/numeric.jpg') ?>">
                        <div class="typename">Nummer</div>
                    </div>
                    <div class="typebutton pagebreak">
                        <hr>
                        <div class="typename">Seitenumbruch</div>
                    </div>
                </div>
            </div>
            <!--<div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal" >Auswählen</button>
            </div>-->
        </div>
    </div>
</div>