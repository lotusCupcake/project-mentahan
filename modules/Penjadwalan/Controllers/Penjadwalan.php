<?php

/* 
This is Controller Krs
 */

namespace Modules\Penjadwalan\Controllers;

use App\Controllers\BaseController;
use \Modules\Penjadwalan\Models\PenjadwalanModel;
use Modules\Sesi\Models\SesiModel;
use Modules\Blok\Models\BlokModel;
use Modules\JenisJadwal\Models\JenisJadwalModel;

class Penjadwalan extends BaseController
{
    protected $penjadwalan;
    protected $validation;
    protected $sesi;
    protected $matkulBlok;
    protected $jenisJadwal;

    public function __construct()
    {
        $this->penjadwalan = new PenjadwalanModel();
        $this->sesi = new SesiModel();
        $this->matkulBlok = new BlokModel();
        $this->jenisJadwal = new JenisJadwalModel();
        $this->validation = \Config\Services::validation();
    }

    public function index()
    {
        $currentPage = $this->request->getVar('page_penjadwalan') ? $this->request->getVar('page_penjadwalan') : 1;
        $grup = getSpecificUser(['users.id' => user()->id])->name;
        if ($grup == 'operatorX') {
            $jenis = [3, 4, 5];
        } elseif ($grup == 'operatorY') {
            $jenis = [1, 2];
        } elseif ($grup == 'superoperator') {
            $jenis = [4, 5];
        } else {
            $jenis = [];
        }
        $keyword = $this->request->getVar('keyword');
        $jadwal = $this->penjadwalan->getPenjadwalan($keyword, $jenis);
        $data = [
            'menu' => $this->fetchMenu(),
            'penjadwalanJudul' => "Penjadwalan",
            'title' => 'Penjadwalan',
            'icon' => 'fas fa-calendar',
            'breadcrumb' => ['Proses', 'Penjadwalan'],
            'penjadwalan' =>  $jadwal->paginate($this->numberPage, 'penjadwalan'),
            'currentPage' => $currentPage,
            'numberPage' => $this->numberPage,
            'pager' => $jadwal->pager,
            'validation' => $this->validation,
            'color' => colorEvent(),
            'jenisJadwal' => $this->jenisJadwal->getJenisJadwal($jenis)->findAll(),
            'blok' => $this->matkulBlok->getMatkulBlok()->findAll(),
            'dosen' => [],
        ];
        return view('Modules\Penjadwalan\Views\penjadwalan', $data);
    }

    public function penjadwalanAdd()
    {
        ($this->request->getVar('from') != null) ? $from = $this->request->getVar('from') : $from = null;
        if (explode(',', $this->request->getVar('jenisJadwal'))[0] != 3) {
            $rules['sesi'] = rv('required', ['required' => 'Sesi Jadwal Harus Dipilih']);
            $rules['startDate'] = rv('required', ['required' => 'Tanggal Acara Harus Ditetapkan']);
            $eventStart = $this->request->getVar('startDate') . ' ' . explode(',', $this->request->getVar('sesi'))[1];
            $eventEnd = $this->request->getVar('startDate') . ' ' . explode(',', $this->request->getVar('sesi'))[2];
        } else {
            $rules['waktuStart'] = rv('required', ['required' => 'Waktu Selesai Acara Harus Ditetapkan']);
            $rules['waktuEnd'] = rv('required', ['required' => 'Waktu Mulai Acara Harus Ditetapkan']);
            $eventStart = $this->request->getVar('waktuStart');
            $eventEnd = $this->request->getVar('waktuEnd');
        }

        $rules = [
            'blok' => rv('required', ['required' => 'Data Mata Kuliah Harus Dipilih']),
            'jenisJadwal' => rv('required', ['required' => 'Data Jenis Jadwal Harus Dipilih']),
            'dosen' => rv('required', ['required' => 'Dosen Harus Dipilih']),
            'namaAcara' => rv('required', ['required' => 'Data Mata Kuliah Harus Dipilih']),
            'lokasi' => rv('required', ['required' => 'Data Jenis Jadwal Harus Dipilih']),
            'deskripsiAcara' => rv('required', ['required' => 'Tanggal Acara Harus Ditetapkan']),
            'color' => rv('required', ['required' => 'Dosen Harus Dipilih']),
            'angkatan' => rv('required', ['required' => 'Angkatan Harus Dipilih']),
        ];
        if (!$this->validate($rules)) {
            if ($from == null) {
                return redirect()->to('penjadwalan')->withInput();
            } else {
                return redirect()->to('dashboard')->withInput();
            }
        };


        $dosen = [];
        foreach ($this->request->getVar('dosen') as $key => $value) {
            $dosen[] = ['id' => explode(',', $value)[0], 'email' => explode(',', $value)[1]];
        }
        $angkatan  = $this->request->getVar('angkatan');
        $jadwal = explode(',', $this->request->getVar('jenisJadwal'))[1];
        $noteEktra = ($this->request->getVar('noteAcara') != null) ?  $this->request->getVar('noteAcara')  : "";
        $judul = $jadwal . " " . $angkatan . " " . $this->request->getVar('namaAcara') . "-" . explode(',', $this->request->getVar('blok'))[1];

        $event = array(
            'summary' => $judul,
            'description' => $noteEktra,
            'location' => $this->request->getVar('lokasi'),
            'colorId' => $this->request->getVar('color'),
            'start' => array(
                'dateTime' => timeAppToGoogle($eventStart)
            ),
            'end' => array(
                'dateTime' => timeAppToGoogle($eventEnd)
            ),
            // 'attendees' => array($dosen),
            'guestsCanInviteOthers' => false,
            'guestsCanModify' => false,
            'guestsCanSeeOtherGuests' => false,
        );
        $resultCalendar = addEvent($event);

        if ($resultCalendar[0]['status'] == 'confirmed') {
            $data = [
                'penjadwalanJenisJadwalId' => explode(',', $this->request->getVar('jenisJadwal'))[0],
                'penjadwalanMatkulBlokId' => explode(',', $this->request->getVar('blok'))[0],
                'penjadwalanSesiId' => (explode(',', $this->request->getVar('jenisJadwal'))[0] != 3) ? $this->request->getVar('sesi') : 19,
                'penjadwalanCalenderId' => $resultCalendar[0]['id'],
                'penjadwalanJudulShow' => $judul,
                'penjadwalanJudul' => $this->request->getVar('namaAcara'),
                'penjadwalanDeskripsi' => $this->request->getVar('deskripsiAcara'),
                'penjadwalanLokasi' => $this->request->getVar('lokasi'),
                'penjadwalanColorId' => $this->request->getVar('color'),
                'penjadwalanStartDate' => $eventStart,
                'penjadwalanEndDate' => $eventEnd,
                'penjadwalanPeserta' => json_encode(['data' => $dosen]),
                'penjadwalanNotes' => $this->request->getVar('noteAcara'),
                'penjadwalanAngkatan' => $this->request->getVar('angkatan'),
                'penjadwalanTahunAjaran' => getTahunAjaran(),
                'penjadwalanCreatedBy' => user()->email,
            ];

            if ($this->penjadwalan->insert($data)) {
                session()->setFlashdata('success', 'Data berhasil ditambahkan');
                if ($from == null) {
                    return redirect()->to('penjadwalan');
                } else {
                    return redirect()->to('dashboard');
                }
            } else {
                delEvent($resultCalendar[0]['penjadwalanId']);
                session()->setFlashdata('error', 'Data gagal ditambahkan');
                if ($from == null) {
                    return redirect()->to('penjadwalan');
                } else {
                    return redirect()->to('dashboard');
                }
            }
        } else {
            session()->setFlashdata('error', 'Data gagal ditambahkan');
            if ($from == null) {
                return redirect()->to('penjadwalan');
            } else {
                return redirect()->to('dashboard');
            }
        }
    }

    public function loadData()
    {
        $grup = getSpecificUser(['users.id' => user()->id])->name;
        if ($grup == 'operatorX') {
            $jenis = [3, 4, 5];
        } elseif ($grup == 'operatorY') {
            $jenis = [1, 2];
        } elseif ($grup == 'superoperator') {
            $jenis = [4, 5];
        } else {
            $jenis = [];
        }
        $warna = konversiColor();
        $data = $this->penjadwalan->getPenjadwalan($keyword = null, $jenis)->findAll();
        $events = [];
        foreach ($data as $key => $cal) {
            $events[] = [
                'id' => $cal->penjadwalanId,
                'start' => $cal->penjadwalanStartDate,
                'end' => $cal->penjadwalanEndDate,
                'title' => $cal->penjadwalanJudulShow,
                'color'  => $warna[$cal->penjadwalanColorId],
            ];
        }

        return json_encode($events);
    }

    public function select()
    {
        $data = $this->penjadwalan->where(['penjadwalanId' => $this->request->getVar('id')])->findAll();
        $peserta = $data[0]->penjadwalanPeserta;
        $result = [];
        foreach (json_decode($peserta)->data as $key => $value) {
            $result[] = $value->email;
        }

        return json_encode($result);
    }

    public function penjadwalanEdit($id)
    {
        if (explode(',', $this->request->getVar('jenisJadwal'))[0] != 3) {
            $rules['sesi'] = rv('required', ['required' => 'Sesi Jadwal Harus Dipilih']);
            $rules['startDate'] = rv('required', ['required' => 'Tanggal Acara Harus Ditetapkan']);
            $eventStart = $this->request->getVar('startDate') . ' ' . explode(',', $this->request->getVar('sesi'))[1];
            $eventEnd = $this->request->getVar('startDate') . ' ' . explode(',', $this->request->getVar('sesi'))[2];
        } else {
            $rules['waktuStart'] = rv('required', ['required' => 'Waktu Selesai Acara Harus Ditetapkan']);
            $rules['waktuEnd'] = rv('required', ['required' => 'Waktu Mulai Acara Harus Ditetapkan']);
            $eventStart = $this->request->getVar('waktuStart');
            $eventEnd = $this->request->getVar('waktuEnd');
        }

        $rules = [
            'blok' => rv('required', ['required' => 'Data Mata Kuliah Harus Dipilih']),
            'jenisJadwal' => rv('required', ['required' => 'Data Jenis Jadwal Harus Dipilih']),
            'dosen' => rv('required', ['required' => 'Dosen Harus Dipilih']),
            'namaAcara' => rv('required', ['required' => 'Data Mata Kuliah Harus Dipilih']),
            'lokasi' => rv('required', ['required' => 'Data Jenis Jadwal Harus Dipilih']),
            'deskripsiAcara' => rv('required', ['required' => 'Tanggal Acara Harus Ditetapkan']),
            'color' => rv('required', ['required' => 'Dosen Harus Dipilih']),
        ];
        if (!$this->validate($rules)) {
            return redirect()->to('penjadwalan')->withInput();
        };
        $jadwalExists = $this->penjadwalan->where(['penjadwalanId' => $id])->findAll();


        $dosen = [];
        foreach ($this->request->getVar('dosen') as $key => $value) {
            $dosen[] = ['id' => explode(',', $value)[0], 'email' => explode(',', $value)[1]];
        }
        $angkatan  = $this->request->getVar('angkatan');
        $jadwal = explode(',', $this->request->getVar('jenisJadwal'))[1];
        $noteEktra = ($this->request->getVar('noteAcara') != null) ? $this->request->getVar('noteAcara')  : "";
        $judul = $jadwal . " " . $angkatan . " " . $this->request->getVar('namaAcara') . "-" . explode(',', $this->request->getVar('blok'))[1];

        $event = array(
            'summary' => $judul,
            'description' => $noteEktra,
            'location' => $this->request->getVar('lokasi'),
            'colorId' => $this->request->getVar('color'),
            'start' => array(
                'dateTime' => timeAppToGoogle($eventStart)
            ),
            'end' => array(
                'dateTime' => timeAppToGoogle($eventEnd)
            ),
            // 'attendees' => array($dosen),
            'guestsCanInviteOthers' => false,
            'guestsCanModify' => false,
            'guestsCanSeeOtherGuests' => false,
        );
        // dd($event);
        $resultCalendar = editEvent($jadwalExists[0]->penjadwalanCalenderId, $event);

        if ($resultCalendar == 'confirmed') {
            $data = [
                'penjadwalanJenisJadwalId' => explode(',', $this->request->getVar('jenisJadwal'))[0],
                'penjadwalanMatkulBlokId' => explode(',', $this->request->getVar('blok'))[0],
                'penjadwalanSesiId' => $this->request->getVar('sesi'),
                'penjadwalanJudulShow' => $judul,
                'penjadwalanJudul' => $this->request->getVar('namaAcara'),
                'penjadwalanDeskripsi' => $this->request->getVar('deskripsiAcara'),
                'penjadwalanLokasi' => $this->request->getVar('lokasi'),
                'penjadwalanColorId' => $this->request->getVar('color'),
                'penjadwalanStartDate' => $eventStart,
                'penjadwalanEndDate' => $eventEnd,
                'penjadwalanPeserta' => json_encode(['data' => $dosen]),
                'penjadwalanNotes' => $this->request->getVar('noteAcara'),
                'penjadwalanAngkatan' => $this->request->getVar('angkatan'),
                'penjadwalanTahunAjaran' => getTahunAjaran(),
                'penjadwalanModifiedBy' => user()->email,
            ];
            if ($this->penjadwalan->update($id, $data)) {
                session()->setFlashdata('success', 'Data berhasil diubah');
                return redirect()->to('penjadwalan');
            } else {
                delEvent($resultCalendar[0]['penjadwalanId']);
                session()->setFlashdata('error', 'Data gagal diubah');
                return redirect()->to('penjadwalan');
            }
        } else {
            session()->setFlashdata('error', 'Data gagal ditambahkan');
            return redirect()->to('penjadwalan');
        }
    }

    public function ajax()
    {
        switch ($this->request->getVar('type')) {
            case 'add':
                $data = [
                    'penjadwalanJudul' => $this->request->getVar('title'),
                    'penjadwalanStartDate' => $this->request->getVar('start'),
                    'penjadwalanEndDate' => $this->request->getVar('end'),
                ];
                $this->penjadwalan->insert($data);
                return json_encode($this->penjadwalan);
                break;
            case 'update':
                $jadwal = $this->penjadwalan->where(['penjadwalanId' => $this->request->getVar('id')])->findAll();
                $event = array(
                    'summary' => $jadwal[0]->penjadwalanJudulShow,
                    'description' => $jadwal[0]->penjadwalanDeskripsi,
                    'location' => $jadwal[0]->penjadwalanLokasi,
                    'colorId' => $jadwal[0]->penjadwalanColorId,
                    'start' => array(
                        'dateTime' => timeAppToGoogle(
                            date('Y-m-d H:i:s', strtotime($this->request->getVar('interval') . ' day', strtotime($jadwal[0]->penjadwalanStartDate)))
                        )
                    ),
                    'end' => array(
                        'dateTime' => timeAppToGoogle(date('Y-m-d H:i:s', strtotime($this->request->getVar('interval') . ' day', strtotime($jadwal[0]->penjadwalanEndDate))))
                        // ),
                        // 'attendees' => array(
                        //     array('email' => 'fikriansari.mfa@gmail.com'),
                    ),
                    'guestsCanInviteOthers' => false,
                    'guestsCanModify' => false,
                    'guestsCanSeeOtherGuests' => false,
                );
                if (editEvent($jadwal[0]->penjadwalanCalenderId, $event) == "confirmed") {
                    $data = [
                        'penjadwalanStartDate' => date('Y-m-d H:i:s', strtotime($this->request->getVar('interval') . ' day', strtotime($jadwal[0]->penjadwalanStartDate))),
                        'penjadwalanEndDate' => date('Y-m-d H:i:s', strtotime($this->request->getVar('interval') . ' day', strtotime($jadwal[0]->penjadwalanEndDate))),
                        'penjadwalanModifiedBy' => user()->email,
                    ];
                    $penjadwalanId = $this->request->getVar('id');
                    $this->penjadwalan->update($penjadwalanId, $data);
                    return json_encode($this->penjadwalan);
                    break;
                }

            case 'delete':
                $jadwal = $this->penjadwalan->where(['penjadwalanId' => $this->request->getVar('id')])->findAll();
                if (delEvent($jadwal[0]->penjadwalanCalenderId) == 204) {
                    $penjadwalanId = $this->request->getVar('id');
                    $this->penjadwalan->delete($penjadwalanId);
                    return json_encode($this->penjadwalan);
                    break;
                }
            default:
                break;
        }
    }

    public function cekBentrok()
    {
        $id = $this->request->getVar('id');
        $interval = $this->request->getVar('interval');
        $exe = $this->penjadwalan->cekBentrok($id, $interval)->getresult();
        if (count($exe) < 1) {
            echo json_encode(['status' => true, 'message' => 'Tidak ada bentrok']);
        } else {
            echo json_encode(['status' => false, 'message' => 'Ada Jadwal Dosen yang Bentrok']);
        }
    }

    public function detailCalendar()
    {
        $id = $this->request->getVar('calId');
        echo json_encode(detailCalendar($id));
    }
}
