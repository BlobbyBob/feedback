<div class="content p-4 col">

    <div class="mb-4 col-12">
        <h2 class="mb-4 float-left">Umfrage</h2>
        <button type="button" id="drop_changes" class="btn btn-danger float-right mb-4">Änderungen verwerfen</button>
        <button type="button" id="save_survey" class="btn btn-success float-right mb-4 mr-4">Änderungen speichern</button>
    </div>

    <?php if (isset($alert)): ?>
    <div class="mb-4 col-12" style="clear: both;">
        <?= $alert ?>
    </div>
    <?php endif; ?>

    <div class="card mb-4 col-12">

        <div class="sortable" id="form">
            <?php
                if (isset($formelements)) foreach ($formelements as $element) {
                    echo '<form class="sortable-item">'.$element.'</form>';
                }
            ?>
        </div>
        <div class="sortable">
            <div id="add_new" class="sortable-placeholder disabled" data-toggle="modal" data-target="#type_select">Neues Element hinzufügen</div>
        </div>
    </div>

    <?= $hidden_form ?>
        <input type="hidden" id="hidden_form_data" name="data" value="">
    </form>

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
                    <div class="typebutton" data-type="text" data-dismiss="modal">
                        <img class="typeicon" src="<?= base_url('resources/img/text.jpg') ?>">
                        <div class="typename">Textfeld</div>
                    </div>
                    <div class="typebutton" data-type="textarea" data-dismiss="modal">
                        <img class="typeicon" src="<?= base_url('resources/img/textarea.jpg') ?>">
                        <div class="typename">Großes Textfeld</div>
                    </div>
                    <div class="typebutton" data-type="rating" data-dismiss="modal">
                        <img class="typeicon" src="<?= base_url('resources/img/stars.jpg') ?>">
                        <div class="typename">Bewertung</div>
                    </div>
                    <div class="typebutton" data-type="checkbox" data-dismiss="modal">
                        <img class="typeicon" src="<?= base_url('resources/img/checkbox.jpg') ?>">
                        <div class="typename">Checkbox</div>
                    </div>
                    <div class="typebutton" data-type="select" data-dismiss="modal">
                        <img class="typeicon" src="<?= base_url('resources/img/select.jpg') ?>">
                        <div class="typename">Auswahlbox</div>
                    </div>
                    <div class="typebutton" data-type="numeric" data-dismiss="modal">
                        <img class="typeicon" src="<?= base_url('resources/img/numeric.jpg') ?>">
                        <div class="typename">Nummer</div>
                    </div>
                    <div class="typebutton pagebreak" data-type="pagebreak" data-dismiss="modal">
                        <hr>
                        <div class="typename">Seitenumbruch</div>
                    </div><!-- todo: add radio buttons -->
                </div>
            </div>
            <!--<div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal" >Auswählen</button>
            </div>-->
        </div>
    </div>
</div>