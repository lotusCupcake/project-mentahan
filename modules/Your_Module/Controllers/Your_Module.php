<?php

/* 
This is Controller Krs
 */

namespace Modules\Your_Module\Controllers;

use App\Controllers\BaseController;


class Your_Module extends BaseController
{
    public function index()
    {
        $data = [
            'title' => "Your_Module",
            'breadcrumb' => ['Home', 'Your_Module'],
        ];
        return view('Modules\Your_Module\Views\your_Module', $data);
    }
}
