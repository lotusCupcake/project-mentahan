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
                <div class="breadcrumb-item"><a href="/absensi"><?= $breadcrumb[1]; ?></a></div>
                <div class="breadcrumb-item active"><?= $breadcrumb[2]; ?></div>
            </div>
        </div>
        <div class="section-body">
            <div class="card">
                <div class="card-header">
                    <button class="btn btn-icon icon-left btn-primary" data-toggle="modal" data-target="#upload"><i class="fas fa-file-excel"></i> Upload Data</button>
                </div>
                <div class="card-body">
                    <?php if (!empty(session()->getFlashdata('success'))) : ?>
                        <?= view('layout/templateAlertIcon', ['msg' => ['success', 'fas fa-check', 'Sukses!', session()->getFlashdata('success')]]); ?>
                    <?php endif; ?>
                    <?php if ($validation->hasError('dataBlok')) : ?>
                        <?= view('layout/templateAlertIcon', ['msg' => ['danger', 'fas fa-exclamation', 'Gagal!', $validation->getError('dataBlok')]]); ?>
                    <?php endif; ?>
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th width="2%" style="text-align:center" scope="col">No.</th>
                                    <th scope="col">Tahun Ajar</th>
                                    <th scope="col">Angkatan</th>
                                    <th scope="col">Blok</th>
                                    <th scope="col">Dosen</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?= view('layout/templateEmpty', ['jumlahSpan' => 5]); ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<!-- start modal hapus  -->
<div class="modal fade" tabindex="-1" role="dialog" id="upload">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Data <strong><?= $title; ?></strong></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="post" action="/absensi/unggah" enctype="multipart/form-data">
                <?= csrf_field(); ?>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Tahun Ajaran</label>
                        <select class="form-control select2" name="absensiTahunAjaran">
                            <option value="">Pilih Tahun Ajaran</option>
                            <option value="2021/Genap">2021/Genap</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Angkatan</label>
                        <input name="absensiAngkatan" type="number" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Nama Blok</label>
                        <select class="form-control select2" name="absensiMatkulBlokId">
                            <option value="">Pilih Blok</option>
                            <?php foreach ($blok as $key => $blok) : ?>
                                <option value="<?= $blok->matkulBlokId ?>"><?= $blok->matkulBlokKode ?> - <?= $blok->matkulBlokNama ?> (<?= $blok->matkulBlokKurikulumNama ?>)</option>
                            <?php endforeach ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Dosen</label>
                        <select class="form-control select2" multiple="" name="absensiPeserta[]">
                            <option value="">Pilih Dosen</option>
                            <?php foreach ($dosen as $key => $dosen) : ?>
                                <option value="<?= $dosen->dosenId ?>"><?= $dosen->dosenFullname ?></option>
                            <?php endforeach ?>
                        </select>
                    </div>
                </div>
                <div class="modal-footer bg-whitesmoke br">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- end modal hapus -->

<?= view('layout/templateFooter'); ?>

<?= $this->endSection(); ?>