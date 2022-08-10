<?php

namespace App\Controllers;

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

    public function __construct()
    {
        $this->hasher = new MDHearing();
        $this->client = new Google_Client();
        //The json file you got after creating the service account
        $pathconf = 'config/vps-ivan-0748b26484ca.json';
        putenv('GOOGLE_APPLICATION_CREDENTIALS=' . $pathconf);
        $this->client->useApplicationDefaultCredentials();
        $this->client->setApplicationName("schedulerFK");
        // $this->client->setClientId('985751171310-tl3b0tnpj2bmd5a9qi6gbb9u226tiakp.apps.googleusercontent.com');
        // $this->client->setClientSecret('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');
        // $this->client->addScope('email');
        // $this->client->addScope('profile');
        $this->client->addScope(Google_Service_Calendar::CALENDAR);
        // $this->client->setAccessType('offline');
        // $this->client->setRedirectUri('http://localhost:8080/loginWithGoogle');

        $this->service = new Google_Service_Calendar($this->client);

        $calendarList = $this->service->calendarList->listCalendarList();
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
            'description' => 'Fikri Bedol',
            'location' => 'KKD Lantai 2',
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
        ));

        $calendarId = 'oc9jbs14jprou74o5im5isjq3s@group.calendar.google.com';
        $event = $this->service->events->insert($calendarId, $event);
        dd($event);
    }

    public function testhash()
    {
        $hashedPassword = $this->hasher->hashPassword('allahuakbar1213');
        $result = $this->hasher->verifyHashedPassword($hashedPassword, 'allahuakbar1213');
        dd($result);
    }
}
