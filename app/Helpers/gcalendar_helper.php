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