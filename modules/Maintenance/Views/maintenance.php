<?= $this->extend('layout/templateHome'); ?>

<?= $this->section('content'); ?>

<?= view('layout/templateSidebar', ['menus' => $menu]); ?>

<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Maintenance</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item"><a href="#"><?= $breadcrumb[0]; ?></a></div>
                <div class="breadcrumb-item active"><?= $breadcrumb[1]; ?></div>
            </div>
        </div>
        <div class="section-body">
            <div class="card">
                <center>
                    <lottie-player src="https://assets1.lottiefiles.com/packages/lf20_vlpqwkz3.json" background="transparent" speed="1" style="width: 100%; height: 600px;" loop autoplay></lottie-player>
                </center>
            </div>
        </div>
    </section>
</div>

<?= view('layout/templateFooter'); ?>

<?= $this->endSection(); ?>