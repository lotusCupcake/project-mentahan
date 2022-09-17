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

    public function index()
    {
        $data = [
            'menu' => $this->fetchMenu(),
            'title' => "Manajemen Akun",
            'breadcrumb' => ['User', 'Manajemen Akun'],
        ];

        return view('Modules\ManajemenAkun\Views\manajemenAkun', $data);
    }
}
