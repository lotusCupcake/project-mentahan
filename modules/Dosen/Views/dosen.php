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
                </div>
                <div class="card-body">
                    <?php if (!empty(session()->getFlashdata('success'))) : ?>
                        <?= view('layout/templateAlertIcon', ['msg' => ['success', 'fas fa-check', 'Sukses!', session()->getFlashdata('success')]]); ?>
                    <?php endif; ?>
                    <?php if (!empty(session()->getFlashdata('abort'))) : ?>
                        <?= view('layout/templateAlertIcon', ['msg' => ['success', 'fas fa-check', 'Sukses!', session()->getFlashdata('abort')]]); ?>
                    <?php endif; ?>
                    <?php if (!empty(session()->get('dataSession')['dtDosen'])) : ?>
                        <?= view('layout/templateAlertIcon', ['msg' => ['info', 'far fa-lightbulb', 'Info!', 'Pastikan Email General Dosen Valid/Tidak Kosong']]); ?>
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
                                    <th width="15%" scope="col">Email Corporate</th>
                                    <th width="15%" scope="col">Email General</th>
                                    <th scope="col">Handphone</th>
                                    <th width="8%" scope="col">Status</th>
                                    <th width="8%" scope="col"></th>
                                </tr>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty(session()->get('dataSession')['dtDosen'])) : ?>
                                    <?php $no = 1;
                                    foreach (session()->get('dataSession')['dtDosen'] as $sync) : ?>
                                        <form action="/dosen/simpan" method="POST">
                                            <input type="hidden" name="dosenSimakadId[]" value="<?= $sync['dosenSimakadId']; ?>">
                                            <input type="hidden" name="dosenId[]" value="<?= $sync['dosenId']; ?>">
                                            <tr>
                                                <td style="text-align:center" scope="row"><?= $no++; ?></td>
                                                <td><input type="text" name="dosenFullname[]" class="form-control" value="<?= $sync['dosenFullname']; ?>" readonly></td>
                                                <td><input type="text" name="dosenShortname[]" class="form-control" value="<?= $sync['dosenShortname']; ?>" readonly></td>
                                                <td><input type="text" name="dosenEmailCorporate[]" class="form-control" value="<?= $sync['dosenEmailCorporate']; ?>" readonly></td>
                                                <td><input type="text" name="dosenEmailGeneral[]" class="form-control" value="<?= $sync['dosenEmailGeneral']; ?>" required></td>
                                                <td><input type="text" name="dosenPhone[]" class="form-control" value="<?= $sync['dosenPhone']; ?>" readonly></td>
                                                <td><input type="text" name="dosenStatus[]" class="form-control" value="<?= ($sync['dosenStatus'] == 1) ? 'Internal' : 'Eksternal'; ?>" readonly></td>
                                                <td><input type="hidden" name="dosenAkun[]" class="form-control" id="akun" value="<?= $sync['dosenAkun']; ?>" readonly> <label for="akun" class="<?= ($sync['dosenAkun'] == 'Update') ? 'text-warning' : (($sync['dosenAkun'] == 'Denied/Duplicate') ? 'text-danger' : (($sync['dosenAkun'] == 'Insert New') ? 'text-success' : '')); ?>"><?= $sync['dosenAkun']; ?></label></td>
                                            </tr>
                                        <?php endforeach ?>
                                    <?php else : ?>
                                        <?= view('layout/templateEmptySession', ['jumlahSpan' => 8]); ?>
                                    <?php endif ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <?php if (!empty(session()->getFlashdata('counts'))) : ?>
                    <div class="card-footer">
                        <div><span><strong>Insert New: <?= session()->get('counts')['inserted'] ?></strong></span></div>
                        <div><span><strong>Update: <?= session()->get('counts')['updated'] ?></strong></span></div>
                        <div><span><strong>Denied/Duplicate: <?= session()->get('counts')['denied'] ?></strong></span></div>
                        <div><span><strong>No Action: <?= session()->get('counts')['noaction'] ?></strong></span></div>
                    </div>
                <?php endif ?>
                <?php if (!empty(session()->get('dataSession')['dtDosen'])) : ?>
                    <div class="card-footer">
                        <a href="/dosen/batal" type="button" class="btn btn-icon icon-left btn-danger mr-2"><i class="fas fa-trash"></i> Batal</a>
                        <button type="submit" class="btn btn-icon icon-left btn-success"><i class="fas fa-check"></i> Simpan</button>
                    </div>
                <?php endif ?>
                </form>
            </div>
            <div class="card">
                <div class="card-header">
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
                    <?php if (!empty(session()->getFlashdata('update'))) : ?>
                        <?= view('layout/templateAlertIcon', ['msg' => ['success', 'fas fa-check', 'Sukses!', session()->getFlashdata('update')]]); ?>
                    <?php endif; ?>
                    <?php if (!empty(session()->getFlashdata('danger'))) : ?>
                        <?= view('layout/templateAlertIcon', ['msg' => ['danger', 'fas fa-exclamation', 'Gagal!', session()->getFlashdata('danger')]]); ?>
                    <?php endif; ?>
                    <?php if ($validation->hasError('dosenFullname')) : ?>
                        <?= view('layout/templateAlertIcon', ['msg' => ['danger', 'fas fa-exclamation', 'Gagal!', $validation->getError('dosenFullname')]]); ?>
                    <?php endif; ?>
                    <?php if ($validation->hasError('dosenShortname')) : ?>
                        <?= view('layout/templateAlertIcon', ['msg' => ['danger', 'fas fa-exclamation', 'Gagal!', $validation->getError('dosenShortname')]]); ?>
                    <?php endif; ?>
                    <?php if ($validation->hasError('dosenEmailGeneral')) : ?>
                        <?= view('layout/templateAlertIcon', ['msg' => ['danger', 'fas fa-exclamation', 'Gagal!', $validation->getError('dosenEmailGeneral')]]); ?>
                    <?php endif; ?>
                    <?php if ($validation->hasError('dosenPhone')) : ?>
                        <?= view('layout/templateAlertIcon', ['msg' => ['danger', 'fas fa-exclamation', 'Gagal!', $validation->getError('dosenPhone')]]); ?>
                    <?php endif; ?>
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th width="2%" style="text-align:center" scope="col">No.</th>
                                    <th width="25%" scope="col">Nama Lengkap</th>
                                    <th scope="col">Nama</th>
                                    <th scope="col">Email Corporate</th>
                                    <th scope="col">Email General</th>
                                    <th scope="col">Handphone</th>
                                    <th scope="col">Status</th>
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
                                            <td><?= ($data->dosenEmailCorporate == null) ? '-' : $data->dosenEmailCorporate; ?></td>
                                            <td><?= ($data->dosenEmailGeneral == null) ? '-' : $data->dosenEmailGeneral; ?></td>
                                            <td><?= ($data->dosenPhone == null) ? '-' : $data->dosenPhone; ?></td>
                                            <td><?= ($data->dosenStatus == '1') ? 'Internal' : 'Eksternal'; ?></td>
                                            <td style="text-align:center">
                                                <button class="btn btn-icon icon-left btn-warning" data-toggle="modal" data-target="#edit<?= $data->dosenId; ?>"><i class="fas fa-pen"></i></button>
                                                <button class="btn btn-icon icon-left btn-danger" data-toggle="modal" data-target="#hapus<?= $data->dosenId; ?>"><i class="fas fa-trash"></i></button>
                                            </td>
                                        </tr>
                                    <?php endforeach ?>
                                <?php else : ?>
                                    <?= view('layout/templateEmpty', ['jumlahSpan' => 8]); ?>
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
                    <span aria-hin="tr-e">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="dosen-umsu" data-toggle="tab" href="#dosenUmsu" role="tab" aria-controls="dosenUmsu" aria-selected="true">Dosen Internal</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="dosen-luar" data-toggle="tab" href="#dosenLuar" role="tab" aria-controls="dosenLuar" aria-selected="false">Dosen Eksternal</a>
                    </li>
                </ul>
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="dosenUmsu" role="tabpanel" aria-labelledby="dosen-umsu">
                        <form action="dosen/tambah/internal" method="POST">
                            <div class="table-responsive">
                                <input type="hidden" name="dosen" value="internal">
                                <table class="table table-striped table-bordered">
                                    <thead>
                                        <tr>
                                            <th width="2%" style="text-align:center" scope="col"></th>
                                            <th width="25%" scope="col">Nama Lengkap</th>
                                            <th scope="col">Nama</th>
                                            <th scope="col">Email Corporate</th>
                                            <th scope="col">Email General</th>
                                            <th scope="col">Handphone</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        foreach ($apiDosen as $data) : ?>
                                            <tr>
                                                <td style="text-align:center" scope="row">
                                                    <div class="custom-control custom-checkbox">
                                                        <input type="checkbox" class="custom-control-input" id="check<?= $data->Employee_Id ?>" name="dataDosen[]" value="<?= $data->Full_Name . "#" . $data->Name . "#" . $data->Email_Corporate . "#" . $data->Email_General . "#" . $data->Phone_Mobile . "#" .  $data->Employee_Id   ?>">
                                                        <label class="custom-control-label" for="check<?= $data->Employee_Id ?>"></label>
                                                    </div>
                                                </td>
                                                <td><?= $data->Full_Name; ?></td>
                                                <td><?= $data->Name; ?></td>
                                                <td><?= ($data->Email_Corporate == null) ? '-' : $data->Email_Corporate; ?></td>
                                                <td><?= ($data->Email_General == null) ? '-' : $data->Email_General; ?></td>
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
                        </form>
                    </div>
                    <div class="tab-pane fade" id="dosenLuar" role="tabpanel" aria-labelledby="dosen-luar">
                        <form action="dosen/tambah/eksternal" method="POST">
                            <input type="hidden" name="dosen" value="eksternal">
                            <div class="form-group">
                                <label>Nama Lengkap</label>
                                <input name="dosenFullname" type="text" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label>Nama</label>
                                <input name="dosenShortname" type="text" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label>Email</label>
                                <input name="dosenEmailGeneral" type="email" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label>Handphone</label>
                                <input name="dosenPhone" type="number" class="form-control" required>
                            </div>
                            <div class="modal-footer bg-whitesmoke br">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Save</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- end modal tambah -->

<!-- start modal hapus  -->
<?php foreach ($dosen as $hapus) : ?>
    <div class="modal fade" tabindex="-1" role="dialog" id="hapus<?= $hapus->dosenId; ?>">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><strong>Konfirmasi</strong></h5>
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
                        <button type="submit" class="btn btn-danger">Yes</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php endforeach ?>
<!-- end modal hapus -->

<!-- start modal edit  -->
<?php foreach ($dosen as $edit) : ?>
    <div class="modal fade" tabindex="-1" role="dialog" id="edit<?= $edit->dosenId; ?>">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Data <strong><?= $title; ?></strong></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="/dosen/ubah/<?= $edit->dosenId; ?>" method="post">
                    <?= csrf_field(); ?>
                    <div class="modal-body">
                        <input type="hidden" name="dosenStatus" value="<?= $edit->dosenStatus ?>">
                        <div class="form-group">
                            <label>Nama Lengkap</label>
                            <input name="dosenFullname" type="text" class="form-control" value="<?= $edit->dosenFullname; ?>" <?= ($edit->dosenStatus == '1') ? 'readonly' : ''; ?>>
                        </div>
                        <div class="form-group">
                            <label>Nama</label>
                            <input name="dosenShortname" type="text" class="form-control" value="<?= $edit->dosenShortname; ?>" <?= ($edit->dosenStatus == '1') ? 'readonly' : ''; ?>>
                        </div>
                        <?php if ($edit->dosenStatus == '1') : ?>
                            <div class="form-group">
                                <label>Email Corporate</label>
                                <input name="dosenEmailCorporate" type="text" class="form-control" value="<?= $edit->dosenEmailCorporate; ?>" <?= ($edit->dosenStatus == '1') ? 'readonly' : ''; ?>>
                            </div>
                        <?php endif ?>
                        <div class="form-group">
                            <label><?= ($edit->dosenStatus == '1') ? 'Email General' : 'Email'; ?></label>
                            <input name="dosenEmailGeneral" type="text" class="form-control" value="<?= $edit->dosenEmailGeneral; ?>">
                        </div>
                        <div class="form-group">
                            <label>Handphone</label>
                            <input name="dosenPhone" type="number" class="form-control" value="<?= $edit->dosenPhone; ?>" <?= ($edit->dosenStatus == '1') ? 'readonly' : ''; ?>>
                        </div>
                        <?php if ($edit->dosenStatus == '1') : ?>
                            <p class="text-warning"><small>Only change the general email that is in digisched</small></p>
                        <?php endif ?>
                    </div>
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

<?= view('layout/templateFooter'); ?>

<?= $this->endSection(); ?>