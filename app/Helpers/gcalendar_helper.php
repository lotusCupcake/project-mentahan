<?php

function addEvent($event)
{
    $google = new App\Libraries\GoogleCalendar;
    $exe = $google->addCalendar($event);
    return $exe;
}

function editEvent($id, $event)
{
    $google = new App\Libraries\GoogleCalendar;
    $exe = $google->editCalendar($id, $event);
    return $exe;
}

function listevent()
{
    $google = new App\Libraries\GoogleCalendar;
    $exe = $google->listCalendar();
    return $exe;
}

function listeventall()
{
    $google = new App\Libraries\GoogleCalendar;
    $exe = $google->listCalendarAll();
    return $exe;
}

function delEvent($id)
{
    $google = new App\Libraries\GoogleCalendar;
    $exe = $google->delCalendar($id);
    return $exe;
}

function colorEvent()
{
    $google = new App\Libraries\GoogleCalendar;
    $exe = $google->colorCalendar();
    return $exe;
}

function konversiColor($id)
{
    $google = new App\Libraries\GoogleCalendar;
    $exe = $google->colorCalendar();
    foreach ($exe as $key => $value) {
        if ($value['id'] == $id) {
            return $value['background'];
        }
    }
    // return $exe;
}
