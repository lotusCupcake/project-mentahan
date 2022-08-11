<?php

namespace Modules\Home\Controllers;

use App\Controllers\BaseController;

use Google\Client as Google_Client;
use Google\Service\Calendar  as Google_Service_Calendar;
use Google\Service\Calendar\Event as Google_Service_Calendar_Event;
use MDHearing\AspNetCore\Identity\PasswordHasher as MDHearing;
use Google\Service\OAuth2 as Google_Service_Oauth2;

class Home extends BaseController
{
    protected $client;
    protected $calendar;
    protected $service;
    protected $hasher;
    protected $calId;

    public function __construct()
    {
        $this->hasher = new MDHearing();
        $this->client = new Google_Client();
        //The json file you got after creating the service account
        $pathconf = 'config/vps-ivan-0748b26484ca.json';
        // $pathconf = 'config/digital-schedule-9258d488752a.json';

        putenv('GOOGLE_APPLICATION_CREDENTIALS=' . $pathconf);
        $this->client->useApplicationDefaultCredentials();
        $this->client->setApplicationName("schedulerFK");
        $this->client->addScope(Google_Service_Calendar::CALENDAR);

        $this->service = new Google_Service_Calendar($this->client);

        $calendarList = $this->service->calendarList->listCalendarList();
        $this->calId = 'oc9jbs14jprou74o5im5isjq3s@group.calendar.google.com';
        // $this->calId = 'digisched@umsu.ac.id';

        // print_r($calendarList);
    }

    public function index()
    {
        // $data['googleButton'] = '<a href="' . $this->client->createAuthUrl() . '"><button class="btn btn-danger">Login with Google</button></a>';
        return view('welcome_message');
    }

    public function loginWithGoogle()
    {
        $token = $this->client->fetchAccessTokenWithAuthCode($this->request->getVar('code'));
        if (!isset($token['error'])) {
            $this->client->setAccessToken($token['access_token']);
            session()->set('access_token', $token['access_token']);

            $googleService = new Google_Service_Oauth2($this->client);
            $data = $googleService->userinfo->get();
            dd($data);
        } else {
            dd($token);
            // session()->setFlashdata("error", $token['error_description']);
            // return redirect()->to(base_url());
        }
    }

    public function addCalendar()
    {
        $event = new Google_Service_Calendar_Event(array(
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
        ));

        $calendarId = $this->calId;
        $event = $this->service->events->insert($calendarId, $event);
        dd($event);
    }

    public function editCalendar()
    {
        $event = new Google_Service_Calendar_Event(array(
            'summary' => 'Jadwal KKD',
            'description' => 'Fikri Ansari',
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
        ));
        $eventId = '8dbvsqccu07v3ct121t99hqlms';
        $calendarId = $this->calId;
        $event = $this->service->events->update($calendarId, $eventId, $event);
        dd($event);
    }

    public function delCalendar()
    {
        $eventId = 'mea3dpb4muvcdr6l392huat6rs';
        $calendarId = $this->calId;
        $event = $this->service->events->delete($calendarId, $eventId);
        dd($event);
    }

    public function listCalendar()
    {
        $calendarId = $this->calId;
        $event = $this->service->events->listEvents($calendarId)->items;
        $data = [];
        foreach ($event as $key) {
            $data[] = [
                'id' => $key->id,
                'summary' => $key->summary,
                'description' => $key->description,
                'location' => $key->location,
                'colorId' => $key->colorId,
                'start' => $key->start->dateTime,
                'end' => $key->end->dateTime,
                'attendees' => $key->attendees
            ];
        }
        dd($data);
    }

    public function colorCalendar()
    {
        // $calendarId = $this->calId;
        $event = $this->service->colors->get()->event;
        $data = [];
        foreach ($event as $key => $value) {
            $data[] = [
                'id' => $key,
                'background' => $value->background,
                'foreground' => $value->foreground,
            ];
        }
        dd($data);
    }

    public function testhash()
    {
        $hashedPassword = $this->hasher->hashPassword('allahuakbar1213');
        $result = $this->hasher->verifyHashedPassword($hashedPassword, 'allahuakbar1213');
        dd($result);
    }
}
