<?php

/* 
This is Controller Krs
 */

namespace Modules\PemetaanJadwal\Controllers;

use App\Controllers\BaseController;
use Modules\PemetaanJadwal\Models\PemetaanJadwalModel;

class PemetaanJadwal extends BaseController
{
    protected $pemetaanJadwalModel;

    public function __construct()
    {
        $this->pemetaanJadwalModel = new PemetaanJadwalModel();
    }

    public function index()
    {
        $data = [
            'menu' => $this->fetchMenu(),
            'title' => "Pemetaan Jadwal",
            'breadcrumb' => ['Proses', 'Pemetaan Jadwal'],
            'validation' => \Config\Services::validation(),
        ];
        return view('Modules\PemetaanJadwal\Views\pemetaanJadwal', $data);
    }
}
