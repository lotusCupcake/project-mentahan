<?php

/* 
This is Controller Krs
 */

namespace Modules\Dashboard\Controllers;

use App\Controllers\BaseController;
use Modules\Sesi\Models\SesiModel;
use Modules\Blok\Models\BlokModel;
use Modules\JenisJadwal\Models\JenisJadwalModel;
use \Modules\Penjadwalan\Models\PenjadwalanModel;

class Dashboard extends BaseController
{
    protected $sesi;
    protected $matkulBlok;
    protected $jenisJadwal;
    protected $penjadwalan;

    public function __construct()
    {

        $this->sesi = new SesiModel();
        $this->matkulBlok = new BlokModel();
        $this->jenisJadwal = new JenisJadwalModel();
        $this->penjadwalan = new PenjadwalanModel();
    }

    public function index()
    {
        $data = [
            'menu' => $this->fetchMenu(),
            'title' => "Dashboard",
            'breadcrumb' => ['Home', 'Dashboard'],
            'sesi' => $this->sesi->findAll(),
            'jenisJadwal' => $this->jenisJadwal->where('jenisJadwalIsAktif', '1')->findAll(),
            'penjadwalan' => $this->penjadwalan->getPenjadwalan()->get()->getResult(),
            'blok' => $this->matkulBlok->getMatkulBlok()->findAll(),
            'color' => colorEvent(),
            'calendar' => calendar(),
        ];
        // dd($data['blok']);
        return view('Modules\Dashboard\Views\dashboard', $data);
    }
}
