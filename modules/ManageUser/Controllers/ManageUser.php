<?php

/* 
This is Controller Krs
 */

namespace Modules\ManageUser\Controllers;

use App\Controllers\BaseController;


class ManageUser extends BaseController
{
    public function index()
    {
        $data = [
            'title' => "ManageUser",
            'breadcrumb' => ['Home', 'ManageUser'],
        ];
        return view('Modules\ManageUser\Views\manageUser', $data);
    }
}
