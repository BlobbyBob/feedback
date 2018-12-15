<h6><?php if (isset($label)) echo $label; ?></h6>
<?php if (isset($type)) switch($type): ?>



    <?php case 'options':
        usort($options, function ($a, $b) {return $a['value'] <=> $b['value'];});
        $total = statistics_get_total($options); ?>
        <?php if (count($options) == 2):?>

            <strong><?= $options[0]['key'] ?></strong>: <?= printf('%.2f%%', 100*$options[0]['value']/$total) ?><br>
            <strong><?= $options[1]['key'] ?></strong>: <?= printf('%.2f%%', 100*$options[0]['value']/$total) ?><br>
        <?php else: ?>
            <?php foreach ($options as $i => $option): if ($i > 4) break;?>
                <strong><?= $option['key'] ?></strong>: <?= printf('%.2f%%', 100*$option['value']/$total) ?><br>
            <?php endforeach; ?>
        <?php endif; ?>
    <?php break; ?>



    <?php case 'numbers':
        usort($numbers, function ($a, $b) {
            $v=['min','max','median','mean','avg'];
            return array_search($a, $v) <=> array_search($b, $v);
        }); ?>

        <strong>Minimum/Maximum:</strong> <?= $numbers[0]['value']; ?> / <?= $numbers[1]['value']; ?><br>
        <strong>Median/Mittelwert:</strong> <?= $numbers[2]['value']; ?> / <?= $numbers[3]['value']; ?><br>
    <?php break; ?>



    <?php case 'text':
        usort($text, function ($a, $b) {return strlen($a['value']) <=> strlen($b['value']);}); ?>
        <?php if (count($text) < 3): ?>
            <?php foreach ($text as $t): ?>
                <p><em><?= htmlspecialchars($t) ?></em></p><br>
            <?php endforeach; ?>
        <?php else: ?>
            <p><em><?= htmlspecialchars($text[0]) ?></em></p><br>
            <p><em><?= htmlspecialchars($text[count($text) / 2]) ?></em></p><br>
            <p><em><?= htmlspecialchars($text[count($text) - 1]) ?></em></p><br>
        <?php endif; ?>
    <?php break; ?>



    <?php default: ?>
    <h6 class="warning">Unbekannter Statistik-Typ</h6>
<?php endswitch; ?>
<hr>
<?php
function statistics_get_total($options) {
$t = 0;
foreach ($options as $o) $t += $o['value'];
return $t;
}