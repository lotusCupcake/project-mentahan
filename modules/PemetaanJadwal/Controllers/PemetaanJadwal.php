<?php

/* 
This is Controller Krs
 */

namespace Modules\PemetaanJadwal\Controllers;

use App\Controllers\BaseController;
use Modules\PemetaanJadwal\Models\PemetaanJadwalModel;
use Modules\Dosen\Models\DosenModel;
use Modules\JenisJadwal\Models\JenisJadwalModel;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class PemetaanJadwal extends BaseController
{
    protected $pemetaanJadwalModel;
    protected $dosenModel;
    protected $jenisJadwalModel;
    protected $spreadsheet;

    public function __construct()
    {
        $this->pemetaanJadwalModel = new PemetaanJadwalModel();
        $this->dosenModel = new DosenModel();
        $this->jenisJadwalModel = new JenisJadwalModel();
        $this->spreadsheet = new Spreadsheet();
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

    public function print()
    {
        $tahunAjaran = $this->request->getVar('jadwalTentatifTahunAjaran');
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
        $keyword = $this->request->getVar('keyword');
        $dosen =  $this->dosenModel->getDataDosen($keyword)->findAll();
        $hari = ['S', 'S', 'R', 'K', 'J'];
        $jadwal = $this->jenisJadwalModel->getTentatif()->get()->getResult();
        $jadwalTentatif = $this->jenisJadwalModel->getJadwalTentatif()->get()->getResult();
        $jadwalPemetaanJadwalSemester = $detailJadwalExist;

        $spreadsheet = new Spreadsheet();

        $default = 1;
        $konten = 0;
        $konten = $default + $konten;
        $spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('A' . $konten, 'No.')
            ->setCellValue('B' . $konten, 'Jenis Kegiatan')
            ->setCellValue('C' . $konten, 'Nilai (Bobot X Nilai)')->getStyle("A" . $konten . ":" . "C" . $konten)->getFont()->setBold(true);
        $konten++;
        $writer = new Xlsx($spreadsheet);
        $fileName = 'Tentatif Jadwal Tahun Ajaran ' . $tahunAjaran;

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename=' . $fileName . '.xlsx');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
    }
}
