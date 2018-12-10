<div class="sidebar sidebar-dark bg-dark">
    <ul class="list-unstyled">
        <li<?php if ($active == 'main'): ?> class="active"<?php endif; ?>><a href="<?php echo $urls['main']; ?>"><i class="fa fa-fw fa-laptop"></i> Dashboard</a></li>
        <li<?php if ($active == 'images'): ?> class="active"<?php endif; ?>><a href="<?php echo $urls['images']; ?>"><i class="fa fa-fw fa-images"></i> Bilder</a></li>
        <li>
            <a href="#sm_expand_1" data-toggle="collapse"<?php if (strpos($active, 'routes') === 0) echo ' aria-expanded="true"'; ?>>
                <i class="fa fa-fw fa-route"></i> Routen
            </a>
            <ul id="sm_expand_1" class="list-unstyled collapse<?php if (strpos($active, 'routes') === 0) echo ' show'; ?>">
                <li<?php if ($active == 'routes/add'): ?> class="active"<?php endif; ?>><a href="<?php echo $urls['routes/add']; ?>"><i class="fa fa-fw fa-plus"></i> Hinzufügen</a></li>
                <li<?php if ($active == 'routes/manage'): ?> class="active"<?php endif; ?>><a href="<?php echo $urls['routes/manage']; ?>"><i class="fa fa-fw fa-bars"></i> Verwalten</a></li>
            </ul>
        </li>
        <li<?php if ($active == 'survey'): ?> class="active"<?php endif; ?>><a href="<?php echo $urls['survey']; ?>"><i class="fa fa-fw fa-align-left"></i> Umfrage</a></li>
        <li<?php if ($active == 'results'): ?> class="active"<?php endif; ?>><a href="<?php echo $urls['results']; ?>"><i class="fa fa-fw fa-chart-bar"></i> Ergebnisse</a></li>
    </ul>
</div>