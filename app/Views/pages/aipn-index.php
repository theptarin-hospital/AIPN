<?= $this->extend("layout/aipn-master") ?>

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
            <?php $validation = \Config\Services::validation(); ?>
        </div>	
        <form action="<?php echo base_url('aipn/upload'); ?>" class="was-validated" method="post" enctype="multipart/form-data">
            <div class="form-group mb-3">
                <div class="input-group mb-3">               
                    <span class="input-group-text" >ID</span>
                    <input type="number" name="num"class="form-control" min="1" max="9999" placeholder="<?= lang('app.aipn_index_id_placeholder') ?>" required>
                </div>
                <div class="input-group mb-3">
                    <input type="file" name="ipadt" class="form-control" accept=".CSV" required>
                    <span class="input-group-text" id="text-ipadt">IPADT</span>
                </div>
                <div class="input-group mb-3">
                    <input type="file" name="ipdx" class="form-control" accept=".CSV" required>
                    <span class="input-group-text" id="text-ipdx">IPDx</span>
                </div>
                <div class="input-group mb-3">
                    <input type="file" name="ipop" class="form-control" accept=".CSV" required>
                    <span class="input-group-text" id="text-ipop">IPOp</span>
                </div>
                <div class="input-group mb-3">
                    <input type="file" name="billitems" class="form-control" accept=".CSV" required>
                    <span class="input-group-text" id="text-billitems">BillItems</span>
                </div>
            </div>
            <div class="d-grid">
                <input type="submit" name="submit" value="<?= lang('app.aipn_index_submit') ?>" class="btn  btn-primary" />
            </div>
        </form>
    </div>
</div>
<?= $this->endSection() ?>