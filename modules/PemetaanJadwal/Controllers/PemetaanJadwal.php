<?php

/* 
This is Controller Krs
 */

namespace Modules\PemetaanJadwal\Controllers;

use App\Controllers\BaseController;
use Modules\PemetaanJadwal\Models\PemetaanJadwalModel;
use Modules\Dosen\Models\DosenModel;
use Modules\JenisJadwal\Models\JenisJadwalModel;

class PemetaanJadwal extends BaseController
{
    protected $pemetaanJadwalModel;
    protected $dosenModel;
    protected $jenisJadwalModel;

    public function __construct()
    {
        $this->pemetaanJadwalModel = new PemetaanJadwalModel();
        $this->dosenModel = new DosenModel();
        $this->jenisJadwalModel = new JenisJadwalModel();
    }

    public function index()
    {
        $keyword = $this->request->getVar('keyword');
        $tahunAjaran = $this->request->getVar('tahun_ajaran') ? $this->request->getVar('tahun_ajaran') : getTahunAjaran();
        $jadwalPemetaanJadwalSemester = $this->pemetaanJadwalModel->dataExist(['jadwalTentatifTahunAjaran' => $tahunAjaran])->findAll();
        $detailJadwalExist = [];
        if (count($jadwalPemetaanJadwalSemester) > 0) {
            foreach ($jadwalPemetaanJadwalSemester as $jad => $jadwal) {
                $dosenId = $jadwal->jadwalTentatifDosenId;
                foreach (json_decode($jadwal->jadwalTentatifDetail)->data as $det => $detail) {
                    $detailJadwalExist[] = [
                        'dosen' => $dosenId,
                        'sesi' => $detail->sesi,
                        'hari' => $detail->hari,
                        'jenis' => $detail->jenis
                    ];
                }
            }
        }

        $data = [
            'menu' => $this->fetchMenu(),
            'title' => "Pemetaan Jadwal",
            'breadcrumb' => ['Proses', 'Pemetaan Jadwal'],
            'dosen' =>  $this->dosenModel->getDataDosen($keyword)->findAll(),
            'tahunAjaran' => getListTahunAjaran(),
            'hari' => ['S', 'S', 'R', 'K', 'J'],
            'jadwal' => $this->jenisJadwalModel->getTentatif()->get()->getResult(),
            'jadwalTentatif' => $this->jenisJadwalModel->getJadwalTentatif()->get()->getResult(),
            'validation' => \Config\Services::validation(),
            'tahunAjaranAktif' => $tahunAjaran,
            'jadwalPemetaanJadwalSemester' => $detailJadwalExist
        ];
        return view('Modules\PemetaanJadwal\Views\pemetaanJadwal', $data);
    }

    public function add()
    {
        $dataExist = $this->pemetaanJadwalModel->dataExist(
            [
                'jadwalTentatifTahunAjaran' => trim($this->request->getvar('ta')),
                'jadwalPemetaanJadwalDosenId' => trim($this->request->getvar('dosen')),
            ]
        )->findAll();
        if (count($dataExist) == 0) {
            $data = [
                'jadwalTentatifTahunAjaran' => trim($this->request->getvar('ta')),
                'jadwalPemetaanJadwalDosenId' => trim($this->request->getvar('dosen')),
                'jadwalPemetaanJadwalDetail' => trim($this->request->getvar('jadwal')),
            ];
            if ($this->pemetaanJadwalModel->insert($data)) {
                $response = ['status' => true, 'message' => 'Berhasil Tambah'];
            } else {
                $response = ['status' => false, 'message' => 'Tidak Berhasil Tambah'];
            }
            echo json_encode($response);
        } else {
            $id = $dataExist[0]->jadwalPemetaanJadwalId;
            $data = [
                'jadwalPemetaanJadwalDetail' => trim($this->request->getvar('jadwal')),
            ];
            if ($this->pemetaanJadwalModel->update($id, $data)) {
                $response = ['status' => true, 'message' => 'Berhasil Update'];
            } else {
                $response = ['status' => false, 'message' => 'Tidak Berhasil Update'];
            }
            echo json_encode($response);
        }
    }
}
