<?php

/* 
This is Controller Krs
 */

namespace Modules\Penjadwalan\Controllers;

use App\Controllers\BaseController;


class Penjadwalan extends BaseController
{
    public function index()
    {
        $data = [
            'menu' => $this->fetchMenu(),
            'title' => "Penjadwalan",
            'breadcrumb' => ['Home', 'Penjadwalan'],
        ];
        return view('Modules\Penjadwalan\Views\penjadwalan', $data);
    }
}
