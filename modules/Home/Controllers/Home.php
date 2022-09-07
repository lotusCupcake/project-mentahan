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
            ),
            'attendees' => array(
                array('email' => 'fikriansari.mfa@gmail.com'),
            ),
            'guestsCanInviteOthers' => false,
            'guestsCanModify' => false,
            'guestsCanSeeOtherGuests' => false,
        );
        dd(addEvent($event));
    }

    public function editCalendar()
    {
        $id = '9sobjjnfeoshc3m8krf1rrsf68';
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
        $id = 'bppi6tt3u20gnid1fp7su8lb48';
        dd(delEvent($id));
    }

    public function detailCalendar()
    {
        $id = 'um660ek68827objcq7kt1desa4';
        dd(detailCalendar($id));
    }

    public function listCalendar()
    {
        dd(listevent());
    }

    public function listCalendarAll()
    {
        dd(listeventall());
    }

    public function colorCalendar()
    {
        dd(konversiColor());
    }

    public function getProfile()
    {
        $date = timeGoogleToAppLong(date('Y-m-d H:i:s'));
        dd($date);
    }

    public function calendar()
    {
        $data = calendar();
        dd($data);
    }
}
