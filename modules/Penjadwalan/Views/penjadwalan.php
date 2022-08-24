<?= $this->extend('layout/templateHome'); ?>

<?= $this->section('content'); ?>

<?= view('layout/templateSidebar', ['menus' => $menu]); ?>

<!-- Main Content -->
<div class="main-content">
    <section class=" section">
        <div class="section-header">
            <h1 id="judul"><?= $title ?></h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item"><a href="#"><?= $breadcrumb[0]; ?></a></div>
                <div class="breadcrumb-item active"><?= $breadcrumb[1]; ?></div>
            </div>
        </div>
        <div class="section-body">
            <?php if ($validation->hasError('blok')) : ?>
                <?= view('layout/templateAlertIcon', ['msg' => ['danger', 'fas fa-exclamation', 'Gagal!', $validation->getError('blok')]]); ?>
            <?php endif; ?>
            <?php if ($validation->hasError('jenisJadwal')) : ?>
                <?= view('layout/templateAlertIcon', ['msg' => ['danger', 'fas fa-exclamation', 'Gagal!', $validation->getError('jenisJadwal')]]); ?>
            <?php endif; ?>
            <?php if ($validation->hasError('startDate')) : ?>
                <?= view('layout/templateAlertIcon', ['msg' => ['danger', 'fas fa-exclamation', 'Gagal!', $validation->getError('startDate')]]); ?>
            <?php endif; ?>
            <?php if ($validation->hasError('sesi')) : ?>
                <?= view('layout/templateAlertIcon', ['msg' => ['danger', 'fas fa-exclamation', 'Gagal!', $validation->getError('sesi')]]); ?>
            <?php endif; ?>
            <?php if ($validation->hasError('dosen')) : ?>
                <?= view('layout/templateAlertIcon', ['msg' => ['danger', 'fas fa-exclamation', 'Gagal!', $validation->getError('dosen')]]); ?>
            <?php endif; ?>
            <?php if ($validation->hasError('namaAcara')) : ?>
                <?= view('layout/templateAlertIcon', ['msg' => ['danger', 'fas fa-exclamation', 'Gagal!', $validation->getError('namaAcara')]]); ?>
            <?php endif; ?>
            <?php if ($validation->hasError('lokasi')) : ?>
                <?= view('layout/templateAlertIcon', ['msg' => ['danger', 'fas fa-exclamation', 'Gagal!', $validation->getError('lokasi')]]); ?>
            <?php endif; ?>
            <?php if ($validation->hasError('deskripsiAcara')) : ?>
                <?= view('layout/templateAlertIcon', ['msg' => ['danger', 'fas fa-exclamation', 'Gagal!', $validation->getError('deskripsiAcara')]]); ?>
            <?php endif; ?>
            <?php if ($validation->hasError('color')) : ?>
                <?= view('layout/templateAlertIcon', ['msg' => ['danger', 'fas fa-exclamation', 'Gagal!', $validation->getError('color')]]); ?>
            <?php endif; ?>
            <?php if ($validation->hasError('angkatan')) : ?>
                <?= view('layout/templateAlertIcon', ['msg' => ['danger', 'fas fa-exclamation', 'Gagal!', $validation->getError('angkatan')]]); ?>
            <?php endif; ?>
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4><button class="btn btn-primary" id="tambahPenjadwalan"><i class="fas fa-plus"></i> Tambah Data</button></h4>
                            <div class="card-header-form">
                                <form action="">
                                    <div class="input-group">
                                        <input type="text" class="form-control" placeholder="Search" name="keyword" value="<?= isset($_GET['keyword']) ? $_GET['keyword'] : "" ?>">
                                        <div class="input-group-btn">
                                            <button class="btn btn-primary"><i class="fas fa-search"></i></button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Acara</th>
                                        <th>Lokasi</th>
                                        <th>Dosen</th>
                                        <th>Jadwal</th>
                                        <th style="text-align:center">Action</th>
                                    </tr>
                                    <?php if (!empty($penjadwalan)) : ?>
                                        <?php
                                        $no = 1 + ($numberPage * ($currentPage - 1));
                                        foreach ($penjadwalan as $jadwal) : ?>
                                            <?php $peserta = getPeserta($jadwal->penjadwalanId); ?>
                                            <tr>
                                                <td><?= $no++; ?></td>
                                                <td><?= $jadwal->penjadwalanJudul; ?></td>
                                                <td class="align-middle"><i class="fas fa-location-arrow text-info"></i> <?= $jadwal->penjadwalanLokasi ?></td>
                                                <td>
                                                    <?php foreach (json_decode($peserta)->data as $key => $dsn) : ?>
                                                        <?php if ($key < 5) : ?>
                                                            <img alt="image" src=' <?= base_url("template/assets/img/avatar/avatar-3.png") ?>' class="rounded-circle" width="35" data-toggle="tooltip" title="<?= $dsn->email ?>">
                                                        <?php endif; ?>
                                                    <?php endforeach; ?>
                                                </td>
                                                <td><?= $jadwal->penjadwalanStartDate ?> s/d <?= $jadwal->penjadwalanEndDate ?></td>
                                                <td style="text-align:center">
                                                    <button class="btn btn-info" data-toggle="modal" data-target="#viewJadwal<?= $jadwal->penjadwalanId ?>"><i class="fas fa-eye"></i></button>
                                                    <button class="btn btn-warning" onclick="editJadwal(<?= $jadwal->penjadwalanId ?>)" data-toggle="modal" data-target="#editPenjadwalan<?= $jadwal->penjadwalanId ?>"><i class="fas fa-pen"></i></button>
                                                    <button class="btn btn-danger" data-confirm="Konfirmasi|Apakah Kamu yakin akan menghapus penjadwalan <strong><?= $jadwal->penjadwalanJudul; ?></strong>?<p class='text-warning'><small>This action cannot be undone</small></p>" data-confirm-yes='hapusEvent(<?= $jadwal->penjadwalanId; ?>,"<?= $jadwal->penjadwalanJudul; ?>","penjadwalan")'><i class="fas fa-trash"></i></button>
                                                </td>
                                            </tr>
                                        <?php endforeach ?>
                                    <?php else : ?>
                                        <?= view('layout/templateEmpty', ['jumlahSpan' => 6]); ?>
                                    <?php endif ?>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<div class="tambah">
    <form action="/penjadwalan/add" id="formTambah" method="post">
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label class="form-label">Jadwal</label>
                    <div class="selectgroup selectgroup-pills">
                        <?php if (in_groups('kuliah')) : ?>
                            <label class="selectgroup-item">
                                <input type="radio" name="jenisJadwal" value="<?= $jenisJadwal[0]->jenisJadwalId ?>,<?= $jenisJadwal[0]->jenisJadwalKode ?>" class="selectgroup-input" <?= (old('jenisJadwal') == $jenisJadwal[0]->jenisJadwalId . ',' . $jenisJadwal[0]->jenisJadwalKode) ? 'checked' : '' ?>>
                                <span class="selectgroup-button"><?= $jenisJadwal[0]->jenisJadwalKode ?></span>
                            </label>
                        <?php elseif (in_groups('praktikum')) : ?>
                            <label class="selectgroup-item">
                                <input type="radio" name="jenisJadwal" value="<?= $jenisJadwal[1]->jenisJadwalId ?>,<?= $jenisJadwal[1]->jenisJadwalKode ?>" class="selectgroup-input" <?= (old('jenisJadwal') == $jenisJadwal[1]->jenisJadwalId . ',' . $jenisJadwal[1]->jenisJadwalKode) ? 'checked' : '' ?>>
                                <span class="selectgroup-button"><?= $jenisJadwal[1]->jenisJadwalKode ?></span>
                            </label>
                        <?php elseif (in_groups('ujian')) : ?>
                            <label class="selectgroup-item">
                                <input type="radio" name="jenisJadwal" value="<?= $jenisJadwal[2]->jenisJadwalId ?>,<?= $jenisJadwal[2]->jenisJadwalKode ?>" class="selectgroup-input" <?= (old('jenisJadwal') == $jenisJadwal[2]->jenisJadwalId . ',' . $jenisJadwal[2]->jenisJadwalKode) ? 'checked' : '' ?>>
                                <span class="selectgroup-button"><?= $jenisJadwal[2]->jenisJadwalKode ?></span>
                            </label>
                        <?php elseif (in_groups('sgd')) : ?>
                            <label class="selectgroup-item">
                                <input type="radio" name="jenisJadwal" value="<?= $jenisJadwal[3]->jenisJadwalId ?>,<?= $jenisJadwal[3]->jenisJadwalKode ?>" class="selectgroup-input" <?= (old('jenisJadwal') == $jenisJadwal[3]->jenisJadwalId . ',' . $jenisJadwal[3]->jenisJadwalKode) ? 'checked' : '' ?>>
                                <span class="selectgroup-button"><?= $jenisJadwal[3]->jenisJadwalKode ?></span>
                            </label>
                        <?php elseif (in_groups('kkd')) : ?>
                            <label class="selectgroup-item">
                                <input type="radio" name="jenisJadwal" value="<?= $jenisJadwal[4]->jenisJadwalId ?>,<?= $jenisJadwal[4]->jenisJadwalKode ?>" class="selectgroup-input" <?= (old('jenisJadwal') == $jenisJadwal[4]->jenisJadwalId . ',' . $jenisJadwal[4]->jenisJadwalKode) ? 'checked' : '' ?>>
                                <span class="selectgroup-button"><?= $jenisJadwal[4]->jenisJadwalKode ?></span>
                            </label>
                        <?php else : ?>
                            <?php foreach ($jenisJadwal as $key => $jenis) : ?>
                                <label class="selectgroup-item">
                                    <input type="radio" name="jenisJadwal" value="<?= $jenis->jenisJadwalId ?>,<?= $jenis->jenisJadwalKode ?>" class="selectgroup-input" <?= (old('jenisJadwal') == $jenis->jenisJadwalId . ',' . $jenis->jenisJadwalKode) ? 'checked' : '' ?>>
                                    <span class="selectgroup-button"><?= $jenis->jenisJadwalKode ?></span>
                                </label>
                            <?php endforeach ?>
                        <?php endif ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Nama Blok</label>
                            <select class="form-control select2" name="blok">
                                <option value="">Pilih Blok</option>
                                <?php foreach ($blok as $key => $bk) : ?>
                                    <option value="<?= $bk->matkulBlokId ?>,<?= $bk->matkulBlokNama ?>" <?= (old('blok') == $bk->matkulBlokId . ',' . $bk->matkulBlokNama) ? 'selected' : '' ?>><?= $bk->matkulBlokNama ?></option>
                                <?php endforeach ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Angkatan</label>
                            <select class="form-control select2" name="angkatan">
                                <option value="">Pilih Angkatan</option>
                                <?php for ($i = 2016; $i <= date("Y"); $i++) : ?>
                                    <option value="<?= $i ?>"><?= $i ?></option>
                                <?php endfor ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Tanggal</label>
                            <input type="date" class="form-control" placeholder="Pilih Tanggal" name="startDate" value=<?= (old('startDate')) ? date('Y-m-d', strtotime(old('startDate'))) : "" ?>>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Sesi</label>
                            <select class="form-control select2" name="sesi">
                                <option value="">Pilih Sesi</option>
                                <?php foreach ($sesi as $key => $ses) : ?>
                                    <?php $valSesi = $ses->sesiId . ',' . $ses->sesiStart . ',' . $ses->sesiEnd ?>
                                    <option value="<?= $valSesi ?>" <?= (old('sesi') == $valSesi) ? 'selected' : '' ?>><?= $ses->sesiNama ?> (<?= $ses->sesiStart ?>-<?= $ses->sesiEnd ?>)</option>
                                <?php endforeach ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label>Dosen</label>
                    <select class="form-control select2" multiple="" name="dosen[]">
                    </select>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>Nama Acara</label>
                    <input name="namaAcara" type="text" class="form-control" value="<?= old('namaAcara'); ?>">
                </div>
                <div class="form-group">
                    <label>Lokasi Acara</label>
                    <input name="lokasi" type="text" class="form-control" value="<?= old('lokasi'); ?>">
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Kelas</label>
                            <input type="text" name="deskripsiAcara" class="form-control" value="<?= old('deskripsiAcara'); ?>">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class=" form-group">
                            <label>Catatan Ekstra</label>
                            <input type="text" name="noteAcara" class="form-control" value="<?= old('noteAcara'); ?>">
                        </div>
                    </div>
                </div>
                <div class=" form-group">
                    <label class="form-label">Warna Acara</label>
                    <div class="row gutters-xs">
                        <div class="col-auto">
                            <?php foreach ($color as $key => $col) : ?>
                                <label class="colorinput">
                                    <input name="color" type="radio" value="<?= $col['id'] ?>" class="colorinput-input" <?= (old('color') == $col['id']) ? 'checked' : '' ?> />
                                    <span class="colorinput-color rounded" style="background-color: <?= $col['background'] ?>;"></span>
                                </label>
                            <?php endforeach ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<?php foreach ($penjadwalan as $jadwalEdit) : ?>
    <div class="modal fade" role="dialog" id="editPenjadwalan<?= $jadwalEdit->penjadwalanId; ?>">
        <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
            <div class="modal-content">
                <form action="/penjadwalan/edit/<?= $jadwalEdit->penjadwalanId ?>" id="formEdit<?= $jadwalEdit->penjadwalanId ?>" method="post">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Data <strong><?= $title; ?></strong></h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" value="PUT" name="_method">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">Jadwal</label>
                                    <div class="selectgroup selectgroup-pills">
                                        <?php if (in_groups('kuliah')) : ?>
                                            <label class="selectgroup-item">
                                                <input type="radio" name="jenisJadwal" value="<?= $jenisJadwal[0]->jenisJadwalId ?>,<?= $jenisJadwal[0]->jenisJadwalKode ?>" class="selectgroup-input" <?= ($jenisJadwal[0]->jenisJadwalId == $jadwalEdit->penjadwalanJenisJadwalId) ? 'checked' : '' ?>>
                                                <span class="selectgroup-button"><?= $jenisJadwal[0]->jenisJadwalKode ?></span>
                                            </label>
                                        <?php elseif (in_groups('praktikum')) : ?>
                                            <label class="selectgroup-item">
                                                <input type="radio" name="jenisJadwal" value="<?= $jenisJadwal[1]->jenisJadwalId ?>,<?= $jenisJadwal[1]->jenisJadwalKode ?>" class="selectgroup-input" <?= ($jenisJadwal[1]->jenisJadwalId == $jadwalEdit->penjadwalanJenisJadwalId) ? 'checked' : '' ?>>
                                                <span class="selectgroup-button"><?= $jenisJadwal[1]->jenisJadwalKode ?></span>
                                            </label>
                                        <?php elseif (in_groups('ujian')) : ?>
                                            <label class="selectgroup-item">
                                                <input type="radio" name="jenisJadwal" value="<?= $jenisJadwal[2]->jenisJadwalId ?>,<?= $jenisJadwal[2]->jenisJadwalKode ?>" class="selectgroup-input" <?= ($jenisJadwal[2]->jenisJadwalId == $jadwalEdit->penjadwalanJenisJadwalId) ? 'checked' : '' ?>>
                                                <span class="selectgroup-button"><?= $jenisJadwal[2]->jenisJadwalKode ?></span>
                                            </label>
                                        <?php elseif (in_groups('sgd')) : ?>
                                            <label class="selectgroup-item">
                                                <input type="radio" name="jenisJadwal" value="<?= $jenisJadwal[3]->jenisJadwalId ?>,<?= $jenisJadwal[3]->jenisJadwalKode ?>" class="selectgroup-input" <?= ($jenisJadwal[3]->jenisJadwalId == $jadwalEdit->penjadwalanJenisJadwalId) ? 'checked' : '' ?>>
                                                <span class="selectgroup-button"><?= $jenisJadwal[3]->jenisJadwalKode ?></span>
                                            </label>
                                        <?php elseif (in_groups('kkd')) : ?>
                                            <label class="selectgroup-item">
                                                <input type="radio" name="jenisJadwal" value="<?= $jenisJadwal[4]->jenisJadwalId ?>,<?= $jenisJadwal[4]->jenisJadwalKode ?>" class="selectgroup-input" <?= ($jenisJadwal[4]->jenisJadwalId == $jadwalEdit->penjadwalanJenisJadwalId) ? 'checked' : '' ?>>
                                                <span class="selectgroup-button"><?= $jenisJadwal[4]->jenisJadwalKode ?></span>
                                            </label>
                                        <?php else : ?>
                                            <?php foreach ($jenisJadwal as $key => $jenis) : ?>
                                                <label class="selectgroup-item">
                                                    <input type="radio" name="jenisJadwal" value="<?= $jenis->jenisJadwalId ?>,<?= $jenis->jenisJadwalKode ?>" class="selectgroup-input" <?= ($jenis->jenisJadwalId == $jadwalEdit->penjadwalanJenisJadwalId) ? "checked" : "" ?>>
                                                    <span class="selectgroup-button"><?= $jenis->jenisJadwalKode ?></span>
                                                </label>
                                            <?php endforeach ?>
                                        <?php endif ?>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Nama Blok</label>
                                            <select class="form-control select2" name="blok">
                                                <option value="">Pilih Blok</option>
                                                <?php foreach ($blok as $key => $bk) : ?>
                                                    <option value="<?= $bk->matkulBlokId ?>,<?= $bk->matkulBlokNama ?>" <?= ($bk->matkulBlokId == $jadwalEdit->penjadwalanMatkulBlokId) ? "selected" : "" ?>><?= $bk->matkulBlokNama ?></option>
                                                <?php endforeach ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Angkatan</label>
                                            <select class="form-control select2" name="angkatan">
                                                <option value="">Pilih Angkatan</option>
                                                <?php for ($i = 2016; $i <= date("Y"); $i++) : ?>
                                                    <option value="<?= $i ?>" <?= ($i == $jadwalEdit->penjadwalanAngkatan) ? "selected" : "" ?>><?= $i ?></option>
                                                <?php endfor ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Tanggal</label>
                                            <input type="date" class="form-control" placeholder="Pilih Tanggal" name="startDate" value="<?= reformat($jadwalEdit->penjadwalanStartDate) ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Sesi</label>
                                            <select class="form-control select2" name="sesi">
                                                <option value="">Pilih Sesi</option>
                                                <?php foreach ($sesi as $key => $ses) : ?>
                                                    <option value="<?= $ses->sesiId ?>,<?= $ses->sesiStart ?>,<?= $ses->sesiEnd ?>" <?= ($ses->sesiId == $jadwalEdit->penjadwalanSesiId) ? "selected" : "" ?>><?= $ses->sesiNama ?> (<?= $ses->sesiStart ?>-<?= $ses->sesiEnd ?>)</option>
                                                <?php endforeach ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Dosen</label>
                                    <select class="form-control select2" multiple="" name="dosen[]">
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Nama Acara</label>
                                    <input name="namaAcara" type="text" class="form-control" value="<?= $jadwalEdit->penjadwalanJudul ?>">
                                </div>
                                <div class="form-group">
                                    <label>Lokasi Acara</label>
                                    <input name="lokasi" type="text" class="form-control" value="<?= $jadwalEdit->penjadwalanLokasi; ?>">
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Kelas</label>
                                            <input type="text" name="deskripsiAcara" class="form-control" value="<?= $jadwalEdit->penjadwalanDeskripsi ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class=" form-group">
                                            <label>Catatan Ekstra</label>
                                            <input type="text" name="noteAcara" class="form-control" value="<?= $jadwalEdit->penjadwalanNotes ?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Warna Acara</label>
                                    <div class="row gutters-xs">
                                        <div class="col-auto">
                                            <?php foreach ($color as $key => $col) : ?>
                                                <label class="colorinput">
                                                    <input name="color" type="radio" value="<?= $col['id'] ?>" class="colorinput-input" <?= ($col['id'] == $jadwalEdit->penjadwalanColorId) ? "checked" : "" ?> />
                                                    <span class="colorinput-color rounded" style="background-color: <?= $col['background'] ?>;"></span>
                                                </label>
                                            <?php endforeach ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>

        </div>
    </div>
<?php endforeach ?>

<?php foreach ($penjadwalan as $view) : ?>
    <div class="modal fade" id="viewJadwal<?= $view->penjadwalanId ?>">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title"></h4>
                    <button type="button" class="close" data-dismiss="modal">&times;
                    </button>
                </div>
                <div class="modal-body">
                    <?php $peserta = getPeserta($view->penjadwalanId); ?>
                    <div class="row">
                        <div class="col-md-6">
                            <h5>Jadwal</h5>
                            <p><i class="fas fa-clipboard-list mr-2 text-info"></i><?= $view->jenisJadwalNama ?></p>
                            <h5>Blok</h5>
                            <p><i class="fas fa-book mr-2 text-info"></i></i><?= $view->matkulBlokNama ?></p>
                            <h5>Tanggal/Sesi</h5>
                            <p><i class="fas fa-calendar mr-2 text-info"></i><?= $view->penjadwalanStartDate ?> - <?= $view->penjadwalanEndDate ?></p>
                            <h5>Dosen</h5>
                            <p>
                                <?php foreach (json_decode($peserta)->data as $key => $dsn) : ?>
                                    <img alt="image" src=' <?= base_url("template/assets/img/avatar/avatar-3.png") ?>' class="rounded-circle" width="35" data-toggle="tooltip" title="<?= $dsn->email ?>">
                                <?php endforeach; ?>
                            </p>
                        </div>
                        <div class="col-md-6">
                            <h5>Nama Acara</h5>
                            <p><i class="fab fa-elementor mr-2 text-info"></i></i></i><?= $view->penjadwalanJudul ?></p>
                            <h5>Angkatan</h5>
                            <p><i class="fas fa-graduation-cap mr-2 text-info"></i></i><?= $view->penjadwalanAngkatan ?></p>
                            <h5>Lokasi</h5>
                            <p><i class="fas fa-location-arrow mr-2 text-info"></i><?= $view->penjadwalanLokasi ?></p>
                            <div class="row">
                                <div class="col-md-6">
                                    <h5>Kelas</h5>
                                    <p><i class="fas fa-building mr-2 text-info"></i></i><?= $view->penjadwalanDeskripsi ?></p>
                                </div>
                                <div class="col-md-6">
                                    <h5>Catatan</h5>
                                    <p><i class="fas fa-align-left mr-2 text-info"></i></i><?= $view->penjadwalanNotes ?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
<?php endforeach ?>

<?= view('layout/templateFooter'); ?>

<?= $this->endSection(); ?>