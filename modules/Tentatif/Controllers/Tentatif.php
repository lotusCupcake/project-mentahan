<?php

/* 
This is Controller Krs
 */

namespace Modules\Tentatif\Controllers;

use App\Controllers\BaseController;
use Modules\Tentatif\Models\TentatifModel;
use Modules\Dosen\Models\DosenModel;
use Modules\JenisJadwal\Models\JenisJadwalModel;

class Tentatif extends BaseController
{
    protected $tentatifModel;
    protected $dosenModel;
    protected $jenisJadwalModel;

    public function __construct()
    {
        $this->tentatifModel = new TentatifModel();
        $this->dosenModel = new DosenModel();
        $this->jenisJadwalModel = new JenisJadwalModel();
    }

    public function index()
    {
        $keyword = $this->request->getVar('keyword');
        $data = [
            'menu' => $this->fetchMenu(),
            'title' => "Jadwal Tentatif",
            'breadcrumb' => ['Proses', 'Jadwal Tentatif'],
            'dosen' =>  $this->dosenModel->getDataDosen($keyword)->findAll(),
            'hari' => ['S', 'S', 'R', 'K', 'J'],
            'jadwal' => $this->jenisJadwalModel->getTentatif()->get()->getResult(),
            'validation' => \Config\Services::validation(),
        ];
        return view('Modules\Tentatif\Views\tentatif', $data);
    }
}
