<?php

/* 
This is Controller Krs
 */

namespace Modules\Tentatif\Controllers;

use App\Controllers\BaseController;
use Modules\Tentatif\Models\TentatifModel;

class Tentatif extends BaseController
{
    protected $tentatifModel;

    public function __construct()
    {
        $this->tentatifModel = new TentatifModel();
    }

    public function index()
    {
        $data = [
            'menu' => $this->fetchMenu(),
            'title' => "Jadwal Tentatif",
            'breadcrumb' => ['Proses', 'Jadwal Tentatif'],
            'validation' => \Config\Services::validation(),
        ];
        return view('Modules\Tentatif\Views\tentatif', $data);
    }
}
