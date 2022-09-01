<?= $this->extend('layout/templateHome'); ?>

<?= $this->section('content'); ?>

<?= view('layout/templateSidebar', ['menus' => $menu]); ?>

<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1><?= $title; ?></h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item"><a href="/dashboard"><?= $breadcrumb[0]; ?></a></div>
                <div class="breadcrumb-item active"><?= $breadcrumb[1]; ?></div>
            </div>
        </div>
        <div class="section-body">
            <div class="card">
                <div class="card-body">
                </div>
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="blok-angkatan" data-toggle="tab" href="#blokAngkatan" role="tab" aria-controls="blokAngkatan" aria-selected="true">Blok dan Angkatan</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="range-tanggal" data-toggle="tab" href="#rangeTanggal" role="tab" aria-controls="rangeTanggal" aria-selected="false">Range Tanggal</a>
                    </li>
                </ul>
                <div class="tab-content tab-bordered" id="myTabContent">
                    <div class="tab-pane fade show active" id="blokAngkatan" role="tabpanel" aria-labelledby="blok-angkatan">
                        <form action="/reportJadwal/blokAngkatan/proses" method="POST">
                            <?php csrf_field() ?>
                            <div class="form-row mt-2">
                                <div class="form-group col-md-3">
                                    <select class="form-control" name="staseRefleksi">
                                        <option value="">Pilih Stase</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-3">
                                    <select class="form-control" name="kelompokRefleksi">
                                        <option value="">Pilih Kelompok</option>
                                    </select>
                                </div>
                                <div style="display: inline-block; margin-top: 4px; margin-left: 5px;" class="buttons">
                                    <button type="submit" class="btn btn-icon icon-left btn-primary"><i class="fas fa-search"></i> Cari</button>
                                </div>
                            </div>
                        </form>
                        <div class="card">
                            <div class="card-body">
                                <?php if (!empty(session()->getFlashdata('success'))) : ?>
                                    <?= view('layout/templateAlertIcon', ['msg' => ['success', 'fas fa-check', 'Sukses!', session()->getFlashdata('success')]]); ?>
                                <?php endif; ?>
                                <?php if ($validation->hasError('dataBlok')) : ?>
                                    <?= view('layout/templateAlertIcon', ['msg' => ['danger', 'fas fa-exclamation', 'Gagal!', $validation->getError('dataBlok')]]); ?>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="rangeTanggal" role="tabpanel" aria-labelledby="range-tanggal">
                        <form action="/reportJadwal/rangeTanggal/proses" method="POST">
                            <?php csrf_field() ?>
                            <div class="form-row mt-2">
                                <div class="form-group col-md-3">
                                    <select class="form-control" name="staseRefleksi">
                                        <option value="">Pilih Stase</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-3">
                                    <select class="form-control" name="kelompokRefleksi">
                                        <option value="">Pilih Kelompok</option>
                                    </select>
                                </div>
                                <div style="display: inline-block; margin-top: 4px; margin-left: 5px;" class="buttons">
                                    <button type="submit" class="btn btn-icon icon-left btn-primary"><i class="fas fa-search"></i> Cari</button>
                                </div>
                            </div>
                        </form>
                        <div class="card">
                            <div class="card-body">
                                <?php if (!empty(session()->getFlashdata('success'))) : ?>
                                    <?= view('layout/templateAlertIcon', ['msg' => ['success', 'fas fa-check', 'Sukses!', session()->getFlashdata('success')]]); ?>
                                <?php endif; ?>
                                <?php if ($validation->hasError('dataBlok')) : ?>
                                    <?= view('layout/templateAlertIcon', ['msg' => ['danger', 'fas fa-exclamation', 'Gagal!', $validation->getError('dataBlok')]]); ?>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<?= view('layout/templateFooter'); ?>

<?= $this->endSection(); ?>