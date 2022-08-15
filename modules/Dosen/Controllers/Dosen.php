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
        $dosen = $this->dosenModel->getDataDosen($keyword);
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
        if ($this->request->getVar('dosen') == 'internal') {
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
                        'dosenEmailCorporate' => explode('#', $dosen)[2],
                    ]
                );
                if ($jumlah == 0) {
                    $data = [
                        'dosenFullname' => trim(explode('#', $dosen)[0]),
                        'dosenShortname' => trim(explode('#', $dosen)[1]),
                        'dosenEmailCorporate' => (explode('#', $dosen)[2] == null) ? null : trim(explode('#', $dosen)[2]),
                        'dosenEmailGeneral' => (explode('#', $dosen)[3] == null) ? null : trim(explode('#', $dosen)[3]),
                        'dosenPhone' => (explode('#', $dosen)[4] == null) ? null : trim(explode('#', $dosen)[4]),
                        'dosenStatus' => 1
                    ];
                    $this->dosenModel->insert($data);
                    session()->setFlashdata('success', 'Data Dosen Berhasil Ditambahkan');
                }
            };
        } else {
            $rules = [
                'dosenFullname' => rv('required', ['required' => 'Nama Lengkap Dosen Harus Diisi']),
                'dosenShortname' => rv('required', ['required' => 'Nama Dosen Harus Diisi']),
                'dosenEmailGeneral' => rv('required', ['required' => 'Email Dosen Harus Diisi']),
                'dosenPhone' => rv('required', ['required' => 'No. Handphone Dosen Harus Diisi']),
            ];
            if (!$this->validate($rules)) {
                return redirect()->to($url)->withInput();
            };
            $jumlah = $this->dosenModel->dataExist(
                [
                    'dosenEmailGeneral' => $this->request->getVar('dosenEmailGeneral'),
                ]
            );
            if ($jumlah == 0) {
                $data = [
                    'dosenFullname' => trim($this->request->getVar('dosenFullname')),
                    'dosenShortname' => trim($this->request->getVar('dosenShortname')),
                    'dosenEmailCorporate' => null,
                    'dosenEmailGeneral' => ($this->request->getVar('dosenEmailGeneral') == null) ? null : trim($this->request->getVar('dosenEmailGeneral')),
                    'dosenPhone' => ($this->request->getVar('dosenPhone') == null) ? null : trim($this->request->getVar('dosenPhone')),
                    'dosenStatus' => 0
                ];
                $this->dosenModel->insert($data);
                session()->setFlashdata('success', 'Data Dosen Berhasil Ditambahkan');
            }
        }
        return redirect()->to($url);
    }

    public function edit($id)
    {
        $url = $this->request->getServer('HTTP_REFERER');
        if ($this->request->getVar('dosenStatus') == 1) {
            $rules = [
                'dosenEmailGeneral' => rv('required', ['required' => 'Email General Harus Diisi']),
            ];
            if (!$this->validate($rules)) {
                return redirect()->to($url)->withInput();
            };

            $jumlah = $this->dosenModel->dataExist(
                [
                    'dosenEmailGeneral' => $this->request->getVar('dosenEmailGeneral'),
                ]
            );
            if ($jumlah == 0) {
                $data = ['dosenEmailGeneral' => trim($this->request->getVar('dosenEmailGeneral'))];
                if ($this->dosenModel->update($id, $data)) {
                    session()->setFlashdata('success', 'Data Dosen Berhasil Diupdate');
                }
            } else {
                session()->setFlashdata('danger', 'Email General Dosen Sudah Terdaftar');
            }
        } else {
            $rules = [
                'dosenFullname' => rv('required', ['required' => 'Nama Lengkap Dosen Harus Diisi']),
                'dosenShortname' => rv('required', ['required' => 'Nama Dosen Harus Diisi']),
                'dosenEmailGeneral' => rv('required', ['required' => 'Email Dosen Harus Diisi']),
                'dosenPhone' => rv('required', ['required' => 'No. Handphone Dosen Harus Diisi']),
            ];
            if (!$this->validate($rules)) {
                return redirect()->to($url)->withInput();
            };

            $jumlah = $this->dosenModel->dataExist(
                [
                    'dosenEmailGeneral' => $this->request->getVar('dosenEmailGeneral'),
                ]
            );
            if ($jumlah == 0) {
                $data = [
                    'dosenFullname' => trim($this->request->getVar('dosenFullname')),
                    'dosenShortname' => trim($this->request->getVar('dosenShortname')),
                    'dosenEmailGeneral' => trim($this->request->getVar('dosenEmailGeneral')),
                    'dosenPhone' => trim($this->request->getVar('dosenPhone')),
                ];
                if ($this->dosenModel->update($id, $data)) {
                    session()->setFlashdata('success', 'Data Dosen Berhasil Diupdate');
                }
            } else {
                session()->setFlashdata('danger', 'Email Dosen Sudah Terdaftar');
            }
        }
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
