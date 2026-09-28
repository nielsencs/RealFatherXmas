<?php

function getEvents() {
    if (GOOGLE_API_KEY == '' || GOOGLE_CALENDAR_ID == '') {
        return '<p>Please configure the Google Calendar API settings in config.php</p>';
    }

    require_once __DIR__ . '/../vendor/autoload.php';

    $client = new Google_Client();
    $client->setApplicationName(SITE_NAME);
    $client->setDeveloperKey(GOOGLE_API_KEY);

    $service = new Google_Service_Calendar($client);

    $calendarId = GOOGLE_CALENDAR_ID;
    $optParams = array(
      'maxResults' => 10,
      'orderBy' => 'startTime',
      'singleEvents' => true,
      'timeMin' => date('c'),
    );
    $results = $service->events->listEvents($calendarId, $optParams);
    $events = $results->getItems();

    $tEvents = '';
    if (empty($events)) {
        $tEvents = "<p>No upcoming events found.</p>";
    } else {
        foreach ($events as $event) {
            $start = $event->start->dateTime;
            if (empty($start)) {
                $start = $event->start->date;
            }
            $tEvents .= '<div class="eventBox">';
            $tEvents .= '<h3>-= ' . $event->getSummary() . ' =-</h3>';
            $tEvents .= '<h4>--- ' . date('l jS F Y', strtotime($start)) . ' ---</h4>';
            $tEvents .= '<p>' . $event->getDescription() . '</p>';
            $tEvents .= '</div>';
        }
    }
    return $tEvents;
}

?>
