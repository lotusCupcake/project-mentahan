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
                            <div class="form-row">
                                <div class="form-group col-md-2">
                                    <select class="form-control" name="jadwalPemetaanJadwalTahunAjaran" onchange="tahunAjaran()">
                                        <option value="">Pilih Tahun Ajaran</option>
                                        <?php foreach ($tahunAjaran as $thn) : ?>
                                            <option value="<?= $thn->Term_Year_Name ?>" <?= ($thn->Term_Year_Name == $tahunAjaranAktif) ? 'selected' : '' ?>><?= $thn->Term_Year_Name ?></option>
                                        <?php endforeach ?>
                                    </select>
                                </div>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                        <?php $jlhHari = count($hari); ?>
                                        <tr>
                                            <th rowspan="3" width="2%" style="text-align:center" scope="col">No.</th>
                                            <th rowspan="3" width="30%" scope="col">Nama Lengkap</th>
                                            <?php foreach ($jadwal as $key => $jdwl) : ?>
                                                <th colspan="<?= $jlhHari * count(getSesiWhere(['jenis_jadwal.jenisJadwalId' => $jdwl->jenisJadwalId])) ?>" style="text-align:center" scope="col"><?= $jdwl->jenisJadwalKode ?></th>
                                            <?php endforeach ?>

                                            <?php foreach ($jadwalTentatif as $key => $tentatif) : ?>
                                                <th rowspan="3" style="text-align:center" scope="col"><?= $tentatif->jenisJadwalKode; ?></th>
                                                <th rowspan="3" style="text-align:center" scope="col">Total</th>
                                            <?php endforeach ?>
                                            <th rowspan="3" style="text-align:center" scope="col">Grand Total</th>
                                        </tr>
                                        <tr>
                                            <?php foreach ($jadwal as $key => $jdwl) : ?>
                                                <?php foreach (getSesiWhere(['jenis_jadwal.jenisJadwalId' => $jdwl->jenisJadwalId]) as $key => $sesi) : ?>
                                                    <th colspan="<?= $jlhHari ?>" style="text-align:center" scope="col"><?= $sesi->sesiStart ?>-<?= $sesi->sesiEnd ?></th>
                                                <?php endforeach ?>
                                            <?php endforeach ?>
                                        </tr>
                                        <tr>
                                            <?php foreach ($jadwal as $key => $jdwl) : ?>
                                                <?php foreach (getSesiWhere(['jenis_jadwal.jenisJadwalId' => $jdwl->jenisJadwalId]) as $key => $sesi) : ?>
                                                    <?php foreach ($hari as $key => $value) : ?>
                                                        <th style="text-align:center" scope="col"><?= $value; ?></th>
                                                    <?php endforeach ?>
                                                <?php endforeach ?>
                                            <?php endforeach ?>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if (!empty($dosen)) : ?>
                                            <?php
                                            $no = 1;
                                            foreach ($dosen as $i => $data) : ?>
                                                <tr>
                                                    <td style="text-align:center" scope="row" class="frezz"><?= $no++; ?></td>
                                                    <td class="frezz">
                                                        <p class="ft12"><?= $data->dosenFullname; ?></p>
                                                    </td>
                                                    <?php foreach ($jadwal as $key => $jdwl) : ?>
                                                        <?php foreach (getSesiWhere(['jenis_jadwal.jenisJadwalId' => $jdwl->jenisJadwalId]) as $key => $sesi) : ?>
                                                            <?php foreach ($hari as $h => $value) : ?>
                                                                <td style="text-align:center" scope="col">
                                                                    <?php if (count($jadwalPemetaanJadwalSemester) > 0) : ?>
                                                                        <?php foreach ($jadwalPemetaanJadwalSemester as $jad => $dtjadwal) : ?>
                                                                            <?php if ($dtjadwal['dosen'] == $data->dosenId && $dtjadwal['sesi'] == $sesi->sesiId && in_array($h, array_map('intval', $dtjadwal['hari'])) && $jdwl->unic == $dtjadwal['jenis']) : ?>
                                                                                <i class="fas fa-check"></i>
                                                                            <?php endif ?>
                                                                        <?php endforeach ?>
                                                                    <?php endif ?>
                                                                </td>
                                                            <?php endforeach ?>
                                                        <?php endforeach ?>
                                                    <?php endforeach ?>
                                                    <?php foreach ($jadwalTentatif as $key => $tentatif) : ?>
                                                        <td style="text-align:center" scope="col"></td>
                                                        <td style="text-align:center" scope="col"></td>
                                                    <?php endforeach ?>
                                                    <td style="text-align:center" scope="col"></td>
                                                </tr>
                                            <?php endforeach ?>
                                        <?php else : ?>
                                            <?= view('layout/templateEmpty', ['jumlahSpan' => 4]); ?>
                                        <?php endif ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<?= view('layout/templateFooter'); ?>

<?= $this->endSection(); ?>