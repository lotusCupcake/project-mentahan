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
        $data = [
            'menu' => $this->fetchMenu(),
            'title' => "Absensi Workshop",
            'breadcrumb' => ['Home', 'Data', 'Absensi Workshop'],
            'blok' => $this->blokModel->getMatkulBlok()->findAll(),
            'dosen' => $this->dosenModel->getDataDosen()->findAll(),
            'validation' => \Config\Services::validation(),
        ];
        return view('Modules\Absensi\Views\absensi', $data);
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
