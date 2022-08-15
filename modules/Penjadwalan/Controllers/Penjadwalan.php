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
        $eventStart = $this->request->getVar('startDate') . ' ' . explode(',', $this->request->getVar('sesi'))[1];
        $eventEnd = $this->request->getVar('startDate') . ' ' . explode(',', $this->request->getVar('sesi'))[2];
        $dosen = [];
        foreach ($this->request->getVar('dosen') as $key => $value) {
            $dosen[] = ['email' => $value];
        }

        $event = array(
            'summary' => $this->request->getVar('namaAcara'),
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
                'penjadwalanJenisJadwalId' => $this->request->getVar('jenisJadwal'),
                'penjadwalanMatkulBlokId' => $this->request->getVar('blok'),
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
                return redirect()->to('penjadwalan');
            } else {
                delEvent($resultCalendar[0]['penjadwalanId']);
                session()->setFlashdata('error', 'Data gagal ditambahkan');
                return redirect()->to('penjadwalan');
            }
        } else {
            session()->setFlashdata('error', 'Data gagal ditambahkan');
            return redirect()->to('penjadwalan');
        }
    }

    public function loadData()
    {
        $data = $this->penjadwalan->findAll();
        $events = [];
        foreach ($data as $key => $cal) {
            $events[] = [
                'id' => $cal->penjadwalanId,
                'start' => $cal->penjadwalanStartDate,
                'end' => $cal->penjadwalanEndDate,
                'title' => $cal->penjadwalanJudul,
                'color'  => konversiColor($cal->penjadwalanColorId),
            ];
        }

        return json_encode($events);
    }

    public function ajax()
    {
        switch ($this->request->getVar('type')) {

                // For add EventModel
            case 'add':
                $data = [
                    'penjadwalanJudul' => $this->request->getVar('title'),
                    'penjadwalanStartDate' => $this->request->getVar('start'),
                    'penjadwalanEndDate' => $this->request->getVar('end'),
                ];
                $this->penjadwalan->insert($data);
                return json_encode($this->penjadwalan);
                break;

                // For update EventModel        
            case 'update':
                $data = [
                    'penjadwalanJudul' => $this->request->getVar('title'),
                    'penjadwalanStartDate' => $this->request->getVar('start'),
                    'penjadwalanEndDate' => $this->request->getVar('end'),
                ];

                $penjadwalanId = $this->request->getVar('id');

                $this->penjadwalan->update($penjadwalanId, $data);

                return json_encode($this->penjadwalan);
                break;

                // For delete EventModel    
            case 'delete':

                $penjadwalanId = $this->request->getVar('id');

                $this->penjadwalan->delete($penjadwalanId);

                return json_encode($this->penjadwalan);
                break;

            default:
                break;
        }
    }
}
