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
        $tahunAjaran = $this->request->getVar('tahun_ajaran') ? $this->request->getVar('tahun_ajaran') : getTahunAjaran();
        $jadwalTentatifSemester = $this->tentatifModel->dataExist(['jadwalTentatifTahunAjaran' => $tahunAjaran])->findAll();
        $data = [
            'menu' => $this->fetchMenu(),
            'title' => "Jadwal Tentatif",
            'breadcrumb' => ['Proses', 'Jadwal Tentatif'],
            'dosen' =>  $this->dosenModel->getDataDosen($keyword)->findAll(),
            'tahunAjaran' => getListTahunAjaran(),
            'hari' => ['S', 'S', 'R', 'K', 'J'],
            'jadwal' => $this->jenisJadwalModel->getTentatif()->get()->getResult(),
            'validation' => \Config\Services::validation(),
            'tahunAjaranAktif' => $tahunAjaran,
            'jadwalTentatifSemester' => $jadwalTentatifSemester
        ];
        // dd($data['jadwalTentatifSemester']);
        return view('Modules\Tentatif\Views\tentatif', $data);
    }

    public function add()
    {
        $dataExist = $this->tentatifModel->dataExist(
            [
                'jadwalTentatifTahunAjaran' => trim($this->request->getvar('ta')),
                'jadwalTentatifDosenId' => trim($this->request->getvar('dosen')),
            ]
        )->findAll();
        if (count($dataExist) == 0) {
            $data = [
                'jadwalTentatifTahunAjaran' => trim($this->request->getvar('ta')),
                'jadwalTentatifDosenId' => trim($this->request->getvar('dosen')),
                'jadwalTentatifDetail' => trim($this->request->getvar('jadwal')),
            ];
            if ($this->tentatifModel->insert($data)) {
                $response = ['status' => true, 'message' => 'Berhasil Tambah'];
            } else {
                $response = ['status' => false, 'message' => 'Tidak Berhasil Tambah'];
            }
            echo json_encode($response);
        } else {
            $id = $dataExist[0]->jadwalTentatifId;
            $data = [
                'jadwalTentatifDetail' => trim($this->request->getvar('jadwal')),
            ];
            if ($this->tentatifModel->update($id, $data)) {
                $response = ['status' => true, 'message' => 'Berhasil Update'];
            } else {
                $response = ['status' => false, 'message' => 'Tidak Berhasil Update'];
            }
            echo json_encode($response);
        }
    }
}
