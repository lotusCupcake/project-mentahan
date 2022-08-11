<?php

/* 
This is Controller Krs
 */

namespace Modules\Calendar\Controllers;

use App\Controllers\BaseController;


class Calendar extends BaseController
{
    public function index()
    {
        $data = [
            'title' => "Calendar",
            'breadcrumb' => ['Home', 'Calendar'],
        ];
        return view('Modules\Calendar\Views\calendar', $data);
    }
}
