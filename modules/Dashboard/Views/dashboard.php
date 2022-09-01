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
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4><?= $title ?></h4>
                        </div>
                        <div class="card-body">
                            <?php if (in_groups('general')) : ?>
                                <div class="text-center" style="height: 700px;">
                                    <div class="pt-5" style="width: 100%; height: 600px ;margin-top: 100px">
                                        <lottie-player src="https://assets5.lottiefiles.com/packages/lf20_3xtpb0bw.json" background="transparent" speed="1" loop autoplay></lottie-player>
                                    </div>
                                </div>
                            <?php else : ?>
                                <div class="fc-overflow">
                                    <input type="hidden" name="role" value="<?= getSpecificUser(['user_id' => user()->id])->name ?>">
                                    <div id="calendar"></div>
                                </div>
                            <?php endif ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<?php if (!in_groups('biasa')) : ?>
    <div class="modal fade" id="tambahJadwalDashboard">
        <div class="modal-dialog modal-dialog-centered modal-xl">
            <div class="modal-content">
                <form action="/penjadwalan/add" id="formTambah" method="post">
                    <input type="hidden" name="from" value="dashboard">
                    <div class="modal-header">
                        <h4 class="modal-title">Tambah Penjadwalan</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">Jadwal</label>
                                    <div class="selectgroup selectgroup-pills">
                                        <?php foreach ($jenisJadwal as $key => $jenis) : ?>
                                            <label class="selectgroup-item">
                                                <input type="radio" name="jenisJadwal" value="<?= $jenis->jenisJadwalId ?>,<?= $jenis->jenisJadwalKode ?>" class="selectgroup-input">
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
                                                <?php foreach ($blok as $key => $blok) : ?>
                                                    <option value="<?= $blok->matkulBlokId ?>,<?= $blok->matkulBlokNama ?>"><?= $blok->matkulBlokNama ?></option>
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
                                                    <option value="<?= $i ?>" <?= (old('angkatan') == $i) ? "selected" : ""; ?>><?= $i ?></option>
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
                                    <input name="namaAcara" type="text" class="form-control" value="">
                                </div>
                                <div class="form-group">
                                    <label>Lokasi Acara</label>
                                    <input name="lokasi" type="text" class="form-control" value="<?= old('lokasi'); ?>">
                                </div>
                                <div class="form-group">
                                    <label>Kelas</label>
                                    <input type="text" name="deskripsiAcara" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Warna Acara</label>
                                    <div class="row gutters-xs">
                                        <div class="col-auto">
                                            <?php foreach ($color as $key => $col) : ?>
                                                <label class="colorinput">
                                                    <input name="color" type="radio" value="<?= $col['id'] ?>" class="colorinput-input" />
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
                    </div>
                    <!-- Modal footer -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php endif ?>

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

<?php if (in_groups('general')) : ?>
    <div class="modal fade" tabindex="-1" role="dialog" id="announcement">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Kontak Administrator</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;
                    </button>
                </div>
                <div class="modal-body">
                    <p>Role akun kamu adalah general user, hubungi administrator untuk promosi akun</p>
                </div>
                <div class="modal-footer bg-whitesmoke br">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
<?php endif ?>

<?= view('layout/templateFooter'); ?>

<?= $this->endSection(); ?>