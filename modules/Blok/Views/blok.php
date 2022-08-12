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
                    <h4></h4>
                    <div class="card-header-form col-md-4">
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
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th width="2%" style="text-align:center" scope="col">No.</th>
                                    <th scope="col">Kode</th>
                                    <th scope="col">Nama</th>
                                    <th scope="col">Nama Asing</th>
                                    <th width="18%" scope="col">Prodi</th>
                                    <th scope="col">Semester</th>
                                    <th width="10%" scope="col">Kurikulum</th>
                                    <th width="10%" style="text-align:center" scope="col">Action</th>
                                </tr>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($matkulBlok)) : ?>
                                    <?php
                                    $no = 1 + ($numberPage * ($currentPage - 1));
                                    foreach ($matkulBlok as $data) : ?>
                                        <tr>
                                            <td style="text-align:center" scope="row"><?= $no++; ?></td>
                                            <td><?= $data->matkulBlokKode; ?></td>
                                            <td><?= $data->matkulBlokNama; ?></td>
                                            <td><?= $data->matkulBlokEnglish; ?></td>
                                            <td><?= $data->matkulBlokProdiNama; ?> (<?= $data->matkulBlokProdiAkronim; ?>)</td>
                                            <td><?= $data->matkulBlokSemester; ?></td>
                                            <td><?= $data->matkulBlokKurikulumNama; ?></td>
                                            <td style="text-align:center">
                                                <button class="btn btn-icon icon-left btn-danger" data-toggle="modal" data-target="#hapus<?= $data->matkulBlokId; ?>"><i class="fas fa-trash"></i></button>
                                            </td>
                                        </tr>
                                    <?php endforeach ?>
                                <?php else : ?>
                                    <?= view('layout/templateEmpty', ['jumlahSpan' => 8]); ?>
                                <?php endif ?>
                            </tbody>
                        </table>
                        <?= $pager->links('blok', 'pager') ?>
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
                <h5 class="modal-title">Tambah<strong> <?= $title; ?></strong></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="blok/tambah" method="POST">
                <?= csrf_field() ?>
                <div class="modal-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered" id="table-1">
                            <thead>
                                <tr>
                                    <th width="2%" style="text-align:center" scope="col"></th>
                                    <th scope="col">Kode</th>
                                    <th scope="col">Nama</th>
                                    <th scope="col">Nama Asing</th>
                                    <th width="15%" scope="col">Prodi</th>
                                    <th scope="col">Semester</th>
                                    <th width="10%" scope="col">Kurikulum</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                foreach ($apiBlok as $data) : ?>
                                    <tr>
                                        <td style="text-align:center" scope="row">
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" id="check<?= $data->Course_Id ?>" name="dataBlok[]" value="<?= $data->Course_Code . "," . $data->Course_Name . "," . $data->Course_Name_Eng . "," . $data->Department_Id . "," . $data->Department_Name . "," . $data->Department_Acronym . "," . $data->Study_Level_Id . "," . $data->Curriculum_Id . "," . $data->Curriculum_Name ?>">
                                                <label class="custom-control-label" for="check<?= $data->Course_Id ?>"></label>
                                            </div>
                                        </td>
                                        <td><?= ($data->Course_Code == null) ? '-' : $data->Course_Code; ?></td>
                                        <td><?= ($data->Course_Name == null) ? '-' : $data->Course_Name; ?></td>
                                        <td><?= ($data->Course_Name_Eng == null) ? '-' : $data->Course_Name_Eng; ?></td>
                                        <td><?= $data->Department_Name; ?> (<?= $data->Department_Acronym; ?>)</td>
                                        <td>Semester <?= $data->Study_Level_Id; ?></td>
                                        <td><?= $data->Curriculum_Name; ?></td>
                                    </tr>
                                <?php endforeach ?>
                            </tbody>
                        </table>
                    </div>
                    <br>
                    <label>Tipe Mata Kuliah</label>
                    <div class="form-group">
                        <div class="custom-control custom-radio custom-control-inline">
                            <input type="radio" id="blok" name="matkulBlokType" class="custom-control-input" value="BLOK" checked>
                            <label class="custom-control-label" for="blok">Blok</label>
                        </div>
                        <div class="custom-control custom-radio custom-control-inline">
                            <input type="radio" id="nonBlok" name="matkulBlokType" class="custom-control-input" value="NON BLOK">
                            <label class="custom-control-label" for="nonBlok">Non Blok</label>
                        </div>
                    </div>
                    <div class="modal-footer bg-whitesmoke br">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- end modal tambah -->

<?= view('layout/templateFooter'); ?>

<?= $this->endSection(); ?>