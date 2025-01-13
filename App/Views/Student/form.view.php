<?php if (!is_null(@$data['errors'])) : ?>
    <?php foreach ($data['errors'] as $error) : ?>
        <div id="serverError" class="alert alert-danger">
            <?= $error ?>

        </div>
    <?php endforeach; ?>



<?php endif; ?>

<div id="errors"></div>

<form method="post" action="<?= $link->url('student.save') ?>" enctype="multipart/form-data">

    <input type="hidden" name="id" value="<?= @$data['student']?->getId() ?>">

    <label for="name" class="form-label">Meno</label>
    <div class="input-group has-validation mb-3">
        <?php if (@$data['student'] != "") : ?>
            <input type="text" class="form-control" id="name" name="name" value="<?= $data['student']->getName() ?>" required>
        <?php else : ?>
            <input type="text" class="form-control" id="name" name="name" required>
        <?php endif;?>

    </div>
    <label for="surname" class="form-label">Priezvisko</label>
    <div class="input-group has-validation mb-3">
        <?php if (@$data['student'] != "") : ?>
            <input type="text" class="form-control" id="surname" name="surname" value="<?= $data['student']->getSurname() ?>" required>
        <?php else : ?>
            <input type="text" class="form-control" id="surname" name="surname" required>
        <?php endif;?>
    </div>
    <button type="submit" id="btn-student" class="btn btn-success">Ulozit</button>

</form>
