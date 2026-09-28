<?php

function getEvents() {
  $tEvents = '';
  $oDate = time();
  // ############ ONLY for testing ############
  // $tYear = date("Y", $oDate);
  // $oDate = strtotime("17:01 29 nov " . $tYear); // uncomment and change for testing
  // ############ ONLY for testing ############

  $tFile = 'calendar/RFXEvents.txt';
  $myfile = fopen($tFile, 'r') or die('Unable to open file!');
  $tEvents = fread($myfile, filesize($tFile));
  fclose($myfile);

  // $tEvents = str_replace("£", "&pound;", $tEvents); // weirdly doesn't work
  // $tEvents .= '</p></div>'; // terrible kludge - missing last one in RFXEvents.txt
  $tEvents = trimPastEvents($tEvents, $oDate);
  return $tEvents;
}

function trimPastEvents($tEvents, $oDate) {
  $bLooking = true;
  $tEventStart = '<div class="eventBox">';
  $tDateStart = "<h3>-= ";
  $tDateEnd = " =-</h3>";
  $tTimeStart = "<h4>--- ";

  while ($bLooking && $tEvents > "") {
    $iPos1 = strpos($tEvents, $tDateStart);
    $iPos2 = strpos($tEvents, $tDateEnd);
    $iPos3 = strpos($tEvents, $tTimeStart);
    $tEventDate = substr($tEvents, $iPos1 + 7, $iPos2 - $iPos1 - 7);
    $tEventTime = substr($tEvents, $iPos3 + 14, 5);
    echo "<!-- FFF $tEventTime $tEventDate -->";
    $oEventDate = strtotime($tEventTime . " " . $tEventDate);
    // $oEventDate = strtotime($tEventDate);

    // todo: the 17 in the below calc is the hour - should be taken from event finish
    if ($oEventDate < ($oDate - (17 * 60 * 60))) { // if the event is in the past
      if (strpos($tEvents, $tEventStart, $iPos2) > 0) { // if there are more events
        $tEvents = substr($tEvents, strpos($tEvents, $tEventStart, $iPos2)); // move on
      } else {
        $bLooking = false;
        $tEvents = "";
      }
    } else {
      $bLooking = false;
    }
  }
  return $tEvents;
}


function getEventsFromGoogleCalendar() {
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
