<?php

/* 
This is Controller Krs
 */

namespace Modules\Maintenance\Controllers;

use App\Controllers\BaseController;


class Maintenance extends BaseController
{
    public function index()
    {
        $data = [
            'title' => "Maintenance",
            'breadcrumb' => ['Home', 'Maintenance'],
        ];
        return view('Modules\Maintenance\Views\maintenance', $data);
    }
}
