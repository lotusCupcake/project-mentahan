<?php

/* 
This is Controller Krs
 */

namespace Modules\Absensi\Controllers;

use App\Controllers\BaseController;
use Modules\Absensi\Models\AbsensiModel;
use Modules\Blok\Models\BlokModel;
use Modules\Dosen\Models\DosenModel;


class Absensi extends BaseController
{

    protected $absensiModel;
    protected $blokModel;
    protected $dosenModel;

    public function __construct()
    {
        $this->absensiModel = new AbsensiModel();
        $this->blokModel = new BlokModel();
        $this->dosenModel = new DosenModel();
    }

    public function index()
    {
        $currentPage = $this->request->getVar('page_absen') ? $this->request->getVar('page_absen') : 1;
        $keyword = $this->request->getVar('keyword');
        $absen = $this->absensiModel->getAbsen($keyword);
        $data = [
            'menu' => $this->fetchMenu(),
            'title' => "Absensi Workshop",
            'breadcrumb' => ['Home', 'Data', 'Absensi Workshop'],
            'absen' => $absen->paginate($this->numberPage, 'absen'),
            'blok' => $this->blokModel->getMatkulBlok()->findAll(),
            'dosen' => $this->dosenModel->getDataDosen()->findAll(),
            'tahunAjaran' => getTahunAjaran(),
            'currentPage' => $currentPage,
            'numberPage' => $this->numberPage,
            'pager' => $absen->pager,
            'validation' => \Config\Services::validation(),
        ];
        return view('Modules\Absensi\Views\absensi', $data);
    }

    public function add()
    {
        // dd($_POST);
        $url = $this->request->getServer('HTTP_REFERER');
        $dataDosen = $this->request->getVar('absensiPeserta');
        $dosen = [];
        foreach ($dataDosen as $key => $value) {
            $dosen[] = ['email' => $value];
        }
        $data = [
            'absensiTahunAjaran' => trim($this->request->getvar('absensiTahunAjaran')),
            'absensiAngkatan' => trim($this->request->getvar('absensiAngkatan')),
            'absensiMatkulBlokId' => trim($this->request->getvar('absensiMatkulBlokId')),
            'absensiPeserta' => json_encode(['data' => $dosen]),
            'absensiCreatedBy' => user()->email,
            'absensiCreatedDate' => date('Y-m-d H:i:s'),
        ];
        $this->absensiModel->insert($data);
        session()->setFlashdata('success', 'Data Absensi Berhasil Ditambahkan');
        return redirect()->to($url);
    }

    // public function upload()
    // {
    //     $file_excel = $this->request->getFile('fileexcel');
    //     $ext = $file_excel->getClientExtension();
    //     if ($ext == 'xls') {
    //         $render = new \PhpOffice\PhpSpreadsheet\Reader\Xls();
    //     } else {
    //         $render = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
    //     }
    //     $spreadsheet = $render->load($file_excel);
    //     $contacts = $spreadsheet->getActiveSheet()->toArray();
    //     // dd($contacts);
    //     $dt = [];
    //     foreach ($contacts as $key => $data) {
    //         if ($key == 0) {
    //             continue;
    //         }
    //         array_push($dt, $data[0]);
    //     }
    //     dd($dt);
    // }
}
