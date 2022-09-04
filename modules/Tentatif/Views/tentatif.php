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
                                    <select class="form-control" name="jadwalTentatifTahunAjaran">
                                        <option value="">Pilih Tahun Ajaran</option>
                                        <?php foreach ($tahunAjaran as $thn) : ?>
                                            <option value="<?= $thn->Term_Year_Name ?>" <?= ($thn->Term_Year_Name == $tahunAjaranAktif) ? 'selected' : '' ?>><?= $thn->Term_Year_Name ?></option>
                                        <?php endforeach ?>
                                    </select>
                                </div>
                            </div>
                            <ul class="nav nav-tabs" id="myTab" role="tablist">
                                <?php foreach ($jadwal as $key => $jdwl) : ?>
                                    <li class="nav-item">
                                        <a class="nav-link <?= ($jadwal[0]->jenisJadwalKode == $jdwl->jenisJadwalKode) ? 'active' : '' ?>" id="<?= $jdwl->unic ?>-tab" data-toggle="tab" href="#<?= $jdwl->unic ?>" role="tab" aria-controls="<?= $jdwl->unic ?>" aria-selected="<?= ($jadwal[0]->jenisJadwalKode == $jdwl->jenisJadwalKode) ? 'true' : 'false' ?>"><?= $jdwl->jenisJadwalKode ?></a>
                                    </li>
                                <?php endforeach ?>
                            </ul>
                            <div class="tab-content" id="myTabContent">
                                <?php foreach ($jadwal as $key => $jdwl) : ?>
                                    <div class="tab-pane fade <?= ($jadwal[0]->jenisJadwalKode == $jdwl->jenisJadwalKode) ? 'show active' : '' ?>" id="<?= $jdwl->unic ?>" role="tabpanel" aria-labelledby="<?= $jdwl->unic ?>-tab">

                                        <div class="table-responsive">
                                            <table class="table table-bordered">
                                                <thead>
                                                    <?php $jlhHari = count($hari); ?>
                                                    <tr>
                                                        <th rowspan="2" width="2%" style="text-align:center" scope="col" class="frezz">No.</th>
                                                        <th rowspan="2" width="30%" scope="col" class="frezz">Nama Lengkap</th>
                                                        <?php foreach (getSesiWhere(['jenis_jadwal.jenisJadwalId' => $jdwl->jenisJadwalId]) as $key => $sesi) : ?>
                                                            <th colspan="<?= $jlhHari ?>" style="text-align:center" scope="col"><?= $sesi->sesiStart ?>-<?= $sesi->sesiEnd ?></th>
                                                        <?php endforeach ?>
                                                    </tr>
                                                    <tr>
                                                        <?php foreach (getSesiWhere(['jenis_jadwal.jenisJadwalId' => $jdwl->jenisJadwalId]) as $key => $sesi) : ?>
                                                            <?php foreach ($hari as $key => $value) : ?>
                                                                <th style="text-align:center" scope="col"><?= $value; ?></th>
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
                                                                <?php foreach (getSesiWhere(['jenis_jadwal.jenisJadwalId' => $jdwl->jenisJadwalId]) as $key => $sesi) : ?>
                                                                    <?php foreach ($hari as $h => $value) : ?>
                                                                        <td style="text-align:center" scope="col">
                                                                            <?php foreach ($jadwalTentatifSemester as $t => $tentatif) : ?>
                                                                                <?php $dosenId = $tentatif->jadwalTentatifDosenId ?>
                                                                                <?php $session = json_decode($tentatif->jadwalTentatifDetail)->data ?>
                                                                                <?php foreach ($session as $s => $ses) : ?>
                                                                                    <?php if ($dosenId == $data->dosenId && $ses->sesi == $sesi->sesiId) : ?>
                                                                                        <input <?= (in_array($h,  array_map('intval', $ses->hari))) ? "checked" : "" ?> type="checkbox" onchange="checklistTentatif('<?= $data->dosenId . ',' . $sesi->sesiId . ',' . $key ?>')" data-dosen="<?= $data->dosenId ?>" name="<?= $data->dosenId . $jdwl->unic ?>" value="<?= $sesi->sesiId . ',' . $key ?>">
                                                                                    <?php elseif ($dosenId == $data->dosenId && $ses->sesi != $sesi->sesiId) : ?>
                                                                                    <?php endif ?>
                                                                                <?php endforeach ?>
                                                                            <?php endforeach ?>
                                                                        </td>
                                                                    <?php endforeach ?>
                                                                <?php endforeach ?>
                                                            </tr>
                                                        <?php endforeach ?>
                                                    <?php else : ?>
                                                        <?= view('layout/templateEmpty', ['jumlahSpan' => 4]); ?>
                                                    <?php endif ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                <?php endforeach ?>
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