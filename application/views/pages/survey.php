<div class="sidebar-wrapper">

    <!-- Sidebar  -->
    <div id="sidebar" class="wide">
        <div class="sidebar-header">
            <h3>Route</h3>
        </div>

        <div>
            <img width="360" src="https://www.klettern.de/sixcms/media.php/6/KL-Einste-Wand-IMG_2139.jpg"/>
        </div>

    </div>

    <!-- Page Content  -->
    <div id="content" class="narrow">
        <div class="container">
            <h1>Feedback <span class="badge badge-success d-md-none"><i class="fa fa-align-left"></i>Route anzeigen</span></h1>
            <p class="line"></p>
            <div class="progress">
                <div id="progressbar" class="progress-bar progress-bar-striped" role="progressbar" style="width: 0;"></div>
            </div>
            <p class="line"></p>
            <form>
                <div id="survey">

                    <div id="spacer">

                    </div>

                    <div class="pagewrapper" data-page="1" data-progress="5" data-active="1">
                        <div class="page d-flex flex-column">
                            <div class="formelement form-group">
                                <label for="field-2">Bewertung:</label>
                                <div class="starrating risingstar d-flex justify-content-center flex-row-reverse align-items-center">
                                    <span>Sehr gut</span>
                                    <input id="star16" type="radio" name="rating" value="6"/><label for="star16"></label>
                                    <input id="star15" type="radio" name="rating" value="5"/><label for="star15"></label>
                                    <input id="star14" type="radio" name="rating" value="4"/><label for="star14"></label>
                                    <input id="star13" type="radio" name="rating" value="3"/><label for="star13"></label>
                                    <input id="star12" type="radio" name="rating" value="2"/><label for="star12"></label>
                                    <input id="star11" type="radio" name="rating" value="1"/><label for="star11"></label>
                                    <span>Sehr schlecht</span>
                                </div>
                            </div>
                            <div class="formelement form-group">
                                <label for="field-0">Feedback:</label>
                                <textarea id="field-0" class="form-control" name="field-0"></textarea>
                            </div>
                            <div class="formelement form-group">
                                <label for="field-1">Anmerkungen:</label>
                                <input id="field-1" type="text" class="form-control" name="field-1" placeholder="z.B. Ich wünsche mir, dass kaputte Lampen ausgetauscht werden" maxlength="127">
                            </div>
                        </div>
                    </div>
                    <div class="pagewrapper" data-page="2" data-progress="80" data-active="0" style="display: none;">
                        <div class="page d-flex flex-column finished justify-content-center">
                            <h3 class="center">Umfrage beendet</h3>
                            <button type="submit" class="btn btn-primary">Abschließen</button>
                        </div>
                    </div>

                    <p class="line"></p>
                    <div class="controls d-flex justify-content-between align-items-center">
                        <button type="button" id="prev" aria-label="Vorherige Seite" disabled class="btn btn-outline-primary">
                            <i class="fa fa-arrow-left"></i>
                        </button>
                        <p>Seite <span id="cur_page">1</span> von <span id="tot_page">2</span></p>
                        <button type="button" id="next" aria-label="Nächste Seite" class="btn btn-outline-primary">
                            <i class="fa fa-arrow-right"></i>
                        </button>
                    </div>

                </div>
            </form>
        </div>

    </div>

</div>