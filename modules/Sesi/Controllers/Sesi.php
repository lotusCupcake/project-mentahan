<?php

/* 
This is Controller Krs
 */

namespace Modules\Sesi\Controllers;

use App\Controllers\BaseController;


class Sesi extends BaseController
{
    public function index()
    {
        $data = [
            'title' => "Sesi",
            'breadcrumb' => ['Home', 'Sesi'],
        ];
        return view('Modules\Sesi\Views\sesi', $data);
    }
}
