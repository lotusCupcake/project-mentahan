<?php

/* 
This is Controller Krs
 */

namespace Modules\Sesi\Controllers;

use App\Controllers\BaseController;
use Modules\Sesi\Models\SesiModel;

class Sesi extends BaseController
{
    protected $sesiModel;

    public function __construct()
    {
        $this->sesiModel = new SesiModel();
    }

    public function index()
    {
        $data = [
            'menu' => $this->fetchMenu(),
            'title' => "Sesi",
            'breadcrumb' => ['Data', 'Sesi'],
            'validation' => \Config\Services::validation(),
        ];
        return view('Modules\Sesi\Views\sesi', $data);
    }
}
