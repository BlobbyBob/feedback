<script>
    var graph_data = {};
</script>
<div class="content p-4">

    <div class="mb-2 col-12">
        <h2>Ergebnisse</h2>
    </div>

    <?php if (isset($alert)): ?>
        <div class="mb-4 col-12">
            <?= $alert ?>
        </div>
    <?php endif; ?>

    <div class="card mb-4">
        <div class="card-header font-weight-bold"><?= $name ?></div>

        <div class="card-body container-fluid">
            <div class="row">
                <div class="col-lg-9 col-md-8 col-sm-12">
                    <div class="card mb-4">
                        <div class="card-header">
                            <span class="category">Aktivität</span>
                        </div>
                        <div id="date_graph" class="ct-chart ct-double-octave">
                        </div>
                        <small>Hinweis: XXX</small>
                    </div>
                </div>

                <div class="col-lg-3 col-md-4 col-sm-6 mb-2">
                    <div class="card">
                        <div class="card-header">
                            <span class="category">Umfrageeffizienz</span>
                        </div>
                        <div class="pie-container">
                            <div id="participation_graph" class="ct-chart-pie ct-square chart-binary">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row d-flex">
                <?php foreach ($stats as $stat): ?>
                    <?= $stat ?>
                <?php endforeach; ?>
            </div>

        </div>
    </div>
</div>

<script>
    var date_graph_data = <?= $date_graph ?>;
    for (let i = 0; i < date_graph_data.length; i++) {
        date_graph_data[i].x = new Date(1000 * date_graph_data[i].x);
    }
    var participaton_graph = <?= $participation_graph ?>;
</script>