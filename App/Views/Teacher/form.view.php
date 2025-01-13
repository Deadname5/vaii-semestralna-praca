<?php if (!is_null(@$data['errors'])) : ?>
    <?php foreach ($data['errors'] as $error) : ?>
        <div id="serverError" class="alert alert-danger">
            <?= $error ?>

        </div>
    <?php endforeach; ?>


<?php endif; ?>

<div id="errors"></div>
<div id="success"></div>

<form method="post" action="<?= $link->url('teacher.save') ?>" enctype="multipart/form-data">

    <input type="hidden" name="id" id="id" value="<?= @$data['teacher']?->getId() ?>">
    <input type="hidden" name="uid" id="uid" value="<?= @$data['user']?->getId() ?>">

    <label for="name" class="form-label">Meno</label>
    <div class="input-group has-validation mb-3">
        <?php if (@$data['teacher'] != "") : ?>
            <input type="text" class="form-control" id="name" name="name" value="<?= $data['teacher']->getName() ?>" required>
        <?php else : ?>
            <input type="text" class="form-control" id="name" name="name"  required>
        <?php endif;?>

    </div>
    <label for="surname" class="form-label">Priezvisko</label>
    <div class="input-group has-validation mb-3">
        <?php if (@$data['teacher'] != "") : ?>
            <input type="text" class="form-control" id="surname" name="surname" value="<?= $data['teacher']->getSurname() ?>" required>
        <?php else : ?>
            <input type="text" class="form-control" id="surname" name="surname" required>
        <?php endif;?>
    </div>
    <label for="language" class="form-label">Vyucovaci jazyk</label>
    <div class="input-group has-validation mb-3">
        <?php if (@$data['teacher'] != "") : ?>
            <input type="text" class="form-control" id="language" name="language" value="<?= $data['teacher']->getLanguage() ?>" required>
        <?php else : ?>
            <input type="text" class="form-control" id="language" name="language" required>
        <?php endif;?>
    </div>
    <label for="login" class="form-label">Login</label>
    <div class="input-group has-validation mb-3">
        <?php if (@$data['user'] != "") : ?>
            <input type="text" class="form-control" id="login" name="login" value="<?= $data['user']->getLogin() ?>" required>
        <?php else : ?>
            <input type="text" class="form-control" id="login" name="login" required>
        <?php endif;?>
    </div>
    <label for="password" class="form-label">Password</label>
    <div class="input-group has-validation mb-3">
            <input type="text" class="form-control" id="password" name="password" required>
    </div>
    <button type="submit" id="btn-teacher" class="btn btn-success">Ulozit</button>

</form>