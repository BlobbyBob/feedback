<?php if ($datatype == 'rating'): ?>
    <?php
    $buckets = [];
    foreach ($data as $d) {
        if ( ! isset($buckets[$d]))
            $buckets[$d] = 1;
        else
            $buckets[$d]++;
    }
    $keys = [];
    $vals = [];
    foreach ($buckets as $key => $val) {
        $keys[] = $key.' Stern'.($key!=1?'e':'').' ('.$val.')';
        $vals[] = $val;
    }
    ?>
    <div class="col-lg-4 col-md-6 col-sm-12 mb-2">
        <div class="card">
            <div class="card-header">
                <span class="category"><?= $label ?></span>
            </div>
            <div class="card-body pie-container">
                <div id="graph-<?= $id ?>" class="ct-chart-pie ct-square ct-chart-gauge">
                </div>
            </div>
        </div>
    </div>

    <script>
        graph_data['#graph-<?= $id ?>'] = {
            type: "gauge",
            data: {
                labels: <?= json_encode($keys) ?>,
                series: <?= json_encode($vals) ?>
            },
            total: <?= array_sum($vals) ?>
        };
    </script>

<?php else: ?>
    <?php
    $buckets = [];
    foreach ($data as $d) {
        if ( ! isset($buckets[$d]))
            $buckets[$d] = 1;
        else
            $buckets[$d]++;
    }
    $graph_data = [];
    foreach ($buckets as $key => $val) {
        $graph_data[] = [
            'x' => $key,
            'y' => $val
        ];
    }
    ?>
    <div class="col-lg-4 col-md-6 col-sm-12 mb-2">
        <div class="card">
            <div class="card-header">
                <span class="category"><?= $label ?></span>
            </div>
            <div class="card-body">
                <div id="graph-<?= $id ?>" class="ct-chart-line ct-octave chart-binary">
                </div>
            </div>
        </div>
    </div>

    <script>
        graph_data['#graph-<?= $id ?>'] = {
            type: "line",
            data: {
                labels: <?= json_encode($keys) ?>,
                series: <?= json_encode($vals) ?>
            }
        };

    </script>
<?php endif; ?>