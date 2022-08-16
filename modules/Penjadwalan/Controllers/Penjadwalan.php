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
        $keyword = $this->request->getVar('keyword');
        $jadwal = $this->penjadwalan->getPenjadwalan($keyword);
        $data = [
            'menu' => $this->fetchMenu(),
            'penjadwalanJudul' => "Penjadwalan",
            'title' => 'Penjadwalan',
            'icon' => 'fas fa-calendar',
            'breadcrumb' => ['Home', 'Penjadwalan'],
            'penjadwalan' =>  $jadwal->paginate($this->numberPage, 'penjadwalan'),
            'currentPage' => $currentPage,
            'numberPage' => $this->numberPage,
            'pager' => $jadwal->pager,
            'validation' => $this->validation,
            'color' => colorEvent(),
            'sesi' => $this->sesi->findAll(),
            'jenisJadwal' => $this->jenisJadwal->where('jenisJadwalIsAktif', '1')->findAll(),
            'blok' => $this->matkulBlok->getMatkulBlok()->findAll(),
            'dosen' => [],
        ];
        // dd($data['jenisJadwal']);
        return view('Modules\Penjadwalan\Views\penjadwalan', $data);
    }

    public function penjadwalanAdd()
    {
        // dd($_POST);
        ($this->request->getVar('from') != null) ? $from = $this->request->getVar('from') : $from = null;
        $eventStart = $this->request->getVar('startDate') . ' ' . explode(',', $this->request->getVar('sesi'))[1];
        $eventEnd = $this->request->getVar('startDate') . ' ' . explode(',', $this->request->getVar('sesi'))[2];
        $dosen = [];
        foreach ($this->request->getVar('dosen') as $key => $value) {
            $dosen[] = ['email' => $value];
        }
        $angkatan  = '2020';
        $jadwal = explode(',', $this->request->getVar('jenisJadwal'))[1];
        $noteEktra = ($this->request->getVar('noteAcara') != null) ? "(" . $this->request->getVar('noteAcara') . ")" : "";
        $judul = $jadwal . " " . $angkatan . " " . $this->request->getVar('namaAcara') . "-" . explode(',', $this->request->getVar('blok'))[1] . " " . $noteEktra;

        $event = array(
            'summary' => $judul,
            'description' => $this->request->getVar('deskripsiAcara'),
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
        $resultCalendar = addEvent($event);

        if ($resultCalendar[0]['status'] == 'confirmed') {
            $data = [
                'penjadwalanJenisJadwalId' => explode(',', $this->request->getVar('jenisJadwal'))[0],
                'penjadwalanMatkulBlokId' => explode(',', $this->request->getVar('blok'))[0],
                'penjadwalanSesiId' => $this->request->getVar('sesi'),
                'penjadwalanCalenderId' => $resultCalendar[0]['id'],
                'penjadwalanJudul' => $this->request->getVar('namaAcara'),
                'penjadwalanDeskripsi' => $this->request->getVar('deskripsiAcara'),
                'penjadwalanLokasi' => $this->request->getVar('lokasi'),
                'penjadwalanColorId' => $this->request->getVar('color'),
                'penjadwalanStartDate' => $eventStart,
                'penjadwalanEndDate' => $eventEnd,
                'penjadwalanPeserta' => json_encode(['data' => $dosen]),
                'penjadwalanNotes' => $this->request->getVar('noteAcara'),
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
        $warna = konversiColor();
        $data = $this->penjadwalan->findAll();
        $events = [];
        foreach ($data as $key => $cal) {
            $events[] = [
                'id' => $cal->penjadwalanId,
                'start' => $cal->penjadwalanStartDate,
                'end' => $cal->penjadwalanEndDate,
                'title' => $cal->penjadwalanJudul,
                'color'  => $warna[$cal->penjadwalanColorId],
            ];
        }

        return json_encode($events);
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
                    'summary' => $jadwal[0]->penjadwalanJudul,
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
}
