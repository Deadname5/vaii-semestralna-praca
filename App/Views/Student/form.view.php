<?php if(!is_null(@$data['errors'])): ?>
    <?php foreach ($data['errors'] as $error): ?>
        <div class="alert alert-danger">
            <?= $error ?>

        </div>
    <?php endforeach; ?>


<?php endif; ?>

<form method="post" action="<?= $link->url('student.save') ?>" enctype="multipart/form-data">

    <input type="hidden" name="id" value="<?= @$data['student']?->getId() ?>">

    <label for="jazyk" class="form-label">Zvoleny jazyk</label>
    <div class="input-group has-validation mb-3">
        <?php if (@$data['student'] != ""): ?>
            <input type="text" class="form-control" id="jazyk" name="jazyk" value="<?= $data['student']->getJazyk() ?>" required>
        <?php else: ?>
            <input type="text" class="form-control" id="jazyk" name="jazyk"  required>
        <?php endif;?>

    </div>
    <label for="zaciatok" class="form-label">Zaciatok vyucby</label>
    <div class="input-group has-validation mb-3">
        <?php if (@$data['student'] != ""): ?>
            <input type="date" class="form-control" id="zaciatok" name="zaciatok" value="<?= $data['student']->getZaciatok() ?>" required>
        <?php else: ?>
            <input type="date" class="form-control" id="zaciatok" name="zaciatok" required>
        <?php endif;?>
    </div>
    <label for="koniec" class="form-label">Koniec vyucby</label>
    <div class="input-group has-validation mb-3">
        <?php if (@$data['student'] != ""): ?>
            <input type="date" class="form-control" id="koniec" name="koniec" value="<?= $data['student']->getKoniec() ?>">
        <?php else: ?>
            <input type="date" class="form-control" id="koniec" name="koniec">
        <?php endif;?>
    </div>
    <button type="submit" class="btn btn-success">Ulozit</button>

</form>