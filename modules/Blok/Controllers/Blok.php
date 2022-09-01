<?php

/* 
This is Controller Krs
 */

namespace Modules\Blok\Controllers;

use App\Controllers\BaseController;
use Modules\Blok\Models\BlokModel;
use App\Models\ApiModel;

class Blok extends BaseController
{

    protected $blokModel;
    protected $apiModel;

    public function __construct()
    {
        $this->blokModel = new BlokModel();
        $this->apiModel = new ApiModel();
    }

    public function index()
    {
        $currentPage = $this->request->getVar('page_blok') ? $this->request->getVar('page_blok') : 1;
        $keyword = $this->request->getVar('keyword');
        $blok = $this->blokModel->getMatkulBlok($keyword);
        $data = [
            'menu' => $this->fetchMenu(),
            'title' => "Blok",
            'breadcrumb' => ['Data', 'Blok'],
            'matkulBlok' =>  $blok->paginate($this->numberPage, 'blok'),
            'apiBlok' => $this->apiModel->getBlok(),
            'currentPage' => $currentPage,
            'numberPage' => $this->numberPage,
            'pager' => $blok->pager,
            'validation' => \Config\Services::validation(),
        ];
        return view('Modules\Blok\Views\blok', $data);
    }

    public function add()
    {
        $url = $this->request->getServer('HTTP_REFERER');
        $rules = [
            'dataBlok' => rv('required', ['required' => 'Data Mata Kuliah Harus Dipilih']),
        ];
        if (!$this->validate($rules)) {
            return redirect()->to($url)->withInput();
        };
        $dataBlok = $this->request->getVar('dataBlok');
        $matkulBlokType = $this->request->getVar('matkulBlokType');
        foreach ($dataBlok as $blok) {
            $jumlah = $this->blokModel->dataExist(
                [
                    'matkulBlokNama' => explode('#', $blok)[0],
                ]
            );
            if ($jumlah == 0) {
                $data = [
                    'matkulBlokNama' => trim(explode('#', $blok)[0]),
                    'matkulBlokProdiNama' => trim(explode('#', $blok)[1]),
                    'matkulBlokType' => trim($matkulBlokType)
                ];
                $this->blokModel->insert($data);
                session()->setFlashdata('success', 'Data Mata Kuliah Berhasil Ditambahkan');
            } else {
                session()->setFlashdata('failed', 'Data Mata Kuliah Sudah Ada');
            }
        };
        return redirect()->to($url);
    }

    public function delete($id)
    {
        $url = $this->request->getServer('HTTP_REFERER');
        if ($this->blokModel->delete($id)) {
            session()->setFlashdata('success', 'Data Blok Berhasil Dihapus');
        };
        return redirect()->to($url);
    }
}
