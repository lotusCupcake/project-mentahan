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
            'title' => "Penjadwalan",
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
            'colorId' => 1,
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
        dd(addEvent($event));
    }
}
