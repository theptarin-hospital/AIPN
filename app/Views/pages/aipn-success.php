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
            <ul>
                <li>name: <?= esc($uploaded_fileinfo->getBasename()) ?></li>
                <li>size: <?= esc($uploaded_fileinfo->getSizeByUnit('kb')) ?> KB</li>
                <li>extension: <?= esc($uploaded_fileinfo->guessExtension()) ?></li>
            </ul>
        </div>
    </div>
</div>
<?= $this->endSection() ?>