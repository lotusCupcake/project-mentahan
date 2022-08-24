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
        // dd($_POST);
        $url = $this->request->getServer('HTTP_REFERER');
        if ($this->request->getVar('dosen') == 'internal') {
            $rules = [
                'dataDosen' => rv('required', ['required' => 'Data Dosen Harus Dipilih']),
            ];
            if (!$this->validate($rules)) {
                return redirect()->to($url)->withInput();
            };
            $dataDosen = $this->request->getVar('dataDosen');
            $dtDosen = [];

            foreach ($dataDosen as $dosen) {
                $dosenEmail = $this->dosenModel->cekDosen(['dosenEmailGeneral' => explode('#', $dosen)[3],])->findAll();
                $dosenId = $this->dosenModel->cekDosen(['dosenSimakadId' => explode('#', $dosen)[5],])->findAll();
                $idDosen = $this->dosenModel->cekDosen(['dosenSimakadId' => explode('#', $dosen)[5],])->findAll();
                $email = [];
                foreach ($dosenEmail as $key => $value) {
                    $email[] = $value->dosenEmailGeneral;
                }
                $id = [];
                foreach ($dosenId as $key => $value) {
                    $id[] = $value->dosenSimakadId;
                }
                $dsn = '';
                foreach ($idDosen as $key => $value) {
                    $dsn = $value->dosenId;
                }
                if ($email == null && $id != null) {
                    $akun = 'Update';
                } elseif ($email != null && $id == null) {
                    $akun = 'Denied/Duplicate';
                } elseif ($email == null && $id == null) {
                    $akun = 'Insert New';
                } else {
                    $akun = 'No Action';
                }
                array_push($dtDosen, [
                    'dosenFullname' => trim(explode('#', $dosen)[0]),
                    'dosenShortname' => trim(explode('#', $dosen)[1]),
                    'dosenEmailCorporate' => (explode('#', $dosen)[2] == null) ? null : trim(explode('#', $dosen)[2]),
                    'dosenEmailGeneral' => (explode('#', $dosen)[3] == null) ? null : trim(explode('#', $dosen)[3]),
                    'dosenPhone' => (explode('#', $dosen)[4] == null) ? null : trim(explode('#', $dosen)[4]),
                    'dosenStatus' => 1,
                    'dosenAkun' => $akun,
                    'dosenId' => $dsn,
                    'dosenSimakadId' => trim(explode('#', $dosen)[5]),
                ]);
            };
            $dataSession = ['dtDosen' => $dtDosen];
            session()->set('dataSession', $dataSession);
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
            $dosenSimakadId = md5($this->request->getvar('dosenEmailGeneral'));
            $dosenEmail = $this->dosenModel->cekDosen(['dosenEmailGeneral' => $this->request->getvar('dosenEmailGeneral')])->findAll();
            $dosenId = $this->dosenModel->cekDosen(['dosenSimakadId' => $dosenSimakadId])->findAll();
            $idDosen = $this->dosenModel->cekDosen(['dosenSimakadId' => $dosenSimakadId])->findAll();
            $email = [];
            foreach ($dosenEmail as $key => $value) {
                $email[] = $value->dosenEmailGeneral;
            }
            $id = [];
            foreach ($dosenId as $key => $value) {
                $id[] = $value->dosenSimakadId;
            }
            $dsn = '';
            foreach ($idDosen as $key => $value) {
                $dsn = $value->dosenId;
            }
            if ($email == null && $id != null) {
                $akun = 'Update';
            } elseif ($email != null && $id == null) {
                $akun = 'Denied/Duplicate';
            } elseif ($email == null && $id == null) {
                $akun = 'Insert New';
            } else {
                $akun = 'No Action';
            }
            $dtDosen = [];
            array_push($dtDosen, [
                'dosenFullname' => $this->request->getVar('dosenFullname'),
                'dosenShortname' => $this->request->getVar('dosenShortname'),
                'dosenEmailCorporate' => null,
                'dosenEmailGeneral' => $this->request->getVar('dosenEmailGeneral'),
                'dosenPhone' => $this->request->getVar('dosenPhone'),
                'dosenStatus' => 0,
                'dosenAkun' => $akun,
                'dosenId' => $dsn,
                'dosenSimakadId' => $dosenSimakadId,
            ]);
            $dataSession = ['dtDosen' => $dtDosen];
            session()->set('dataSession', $dataSession);
        }
        return redirect()->to($url);
    }

    public function abort()
    {
        $url = $this->request->getServer('HTTP_REFERER');
        session()->remove('dataSession');
        session()->setFlashdata('abort', 'Pembatalan Berhasil!');
        return redirect()->to($url);
    }

    public function save()
    {
        $dosenId = $this->request->getVar('dosenId');
        $dosenSimakadId = $this->request->getVar('dosenSimakadId');
        $dosenFullname = $this->request->getVar('dosenFullname');
        $dosenShortname = $this->request->getVar('dosenShortname');
        $dosenEmailCorporate = $this->request->getVar('dosenEmailCorporate');
        $dosenEmailGeneral = $this->request->getVar('dosenEmailGeneral');
        $dosenPhone = $this->request->getVar('dosenPhone');
        $dosenStatus = $this->request->getVar('dosenStatus');
        $dosenAkun = $this->request->getVar('dosenAkun');
        $counts['inserted'] = 0;
        $counts['noaction'] = 0;
        $counts['updated'] = 0;
        $counts['denied'] = 0;
        $counts['error'] = 0;
        $dataEktract = [];
        foreach ($dosenSimakadId as $key => $data) {
            $dataEktract[] = [
                'dosenId' => $dosenId[$key],
                'dosenSimakadId' => $dosenSimakadId[$key],
                'dosenFullname' => $dosenFullname[$key],
                'dosenShortname' => $dosenShortname[$key],
                'dosenEmailCorporate' => $dosenEmailCorporate[$key],
                'dosenEmailGeneral' => $dosenEmailGeneral[$key],
                'dosenPhone' => $dosenPhone[$key],
                'dosenStatus' => $dosenStatus[$key],
                'dosenAkun' => $dosenAkun[$key],
            ];
        }

        foreach ($dataEktract as $key => $value) {
            if ($value['dosenAkun'] == 'Insert New') {
                $data = [
                    'dosenSimakadId' => $value['dosenSimakadId'],
                    'dosenFullname' => $value['dosenFullname'],
                    'dosenShortname' => $value['dosenShortname'],
                    'dosenEmailCorporate' => ($value['dosenEmailCorporate'] == null) ? null : $value['dosenEmailCorporate'],
                    'dosenEmailGeneral' => $value['dosenEmailGeneral'],
                    'dosenPhone' => ($value['dosenPhone'] == null) ? null : $value['dosenPhone'],
                    'dosenStatus' => $value['dosenStatus'],
                ];
                if ($this->dosenModel->insert($data)) {
                    $counts['inserted']++;
                } else {
                    $counts['error']++;
                }
            } elseif ($value['dosenAkun'] == 'Update') {
                $data = [
                    'dosenSimakadId' => $value['dosenSimakadId'],
                    'dosenFullname' => $value['dosenFullname'],
                    'dosenShortname' => $value['dosenShortname'],
                    'dosenEmailCorporate' => ($value['dosenEmailCorporate'] == null) ? null : $value['dosenEmailCorporate'],
                    'dosenEmailGeneral' => $value['dosenEmailGeneral'],
                    'dosenPhone' => ($value['dosenPhone'] == null) ? null : $value['dosenPhone'],
                    'dosenStatus' => $value['dosenStatus'],
                ];
                if ($this->dosenModel->update($value['dosenId'], $data)) {
                    $counts['updated']++;
                } else {
                    $counts['error']++;
                }
            } elseif ($value['dosenAkun'] == 'Denied/Duplicate') {
                $counts['denied']++;
            } else {
                $counts['noaction']++;
            }
        }
        $url = $this->request->getServer('HTTP_REFERER');
        session()->remove('dataSession');
        session()->setFlashdata('counts', $counts);
        session()->setFlashdata('success', 'Perintah Berhasil Dijalankan');
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
                    session()->setFlashdata('update', 'Data Dosen Berhasil Diupdate');
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
                    session()->setFlashdata('update', 'Data Dosen Berhasil Diupdate');
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
            session()->setFlashdata('update', 'Data Dosen Berhasil Dihapus');
        };
        return redirect()->to($url);
    }

    public function loadDosenJadwal()
    {
        $sesi = $this->request->getVar('sesi');
        $startDate = $this->request->getVar('startDate');
        $jenisJadwal =  explode(',', $this->request->getVar('jenis'))[0];
        $angkatan = $this->request->getVar('angkatan');
        $blok =  explode(',', $this->request->getVar('blok'))[0];
        $thnAjaran = getTahunAjaran();
        $data = [$sesi, $startDate, $jenisJadwal, $thnAjaran, $angkatan, $blok];

        echo json_encode($this->dosenModel->getDosenJadwal($data)->getresult());
    }

    public function loadDosenJadwalEdit()
    {
        $sesi = $this->request->getVar('sesi');
        $startDate = $this->request->getVar('startDate');
        $jenisJadwal =  explode(',', $this->request->getVar('jenis'))[0];
        $angkatan = $this->request->getVar('angkatan');
        $blok =  explode(',', $this->request->getVar('blok'))[0];
        $thnAjaran = getTahunAjaran();
        $data = [$sesi, $startDate, $jenisJadwal, $thnAjaran, $angkatan, $blok];

        echo json_encode($this->dosenModel->getDosenJadwalEdit($data)->getresult());
    }
}
