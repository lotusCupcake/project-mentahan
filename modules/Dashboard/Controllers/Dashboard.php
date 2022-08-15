<?php

/* 
This is Controller Krs
 */

namespace Modules\Dashboard\Controllers;

use App\Controllers\BaseController;
use Modules\Sesi\Models\SesiModel;
use Modules\Blok\Models\BlokModel;
use Modules\JenisJadwal\Models\JenisJadwalModel;

class Dashboard extends BaseController
{

    public function index()
    {
        $data = [
            'menu' => $this->fetchMenu(),
            'title' => "Dashboard",
            'breadcrumb' => ['Home', 'Dashboard'],
        ];
        return view('Modules\Dashboard\Views\dashboard', $data);
    }
}
