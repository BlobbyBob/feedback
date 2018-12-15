<?php
if ( ! function_exists('statistics_get_total')) {
    function statistics_get_total($options) {
        $t = 0;
        foreach ($options as $o)
            $t += $o['value'];
        return $t;
    }
}
?>
<h5><?php if (isset($label)) echo $label; ?></h5>
<?php if (isset($type)) switch($type):



    case 'options':
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
            $v=['min','max','mean','median'];
            return array_search($a, $v) <=> array_search($b, $v);
        }); ?>

        <strong>Minimum/Maximum:</strong> <?= $numbers[0]['value']; ?> / <?= $numbers[1]['value']; ?><br>
        <strong>Mittelwert/Median:</strong> <?= $numbers[2]['value']; ?> / <?= $numbers[3]['value']; ?><br>
    <?php break; ?>



    <?php case 'text':
        usort($text, function ($a, $b) {return strlen($a['value']) <=> strlen($b['value']);}); ?>
        <?php if (count($text) < 3): ?>
            <?php foreach ($text as $t): ?>
                <p><em><?= htmlspecialchars($t['value']) ?></em></p>
            <?php endforeach; ?>
        <?php else: ?>
            <p><em><?= htmlspecialchars($text[0]['value']) ?></em></p>
            <p><em><?= htmlspecialchars($text[count($text) / 2]['value']) ?></em></p>
            <p><em><?= htmlspecialchars($text[count($text) - 1]['value']) ?></em></p>
        <?php endif; ?>
    <?php break; ?>



    <?php default: ?>
    <h5 class="warning">Unbekannter Statistik-Typ</h5>
<?php endswitch; ?>
<hr>