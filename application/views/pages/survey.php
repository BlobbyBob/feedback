<div class="sidebar-wrapper">

    <!-- Sidebar  -->
    <div id="sidebar" class="wide">
        <div class="sidebar-header">
            <h3>Route</h3>
        </div>

        <div>
            <img width="360" src="<?php echo $img_src; ?>"/>
        </div>

    </div>

    <!-- Page Content  -->
    <div id="content" class="narrow">
        <div class="container">
            <h1>Feedback <span class="badge badge-success d-md-none" id="sidebarCollapse"><i class="fa fa-align-left"></i>Route anzeigen</span></h1>
            <p class="line"></p>
            <div class="progress">
                <div id="progressbar" class="progress-bar progress-bar-striped" role="progressbar" style="width: 0;"></div>
            </div>
            <p class="line"></p>
            <?php echo $form; ?>
                <div id="survey">

                    <div id="spacer">

                    </div>
                    <?php foreach ($pages as $index => $page): ?>
                        <div class="pagewrapper" data-page="<?php echo $index; ?>"
                             data-progress="<?php echo $progress[$index]; ?>"
                             data-active="<?php echo $index == 1 ? 1 : 0; ?>" <?php if ($index != 1) echo "style=\"display: none;\""; ?>>
                        <div class="page d-flex flex-column">
                            <?php echo $page; ?>
                        </div>
                        </div>
                    <?php endforeach; ?>

                    <div class="pagewrapper" data-page="<?php echo $max_page; ?>" data-progress="100" data-active="0" style="display: none;">
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
                        <p>Seite <span id="cur_page">1</span> von <span id="tot_page"><?php echo $max_page; ?></span></p>
                        <button type="button" id="next" aria-label="Nächste Seite" class="btn btn-outline-primary">
                            <i class="fa fa-arrow-right"></i>
                        </button>
                    </div>

                </div>
            </form>
        </div>

    </div>

</div>