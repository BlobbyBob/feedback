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
        <div class="col-md-8">
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
        <div class="col-md-4">
            <div class="card">
                <div class="card-header bg-white font-weight-bold">
                    Durchschnittliche Bewertungen
                </div>
                <div class="card-body">
                    <?php foreach ($ratings as $rating) echo $rating ?>
                </div>
            </div>
        </div>
        <?php endif; ?>
    </div>

    <div class="card">
        <div class="card-header bg-white font-weight-bold">
            Recent Orders
        </div>
        <div class="card-body">

            <table class="table table-hover">
                <thead>
                <tr>
                    <th scope="col">Order ID</th>
                    <th scope="col">Item</th>
                    <th scope="col">Customer</th>
                    <th scope="col">Status</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td><a href="#">00000077</a></td>
                    <td>Praesent eu viverra leo</td>
                    <td>Kevin Dion</td>
                    <td><span class="badge badge-success">Shipped</span></td>
                </tr>
                <tr>
                    <td><a href="#">00000078</a></td>
                    <td>Lorem ipsum dolor</td>
                    <td>Mark Otto</td>
                    <td><span class="badge badge-success">Shipped</span></td>
                </tr>
                <tr>
                    <td><a href="#">00000079</a></td>
                    <td>Etiam eleifend elit</td>
                    <td>Jacob Thornton</td>
                    <td><span class="badge badge-info">Packaging</span></td>
                </tr>
                <tr>
                    <td><a href="#">00000080</a></td>
                    <td>Donec vitae ante egestas</td>
                    <td>Larry the Bird</td>
                    <td><span class="badge badge-secondary">Back Ordered</span></td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>

</div>

<script>
    var date_graph_data = <?= $date_graph ?>;
    for (let i = 0; i < date_graph_data.length; i++) {
        date_graph_data[i].x = new Date(1000 * date_graph_data[i].x);
    }
</script>