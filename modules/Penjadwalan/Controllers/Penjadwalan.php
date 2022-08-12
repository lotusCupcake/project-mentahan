<?php

/* 
This is Controller Krs
 */

namespace Modules\Penjadwalan\Controllers;

use App\Controllers\BaseController;
use \Modules\Penjadwalan\Models\PenjadwalanModel;
use Modules\Sesi\Models\SesiModel;
use Modules\Blok\Models\BlokModel;

class Penjadwalan extends BaseController
{
    protected $penjadwalan;
    protected $validation;
    protected $sesi;
    protected $matkulBlok;

    public function __construct()
    {
        $this->penjadwalan = new PenjadwalanModel();
        $this->sesi = new SesiModel();
        $this->matkulBlok = new BlokModel();
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
            'blok' => $this->matkulBlok->getMatkulBlok()->findAll(),
        ];
        // dd($data['blok']);
        return view('Modules\Penjadwalan\Views\penjadwalan', $data);
    }

    public function penjadwalanAdd()
    {
        dd($_POST);
    }
}
