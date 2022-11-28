<?php
// todo: replace all this with direct access to Google calendar events
$oDate = time();
// ############ ONLY for testing ############
$tYear = date("Y", $oDate);
$oDate = strtotime("17:01 29 nov " . $tYear); // uncomment and change for testing
// ############ ONLY for testing ############

$tFile = 'calendar/RFX.txt';
$myfile = fopen('calendar/RFX.txt', 'r') or die('Unable to open file!');
$tEvents = fread($myfile, filesize($tFile));
fclose($myfile);

// $tEvents = str_replace("£", "&pound;", $tEvents); // weirdly doesn't work
$tEvents .= '</p></div>'; // terrible kludge - missing last one in RFX.txt
$tEvents = trimPastEvents($tEvents, $oDate);

function trimPastEvents($tEvents, $oDate)
{
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
