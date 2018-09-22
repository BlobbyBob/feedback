<div class="content p-4">
    <div class="card mb-4">
        <div class="card-body">
            <table class="table table-hover data-table" cellspacing="0" width="100%">
                <thead>
                <tr>
                    <th>Name</th>
                    <th>Schwierigkeit</th>
                    <th>Farbe</th>
                    <th>Schrauber</th>
                    <th>Seil</th>
                    <th>Bild</th>
                    <th class="actions">Aktionen</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($routes as $route): ?>
                <tr>
                    <td><?php echo $route->name; ?></td>
                    <td><?php echo $route->grade; ?></td>
                    <td><?php echo $route->color; ?></td>
                    <td><?php echo $route->setter; ?></td>
                    <td><?php echo $route->wall; ?></td>
                    <td><?php echo $route->image; ?></td>
                    <td>
                        <a href="<?php echo $route->id; ?>/" class="btn btn-icon btn-pill btn-primary" data-toggle="tooltip" title="Bearbeiten"><i class="fa fa-fw fa-edit"></i></a>
                        <a href="#<?php // todo ?>" class="btn btn-icon btn-pill btn-danger" data-toggle="tooltip" title="Löschen"><i class="fa fa-fw fa-trash"></i></a>
                    </td>
                </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>