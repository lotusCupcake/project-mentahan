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
        $currentPage = $this->request->getVar('page_dosen') ? $this->request->getVar('page_dosen') : 1;
        $keyword = $this->request->getVar('keyword');
        $dosen = $this->dosenModel->getDataDosen($keyword);
        $data = [
            'menu' => $this->fetchMenu(),
            'title' => "Jadwal Tentatif",
            'breadcrumb' => ['Proses', 'Jadwal Tentatif'],
            'dosen' =>  $dosen->paginate($this->numberPage, 'dosen'),
            'hari' => ['S', 'S', 'R', 'K', 'J'],
            'jadwal' => $this->jenisJadwalModel->getTentatif()->get()->getResult(),
            'currentPage' => $currentPage,
            'numberPage' => $this->numberPage,
            'pager' => $dosen->pager,
            'validation' => \Config\Services::validation(),
        ];
        // dd($data['jadwal']);
        return view('Modules\Tentatif\Views\tentatif', $data);
    }
}
