<?php

/* 
This is Controller Krs
 */

namespace Modules\Absensi\Controllers;

use App\Controllers\BaseController;
use Modules\Absensi\Models\AbsensiModel;


class Absensi extends BaseController
{

    protected $absensiModel;

    public function __construct()
    {
        $this->absensiModel = new AbsensiModel();
    }

    public function index()
    {
        $data = [
            'menu' => $this->fetchMenu(),
            'title' => "Absensi Workshop",
            'breadcrumb' => ['Home', 'Data', 'Absensi Workshop'],
            'validation' => \Config\Services::validation(),
        ];
        return view('Modules\Absensi\Views\absensi', $data);
    }

    public function upload()
    {
        // $file_excel = $this->request->getFile('fileexcel');
        // $ext = $file_excel->getClientExtension();
        // if ($ext == 'xls') {
        //     $render = new \PhpOffice\PhpSpreadsheet\Reader\Xls();
        // } else {
        //     $render = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
        // }
        // $spreadsheet = $render->load($file_excel);

        // $data = $spreadsheet->getActiveSheet()->toArray();
        // foreach ($data as $x => $row) {
        //     if ($x == 0) {
        //         continue;
        //     }

        //     $Nis = $row[0];
        //     $NamaSiswa = $row[1];
        //     $Alamat = $row[2];

        //     $db = \Config\Database::connect();

        //     $cekNis = $db->table('siswa')->getWhere(['Nis' => $Nis])->getResult();

        //     if (count($cekNis) > 0) {
        //         session()->setFlashdata('message', '<b style="color:red">Data Gagal di Import NIS ada yang sama</b>');
        //     } else {

        //         $simpandata = [
        //             'Nis' => $Nis, 'NamaSiswa' => $NamaSiswa, 'Alamat' => $Alamat
        //         ];

        //         $db->table('siswa')->insert($simpandata);
        //         session()->setFlashdata('message', 'Berhasil import excel');
        //     }
        // }
    }
}
