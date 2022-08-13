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
                    <div class="card-header-form col-md-4">
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
                    <?php if ($validation->hasError('dataDosen')) : ?>
                        <?= view('layout/templateAlertIcon', ['msg' => ['danger', 'fas fa-exclamation', 'Gagal!', $validation->getError('dataDosen')]]); ?>
                    <?php endif; ?>
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th width="2%" style="text-align:center" scope="col">No.</th>
                                    <th width="25%" scope="col">Nama Lengkap</th>
                                    <th scope="col">Nama</th>
                                    <th scope="col">Email</th>
                                    <th scope="col">Handphone</th>
                                    <th width="10%" style="text-align:center" scope="col">Action</th>
                                </tr>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($dosen)) : ?>
                                    <?php
                                    $no = 1 + ($numberPage * ($currentPage - 1));
                                    foreach ($dosen as $data) : ?>
                                        <tr>
                                            <td style="text-align:center" scope="row"><?= $no++; ?></td>
                                            <td><?= $data->dosenFullname; ?></td>
                                            <td><?= $data->dosenShortname; ?></td>
                                            <td><?= ($data->dosenEmail == null) ? '-' : $data->dosenEmail; ?></td>
                                            <td><?= ($data->dosenPhone == null) ? '-' : $data->dosenPhone; ?></td>
                                            <td style="text-align:center">
                                                <button class="btn btn-icon icon-left btn-danger" data-toggle="modal" data-target="#hapus<?= $data->dosenId; ?>"><i class="fas fa-trash"></i></button>
                                            </td>
                                        </tr>
                                    <?php endforeach ?>
                                <?php else : ?>
                                    <?= view('layout/templateEmpty', ['jumlahSpan' => 6]); ?>
                                <?php endif ?>
                            </tbody>
                        </table>
                        <?= $pager->links('dosen', 'pager') ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<!-- start modal tambah -->
<div class="modal fade" tabindex="-1" role="dialog" id="tambah">
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Data<strong> <?= $title; ?></strong></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="dosen/tambah" method="POST">
                <?= csrf_field() ?>
                <div class="modal-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered" id="table-1">
                            <thead>
                                <tr>
                                    <th width="2%" style="text-align:center" scope="col"></th>
                                    <th width="25%" scope="col">Nama Lengkap</th>
                                    <th scope="col">Nama</th>
                                    <th scope="col">Email</th>
                                    <th scope="col">Handphone</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                foreach ($apiDosen as $data) : ?>
                                    <tr>
                                        <td style="text-align:center" scope="row">
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" id="check<?= $data->Employee_Id ?>" name="dataDosen[]" value="<?= $data->Full_Name . "-" . $data->Name . "-" . $data->Email_Corporate . "-" . $data->Phone_Mobile  ?>">
                                                <label class="custom-control-label" for="check<?= $data->Employee_Id ?>"></label>
                                            </div>
                                        </td>
                                        <td><?= $data->Full_Name; ?></td>
                                        <td><?= $data->Name; ?></td>
                                        <td><?= ($data->Email_Corporate == null) ? '-' : $data->Email_Corporate; ?></td>
                                        <td><?= ($data->Phone_Mobile == null) ? '-' : $data->Phone_Mobile; ?></td>
                                    </tr>
                                <?php endforeach ?>
                            </tbody>
                        </table>
                    </div>
                    <br>
                    <div class="modal-footer bg-whitesmoke br">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- end modal tambah -->

<!-- start modal hapus  -->
<?php foreach ($dosen as $hapus) : ?>
    <div class="modal fade" tabindex="-1" role="dialog" id="hapus<?= $hapus->dosenId; ?>">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Hapus Data <strong><?= $title; ?></strong></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Apakah kamu benar ingin menghapus data dosen <strong><?= $hapus->dosenFullname; ?></strong>?</p>
                    <p class="text-warning"><small>This action cannot be undone</small></p>
                </div>
                <form action="/dosen/hapus/<?= $hapus->dosenId; ?>" method="post">
                    <?= csrf_field(); ?>
                    <input type="hidden" name="_method" value="DELETE">
                    <div class="modal-footer bg-whitesmoke br">
                        <button type="submit" class="btn btn-danger">Delete</button>
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