<?php

namespace Modules\Home\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\I18n\Time;
use CodeIdniter\I18n\DateTime as DateTime;

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
        $id = '2dtniq19l3dcd4k0grnptkcoic';
        dd(delEvent($id));
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
