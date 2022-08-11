<?= $this->extend('layout/templateHome'); ?>

<?= $this->section('content'); ?>
<!-- Wrapper Start -->
<?= view('layout/templateSidebar', ['menus' => $menu]); ?>

<div class="content-page">
    <div class="container-fluid">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb bg-primary">
                <li class="breadcrumb-item"><a href="/dashboard" class="text-white"><?= $breadcrumb[0]; ?></a></li>
                <li class="breadcrumb-item active text-white" aria-current="page"><?= $breadcrumb[1]; ?></li>
            </ol>
        </nav>
        <?php if ($validation->hasError('email')) : ?>
            <?= view('layout/templateAlert', ['msg' => ['danger', "<strong>Failed ! </strong>" . $validation->getError('email')]]); ?>
        <?php endif; ?>
        <?php if ($validation->hasError('name')) : ?>
            <?= view('layout/templateAlert', ['msg' => ['danger', "<strong>Failed ! </strong>" . $validation->getError('name')]]); ?>
        <?php endif; ?>
        <?php if ($validation->hasError('role')) : ?>
            <?= view('layout/templateAlert', ['msg' => ['danger', "<strong>Failed ! </strong>" . $validation->getError('role')]]); ?>
        <?php endif; ?>
        <?php if (!empty(session()->getFlashdata('success'))) : ?>
            <?= view('layout/templateAlert', ['msg' => ['success', 'ri-check-line', session()->getFlashdata('success')]]); ?>
        <?php endif; ?>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <div class="header-title">
                            <h4 class="card-title"><?= $title; ?></h4>
                        </div>
                        <div class="iq-search-bar device-search float-right">
                            <form action="#" class="searchbox">
                                <input type="text" class="text search-input" placeholder="Type here to search..." name="keyword" value="<?= isset($_GET['keyword']) ? $_GET['keyword'] : "" ?>">
                                <a class="search-link" href="#"><i class="ri-search-line"></i></a>
                            </form>
                        </div>
                    </div>

                    <div class="card-body">
                        <table class="table table-bordered table-responsive-md table-striped ">
                            <thead>
                                <tr>
                                    <th width="5%" style="text-align:center">No</th>
                                    <th>Email</th>
                                    <th>Username</th>
                                    <th>Role</th>
                                    <th style="text-align:center">Status</th>
                                    <th width="10%" style="text-align:center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($manajemenAkun)) : ?>
                                    <?php
                                    $no = 1  + ($numberPage * ($currentPage - 1));
                                    foreach ($manajemenAkun as $row) : ?>
                                        <tr>
                                            <td style="text-align:center"><?= $no++; ?></td>
                                            <td><?= $row->email; ?></td>
                                            <td><?= $row->username; ?></td>
                                            <td><?= $row->name; ?></td>
                                            <td style="text-align:center"><span class="mt-2 badge border <?= ($row->active == 1) ? "border-success text-success" : "border-danger text-danger" ?> mt-2"><?= ($row->active == 1) ? "Aktif" : "Tidak aktif" ?></span></td>
                                            <td style="text-align:center">
                                                <button type="button" class="btn btn-sm btn-secondary" data-toggle="modal" data-target="#editAkun<?= $row->user_id ?>"><i class="las la-edit"></i>Edit</button>
                                            </td>
                                        </tr>
                                    <?php endforeach ?>
                                <?php else : ?>
                                    <tr>
                                        <?= view('layout/templateEmpty', ['jumlahSpan' => 6]); ?>
                                    </tr>
                                <?php endif ?>
                            </tbody>
                        </table>
                        <?= $pager->links('manajemenAkun', 'pager') ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>

<!-- start modal edit -->
<?php foreach ($manajemenAkun as $edit) : ?>
    <div class="modal fade" id="editAkun<?= $edit->user_id; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Data Akun<strong> <?= $edit->username; ?></strong></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="manajemenAkun/ubah/<?= $edit->user_id; ?>" method="POST">
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Email</label>
                            <input class="form-control" value="<?= $edit->email ?>" name="email">
                        </div>
                        <div class="form-group">
                            <label>Username</label>
                            <input class="form-control" value="<?= $edit->username ?>" name="username">
                        </div>
                        <div class="form-group">
                            <label>Role</label>
                            <select class="form-control" name="role">
                                <?php foreach ($authGroups as $groups) : ?>
                                    <option value="<?= $groups->id; ?>" <?= ($groups->id == $edit->id) ? "selected" : "" ?>><?= $groups->name; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <div class="custom-control custom-switch custom-switch-icon custom-control-inline">
                                <div class="custom-switch-inner">
                                    <input type="checkbox" class="custom-control-input" id="customSwitch<?= $edit->user_id ?>" <?= ($edit->active == 1) ? 'checked' : ''; ?> value="<?= ($edit->active == null) ? 0 : 1; ?>" name="active">
                                    <label class="custom-control-label" for="customSwitch<?= $edit->user_id ?>">
                                        <span class="switch-icon-left"><i class="fa fa-check"></i></span>
                                        <span class="switch-icon-right"><i class="fa fa-check"></i></span>
                                    </label>
                                </div>
                            </div>
                            <label>Status (Aktif/Tidak Aktif)</label>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-sm btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php endforeach ?>
<!-- end modal edit -->

<!-- Wrapper End-->

<?= view('layout/templateFooter'); ?>

<?= $this->endSection(); ?>