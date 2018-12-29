<div class="content p-4">

    <h2 class="mb-4">Dashboard</h2>

    <div class="row mb-4">
        <div class="col-md">
            <div class="d-flex border">
                <div class="bg-primary text-light p-4">
                    <div class="d-flex align-items-center h-100">
                        <i class="fa fa-3x fa-fw fa-align-left"></i>
                    </div>
                </div>
                <div class="flex-grow-1 bg-white p-4">
                    <p class="text-uppercase text-secondary mb-0">Umfragen ausgefüllt</p>
                    <h3 class="font-weight-bold mb-0"><?= $surveys ?></h3>
                </div>
            </div>
        </div>
        <div class="col-md">
            <div class="d-flex border">
                <div class="bg-success text-light p-4">
                    <div class="d-flex align-items-center h-100">
                        <i class="fa fa-3x fa-fw fa-question"></i>
                    </div>
                </div>
                <div class="flex-grow-1 bg-white p-4">
                    <p class="text-uppercase text-secondary mb-0">Fragen gestellt</p>
                    <h3 class="font-weight-bold mb-0"><?= $questions ?></h3>
                </div>
            </div>
        </div>
        <div class="col-md">
            <div class="d-flex border">
                <div class="bg-danger text-light p-4">
                    <div class="d-flex align-items-center h-100">
                        <i class="fa fa-3x fa-fw fa-chart-pie"></i>
                    </div>
                </div>
                <div class="flex-grow-1 bg-white p-4">
                    <p class="text-uppercase text-secondary mb-0">Fragen beantwortet</p>
                    <h3 class="font-weight-bold mb-0"><?= $answered ?>%</h3>
                </div>
            </div>
        </div>
        <div class="col-md">
            <div class="d-flex border">
                <div class="bg-info text-light p-4">
                    <div class="d-flex align-items-center h-100">
                        <i class="fa fa-3x fa-fw fa-users"></i>
                    </div>
                </div>
                <div class="flex-grow-1 bg-white p-4">
                    <p class="text-uppercase text-secondary mb-0">Umfragen pro Route</p>
                    <h3 class="font-weight-bold mb-0"><?= $surveys_avg ?></h3>
                </div>
            </div>
        </div>
    </div>

    <div class="row mb-4">
        <div class="col-md-6 col-sm-12 mb-4">
            <div class="card">
                <div class="card-header bg-white font-weight-bold">
                    Gesamtaktivität
                </div>
                <div class="card-body">
                    <div id="date_graph" class="ct-chart ct-double-octave"></div>
                </div>
            </div>
        </div>
        <?php if (isset($ratings) && count($ratings) > 0): ?>
        <div class="col-md-6 col-sm-12 mb-4">

            <div class="card">
                <div class="card-header bg-white font-weight-bold">
                    Letzte Aktivität
                </div>
                <div class="card-body">

                    <table class="table table-hover" id="recent_activity">
                        <thead>
                        <tr>
                            <th scope="col">Name</th>
                            <th scope="col">Letzte Umfrage ausgefüllt</th>
                            <th scope="col">Anzahl ausgefüllter Umfragen</th>
                            <th scope="col">Anteil beantworteter Fragen</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($activity as $a): ?>
                            <tr>
                                <td><a href="<?= $urls['evaluation'] . '/' . $a->id ?>"><?= $a->name ?></a></td>
                                <td><?= $a->date ?></td>
                                <td><?= $a->count ?></td>
                                <td><span class="badge <?php
                                    if ($a->ratio < 50) echo 'badge-danger';
                                    elseif ($a->ratio < 75) echo 'badge-warning';
                                    elseif ($a->ratio < 90) echo 'badge-info';
                                    else echo 'badge-success';
                                    ?>"><?= $a->ratio ?>%</span></td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <?php endif; ?>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header bg-white font-weight-bold">
                    Durchschnittliche Bewertungen
                </div>
                <div class="card-body">
                    <?php foreach ($ratings as $rating) echo $rating ?>
                </div>
            </div>
        </div>
    </div>

</div>

<script>
    var date_graph_data = <?= $date_graph ?>;
    for (let i = 0; i < date_graph_data.length; i++) {
        date_graph_data[i].x = new Date(1000 * date_graph_data[i].x);
    }
</script>