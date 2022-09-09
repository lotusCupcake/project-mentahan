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
                        <div class="card-header"></div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-10">
                                    <div class="form-row">
                                        <div class="form-group col-md-2">
                                            <select class="form-control" name="tahunAjaran" onchange="tahunAjaran()">
                                                <option value="">Pilih Tahun Ajaran</option>
                                                <?php $year = isset($_GET['ta']) ? $_GET['ta'] : $tahunAjaranAktif;
                                                foreach ($tahunAjaran as $thn) : ?>
                                                    <option value="<?= $thn->Term_Year_Name ?>" <?= ($thn->Term_Year_Name == $year) ? 'selected' : '' ?>><?= $thn->Term_Year_Name ?></option>
                                                <?php endforeach ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="buttons float-right">
                                        <button class="btn btn-icon icon-left btn-primary mt-1" data-toggle="modal" data-target="#cetak"><i class="fas fa-print"></i> Cetak</button>
                                    </div>
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
                                            <?php $span = 0;
                                            foreach ($jadwal as $key => $jdwl) : ?>
                                                <?php foreach (getSesiWhere(['jenis_jadwal.jenisJadwalId' => $jdwl->jenisJadwalId]) as $key => $sesi) : ?>
                                                    <?php foreach ($hari as $key => $value) : ?>
                                                        <?php $span++ ?>
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
                                            <?= view('layout/templateEmpty', ['jumlahSpan' => $span + 7]); ?>
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

<!-- start modal cetak -->
<div class="modal fade" tabindex="-1" role="dialog" id="cetak">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><strong>Konfirmasi</strong></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Apakah kamu benar ingin mencetak <strong>Tentatif Jadwal Tahun Ajaran <?= isset($_GET['ta']) ? $_GET['ta'] : $tahunAjaranAktif ?></strong>?</p>
            </div>
            <form action="/pemetaanJadwal/cetak" method="post">
                <?= csrf_field(); ?>
                <div class="modal-footer bg-whitesmoke br">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Yes</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- end modal cetak -->

<?= view('layout/templateFooter'); ?>

<?= $this->endSection(); ?>