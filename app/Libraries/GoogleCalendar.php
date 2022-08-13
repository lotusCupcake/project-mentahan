<?php

namespace App\Libraries;

use Google\Client as Google_Client;
use Google\Service\Calendar  as Google_Service_Calendar;
use Google\Service\Calendar\Event as Google_Service_Calendar_Event;


class GoogleCalendar
{
    protected $client;
    protected $calendar;
    protected $service;
    protected $hasher;
    protected $calId;

    public function __construct()
    {
        $this->client = new Google_Client();
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

    }

    public function addCalendar($event)
    {
        $event = new Google_Service_Calendar_Event($event);
        $event = $this->service->events->insert($this->calId, $event);
        if ($event->status == 'confirmed') {
            $data = [];
            $data[] = [
                'id' => $event->id,
                'summary' => $event->summary,
                'description' => $event->description,
                'location' => $event->location,
                'colorId' => $event->colorId,
                'start' => $event->start->dateTime,
                'end' => $event->end->dateTime,
                'attendees' => $event->attendees
            ];
            return $data;
        } else {
            return false;
        }
    }

    public function editCalendar($id, $event)
    {
        $event = new Google_Service_Calendar_Event($event);
        $event = $this->service->events->update($this->calId, $id, $event);
        $data = [];
        $data[] = [
            'id' => $event->id,
            'summary' => $event->summary,
            'description' => $event->description,
            'location' => $event->location,
            'colorId' => $event->colorId,
            'start' => $event->start->dateTime,
            'end' => $event->end->dateTime,
            'attendees' => $event->attendees
        ];

        return $data;
    }

    public function delCalendar($id)
    {
        $event = $this->service->events->delete($this->calId, $id);
        return $event;
    }

    public function listCalendar()
    {
        $event = $this->service->events->listEvents($this->calId)->items;
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
        return $data;
    }

    public function listCalendarAll()
    {
        $event = $this->service->events->listEvents($this->calId)->items;
        $data = $event;
        return $data;
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
        return $data;
    }
}
