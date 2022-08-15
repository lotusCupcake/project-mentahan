<?php

/* 
This is Controller Krs
 */

namespace Modules\Absensi\Controllers;

use App\Controllers\BaseController;

class Absensi extends BaseController
{
    public function index()
    {
        $data = [
            'title' => "Absensi Workshop",
            'breadcrumb' => ['Home', 'Data', 'Absensi Workshop'],
        ];
        return view('Modules\Absensi\Views\absensi', $data);
    }
}
