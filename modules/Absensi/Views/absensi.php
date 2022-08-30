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
                <div class="card-header">
                    <button class="btn btn-icon icon-left btn-primary" data-toggle="modal" data-target="#tambah"><i class="fas fa-plus"></i> Tambah Data</button>
                    <h4></h4>
                    <div class="card-header-form">
                        <form action="">
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="Search" name="keyword" value="<?= isset($_GET['keyword']) ? $_GET['keyword'] : "" ?>">
                                <div class="input-group-btn">
                                    <button type="submit" class="btn btn-primary"><i class="fas fa-search"></i></button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="card-body">
                    <?php if (!empty(session()->getFlashdata('success'))) : ?>
                        <?= view('layout/templateAlertIcon', ['msg' => ['success', 'fas fa-check', 'Sukses!', session()->getFlashdata('success')]]); ?>
                    <?php endif; ?>
                    <?php if ($validation->hasError('absensiAngkatan')) : ?>
                        <?= view('layout/templateAlertIcon', ['msg' => ['danger', 'fas fa-exclamation', 'Gagal!', $validation->getError('absensiAngkatan')]]); ?>
                    <?php endif; ?>
                    <?php if ($validation->hasError('absensiMatkulBlokId')) : ?>
                        <?= view('layout/templateAlertIcon', ['msg' => ['danger', 'fas fa-exclamation', 'Gagal!', $validation->getError('absensiMatkulBlokId')]]); ?>
                    <?php endif; ?>
                    <?php if ($validation->hasError('absensiPeserta')) : ?>
                        <?= view('layout/templateAlertIcon', ['msg' => ['danger', 'fas fa-exclamation', 'Gagal!', $validation->getError('absensiPeserta')]]); ?>
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
                                    <th style="text-align:center" scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($absen)) : ?>
                                    <?php
                                    $no = 1 + ($numberPage * ($currentPage - 1));
                                    foreach ($absen as $data) : ?>
                                        <tr>
                                            <td style="text-align:center" scope="row"><?= $no++; ?></td>
                                            <td><?= $data->absensiTahunAjaran ?></td>
                                            <td><?= $data->absensiAngkatan; ?></td>
                                            <td><?= $data->matkulBlokNama; ?></td>
                                            <td><span data-toggle="modal" data-target="#dosen<?= $data->absensiId ?>" class="text-primary" style="cursor:pointer">Lihat Daftar Dosen</span></td>
                                            <td style="text-align:center">
                                                <button class="btn btn-icon icon-left btn-warning" data-toggle="modal" data-target="#edit<?= $data->absensiId ?>"><i class="fas fa-pen"></i></button>
                                                <button class="btn btn-icon icon-left btn-danger" data-toggle="modal" data-target="#hapus<?= $data->absensiId ?>"><i class="fas fa-trash"></i></button>
                                            </td>
                                        </tr>
                                    <?php endforeach ?>
                                <?php else : ?>
                                    <?= view('layout/templateEmpty', ['jumlahSpan' => 6]); ?>
                                <?php endif ?>
                            </tbody>
                        </table>
                        <?= $pager->links('absen', 'pager') ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<!-- start modal tambah  -->
<div class="modal fade" role="dialog" id="tambah">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Data <strong><?= $title; ?></strong></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="post" action="/absensi/tambah">
                <?= csrf_field(); ?>
                <div class="modal-body">
                    <input type="hidden" name="absensiTahunAjaran" value="<?= $tahunAjaran ?>">
                    <div class="form-group">
                        <label>Angkatan</label>
                        <select class="form-control select2" name="absensiAngkatan">
                            <option value="">Pilih Angkatan</option>
                            <?php for ($i = date("Y"); $i >= 2016; $i--) : ?>
                                <option value="<?= $i ?>"><?= $i ?></option>
                            <?php endfor ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Blok</label>
                        <select class="form-control select2" name="absensiMatkulBlokId">
                            <option value="">Pilih Blok</option>
                            <?php foreach ($blok as $key => $option) : ?>
                                <option value="<?= $option->matkulBlokId ?>"><?= $option->matkulBlokNama ?></option>
                            <?php endforeach ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Dosen</label>
                        <select class="form-control select2" multiple="" name="absensiPeserta[]">
                            <?php foreach ($dosen as $key => $option) : ?>
                                <option value="<?= $option->dosenEmailGeneral ?>"><?= $option->dosenFullname ?></option>
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
<!-- end modal tambah -->

<!-- start modal edit  -->
<?php foreach ($absen as $edit) : ?>
    <div class="modal fade" role="dialog" id="edit<?= $edit->absensiId ?>">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Data <strong><?= $title; ?></strong></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="post" action="/absensi/ubah/<?= $edit->absensiId ?>">
                    <?= csrf_field(); ?>
                    <div class="modal-body">
                        <input type="hidden" value="PUT" name="_method">
                        <input type="hidden" name="absensiTahunAjaran" value="<?= $edit->absensiTahunAjaran ?>">
                        <div class="form-group">
                            <label>Angkatan</label>
                            <select class="form-control select2" name="absensiAngkatan">
                                <option value="">Pilih Angkatan</option>
                                <?php for ($i = date("Y"); $i >= 2016; $i--) : ?>
                                    <option value="<?= $i ?>" <?= ($i == $edit->absensiAngkatan) ? 'selected' : ''; ?>><?= $i ?></option>
                                <?php endfor ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Blok</label>
                            <select class="form-control select2" name="absensiMatkulBlokId">
                                <option value="">Pilih Blok</option>
                                <?php foreach ($blok as $key => $option) : ?>
                                    <option value="<?= $option->matkulBlokId ?>" <?= ($option->matkulBlokId == $edit->absensiMatkulBlokId) ? 'selected' : ''; ?>><?= $option->matkulBlokNama ?></option>
                                <?php endforeach ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Dosen</label>
                            <select class="form-control select2" multiple="" name="absensiPeserta[]">
                                <?php foreach ($dosen as $key => $option) : ?>
                                    <option value="<?= $option->dosenEmailGeneral ?>" <?= (in_array($option->dosenEmailGeneral, decryptPeserta($edit->absensiPeserta))) ? 'selected' : ''; ?>><?= $option->dosenFullname ?></option>
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
<?php endforeach ?>
<!-- end modal edit -->

<!-- start modal hapus  -->
<?php foreach ($absen as $hapus) : ?>
    <div class="modal fade" tabindex="-1" role="dialog" id="hapus<?= $hapus->absensiId; ?>">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><strong>Konfirmasi</strong></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Apakah kamu benar ingin menghapus data <?= $title ?> blok <strong><?= $hapus->matkulBlokNama; ?></strong> angkatan <strong><?= $hapus->absensiAngkatan; ?></strong> tahun ajaran <strong><?= $hapus->absensiTahunAjaran; ?></strong>?</p>
                    <p class="text-warning"><small>This action cannot be undone</small></p>
                </div>
                <form action="/absensi/hapus/<?= $hapus->absensiId; ?>" method="post">
                    <?= csrf_field(); ?>
                    <input type="hidden" name="_method" value="DELETE">
                    <div class="modal-footer bg-whitesmoke br">
                        <button type="submit" class="btn btn-danger">Yes</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php endforeach ?>
<!-- end modal hapus -->

<!-- start modal dosen  -->
<?php foreach ($absen as $dosen) : ?>
    <div class="modal fade" role="dialog" id="dosen<?= $dosen->absensiId ?>">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Daftar <strong>Dosen</strong></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <?php $dsn = json_decode($dosen->absensiPeserta)->data ?>
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th width="2%" style="text-align:center" scope="col">No.</th>
                                    <th scope="col">Nama Lengkap</th>
                                    <th scope="col">Email</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1;
                                foreach ($dsn as $dt) : ?>
                                    <tr>
                                        <td style="text-align:center" scope="row"><?= $no++; ?></td>
                                        <td><?= getDosenName($dt->email) ?></td>
                                        <td><?= $dt->email ?></td>
                                    </tr>
                                <?php endforeach ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer bg-whitesmoke br">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
<?php endforeach ?>
<!-- end modal dosen -->

<?= view('layout/templateFooter'); ?>

<?= $this->endSection(); ?>