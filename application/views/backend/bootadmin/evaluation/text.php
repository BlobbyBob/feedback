<?php

usort($text, function ($a, $b) {return strlen($a['value']) <=> strlen($b['value']);});
$hashes = [];
foreach ($text as $t) {
    $hashes[] = sha1(trim(strtolower($t['value'])));
}
$preprocessed = [];
$count = [];
foreach ($text as $t) {
    $i = array_search(sha1(trim(strtolower($t['value']))), $hashes);
    if ( ! isset($preprocessed[$i])) {
        $preprocessed[$i] = htmlspecialchars(trim($t['value']));
        $count[$i] = 1;
    } else {
        $count[$i]++;
    }
}

array_multisort($count, SORT_DESC, $preprocessed);
?>
<div class="col-lg-4 col-md-6 col-sm-12 mb-2">
    <div class="card">
        <div class="card-header">
            <span class="category"><?= $label ?></span>
        </div>
        <div class="card-body evaluation-text">
            <?php foreach ($preprocessed as $i => $t): ?>
                <p class="font-italic"><?= $t ?>
                    <?php if ($count[$i] > 1): ?><br>
                        <small class="float-right" style="font-style: normal;"><?= $count[$i] ?>x geantwortet</small><?php endif; ?>
                </p><br>
            <?php endforeach; ?>
        </div>
    </div>
</div>