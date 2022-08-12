<?php

namespace Modules\Home\Controllers;

use App\Controllers\BaseController;

class Home extends BaseController
{


    public function index()
    {
        $data = [
            'menu' => $this->fetchMenu(),
            'title' => "Penjadwalan",
            'breadcrumb' => ['Home', 'Penjadwalan'],
        ];
        return view('Modules\Home\Views\home', $data);
    }

    public function addCalendar()
    {
        $event = array(
            'summary' => 'Jadwal KKD',
            'description' => 'Sukrianto Lc, Ma',
            'location' => 'WC Lantai 2',
            'colorId' => 1,
            'start' => array(
                'dateTime' => date('Y-m-d\TH:i:sP')
            ),
            'end' => array(
                'dateTime' => date('Y-m-d\TH:i:sP', +strtotime('+1 hour'))
                // ),
                // 'attendees' => array(
                //     array('email' => 'fikriansari.mfa@gmail.com'),
            ),
            'guestsCanInviteOthers' => false,
            'guestsCanModify' => false,
            'guestsCanSeeOtherGuests' => false,
        );
        dd(addEvent($event));
    }

    public function editCalendar()
    {
        $id = 'e1ba56c2up6og4eqi444viohb0';
        $event = array(
            'summary' => 'Jadwal KKD',
            'description' => 'Sukrianto Lc, Ma',
            'location' => 'Ruang Otopsi Lantai 5',
            'colorId' => 1,
            'start' => array(
                'dateTime' => date('Y-m-d\TH:i:sP')
            ),
            'end' => array(
                'dateTime' => date('Y-m-d\TH:i:sP', +strtotime('+1 hour'))
                // ),
                // 'attendees' => array(
                //     array('email' => 'fikriansari.mfa@gmail.com'),
            ),
            'guestsCanInviteOthers' => false,
            'guestsCanModify' => false,
            'guestsCanSeeOtherGuests' => false,
        );
        dd(editEvent($id, $event));
    }

    public function delCalendar()
    {
        $id = 'atbgot6b55cf8fjl4gn6cruur8';
        dd(delEvent($id));
    }

    public function listCalendar()
    {
        dd(listevent());
    }

    public function colorCalendar()
    {
        dd(colorEvent());
    }

    public function getProfile()
    {
    }
}
