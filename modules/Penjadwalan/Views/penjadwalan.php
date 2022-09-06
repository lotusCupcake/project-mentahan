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
                                        <th>Jadwal</th>
                                        <th>Detail</th>
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
                                                <td><?= $jadwal->penjadwalanStartDate ?> s/d <?= $jadwal->penjadwalanEndDate ?></td>
                                                <td><span data-toggle="modal" data-target="#viewJadwal<?= $jadwal->penjadwalanId ?>" class="text-primary" style="cursor:pointer" onclick="detailJadwal('<?= $jadwal->penjadwalanId ?>','<?= $jadwal->penjadwalanCalenderId ?>')">Klik untuk lihat detail</span></td>
                                                <td style="text-align:center">
                                                    <button class="btn btn-info" data-toggle="modal" data-target="#clonePenjadwalan<?= $jadwal->penjadwalanId ?>"><i class="fas fa-clone"></i></button>
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
                        <?php foreach ($jenisJadwal as $key => $jenis) : ?>
                            <label class="selectgroup-item">
                                <input type="radio" name="jenisJadwal" value="<?= $jenis->jenisJadwalId ?>,<?= $jenis->jenisJadwalKode ?>" class="selectgroup-input" <?= (old('jenisJadwal') == $jenis->jenisJadwalId . ',' . $jenis->jenisJadwalKode) ? 'checked' : '' ?>>
                                <span class="selectgroup-button"><?= $jenis->jenisJadwalKode ?></span>
                            </label>
                        <?php endforeach ?>
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
                <div class="typeSesi">
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
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="typeManual">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Waktu Mulai</label>
                                <input type="datetime-local" class="form-control" placeholder="Pilih Tanggal" name="waktuStart" value=<?= (old('waktuStart')) ? date('Y-m-d\Th:i', strtotime(old('waktuStart'))) : date('Y-m-d\Th:i') ?>>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Waktu Selesai</label>
                                <input type="datetime-local" class="form-control" placeholder="Pilih Tanggal" name="waktuEnd" value=<?= (old('waktuEnd')) ? date('Y-m-d\Th:i', strtotime(old('waktuEnd'))) : date('Y-m-d\Th:i') ?>>
                            </div>
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
                <div class="form-group">
                    <label>Kelas</label>
                    <input type="text" name="deskripsiAcara" class="form-control" value="<?= old('deskripsiAcara'); ?>">
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
        <div class="row">
            <div class="col-md-12">
                <div class=" form-group">
                    <label>Catatan Ekstra</label>
                    <textarea name="noteAcara" class="summernote-simple"><?= old('noteAcara'); ?></textarea>
                </div>
            </div>
        </div>
    </form>
</div>

<?php foreach ($penjadwalan as $jadwalEdit) : ?>
    <div class="modal fade" role="dialog" id="editPenjadwalan<?= $jadwalEdit->penjadwalanId; ?>" data-jenisjadwalid="<?= $jadwalEdit->penjadwalanJenisJadwalId ?>" data-sesi="<?= $jadwalEdit->penjadwalanSesiId ?>">
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
                                        <?php foreach ($jenisJadwal as $key => $jenis) : ?>
                                            <label class="selectgroup-item">
                                                <input type="radio" name="jenisJadwal" value="<?= $jenis->jenisJadwalId ?>,<?= $jenis->jenisJadwalKode ?>" class="selectgroup-input" <?= ($jenis->jenisJadwalId == $jadwalEdit->penjadwalanJenisJadwalId) ? "checked" : "" ?>>
                                                <span class="selectgroup-button"><?= $jenis->jenisJadwalKode ?></span>
                                            </label>
                                        <?php endforeach ?>
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
                                <div class="typeSesi">
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

                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="typeManual">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Waktu Mulai</label>
                                                <input type="datetime-local" class="form-control" placeholder="Pilih Tanggal" name="waktuStart" value="<?= reformatManual($jadwalEdit->penjadwalanStartDate) ?>">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Waktu Selesai</label>
                                                <input type="datetime-local" class="form-control" placeholder="Pilih Tanggal" name="waktuEnd" value="<?= reformatManual($jadwalEdit->penjadwalanEndDate) ?>">
                                            </div>
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
                                <div class="form-group">
                                    <label>Kelas</label>
                                    <input type="text" name="deskripsiAcara" class="form-control" value="<?= $jadwalEdit->penjadwalanDeskripsi ?>">
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
                        <div class="row">
                            <div class="col-md-12">
                                <div class=" form-group">
                                    <label>Catatan Ekstra</label>
                                    <textarea name="noteAcara" class="summernote-simple"><?= $jadwalEdit->penjadwalanNotes ?></textarea>
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

<?php foreach ($penjadwalan as $jadwalClone) : ?>
    <div class="modal fade" role="dialog" id="clonePenjadwalan<?= $jadwalClone->penjadwalanId; ?>" data-jenisjadwalid="<?= $jadwalClone->penjadwalanJenisJadwalId ?>" data-sesi="<?= $jadwalClone->penjadwalanSesiId ?>">
        <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
            <div class="modal-content">
                <form action="/penjadwalan/edit/<?= $jadwalClone->penjadwalanId ?>" id="formEdit<?= $jadwalClone->penjadwalanId ?>" method="post">
                    <div class="modal-header">
                        <h5 class="modal-title">Duplikat Data <strong><?= $title; ?></strong></h5>
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
                                        <?php foreach ($jenisJadwal as $key => $jenis) : ?>
                                            <label class="selectgroup-item">
                                                <input type="radio" name="jenisJadwal" value="<?= $jenis->jenisJadwalId ?>,<?= $jenis->jenisJadwalKode ?>" class="selectgroup-input" <?= ($jenis->jenisJadwalId == $jadwalClone->penjadwalanJenisJadwalId) ? "checked" : "" ?>>
                                                <span class="selectgroup-button"><?= $jenis->jenisJadwalKode ?></span>
                                            </label>
                                        <?php endforeach ?>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Nama Blok</label>
                                            <select class="form-control select2" name="blok">
                                                <option value="">Pilih Blok</option>
                                                <?php foreach ($blok as $key => $bk) : ?>
                                                    <option value="<?= $bk->matkulBlokId ?>,<?= $bk->matkulBlokNama ?>" <?= ($bk->matkulBlokId == $jadwalClone->penjadwalanMatkulBlokId) ? "selected" : "" ?>><?= $bk->matkulBlokNama ?></option>
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
                                                    <option value="<?= $i ?>" <?= ($i == $jadwalClone->penjadwalanAngkatan) ? "selected" : "" ?>><?= $i ?></option>
                                                <?php endfor ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="typeSesi">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Tanggal</label>
                                                <input type="date" class="form-control" placeholder="Pilih Tanggal" name="startDate" value="<?= reformat($jadwalClone->penjadwalanStartDate) ?>">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Sesi</label>
                                                <select class="form-control select2" name="sesi">
                                                    <option value="">Pilih Sesi</option>

                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="typeManual">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Waktu Mulai</label>
                                                <input type="datetime-local" class="form-control" placeholder="Pilih Tanggal" name="waktuStart" value="<?= reformatManual($jadwalClone->penjadwalanStartDate) ?>">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Waktu Selesai</label>
                                                <input type="datetime-local" class="form-control" placeholder="Pilih Tanggal" name="waktuEnd" value="<?= reformatManual($jadwalClone->penjadwalanEndDate) ?>">
                                            </div>
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
                                    <input name="namaAcara" type="text" class="form-control" value="<?= $jadwalClone->penjadwalanJudul ?>">
                                </div>
                                <div class="form-group">
                                    <label>Lokasi Acara</label>
                                    <input name="lokasi" type="text" class="form-control" value="<?= $jadwalClone->penjadwalanLokasi; ?>">
                                </div>
                                <div class="form-group">
                                    <label>Kelas</label>
                                    <input type="text" name="deskripsiAcara" class="form-control" value="<?= $jadwalClone->penjadwalanDeskripsi ?>">
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Warna Acara</label>
                                    <div class="row gutters-xs">
                                        <div class="col-auto">
                                            <?php foreach ($color as $key => $col) : ?>
                                                <label class="colorinput">
                                                    <input name="color" type="radio" value="<?= $col['id'] ?>" class="colorinput-input" <?= ($col['id'] == $jadwalClone->penjadwalanColorId) ? "checked" : "" ?> />
                                                    <span class="colorinput-color rounded" style="background-color: <?= $col['background'] ?>;"></span>
                                                </label>
                                            <?php endforeach ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class=" form-group">
                                    <label>Catatan Ekstra</label>
                                    <textarea name="noteAcara" class="summernote-simple"><?= $jadwalClone->penjadwalanNotes ?></textarea>
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
                            <p><i class="fas fa-clipboard-list mr-2 text-info"></i> <?= $view->jenisJadwalNama ?></p>
                            <h5>Blok</h5>
                            <p><i class="fas fa-book mr-2 text-info"></i><?= $view->matkulBlokNama ?></p>
                            <h5>Tanggal/Sesi</h5>
                            <p><i class="fas fa-calendar mr-2 text-info"></i><?= $view->penjadwalanStartDate ?> - <?= $view->penjadwalanEndDate ?></p>
                        </div>
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-md-12">
                                    <h5>Lokasi</h5>
                                    <p><i class="fas fa-location-arrow mr-2 text-info"></i><?= $view->penjadwalanLokasi ?></p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <h5>Nama Acara</h5>
                                    <p><i class="fab fa-elementor mr-2 text-info"></i></i></i><?= $view->penjadwalanJudul ?></p>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <h5>Angkatan</h5>
                                            <p><i class="fas fa-graduation-cap mr-2 text-info"></i></i><?= $view->penjadwalanAngkatan ?></p>
                                        </div>
                                        <div class="col-md-6">
                                            <h5>Kelas</h5>
                                            <p><i class="fas fa-building mr-2 text-info"></i></i><?= $view->penjadwalanDeskripsi ?></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4>Catatan</h4>
                                </div>
                                <div class="card-body">
                                    <?= $view->penjadwalanNotes ?>
                                    <div id="accordion">
                                        <div class="accordion">
                                            <div class="accordion-header" role="button" data-toggle="collapse" data-target="#panel-body-1" aria-expanded="true">
                                                <h4><span class="jmlDosen"></span> Dosen</h4>
                                            </div>
                                            <div class="accordion-body collapse" id="panel-body-1" data-parent="#accordion">
                                                <ul class="list-group partisipan">
                                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                                        A list item
                                                        <span class="badge badge-success badge-pill"> </span>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
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