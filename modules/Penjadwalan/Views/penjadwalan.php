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
                            <h4><i class='<?= $icon ?>'></i> <?= $title ?></h4>
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
                                        <th>Members</th>
                                        <th>Due Date</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                    <?php if (!empty($penjadwalan)) : ?>
                                        <?php
                                        $no = 1 + ($numberPage * ($currentPage - 1));
                                        foreach ($penjadwalan as $jadwal) : ?>
                                            <tr>
                                                <td><?= $no++; ?></td>
                                                <td><?= $jadwal->penjadwalanJudul; ?></td>
                                                <td class="align-middle"><i class="fas fa-map-marker"></i> <?= $jadwal->penjadwalanLokasi ?></td>
                                                <td>
                                                    <img alt="image" src=' <?= base_url("template/assets/img/avatar/avatar-2.png") ?>' class="rounded-circle" width="35" data-toggle="tooltip" title="Rizal Fakhri">
                                                    <img alt="image" src='<?= base_url("template/assets/img/avatar/avatar-5.png") ?>' class="rounded-circle" width="35" data-toggle="tooltip" title="Isnap Kiswandi">
                                                    <img alt="image" src='<?= base_url("template/assets/img/avatar/avatar-4.png") ?>' class="rounded-circle" width="35" data-toggle="tooltip" title="Yudi Nawawi">
                                                    <img alt="image" src='<?= base_url("template/assets/img/avatar/avatar-1.png") ?>' class="rounded-circle" width="35" data-toggle="tooltip" title="Khaerul Anwar">
                                                </td>
                                                <td><?= $jadwal->penjadwalanStartDate ?> s/d <?= $jadwal->penjadwalanEndDate ?></td>
                                                <td></td>
                                                <td></td>
                                            </tr>
                                        <?php endforeach ?>
                                    <?php else : ?>
                                        <?= view('layout/templateEmpty', ['jumlahSpan' => 7]); ?>
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

<?= view('layout/templateFooter'); ?>

<?= $this->endSection(); ?>