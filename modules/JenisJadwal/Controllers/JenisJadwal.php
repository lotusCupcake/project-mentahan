<?php

/* 
This is Controller Krs
 */

namespace Modules\JenisJadwal\Controllers;

use App\Controllers\BaseController;


class JenisJadwal extends BaseController
{
    public function index()
    {
        $data = [
            'title' => "JenisJadwal",
            'breadcrumb' => ['Home', 'JenisJadwal'],
        ];
        return view('Modules\JenisJadwal\Views\jenisJadwal', $data);
    }
}
