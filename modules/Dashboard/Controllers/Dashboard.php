<?php

/* 
This is Controller Krs
 */

namespace Modules\Dashboard\Controllers;

use App\Controllers\BaseController;


class Dashboard extends BaseController
{
    public function index()
    {
        $data = [
            'title' => "Dashboard",
            'breadcrumb' => ['Home', 'Dashboard'],
        ];
        return view('Modules\Dashboard\Views\dashboard', $data);
    }
}
