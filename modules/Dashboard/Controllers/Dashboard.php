<?php

/* 
This is Controller Krs
 */

namespace Modules\Dashboard\Controllers;

use App\Controllers\BaseController;
use Modules\Sesi\Models\SesiModel;
use Modules\Blok\Models\BlokModel;
use Modules\JenisJadwal\Models\JenisJadwalModel;

class Dashboard extends BaseController
{
    protected $sesi;
    protected $matkulBlok;
    protected $jenisJadwal;

    public function __construct()
    {

        $this->sesi = new SesiModel();
        $this->matkulBlok = new BlokModel();
        $this->jenisJadwal = new JenisJadwalModel();
    }

    public function index()
    {
        $data = [
            'menu' => $this->fetchMenu(),
            'title' => "Dashboard",
            'breadcrumb' => ['Home', 'Dashboard'],
            'sesi' => $this->sesi->findAll(),
            'jenisJadwal' => $this->jenisJadwal->where('jenisJadwalIsAktif', '1')->findAll(),
            'blok' => $this->matkulBlok->getMatkulBlok()->findAll(),
            'color' => colorEvent(),
            'calendar' => calendar(),
        ];
        return view('Modules\Dashboard\Views\dashboard', $data);
    }
}
