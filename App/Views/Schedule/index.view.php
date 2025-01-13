<?php
/** @var Array $data  */
/** @var \App\Models\Schedule $schedule  */
/** @var \App\Core\IAuthenticator $auth */

/** @var \App\Core\LinkGenerator $link */
?>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <?php if ($auth->getLoggedUserRole() == 1) { ?>
            <h1 class="bold">Vsetky harmonogramy</h1>
            <?php } else {?>
            <h1 class="bold">Moje harmonogramy</h1>
            <?php } ?>


        </div>
        <div class="col-12 mb-4">
            <a href="<?= $link->url('schedule.add') ?>" class="btn btn-success">Pridat harmonogram</a>
        </div>
        <div class="row justify-content-center">
            <?php foreach ($data['schedules'] as $schedule) : ?>
                <div class="border col-7 col-md-12 my-3">
                    <?php if ($auth->getLoggedUserRole() == 1) { ?>
                        <div id="teach<?= $schedule->getId()?>" class="row">
                            <div  class="col-12 col-md-3">
                                <h2>ID Ucitel: <?= $schedule->getTeacherId() ?></h2>
                            </div>
                        </div>
                    <?php }?>

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
                        <div class="row" id="info<?= $schedule->getId()?>"></div>
                        <div class="row p-0 m-0 px-md-4 mt-4">
                            <a id="more" onclick=info.getInfo(<?= $schedule->getId()?>) class="btn btn-secondary mb-2">Info</a>
                            <a href="<?= $link->url('schedule.edit', ['id' => $schedule->getId()])?>" class="btn btn-dark btn mb-2">Edit</a>
                            <a id="confirmation" onclick=deletePopUp.openPopup(<?= $schedule->getId()?>) class="btn btn-danger">Delete</a>
                            <div class="popup" id="<?= $schedule->getId()?>">
                                <h2 class="bold" >Naozej chcete zmazať tento harmonogram?</h2>
                                <a href="<?= $link->url('schedule.delete', ['id' => $schedule->getId()])?>" class="btn btn-danger">Ano</a>
                                <a onclick="deletePopUp.closePopup(<?= $schedule->getId()?>)" class="btn btn-dark">Nie</a>

                            </div>
                        </div>

                    </div>

                </div>





            <?php endforeach; ?>
        </div>





    </div>




</div>
