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
        <div class="card-header font-weight-bold">Übersicht</div>
        <div class="card-body">
            <table class="table table-hover data-table" cellspacing="0" width="100%">
                <thead>
                <tr>
                    <th>Name</th>
                    <th>Zuletzt ausgefüllt</th>
                    <th>Umfragen abgeschickt</th>
                    <th>Beantwortete Fragen</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($routes as $route): ?>
                <?php $percent = ($route->q_total == 0) ? 0 : $route->q_answered / $route->q_total; ?>
                <tr>
                    <td><a href="<?= $urls['evaluation'].'/'.$route->id ?>"><?php echo $route->name; ?></a></td>
                    <td><?php echo $route->latest; ?></td>
                    <td><?php echo $route->count; ?></td>
                    <td data-order="<?php echo $percent ?>"><?php echo $route->q_answered . "/" . $route->q_total . " (" . round(100*$percent, 1); ?>%)</td>
                </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-header font-weight-bold">Einzelübersicht</div>
        <div class="card-body">
            <div class="container-fluid overview">
                <div class="row">
            <?php if (isset($statistics)) foreach ($statistics as $i => $statistic): ?>
                <div class="col-sm-12 col-md-6 col-lg-4 single-view mb-2">
                    <div class="card">
                        <div class="card-header font-weight-bold">
                            <a href="<?= $urls['evaluation'].'/'.$ids[$i] ?>"><?= $names[$i] ?></a>
                        </div>
                        <div class="card-body">
                            <?php foreach ($statistic as $stat): ?>
                            <?= $stat ?>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</div>