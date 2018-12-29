<input type="hidden" name="id" value="<?php if (isset($id)) echo $id; ?>">
<input type="hidden" name="index" value="<?php if (isset($index)) echo $index; ?>">
<div class="element-type">
    <strong>Typ:</strong> <?php if (isset($type)) echo $type; ?><br>
    <small class="btn btn-danger delete-element mt-3">Element löschen</small>
</div>
<div class="element-settings">

    <div class="element-settings-title">Einstellungen:</div>

    <?php if (isset($settings)) foreach ($settings as $setting): ?>
    <div class="element-setting">

        <?php if (isset($setting['key'])): ?><div class="element-setting-key"><?= $setting['key'] ?>: </div><?php endif; ?>

        <div class="element-setting-value">

            <?php if ($setting['type'] == 'button'): ?>
                <button type="button" class="btn btn-info <?php if (isset($setting['class'])) echo $setting['class']; ?>" name="<?= $setting['name'] ?>" <?php if (isset($setting['attr'])) echo $setting['attr']; ?>><?= $setting['title'] ?></button>
            <?php endif; ?>

            <?php if ($setting['type'] == 'select'): ?>
            <select class="form-control" name="<?= $setting['name'] ?>">
                <?php if (isset($setting['options'])) foreach ($setting['options'] as $option): ?>
                <option value="<?= $option['value'] ?>"<?php if ($option['selected']) echo ' selected'; ?>><?= $option['title'] ?></option>
                <?php endforeach; ?>
            </select>
            <?php endif; ?>

            <?php if ($setting['type'] != 'select' && $setting['type'] != 'button'): ?>
            <input class="form-control" type="<?= $setting['type'] ?>" name="<?= $setting['name'] ?>" value="<?= $setting['value'] ?>" <?php if (isset($setting['attr'])) echo $setting['attr']; ?>>
            <?php endif; ?>

            <?php if (isset($setting['small'])): ?><small class="form-text"><?= $setting['small'] ?></small><?php endif; ?>
        </div>
    </div>
    <?php endforeach; ?>
</div>