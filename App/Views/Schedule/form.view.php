<?php

/** @var \App\Models\Student $student */
/** @var \App\Models\Teacher $teacher */
/** @var \App\Core\IAuthenticator $auth */
/** @var Array $data */
/** @var \App\Core\LinkGenerator $link */
?>

<?php if (!is_null(@$data['errors'])) : ?>
    <?php foreach ($data['errors'] as $error) : ?>
        <div id="serverError" class="alert alert-danger">
            <?= $error ?>

        </div>
    <?php endforeach; ?>


<?php endif; ?>

<div id="errors"></div>
<div id="success"></div>

<form method="post" action="<?= $link->url('schedule.save') ?>" enctype="multipart/form-data">
    <input type="hidden" name="id" id="id" value="<?= @$data['schedule']?->getId() ?>">

    <label for="student" class="form-label col-form-label-lg">Student</label>
    <div class="input-group">
        <select class="form-select form-select-lg" name="student" id="student">
            <?php foreach (@$data['students'] as $student) : ?>
                <?php if (@$data['schedule'] != "" && @$data['schedule']->getStudentId() == $student->getId()) : ?>
                    <option selected value="<?= $student->getId()?>"><?= $student->getName()?> <?= $student->getSurname()?>, <?= $student->getId()?></option>
                <?php else : ?>
                    <option value="<?= $student->getId()?>"><?= $student->getName()?> <?= $student->getSurname()?>, <?= $student->getId()?></option>
                <?php endif; ?>
            <?php endforeach; ?>
        </select>
    </div>


    <?php if ($auth->getLoggedUserRole() == 1) {?>
        <label for="teacher" class="form-label col-form-label-lg">Ucitel</label>
        <div class="input-group">
            <select class="form-select form-select-lg" name="teacher" id="teacher">
                <?php foreach (@$data['teachers'] as $teacher) : ?>
                    <?php if (@$data['schedule'] != "" && @$data['schedule']->getTeacherId() == $teacher->getId()) : ?>
                        <option selected value="<?= $teacher->getId()?>"><?= $teacher->getName()?> <?= $teacher->getSurname()?>, <?= $teacher->getLanguage()?>, <?= $teacher->getId()?></option>
                    <?php else : ?>
                        <option value="<?= $teacher->getId()?>"><?= $teacher->getName()?> <?= $teacher->getSurname()?>, <?= $teacher->getLanguage()?>, <?= $teacher->getId()?></option>
                    <?php endif; ?>

                <?php endforeach; ?>
            </select>
        </div>

    <?php } else {?>
        <input type="hidden" name="teacher" id="teacher" value="<?= @$data['teacher']?->getId() ?>">
    <?php }?>

    <label for="start" class="form-label col-form-label-lg">Zaciatok vyucby</label>
    <div class="input-group input-group-lg has-validation mb-3">

        <?php if (@$data['schedule'] != "") : ?>
            <input type="date" class="form-control" id="start" name="start" value="<?= $data['schedule']->getStart() ?>" required>
        <?php else : ?>
            <input type="date" class="form-control" id="start" name="start" required>
        <?php endif;?>

    </div>
    <label for="end" class="form-label col-form-label-lg">Koniec vyucby</label>
    <div class="input-group input-group-lg has-validation mb-3">
        <?php if (@$data['schedule'] != "") : ?>
            <input type="date" class="form-control" id="end" name="end" value="<?= $data['schedule']->getEnd() ?>">
        <?php else : ?>
            <input type="date" class="form-control" id="end" name="end">
        <?php endif;?>

    </div>
    <button type="submit" id="btn-schedule" class="btn btn-success">Ulozit</button>

</form>