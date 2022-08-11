<?php

/* 
This is Controller ManajemenAkun
 */

namespace Modules\ManajemenAkun\Controllers;

use App\Controllers\BaseController;
use Modules\ManajemenAkun\Models\ManajemenAkunModel;
use App\Models\AuthGroupsModel;
use App\Models\AuthGroupsUsersModel;


class ManajemenAkun extends BaseController
{
    protected $manajemenAkunModel;
    protected $authGroupsUsersModel;
    protected $authGroupsModel;
    protected $validation;

    public function __construct()
    {
        $this->manajemenAkunModel = new ManajemenAkunModel();
        $this->authGroupsModel = new AuthGroupsModel();
        $this->authGroupsUsersModel = new AuthGroupsUsersModel();
        $this->validation = \Config\Services::validation();
    }

    // public function index()
    // {
    //     $currentPage = $this->request->getVar('page_manajemenAkun') ? $this->request->getVar('page_manajemenAkun') : 1;
    //     $keyword = $this->request->getVar('keyword');
    //     if ($keyword) {
    //         $manajemenAkun = $this->manajemenAkunModel->getManajemenAkunSearch($keyword);
    //     } else {
    //         $manajemenAkun = $this->manajemenAkunModel->getManajemenAkun();
    //     }
    //     $data = [
    //         'menu' => $this->fetchMenu(),
    //         'title' => "Manajemen Akun",
    //         'breadcrumb' => ['User', 'Manajemen Akun'],
    //         'manajemenAkun' => $manajemenAkun->paginate($this->numberPage, 'manajemenAkun'),
    //         'authGroups' =>  $this->authGroupsModel->findAll(),
    //         'currentPage' => $currentPage,
    //         'numberPage' => $this->numberPage,
    //         'pager' => $this->manajemenAkunModel->pager,
    //         'validation' => \Config\Services::validation(),
    //     ];

    //     return view('Modules\ManajemenAkun\Views\manajemenAkun', $data);
    // }

    // public function edit($id)
    // {
    //     $url = $this->request->getServer('HTTP_REFERER');
    //     $rules = [
    //         'email' => rv('required', ['required' => 'Email Harus Diisi!']),
    //         'username' => rv('required', ['required' => 'Nama Harus Diisi!']),
    //         'role' => rv('required', ['required' => 'Role Harus Dipilih!']),
    //     ];
    //     if (!$this->validate($rules)) {
    //         return redirect()->to('/manajemenAkun')->withInput();
    //     };

    //     $data = array(
    //         'email' => trim($this->request->getVar('email')),
    //         'username' => trim($this->request->getVar('username')),
    //         'active' => trim($this->request->getVar('active')) == null ? 0 : 1,
    //     );

    //     $data_user_group = array('group_id' => trim($this->request->getPost('role')));

    //     if ($this->manajemenAkunModel->update($id, $data)) {
    //         if ($this->authGroupsUsersModel->update($id, $data_user_group)) {
    //             session()->setFlashdata('success', 'Data Akun Berhasil Diupdate !');
    //             return redirect()->to($url);
    //         }
    //     }
    // }
}
