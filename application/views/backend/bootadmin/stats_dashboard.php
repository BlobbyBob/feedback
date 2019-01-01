<?php
if ($type == 'numbers' && $datatype == 'rating' && count($data) > 0):
    // Set variables
    $mean = 0;
    $limit_min = 0;
    $limit_max = 1;
    foreach ($numbers as $number) {
        $key = $number['key'];
        $value = $number['value'];
        if (in_array($key, ['mean', 'limit_min', 'limit_max'])) {
            $$key = $value;
        }
    }
    if ($limit_min > $mean)
        $mean = $limit_min;
    if ($limit_max < $mean)
        $limit_max = $mean;
    if ($limit_max <= $limit_min)
        $limit_max += 1;
    $value = round(($mean - $limit_min) / ($limit_max - $limit_min) * 100);
    $style = ['bg-primary', 'bg-success', 'bg-danger', 'bg-secondary', 'bg-info'];
?>
<p class="mb-2"><?= $label ?></p>
<div class="progress mb-3">
    <div class="progress-bar <?= $style[$id%count($style)] ?><?php if ($value == 0) echo ' text-dark'; ?>" role="progressbar" style="width: <?= $value ?>%;" aria-valuenow="<?= $value ?>" aria-valuemin="0" aria-valuemax="100"><?= $value ?>%</div>
</div>
<?php endif; ?>
