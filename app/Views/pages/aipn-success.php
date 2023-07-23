<?= $this->extend("layout/aipn-master") ?>
<?= $this->section("pageTitle") ?>
TRH|<?= lang('app.aipn_success_page') ?>
<?= $this->endSection() ?>
<?= $this->section("content") ?>
<div class="container mt-5">
    <h1><?= lang('app.aipn_success_title') ?></h1>
    <div class="card-header text-center">
        <strong><?= lang('app.aipn_success_header') ?></strong>
    </div>
    <div class="card-body">
        <div class="mt-2">
            <?php $validation = \Config\Services::validation(); ?>
        </div>
        <div class="mt-2">
            <div class="d-grid">
                <a href="<?=$aipn_['url']?>" class="btn btn-success"><?= lang('app.aipn_success_download') ?></a>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>