<?php

/* 
This is Controller Krs
 */

namespace Modules\Dosen\Controllers;

use App\Controllers\BaseController;
use Modules\Dosen\Models\DosenModel;

class Dosen extends BaseController
{

    protected $dosenModel;

    public function __construct()
    {
        $this->dosenModel = new DosenModel();
    }
    public function index()
    {
        $data = [
            'menu' => $this->fetchMenu(),
            'title' => "Dosen",
            'breadcrumb' => ['Data', 'Dosen'],
            'dosen' => $this->dosenModel->getDosen(),
        ];
        return view('Modules\Dosen\Views\dosen', $data);
    }
}
