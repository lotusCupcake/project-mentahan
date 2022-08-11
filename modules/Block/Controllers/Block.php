<?php

/* 
This is Controller Krs
 */

namespace Modules\Block\Controllers;

use App\Controllers\BaseController;


class Block extends BaseController
{
    public function index()
    {
        $data = [
            'title' => "Block",
            'breadcrumb' => ['Home', 'Block'],
        ];
        return view('Modules\Block\Views\block', $data);
    }
}
