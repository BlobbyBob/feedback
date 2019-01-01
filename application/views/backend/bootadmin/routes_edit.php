<div class="content p-4">

    <h2 class="mb-4">Route bearbeiten</h2>

    <?php if ( ! empty($alert)): ?>
        <?php echo $alert; ?>
    <?php endif; ?>

    <?php echo validation_errors(); ?>
    <?php /** @var Models\Route $route */ ?>
    <?php echo $form; ?>
    <div class="card mb-4">
        <input type="hidden" name="id" value="<?php echo set_value('id', $route->id); ?>">
        <div class="card-header bg-white font-weight-bold">Route bearbeiten</div>
        <div class="card-body">
            <div class="form-group mb-4">
                <label for="name">Name (optional):</label>
                <input id="name" type="text" name="name" class="form-control" maxlength="127" value="<?php echo set_value('name', $route->name); ?>">
            </div>
            <div class="form-group mb-4">
                <label for="grade">Grad:</label>
                <select id="grade" name="grade" class="form-control" required>
                    <?php foreach (['IV','V','VI','VII','VIII','IX','X','XI'] as $grade): ?>
                        <option value="<?php echo $grade; ?>-" <?php echo set_select('grade', $grade . '-', $route->grade == $grade . '-'); ?>><?php echo $grade; ?>-</option>
                        <option value="<?php echo $grade; ?>" <?php echo set_select('grade', $grade, $route->grade == $grade); ?>><?php echo $grade; ?></option>
                        <option value="<?php echo $grade; ?>+" <?php echo set_select('grade', $grade . '+', $route->grade == $grade . '+'); ?>><?php echo $grade; ?>+</option>
                    <?php endforeach; ?>
                </select>
                <small class="form-text">Bei Mischgraden kann nach Belieben gerundet werden.</small>
            </div>
            <div class="form-group mb-4">
                <label for="color">Farbe:</label>
                <select id="color" name="color" class="form-control" required>
                    <?php foreach ($colors as $color): ?>
                        <option value="<?php echo $color->id; ?>" <?php echo set_select('color', $color->id, $route->color == $color->id); ?>><?php echo $color->german; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group mb-4">
                <label for="setter">Schrauber:</label>
                <select id="setter" name="setter-list" class="form-control">
                    <?php foreach ($setters as $setter): ?>
                        <option value="<?php echo $setter->id; ?>" <?php echo set_select('setter-list', $setter->id, $route->setter == $setter->id); ?>><?php echo $setter->name; ?></option>
                    <?php endforeach; ?>
                </select>
                <small class="form-text mb-2">oder</small>
                <input name="setter-name" class="form-control" placeholder="Neuen Schrauber hinzufügen" maxlength="127" value="<?php echo set_value('setter-name'); ?>">
                <small class="form-text">Schrauber sollten nach der Form <i>Max M.</i> bzw. <i>Max M./Moritz M.</i> benannt werden</small>
            </div>
            <div class="form-group mb-4">
                <label for="wall">Seil:</label>
                <select id="wall" name="wall" class="form-control" required>
                    <option value="1" <?php echo set_select('wall', 1, $route->wall == 1); ?>>1</option>
                    <option value="2" <?php echo set_select('wall', 2, $route->wall == 2); ?>>2</option>
                    <option value="3" <?php echo set_select('wall', 3, $route->wall == 3); ?>>3</option>
                    <option value="4" <?php echo set_select('wall', 4, $route->wall == 4); ?>>4 (Eckseil)</option>
                    <option value="5" <?php echo set_select('wall', 5, $route->wall == 5); ?>>5</option>
                    <option value="6" <?php echo set_select('wall', 6, $route->wall == 6); ?>>6</option>
                    <option value="7" <?php echo set_select('wall', 7, $route->wall == 7); ?>>7</option>
                    <option value="0" <?php echo set_select('wall', 0, $route->wall == 0); ?>>Vorstieg</option>
                    <option value="8" <?php echo set_select('wall', 8, $route->wall == 8); ?>>8 (Eckseil)</option>
                    <option value="9" <?php echo set_select('wall', 9, $route->wall == 9); ?>>9</option>
                    <option value="10" <?php echo set_select('wall', 10, $route->wall == 10); ?>>10</option>
                    <option value="11" <?php echo set_select('wall', 11, $route->wall == 11); ?>>11</option>
                    <option value="12" <?php echo set_select('wall', 12, $route->wall == 12); ?>>12</option>
                </select>
            </div>
            <div class="form-group mb-4">
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#image_select">Bild auswählen</button>
                <input type="hidden" name="image" value="<?php echo set_value('image', $route->image); ?>">
            </div>
        </div>
        <div class="card-footer">
            <input type="submit" class="btn btn-primary" name="edit_route" value="Route bearbeiten">
        </div>
    </div>
    </form>

    <div class="modal fade" id="image_select" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Bild auswählen</h5>
                    <button type="button" class="close" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <?php if ( ! empty($images)): ?>
                        <div class="d-flex flex-wrap p-2">
                            <?php for ($i = 0; $i < 3; $i++): ?>
                                <div class="image-grid-column-3">
                                    <?php foreach ($images as $index => $image): if ($index%3 == $i): ?>
                                        <div class="image-grid <?php echo set_select('wall', $image['id'], $route->image == $image['id']) ? 'selected' : ''; ?>" data-id="<?php echo $image['id']; ?>">
                                            <img src="<?php echo $image['src']; ?>">
                                        </div>
                                    <?php endif; endforeach; ?>
                                </div>
                            <?php endfor; ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-dismiss="modal" >Auswählen</button>
                </div>
            </div>
        </div>
    </div>

</div>