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
        $keys[] = $key.'* ('.$val.')';
        $vals[] = $val;
    }
    ?>
    <div class="col-lg-4 col-md-6 col-sm-12 mb-2">
        <div class="card">
            <div class="card-header">
                <span class="category"><?= $label ?></span>
            </div>
            <div class="card-body pie-container">
                <div id="graph-<?= $id ?>" class="ct-chart-pie ct-square chart-binary">
                </div>
            </div>
        </div>
    </div>

    <script>// todo: move this into a JS resource file
        new Chartist.Pie('#graph-<?= $id ?>', {
            labels: <?= json_encode($keys) ?>,
            series: <?= json_encode($vals) ?>
        }, {
            donut: true,
            donutWidth: 60,
            donutSolid: true,
            startAngle: 270,
            total: 200,
            showLabel: true
        });
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
                <div id="graph-<?= $id ?>" class="ct-chart-bar ct-square chart-binary">
                </div>
            </div>
        </div>
    </div>

    <script>
    new Chartist.Line('#graph-<?= $id ?>', {
        series: [
            {
                name: '<?= $label ?>',
                data: <?= json_encode($graph_data) ?>
            }
        ]
    }, {
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
    </script>
<?php endif; ?>