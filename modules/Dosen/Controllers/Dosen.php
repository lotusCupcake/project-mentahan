<?php

/* 
This is Controller Krs
 */

namespace Modules\Dosen\Controllers;

use App\Controllers\BaseController;


class Dosen extends BaseController
{
    public function index()
    {
        $data = [
            'title' => "Dosen",
            'breadcrumb' => ['Home', 'Dosen'],
        ];
        return view('Modules\Dosen\Views\dosen', $data);
    }
}
