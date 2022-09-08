<?= $this->extend('layout/templateHome'); ?>

<?= $this->section('content'); ?>

<?= view('layout/templateSidebar', ['menus' => $menu]); ?>

<!-- Main Content -->
<div class="main-content">
    <section class=" section">
        <div class="section-header">
            <h1><?= $title; ?></h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item"><a href="#"><?= $breadcrumb[0]; ?></a></div>
                <div class="breadcrumb-item active"><?= $breadcrumb[1]; ?></div>
            </div>
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col-12">
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
                            <?php if ($validation->hasError('sesiJenisJadwalId')) : ?>
                                <?= view('layout/templateAlertIcon', ['msg' => ['danger', 'fas fa-exclamation', 'Gagal!', $validation->getError('sesiJenisJadwalId')]]); ?>
                            <?php endif; ?>
                            <?php if ($validation->hasError('sesiNama')) : ?>
                                <?= view('layout/templateAlertIcon', ['msg' => ['danger', 'fas fa-exclamation', 'Gagal!', $validation->getError('sesiNama')]]); ?>
                            <?php endif; ?>
                            <?php if ($validation->hasError('sesiStart')) : ?>
                                <?= view('layout/templateAlertIcon', ['msg' => ['danger', 'fas fa-exclamation', 'Gagal!', $validation->getError('sesiStart')]]); ?>
                            <?php endif; ?>
                            <?php if ($validation->hasError('sesiEnd')) : ?>
                                <?= view('layout/templateAlertIcon', ['msg' => ['danger', 'fas fa-exclamation', 'Gagal!', $validation->getError('sesiEnd')]]); ?>
                            <?php endif; ?>
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered">
                                    <thead>
                                        <tr>
                                            <th width="2%" style="text-align:center" scope="col">No.</th>
                                            <th scope="col">Jadwal</th>
                                            <th width="18%" scope="col">Sesi</th>
                                            <th width="10%" style="text-align:center" scope="col">Action</th>
                                        </tr>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if (!empty($sesiJadwal)) : ?>
                                            <?php
                                            $no = 1 + ($numberPage * ($currentPage - 1));
                                            foreach ($sesiJadwal as $data) : ?>
                                                <tr>
                                                    <td style="text-align:center" scope="row"><?= $no++; ?></td>
                                                    <td><?= $data->jenisJadwalKode; ?></td>
                                                    <td><span data-toggle="modal" data-target="#sesi<?= $data->sesiJenisJadwalId; ?>" class="text-primary" style="cursor:pointer">Klik disini untuk liihat sesi</span></td>
                                                    <td style="text-align:center">
                                                        <button class="btn btn-icon icon-left btn-warning" data-toggle="modal" data-target="#editData<?= $data->sesiJenisJadwalId; ?>"><i class="fas fa-pen"></i></button>
                                                    </td>
                                                </tr>
                                            <?php endforeach ?>
                                        <?php else : ?>
                                            <?= view('layout/templateEmpty', ['jumlahSpan' => 4]); ?>
                                        <?php endif ?>
                                    </tbody>
                                </table>
                                <?= $pager->links('sesi', 'pager') ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<!-- start modal sesi  -->
<?php foreach ($jenis as $jns) : ?>
    <div class="modal fade" tabindex="-1" role="dialog" id="sesi<?= $jns->jenisJadwalId; ?>">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><?= $jns->jenisJadwalNama ?></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th width="2%" style="text-align:center" scope="col">No.</th>
                                    <th scope="col">Sesi</th>
                                    <th scope="col">Jam Mulai</th>
                                    <th scope="col">Jam Akhir</th>
                                </tr>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1;
                                foreach ($sesiJam as $detail) : ?>
                                    <?php if ($detail->sesiJenisJadwalId == $jns->jenisJadwalId) : ?>
                                        <tr>
                                            <td style="text-align:center" scope="row"><?= $no++; ?></td>
                                            <td><?= $detail->sesiNama; ?></td>
                                            <td><?= $detail->sesiStart; ?></td>
                                            <td><?= $detail->sesiEnd; ?></td>
                                        </tr>
                                    <?php endif ?>
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
<!-- end modal sesi -->

<!-- start modal edit data  -->
<?php foreach ($jenis as $jns) : ?>
    <div class="modal fade" tabindex="-1" role="dialog" id="editData<?= $jns->jenisJadwalId; ?>">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><?= $jns->jenisJadwalNama ?></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th width="2%" style="text-align:center" scope="col">No.</th>
                                    <th scope="col">Sesi</th>
                                    <th scope="col">Jam Mulai</th>
                                    <th scope="col">Jam Akhir</th>
                                    <th style="text-align:center" scope="col">Action</th>
                                </tr>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1;
                                foreach ($sesiJam as $detail) : ?>
                                    <?php if ($detail->sesiJenisJadwalId == $jns->jenisJadwalId) : ?>
                                        <tr>
                                            <td style="text-align:center" scope="row"><?= $no++; ?></td>
                                            <td><?= $detail->sesiNama; ?></td>
                                            <td><?= $detail->sesiStart; ?></td>
                                            <td><?= $detail->sesiEnd; ?></td>
                                            <td style="text-align:center">
                                                <button class="btn btn-icon icon-left btn-warning" data-toggle="modal" data-target="#edit<?= $detail->sesiId; ?>"><i class="fas fa-pen"></i></button>
                                                <button class="btn btn-icon icon-left btn-danger" data-toggle="modal" data-target="#hapus<?= $detail->sesiId; ?>"><i class="fas fa-trash"></i></button>
                                            </td>
                                        </tr>
                                    <?php endif ?>
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
<!-- end modal edit data -->

<!-- start modal tambah  -->
<div class="modal fade" tabindex="-1" role="dialog" id="tambah">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Data Sesi</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="/sesi/tambah" method="post">
                <?= csrf_field(); ?>
                <input type="hidden" name="sesiCreatedBy" value="<?= user()->email ?>">
                <div class="modal-body">
                    <div class="form-group">
                        <label>Jadwal</label>
                        <select class="form-control select2" name="sesiJenisJadwalId">
                            <option value="">Pilih Jadwal</option>
                            <?php foreach ($jenis as $key => $option) : ?>
                                <option value="<?= $option->jenisJadwalId ?>"><?= $option->jenisJadwalKode ?></option>
                            <?php endforeach ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Sesi</label>
                        <input name="sesiNama" type="text" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Jam Mulai</label>
                        <input name="sesiStart" type="time" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Jam Akhir</label>
                        <input name="sesiEnd" type="time" class="form-control">
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
<?php foreach ($sesiJam as $edit) : ?>
    <div class="modal fade" tabindex="-1" role="dialog" id="edit<?= $edit->sesiId; ?>">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><?= $edit->jenisJadwalNama; ?> - <strong><?= $edit->sesiNama; ?></strong></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="/sesi/ubah/<?= $edit->sesiId; ?>" method="post">
                    <?= csrf_field(); ?>
                    <input type="hidden" name="sesiModifiedBy" value="<?= user()->email ?>">
                    <div class="modal-body">
                        <input type="hidden" name="sesiJenisJadwalId" value="<?= $edit->sesiJenisJadwalId; ?>">
                        <div class="form-group">
                            <label>Sesi</label>
                            <input name="sesiNama" type="text" class="form-control" value="<?= $edit->sesiNama; ?>">
                        </div>
                        <div class="form-group">
                            <label>Jam Mulai</label>
                            <input name="sesiStart" type="time" class="form-control" value="<?= $edit->sesiStart; ?>">
                        </div>
                        <div class="form-group">
                            <label>Jam Akhir</label>
                            <input name="sesiEnd" type="time" class="form-control" value="<?= $edit->sesiEnd; ?>">
                        </div>
                    </div>
                    <input type="hidden" name="_method" value="PUT">
                    <div class="modal-footer bg-whitesmoke br">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php endforeach ?>
<!-- end modal edit -->

<!-- start modal hapus  -->
<?php foreach ($sesiJam as $hapus) : ?>
    <div class="modal fade" tabindex="-1" role="dialog" id="hapus<?= $hapus->sesiId; ?>">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><strong>Konfirmasi</strong></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Apakah kamu benar ingin menghapus data <strong><?= $hapus->sesiNama; ?></strong> di <strong><?= $hapus->jenisJadwalNama; ?></strong>?</p>
                    <p class="text-warning"><small>This action cannot be undone</small></p>
                </div>
                <form action="/sesi/hapus/<?= $hapus->sesiId; ?>" method="post">
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

<?= view('layout/templateFooter'); ?>

<?= $this->endSection(); ?>