<div class="content p-4">

    <h2 class="mb-4">Bilder</h2>

    <?php if ( ! empty($alert)): ?>
    <?php echo $alert; ?>
    <?php endif; ?>

    <?php echo $form; ?>
        <div class="card mb-4">
            <div class="card-header bg-white font-weight-bold">Bild hochladen</div>
            <div class="card-body">
                <div class="form-group">
                    <label for="upload">Datei:</label>
                    <input type="hidden" name="MAX_FILE_SIZE" value="2000000">
                    <input id="upload" class="form-control" type="file" name="image" aria-describedby="upload_desc" required>
                    <small id="upload_desc" class="form-text text-muted">Maximale Uploadgröße: 2MB. Ein optimales Bild hat eine Höhe von 1000px und ist im JPG-Format. Es sollte außerdem im Hochformat vorliegen.<br>
                    <strong>Beachte:</strong> Große Dateien verlängern die Ladedauer insbesondere auf mobilen Geräten enorm.</small>
                </div>
            </div>
            <div class="card-footer">
                <input type="submit" class="btn btn-primary" name="upload" value="Hochladen">
            </div>
        </div>
    </form>

    <div class="card mb-4">
        <div class="card-header bg-white font-weight-bold">Bilder</div>
        <div class="card-body">
            <?php if ( ! empty($images)): ?>
            <div class="d-flex flex-wrap p-2">
                <div class="image-grid-column">
                    <?php foreach ($images as $index => $image): if ($index%4 == 0): ?>
                    <div class="image-grid">
                        <img src="<?php echo $image['src']; ?>">
                        <div class="controls">
                            <a href="<?php echo $image['delete']; ?>" class="btn btn-outline-danger fas fa-trash-alt"></a>
                        </div>
                    </div>
                    <?php endif; endforeach; ?>
                </div>
                <div class="image-grid-column">
                    <?php foreach ($images as $index => $image): if ($index%4 == 1): ?>
                        <div class="image-grid">
                            <img src="<?php echo $image['src']; ?>">
                            <div class="controls">
                                <a href="<?php echo $image['delete']; ?>" class="btn btn-outline-danger fas fa-trash-alt"></a>
                            </div>
                        </div>
                    <?php endif; endforeach; ?>
                </div>
                <div class="image-grid-column">
                    <?php foreach ($images as $index => $image): if ($index%4 == 2): ?>
                        <div class="image-grid">
                            <img src="<?php echo $image['src']; ?>">
                            <div class="controls">
                                <a href="<?php echo $image['delete']; ?>" class="btn btn-outline-danger fas fa-trash-alt"></a>
                            </div>
                        </div>
                    <?php endif; endforeach; ?>
                </div>
                <div class="image-grid-column">
                    <?php foreach ($images as $index => $image): if ($index%4 == 3): ?>
                        <div class="image-grid">
                            <img src="<?php echo $image['src']; ?>">
                            <div class="controls">
                                <a href="<?php echo $image['delete']; ?>" class="btn btn-outline-danger fas fa-trash-alt"></a>
                            </div>
                        </div>
                    <?php endif; endforeach; ?>
                </div>
            </div>
            <?php endif; ?>
        </div>
    </div>

</div>