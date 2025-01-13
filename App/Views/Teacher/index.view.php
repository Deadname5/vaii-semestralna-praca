<?php
/** @var Array $data  */
/** @var \App\Models\Teacher $teacher  */

/** @var \App\Core\LinkGenerator $link */
?>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <h1 class="bold">Studenti</h1>
        </div>
        <div class="col-12 mb-4">
            <a href="<?= $link->url('teacher.add') ?>" class="btn btn-success">Pridat ucitela</a>
        </div>
        <div class="row justify-content-center">
            <?php foreach ($data['teachers'] as $teacher) : ?>
                <div class="border col-7 col-md-12 my-3">
                    <div class="row">
                        <div class="col-12 col-md-3">
                            <h2>ID: <?= $teacher->getId() ?></h2>

                        </div>
                        <div class="col-12 col-md-3">
                            <h2>Meno: <?= $teacher->getName() ?></h2>
                        </div>
                        <div class="col-12 col-md-3">
                            <h2>Priezvisko: <?= $teacher->getSurname() ?></h2>
                        </div>
                        <div class="col-12 col-md-3">
                            <h2>Jazyk: <?= $teacher->getLanguage() ?></h2>
                        </div>
                        <div class="row p-0 m-0 px-md-4 mt-4">

                            <a href="<?= $link->url('teacher.edit', ['id' => $teacher->getId()])?>" class="btn btn-dark btn mb-2">Edit</a>
                            <a id="confirmation" onclick=deletePopUp.openPopup(<?= $teacher->getId()?>) class="btn btn-danger">Delete</a>
                            <div class="popup" id="<?= $teacher->getId()?>">
                                <h2 class="bold ">Are you sure you want to delete this teacher?</h2>
                                <a href="<?= $link->url('teacher.delete', ['id' => $teacher->getId()])?>" class="btn btn-danger">Yes</a>
                                <a onclick="deletePopUp.closePopup(<?= $teacher->getId()?>)" class="btn btn-dark">No</a>

                            </div>
                        </div>
                    </div>
                </div>




            <?php endforeach; ?>
        </div>





    </div>




</div>