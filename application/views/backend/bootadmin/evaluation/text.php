<?php

usort($text, function ($a, $b) {return strlen($a['value']) <=> strlen($b['value']);});
$hashes = [];
foreach ($text as $t) {
    $hashes[] = sha1(trim(strtolower($t)));
}
$preprocessed = [];
$count = [];
foreach ($text as $t) {
    $i = array_search(sha1(trim(strtolower($t))), $hashes);
    if ( ! isset($preprocessed[$i])) {
        $preprocessed[$i] = htmlspecialchars(trim($t));
        $count[$i] = 1;
    } else {
        $count[$i]++;
    }
}

array_multisort($count, SORT_DESC, $preprocessed);
?>
<div class="card">
    <div class="card-header">
        <span class="category"><?= $label ?></span>
    </div>
    <div class="card-body">
        <?php foreach ($preprocessed as $i => $t): ?>
        <p class="font-weight-italic"><?= $t ?></p>
        <?php if ($count[$i] > 1): ?><small><?= $count[$i] ?>x geantwortet</small><?php endif; ?>
        <?php endforeach; ?>
    </div>
</div>