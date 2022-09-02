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
        $data = [
            'menu' => $this->fetchMenu(),
            'title' => "Dashboard",
            'breadcrumb' => ['Home', 'Dashboard'],
            'jenisJadwal' => $this->jenisJadwal->getJenisJadwal($jenis)->findAll(),
            'penjadwalan' => $this->penjadwalan->getPenjadwalan($keyword = null, $jenis)->get()->getResult(),
            'blok' => $this->matkulBlok->getMatkulBlok()->findAll(),
            'color' => colorEvent(),
            'calendar' => calendar(),
        ];
        return view('Modules\Dashboard\Views\dashboard', $data);
    }
}
