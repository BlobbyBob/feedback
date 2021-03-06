<?php
$colors = [
    '#0074D9',
    '#FF851B',
    '#01FF70',
    '#B10DC9',
    '#7FDBFF',
    '#FF4136',
    '#FFDC00',
    '#85144b',
    '#39CCCC',
    '#F012BE',
    '#3D9970'
];
?>
<div class="col-md-4 col-sm-6 mb-2">
    <div class="card">
        <div class="card-header">
            <span class="category"><?= $label ?></span>
        </div>
        <div class="card-body evaluation-options">
            <?php $total = 0; foreach ($options as $o) $total += $o['value']; ?>
            <?php foreach ($options as $i => $option): ?>
            <?php $value = round(100 * $option['value'] / $total,2); ?>
            <p class="mb-2"><?= $option['key'] ?></p>
            <div class="progress mb-3">
                <div class="progress-bar bg-primary <?php if (!$value) echo 'text-dark'; ?>" role="progressbar" style="width: <?= $value ?>%;background-color: <?= $colors[$i%count($colors)]; ?> !important;" aria-valuemin="0" aria-valuemax="100" aria-valuenow="<?= $value ?>"><?= $value ?>%</div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>