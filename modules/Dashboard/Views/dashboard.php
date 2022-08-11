<?= $this->extend('layout/templateHome'); ?>

<?= $this->section('content'); ?>

<?= view('layout/templateSidebar', ['menus' => $menu]); ?>

<!-- Main Content -->
<div class="main-content">
    <section class=" section">
        <div class="section-header">
            <h1>Selamat Datang di Aplikasi Digisched UMSU</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item"><a href="#"><?= $breadcrumb[0]; ?></a></div>
                <div class="breadcrumb-item active"><?= $breadcrumb[1]; ?></div>
            </div>
        </div>
        <div class="section-body">
            <div class="card text-center" style="height: 700px;">
                <div class="pt-5" style="width: 100%; height: 600px ;margin-top: 100px">
                    <lottie-player src="https://assets5.lottiefiles.com/packages/lf20_3xtpb0bw.json" background="transparent" speed="1" loop autoplay></lottie-player>
                </div>
            </div>
        </div>
    </section>
</div>

<?= view('layout/templateFooter'); ?>

<?= $this->endSection(); ?>