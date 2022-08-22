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
                            <div class="fc-overflow">
                                <div id="calendar"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

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
                            <div class="form-group">
                                <label>Nama Blok</label>
                                <select class="form-control select2" name="blok">
                                    <option value="">Pilih Blok</option>
                                    <?php foreach ($blok as $key => $blok) : ?>
                                        <option value="<?= $blok->matkulBlokId ?>,<?= $blok->matkulBlokNama ?>"><?= $blok->matkulBlokNama ?></option>
                                    <?php endforeach ?>
                                </select>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Tanggal</label>
                                        <input type="date" class="form-control" placeholder="Pilih Tanggal" name="startDate" readonly>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Sesi</label>
                                        <select class="form-control select2" name="sesi">
                                            <option value="">Pilih Sesi</option>
                                            <?php foreach ($sesi as $key => $sesi) : ?>
                                                <option value="<?= $sesi->sesiId ?>,<?= $sesi->sesiStart ?>,<?= $sesi->sesiEnd ?>"><?= $sesi->sesiNama ?> (<?= $sesi->sesiStart ?>-<?= $sesi->sesiEnd ?>)</option>
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
                                <input name="namaAcara" type="text" class="form-control" value="">
                            </div>
                            <div class="row">
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
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Lokasi Acara</label>
                                        <input name="lokasi" type="text" class="form-control" value="<?= old('lokasi'); ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Kelas</label>
                                        <input type="text" name="deskripsiAcara" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class=" form-group">
                                        <label>Catatan Ekstra</label>
                                        <input type="text" name="noteAcara" class="form-control">
                                    </div>
                                </div>
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

<div class="modal fade" id="editJadwal">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content">
            <form action="/penjadwalan/add" id="formTambah" method="post">
                <input type="hidden" name="from" value="dashboard">
                <div class="modal-header">
                    <h4 class="modal-title">Edit Penjadwalan</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;
                    </button>
                </div>
                <div class="modal-body">

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
<?= view('layout/templateFooter'); ?>

<?= $this->endSection(); ?>