<?php

/** @var \App\Core\LinkGenerator $link */
/** @var Array $data */

?>


<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h1>Pridanie noveho studenta</h1>

        </div>
        <form method="post" action="" enctype="multipart/form-data">
            <label for="jazyk" class="form-label">Zvoleny jazyk</label>
            <div class="input-group has-validation mb-3">
                <input type="text" class="form-control" id="jazyk" name="jazyk" required>
            </div>
            <label for="zaciatok" class="form-label">Zaciatok vyucby</label>
            <div class="input-group has-validation mb-3">
                <input type="date" class="form-control" id="zaciatok" name="zaciatok" required>
            </div>
            <label for="koniec" class="form-label">Koniec vyucby</label>
            <div class="input-group has-validation mb-3">
                <input type="date" class="form-control" id="koniec" name="koniec">
            </div>
            <button type="submit" class="btn btn-success">Ulozit</button>

        </form>


    </div>



</div>
