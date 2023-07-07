<?= $this->extend("layout/master") ?>

<?= $this->section("pageTitle") ?>
TRH|<?= lang('app.aipn_index_page') ?>
<?= $this->endSection() ?>

<?= $this->section("content") ?>
<div class="container mt-5">
    <h1><?= lang('app.aipn_index_title') ?></h1>
    <div class="card-header text-center">
        <strong><?= lang('app.aipn_index_header') ?></strong>
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
        <form action="<?php echo base_url('StudentController/importCsvToDb'); ?>" method="post" enctype="multipart/form-data">
            <div class="form-group mb-3">
                <div class="input-group mb-3">
                    <span class="input-group-text" id="basic-addon3">AN.</span>
                    <input type="text" class="form-control" placeholder="รหัสการรับผู้ป่วยใน" aria-label="" aria-describedby="aipn-an1">
                </div>			   
            </div>
            <div class="d-grid">
                <input type="submit" name="submit" value="Submit" class="btn  btn-primary" />
            </div>
        </form>
    </div>
</div>
<?= $this->endSection() ?>