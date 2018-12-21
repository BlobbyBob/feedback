<?php use Models\Checkbox;

if (empty($none)): ?>
    <div class="formelement form-group">

    <?php if ( ! (isset($type) && $type == 'checkbox')): ?>
        <label for="field-<?= $id ?>"><?= $label ?></label>
    <?php endif; ?>

        <?php if ( ! empty($special) && $special == 'rating'): ?>

        <div class='starrating risingstar d-flex justify-content-center flex-row-reverse align-items-center'>
            <span><?= $label_after ?></span>
            <?php for ($i = $count; $i >= 1; $i--): ?>
            <input id='field-<?= $id ?>-<?= $i ?>' type='radio' name='field-<?= $id ?>' value='<?= $id ?>'><label for='field-<?= $id ?>-<?= $i ?>'></label>
            <?php endfor; ?>
            <span><?= $label_before ?></span>
        </div>

        <?php elseif ( ! empty($special) && $special == 'select'): ?>

        <select id="field-<?= $id ?>" class="form-control">
            <?php foreach ($options as $val => $optlabel): ?>
            <option name="<?= $val ?>"><?= $optlabel ?></option>
            <?php endforeach; ?>
        </select>

        <?php elseif ( ! empty($special) && $special == 'radio'): ?>
            <?php $i = 0 ?>
            <?php foreach ($options as $val => $radiolabel): ?>
            <?php $i++; ?>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="field-<?= $id ?>" id="field-<?= $id ?>-<?= $i ?>" value="<?= $val ?>">
                    <label class="form-check-label" for="field-<?= $id ?>-<?= $i ?>">
                        <?= $radiolabel ?>
                    </label>
                </div>
            <?php endforeach; ?>

        <?php else: ?>

            <?php if (isset($type) && $type == 'checkbox'): ?>
            <div class="form-check">
            <input type="hidden" name="field-<?= $id ?>" value="0">
            <?php endif; ?>

            <?php if (isset($type) && $type == 'checkbox' && 'label_position' == Checkbox::BEFORE): ?>
                <label class="form-check-label" for="field-<?= $id ?>">
                    <?= $label ?>
                </label>
            <?php endif; ?>

            <<?= $tag ?>
            id='field-<?= $id ?>'
            class='form-control'
            name='field-<?= $id ?>'
            <?php if (isset($type)) echo 'type="'.$type.'"' ?>
            <?php if (isset($placeholder)) echo 'placeholder="'.$placeholder.'"' ?>
            <?php if (isset($maxlength)) echo 'maxlength="'.$maxlength.'"' ?>>
            <?php if ($closing) echo '</'.$tag.'>' ?>

            <?php if (isset($type) && $type == 'checkbox' && 'label_position' == Checkbox::AFTER): ?>
                <label class="form-check-label" for="field-<?= $id ?>">
                    <?= $label ?>
                </label>
            <?php endif; ?>

            <?php if (isset($type) && $type == 'checkbox'): ?>
            </div>
            <?php endif; ?>

        <?php endif; ?>

    </div>
<?php endif; ?>
