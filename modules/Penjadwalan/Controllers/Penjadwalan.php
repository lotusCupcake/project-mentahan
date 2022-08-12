<?php

/* 
This is Controller Krs
 */

namespace Modules\Penjadwalan\Controllers;

use App\Controllers\BaseController;
use \Modules\Penjadwalan\Models\PenjadwalanModel;


class Penjadwalan extends BaseController
{
    protected $penjadwalan;
    protected $validation;

    public function __construct()
    {
        $this->penjadwalan = new PenjadwalanModel();
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
        ];
        return view('Modules\Penjadwalan\Views\penjadwalan', $data);
    }
}
