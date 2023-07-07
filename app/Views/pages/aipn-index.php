<?= $this->extend("layout/master") ?>

<?= $this->section("pageTitle") ?>
About Us
<?= $this->endSection() ?>

<?= $this->section("content") ?>

<h1>Theptarin AIPN page.</h1>
<p class="lead"><?= lang('app.msg') ?></p>
<p class="lead">
    <a href="#" class="btn btn-lg btn-secondary fw-bold border-white bg-white">Learn more</a>
</p>
<div class="form-floating">
    <input type="text" class="form-control" id="floatingInput" placeholder="123-456-789" maxlength="9">
    <label for="floatingInput">Admit Number</label>
</div>

<?= $this->endSection() ?>