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
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4><button class="btn btn-primary" id="tambahPenjadwalan"><i class="fas fa-plus"></i> Tambah</button></h4>
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
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Acara</th>
                                        <th>Lokasi</th>
                                        <th>Dosen</th>
                                        <th>Jadwal</th>
                                        <th>Action</th>
                                    </tr>
                                    <?php if (!empty($penjadwalan)) : ?>
                                        <?php
                                        $no = 1 + ($numberPage * ($currentPage - 1));
                                        foreach ($penjadwalan as $jadwal) : ?>
                                            <?php $peserta = getPeserta($jadwal->penjadwalanId); ?>
                                            <tr>
                                                <td><?= $no++; ?></td>
                                                <td><?= $jadwal->penjadwalanJudul; ?></td>
                                                <td class="align-middle"><i class="fas fa-map-marker <?= "text-" . randomColor() ?>"></i> <?= $jadwal->penjadwalanLokasi ?></td>
                                                <td>
                                                    <?php foreach (json_decode($peserta)->data as $key => $dsn) : ?>
                                                        <?php if ($key < 5) : ?>
                                                            <img alt="image" src=' <?= base_url("template/assets/img/avatar/avatar-" . random_int(1, 5) . ".png") ?>' class="rounded-circle" width="35" data-toggle="tooltip" title="<?= $dsn->email ?>">
                                                        <?php endif; ?>
                                                    <?php endforeach; ?>
                                                </td>
                                                <td><?= $jadwal->penjadwalanStartDate ?> s/d <?= $jadwal->penjadwalanEndDate ?></td>
                                                <td>
                                                    <button class="btn btn-info"><i class="fas fa-eye"></i></button>
                                                    <button class="btn btn-warning"><i class="fas fa-pen"></i></button>
                                                    <button class="btn btn-danger" data-confirm="Konfirmasi|Apakah Kamu yakin akan menghapus penjadwalan <strong><?= $jadwal->penjadwalanJudul; ?></strong>?" data-confirm-yes='hapusEvent(<?= $jadwal->penjadwalanId; ?>,"<?= $jadwal->penjadwalanJudul; ?>","penjadwalan")'><i class="fas fa-trash"></i></button>
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
                            <option value="<?= $blok->matkulBlokId ?>,<?= $blok->matkulBlokNama ?>"><?= $blok->matkulBlokKode ?> - <?= $blok->matkulBlokNama ?> (<?= $blok->matkulBlokKurikulumNama ?>)</option>
                        <?php endforeach ?>
                    </select>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Tanggal</label>
                            <input type="date" class="form-control" placeholder="Pilih Tanggal" name="startDate">
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
                <div class="form-group">
                    <label>Lokasi Acara</label>
                    <input name="lokasi" type="text" class="form-control" value="">
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
    </form>
</div>

<?= view('layout/templateFooter'); ?>


<?= $this->endSection(); ?>