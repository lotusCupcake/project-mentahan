<?php

/* 
This is Controller Krs
 */

namespace Modules\Sesi\Controllers;

use App\Controllers\BaseController;
use Modules\Sesi\Models\SesiModel;
use Modules\JenisJadwal\Models\JenisJadwalModel;

class Sesi extends BaseController
{
    protected $sesiModel;
    protected $jenisJadwalModel;

    public function __construct()
    {
        $this->sesiModel = new SesiModel();
        $this->jenisJadwalModel = new JenisJadwalModel();
    }

    public function index()
    {
        $currentPage = $this->request->getVar('page_sesi') ? $this->request->getVar('page_sesi') : 1;
        $keyword = $this->request->getVar('keyword');
        $sesi = $this->sesiModel->getSesiJadwal($keyword);
        $data = [
            'menu' => $this->fetchMenu(),
            'title' => "Sesi",
            'breadcrumb' => ['Data', 'Sesi'],
            'sesiJadwal' =>  $sesi->paginate($this->numberPage, 'sesi'),
            'jenis' => $this->jenisJadwalModel->findAll(),
            'sesiJam' => $this->sesiModel->getSesi()->findAll(),
            'currentPage' => $currentPage,
            'numberPage' => $this->numberPage,
            'pager' => $sesi->pager,
            'validation' => \Config\Services::validation(),
        ];
        return view('Modules\Sesi\Views\sesi', $data);
    }

    public function add()
    {
        $url = $this->request->getServer('HTTP_REFERER');
        $rules = [
            'sesiJenisJadwalId' => rv('required', ['required' => 'Jadwal Harus Dipilih']),
            'sesiNama' => rv('required', ['required' => 'Sesi Harus Diisi']),
            'sesiStart' => rv('required', ['required' => 'Jam Mulai Harus Diisi']),
            'sesiEnd' => rv('required', ['required' => 'Jam Akhir Harus Diisi']),
        ];
        if (!$this->validate($rules)) {
            return redirect()->to($url)->withInput();
        };
        if ($this->sesiModel->insert($_POST)) {
            session()->setFlashdata('success', 'Data Sesi Berhasil Ditambahkan');
        };
        return redirect()->to($url);
    }

    public function edit($id)
    {
        $url = $this->request->getServer('HTTP_REFERER');
        $rules = [
            'sesiJenisJadwalId' => rv('required', ['required' => 'Jadwal Harus Dipilih']),
            'sesiNama' => rv('required', ['required' => 'Sesi Harus Diisi']),
            'sesiStart' => rv('required', ['required' => 'Jam Mulai Harus Diisi']),
            'sesiEnd' => rv('required', ['required' => 'Jam Akhir Harus Diisi']),
        ];
        if (!$this->validate($rules)) {
            return redirect()->to($url)->withInput();
        };
        if ($this->sesiModel->update($id, $_POST)) {
            session()->setFlashdata('success', 'Data Sesi Berhasil Diupdate');
        };
        return redirect()->to($url);
    }

    public function delete($id)
    {
        $url = $this->request->getServer('HTTP_REFERER');
        if ($this->sesiModel->delete($id)) {
            session()->setFlashdata('success', 'Data Sesi Berhasil Dihapus');
        };
        return redirect()->to($url);
    }
}
