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
    protected $ReaderHtml;

    public function __construct()
    {
        $this->pemetaanJadwalModel = new PemetaanJadwalModel();
        $this->dosenModel = new DosenModel();
        $this->jenisJadwalModel = new JenisJadwalModel();
        $this->spreadsheet = new Spreadsheet();
        $this->ReaderHtml = new \PhpOffice\PhpSpreadsheet\Reader\Html();
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
        $jlhHari = count($hari);
        $jadwal = $this->jenisJadwalModel->getTentatif()->get()->getResult();
        $jadwalTentatif = $this->jenisJadwalModel->getJadwalTentatif()->get()->getResult();
        $jadwalPemetaanJadwalSemester = $detailJadwalExist;
        $span = 0;

        $this->spreadsheet = new Spreadsheet();
        $htmlString = '';
        $htmlString .= '<table style="border: 1px solid black">';
        $htmlString .= '<tr>';
        $htmlString .= '<th rowspan="3" align="center" valign="center"  style="font-weight: bold;border:solid black">No</th>';
        $htmlString .= '<th rowspan="3" width="550%" align="center" valign="center" style="font-weight: bold;border: solid black" bgcolor="#B7E1CD">Nama Lengkap</th>';
        foreach ($jadwal as $key => $jdwl) {
            $htmlString .= '<th colspan="' . $jlhHari * count(getSesiWhere(['jenis_jadwal.jenisJadwalId' => $jdwl->jenisJadwalId])) . '" align="center"  style="font-weight: bold;border:solid black">' . $jdwl->jenisJadwalKode . '</th>';
            $htmlString .= '<th bgcolor="gray" style="border:solid black"></th>';
        }
        foreach ($jadwalTentatif as $key => $tentatif) {
            $htmlString .= '<th rowspan="3" align="center" valign="center" style="font-weight: bold;border:solid black">' . $tentatif->jenisJadwalKode . '</th>';
            $htmlString .= '<th rowspan="3" align="center" valign="center" style="font-weight: bold;border:solid black" bgcolor="#B7E1CD">Total</th>';
        }
        $htmlString .= '<th rowspan="3" align="center" valign="center" style="font-weight: bold;border:solid black" bgcolor="#B7E1CD">Grand Total</th>';
        $htmlString .= '</tr>';
        $htmlString .= '<tr>';
        foreach ($jadwal as $key => $jdwl) {
            foreach (getSesiWhere(['jenis_jadwal.jenisJadwalId' => $jdwl->jenisJadwalId]) as $key => $sesi) {
                $htmlString .= '<th colspan="' . $jlhHari . '" align="center" style="font-weight: bold;border:solid black" bgcolor="#B7E1CD">' . $sesi->sesiStart . '-' . $sesi->sesiEnd . '</th>';
            }
            $htmlString .= '<th bgcolor="gray" style="border:solid black"></th>';
        }
        $htmlString .= '</tr>';
        $htmlString .= '<tr>';
        foreach ($jadwal as $key => $jdwl) {
            foreach (getSesiWhere(['jenis_jadwal.jenisJadwalId' => $jdwl->jenisJadwalId]) as $key => $sesi) {
                foreach ($hari as $key => $value) {
                    $htmlString .= '<th align="center" style="font-weight: bold;border:solid black" bgcolor="#A2C4C9">' . $value . '</th>';
                }
            }
            $htmlString .= '<th bgcolor="gray" style="border:solid black"></th>';
        }
        $htmlString .= '</tr>';
        $no = 1;
        foreach ($dosen as $i => $data) {
            $htmlString .= '<tr>';
            $htmlString .= '<td style="text-align:center;border:solid black">' . $no++ . '</td>';
            $htmlString .= '<td style="border:solid black">' . $data->dosenFullname . '</td>';
            foreach ($jadwal as $key => $jdwl) {
                foreach (getSesiWhere(['jenis_jadwal.jenisJadwalId' => $jdwl->jenisJadwalId]) as $key => $sesi) {
                    foreach ($hari as $h => $value) {
                        $htmlString .= '<td align="center" style="border:solid black ">';
                        if (count($jadwalPemetaanJadwalSemester) > 0) {
                            foreach ($jadwalPemetaanJadwalSemester as $jad => $dtjadwal) {
                                if ($dtjadwal['dosen'] == $data->dosenId && $dtjadwal['sesi'] == $sesi->sesiId && in_array($h, array_map('intval', $dtjadwal['hari'])) && $jdwl->unic == $dtjadwal['jenis']) {
                                    $htmlString .= '1';
                                }
                            }
                        }
                        $htmlString .= '</td>';
                    }
                }
                $htmlString .= '<td bgcolor="gray" style="border:solid black"></td>';
            }
            foreach ($jadwalTentatif as $key => $tentatif) {
                $htmlString .= '<td align="center" style="border:solid black"></td>';
                $htmlString .= '<td bgcolor="#B7E1CD" align="center" style="border:solid black"></td>';
            }
            $htmlString .= '<td bgcolor="#B7E1CD" align="center" style="border:solid black"></td>';
            $htmlString .= '</tr>';
        }
        $htmlString .= '</table>';

        $reader = new \PhpOffice\PhpSpreadsheet\Reader\Html();
        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Html($this->spreadsheet);
        $this->spreadsheet = $reader->loadFromString($htmlString);

        $writer = new Xlsx($this->spreadsheet);
        $fileName = 'Tentatif Jadwal Tahun Ajaran ' . $tahunAjaran;
        ob_end_clean();
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $fileName . '.xlsx"');
        header('Cache-Control: max-age=0');

        ob_end_clean();
        $writer->save('php://output');
    }
}
