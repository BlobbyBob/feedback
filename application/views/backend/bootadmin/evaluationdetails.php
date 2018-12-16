<div class="content p-4">

    <div class="mb-4 col-12">
        <h2>Ergebnisse</h2>
    </div>

    <?php if (isset($alert)): ?>
        <div class="mb-4 col-12">
            <?= $alert ?>
        </div>
    <?php endif; ?>

    <div class="card mb-4">
        <div class="card-header font-weight-bold"><?= $name ?></div>
        <div class="card-body">
            <div id="date_graph">
                <h3 class="align-center mb-3">Aktivität</h3>
            </div>
            <small>Hinweis: XXX</small>
        </div>
    </div>
</div>

<script>
    var date_graph_data = <?= $date_graph ?>;
    for (let i = 0; i < date_graph_data.length; i++) {
        date_graph_data[i].x = new Date(1000 * date_graph_data[i].x);
    }
</script>