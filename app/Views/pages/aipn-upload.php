<?= $this->extend("layout/aipn-master") ?>

<?= $this->section("pageTitle") ?>
TRH|<?= lang('app.aipn_upload_page') ?>
<?= $this->endSection() ?>

<?= $this->section("content") ?>
<div class="container mt-5">
    <h1><?= lang('app.aipn_upload_title') ?></h1>
    <div class="card-header text-center">
        <strong><?= lang('app.aipn_upload_header') ?> AN.<?=$an?></strong>
    </div>
    <div class="card-body">
        <div class="mt-2">
            <?php if (session()->has('message')) { ?>
                <div class="alert <?= session()->getFlashdata('alert-class') ?>">
                    <?= session()->getFlashdata('message') ?>
                </div>
            <?php } ?>
            <?php $validation = \Config\Services::validation(); ?>
        </div>	
        <form action="<?php echo base_url('aipn/ipadt/upload'); ?>" class="was-validated" method="post" enctype="multipart/form-data">
            <div class="form-group mb-3">
                <div class="mb-3">
                    <input type="file" name="file" class="form-control" id="file" required>
                </div>					   
            </div>
            <div class="d-grid">
                <input type="submit" name="submit" value="Upload" class="btn  btn-primary" />
            </div>
        </form>
    </div>
</div>
<?= $this->endSection() ?>