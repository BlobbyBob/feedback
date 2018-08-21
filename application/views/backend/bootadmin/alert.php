<div class="alert<?php if (isset($type)) echo ' alert-'.$type; ?> alert-dismissable" role="alert">
    <?php echo $msg; ?>
    <button type="button" class="close" data-dismiss="alert" aria-label="Schließen">
        <span aria-hidden="true">&times;</span>
    </button>
</div>