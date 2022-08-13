<?php

/* 
This is Controller Krs
 */

namespace Modules\Dosen\Controllers;

use App\Controllers\BaseController;
use Modules\Dosen\Models\DosenModel;
use App\Models\ApiModel;

class Dosen extends BaseController
{

    protected $dosenModel;
    protected $apiModel;

    public function __construct()
    {
        $this->dosenModel = new DosenModel();
        $this->apiModel = new ApiModel();
    }

    public function index()
    {
        $currentPage = $this->request->getVar('page_dosen') ? $this->request->getVar('page_dosen') : 1;
        $keyword = $this->request->getVar('keyword');
        $dosen = $this->dosenModel->getMatkulDosen($keyword);
        $data = [
            'menu' => $this->fetchMenu(),
            'title' => "Dosen",
            'breadcrumb' => ['Data', 'Dosen'],
            'dosen' =>  $dosen->paginate($this->numberPage, 'dosen'),
            'apiDosen' => $this->apiModel->getDosen(),
            'currentPage' => $currentPage,
            'numberPage' => $this->numberPage,
            'pager' => $dosen->pager,
            'validation' => \Config\Services::validation(),
        ];
        return view('Modules\Dosen\Views\dosen', $data);
    }

    public function add()
    {
        $url = $this->request->getServer('HTTP_REFERER');
        $rules = [
            'dataDosen' => rv('required', ['required' => 'Data Dosen Harus Dipilih']),
        ];
        if (!$this->validate($rules)) {
            return redirect()->to($url)->withInput();
        };
        $dataDosen = $this->request->getVar('dataDosen');
        foreach ($dataDosen as $dosen) {
            $jumlah = $this->dosenModel->dataExist(
                [
                    'dosenEmail' => explode(',', $dosen)[2],
                ]
            );
            if ($jumlah == 0) {
                $data = [
                    'dosenFullname' => explode(',', $dosen)[0],
                    'dosenShortname' => explode(',', $dosen)[1],
                    'dosenEmail' => explode(',', $dosen)[2],
                    'dosenPhone' => explode(',', $dosen)[3]
                ];
                $this->dosenModel->insert($data);
            }
        };
        session()->setFlashdata('success', 'Data Dosen Berhasil Ditambahkan');
        return redirect()->to($url);
    }

    public function delete($id)
    {
        $url = $this->request->getServer('HTTP_REFERER');
        if ($this->dosenModel->delete($id)) {
            session()->setFlashdata('success', 'Data Dosen Berhasil Dihapus');
        };
        return redirect()->to($url);
    }

    public function loadDosenJadwal()
    {
        $sesi = $this->request->getVar('sesi');
        $startDate = $this->request->getVar('startDate');

        echo json_encode($this->dosenModel->getDosenJadwal($sesi, $startDate)->getresult());
    }
}
