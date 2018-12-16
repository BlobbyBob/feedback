<?php if ($datatype == 'rating'): ?>

    <div class="col-lg-4 col-md-6 col-sm-12 mb-2">
        <div class="card">
            <div class="card-header">
                <span class="category"><?= $label ?></span>
            </div>
            <div class="pie-container">
                <div id="graph-<?= $id ?>" class="ct-chart-pie ct-square chart-binary">
                </div>
            </div>
        </div>
    </div>

<?php else: ?>

<div class="col-lg-4 col-md-6 col-sm-12 mb-2">
    <div class="card">
        <div class="card-header">
            <span class="category"><?= $label ?></span>
        </div>
        <div class="pie-container">
            <div id="graph-<?= $id ?>" class="ct-chart-bar ct-square chart-binary">
            </div>
        </div>
    </div>
</div>

<?php endif; ?>