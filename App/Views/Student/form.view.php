<form method="post" action="" enctype="multipart/form-data">
    <label for="jazyk" class="form-label">Zvoleny jazyk</label>
    <div class="input-group has-validation mb-3">
        <?php if (@$data['student'] != ""): ?>
            <input type="text" class="form-control" id="jazyk" name="jazyk" placeholder="<?= $data['student']->getJazyk() ?>" required>
        <?php else: ?>
            <input type="text" class="form-control" id="jazyk" name="jazyk"  required>
        <?php endif;?>

    </div>
    <label for="zaciatok" class="form-label">Zaciatok vyucby</label>
    <div class="input-group has-validation mb-3">
        <?php if (@$data['student'] != ""): ?>
            <input type="text" class="form-control" id="zaciatok" name="zaciatok" placeholder="<?= $data['student']->getZaciatok() ?>" onfocus="(this.type='date')" onblur="(this.type='text')" required>
        <?php else: ?>
            <input type="date" class="form-control" id="zaciatok" name="zaciatok" required>
        <?php endif;?>
    </div>
    <label for="koniec" class="form-label">Koniec vyucby</label>
    <div class="input-group has-validation mb-3">
        <?php if (@$data['student'] != ""): ?>
            <input type="text" class="form-control" id="koniec" name="koniec" placeholder="<?= $data['student']->getKoniec() ?>" onfocus="(this.type='date')" onblur="(this.type='text')">
        <?php else: ?>
            <input type="date" class="form-control" id="koniec" name="koniec">
        <?php endif;?>
    </div>
    <button type="submit" class="btn btn-success">Ulozit</button>

</form>