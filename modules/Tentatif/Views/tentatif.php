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
                                            <table class="table table-striped table-bordered">
                                                <thead>
                                                    <?php $jlhHari = count($hari); ?>
                                                    <tr>
                                                        <th rowspan="2" width="2%" style="text-align:center" scope="col">No.</th>
                                                        <th rowspan="2" width="30%" scope="col">Nama Lengkap</th>
                                                        <th rowspan="2" scope="col">Nama</th>
                                                        <th rowspan="2" scope="col">Email General</th>
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
                                                        $no = 1 + ($numberPage * ($currentPage - 1));
                                                        foreach ($dosen as $data) : ?>
                                                            <tr>
                                                                <td style="text-align:center" scope="row"><?= $no++; ?></td>
                                                                <td><?= $data->dosenFullname; ?></td>
                                                                <td><?= $data->dosenShortname; ?></td>
                                                                <td><?= ($data->dosenEmailGeneral == null) ? '-' : $data->dosenEmailGeneral; ?></td>
                                                                <?php foreach (getSesiWhere(['jenis_jadwal.jenisJadwalId' => $jdwl->jenisJadwalId]) as $key => $sesi) : ?>
                                                                    <?php foreach ($hari as $key => $value) : ?>
                                                                        <td style="text-align:center" scope="col">
                                                                            <input type="checkbox" name="<?= $data->dosenId . $jdwl->unic ?>" value="<?= $sesi->sesiId . ',' . $key ?>">
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
                                            <?= $pager->links('dosen', 'pager') ?>
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