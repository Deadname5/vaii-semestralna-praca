
<?php
/** @var Array $data  */
/** @var \App\Models\Student $student  */

/** @var \App\Core\LinkGenerator $link */
?>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <h1 class="bold">Studenti</h1>
        </div>
        <div class="col-12 mb-4">
            <a href="<?= $link->url('student.add') ?>" class="btn btn-success">Pridat studenta</a>
        </div>
        <div class="row justify-content-center">
    <?php foreach ($data['students'] as $student) : ?>
            <div class="border col-7 col-md-12 my-3">
                <div class="row">
                    <div class="col-12 col-md-3">
                        <h2>ID: <?= $student->getId() ?></h2>

                    </div>
                    <div class="col-12 col-md-3">
                        <h2>Meno: <?= $student->getName() ?></h2>
                    </div>
                    <div class="col-12 col-md-3">
                        <h2>Priezvisko: <?= $student->getSurname() ?></h2>
                    </div>
                    <div class="row p-0 m-0 px-md-4 mt-4">

                            <a href="<?= $link->url('student.edit', ['id' => $student->getId()])?>" class="btn btn-dark btn mb-2">Edit</a>
                            <a id="confirmation" onclick=deletePopUp.openPopup(<?= $student->getId()?>) class="btn btn-danger">Delete</a>
                        <div class="popup" id="<?= $student->getId()?>">
                            <h2 class="bold ">Naozej chcete zmazať tohto študenta?</h2>
                            <a href="<?= $link->url('student.delete', ['id' => $student->getId()])?>" class="btn btn-danger">Ano</a>
                            <a onclick="deletePopUp.closePopup(<?= $student->getId()?>)" class="btn btn-dark">Nie</a>

                        </div>
                    </div>
                </div>
            </div>




    <?php endforeach; ?>
        </div>





    </div>




</div>
