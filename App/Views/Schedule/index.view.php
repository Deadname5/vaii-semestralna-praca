<?php
/** @var Array $data  */
/** @var \App\Models\Schedule $schedule  */
/** @var \App\Core\IAuthenticator $auth */

/** @var \App\Core\LinkGenerator $link */
?>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <?php if($auth->getLoggedUserRole() == 1){ ?>
            <h1 class="bold">Vsetci studenti</h1>
            <?php } else {?>
            <h1 class="bold">Moji studenti</h1>
            <?php } ?>


        </div>
        <div class="col-12 mb-4">
            <a href="<?= $link->url('schedule.add') ?>" class="btn btn-success">Pridat studenta</a>
        </div>
        <div class="row justify-content-center">
            <?php foreach ($data['schedules'] as $schedule) : ?>
                <?php if($auth->getLoggedUserRole() == 1){ ?>
                    <div class="col-12 col-md-3">
                        <h2>ID Teacher: <?= $schedule->getTeacherId() ?></h2>
                    </div>
                <?php }?>
                <div class="border col-7 col-md-12 my-3">
                    <div class="row" id="info<?= $schedule->getId()?>"></div>
                    <!--TODO create button more, add to this row id studentID, show student name and surname -->
                    <div class="row">
                        <div class="col-12 col-md-3">
                            <h2>ID: <?= $schedule->getStudentId() ?></h2>

                        </div>
                        <div class="col-12 col-md-3">
                            <h2>Jazyk: <?= $schedule->getLanguage() ?></h2>
                        </div>
                        <div class="col-12 col-md-3">
                            <h2>Zaciatok: <?= $schedule->getStart() ?></h2>
                        </div>
                        <div class="col-12 col-md-3">
                            <h2>Koniec: <?= $schedule->getEnd() ?></h2>
                        </div>
                        <div class="row p-0 m-0 px-md-4 mt-4">
                            <a id="more" onclick=studentInfo.getStudentInfo(<?= $schedule->getId()?>) class="btn btn-secondary mb-2">Info</a>
                            <a href="<?= $link->url('schedule.edit', ['id' => $schedule->getId()])?>" class="btn btn-dark btn mb-2">Edit</a>
                            <a id="confirmation" onclick=deletePopUp.openPopup(<?= $schedule->getId()?>) class="btn btn-danger">Delete</a>
                            <div class="popup" id="<?= $schedule->getId()?>">
                                <h2 class="bold" >Are you sure you want to delete this schedule?</h2>
                                <a href="<?= $link->url('schedule.delete', ['id' => $schedule->getId()])?>" class="btn btn-danger">Yes</a>
                                <a onclick="deletePopUp.closePopup(<?= $schedule->getId()?>)" class="btn btn-dark">No</a>

                            </div>
                        </div>

                    </div>
                </div>





            <?php endforeach; ?>
        </div>





    </div>




</div>
