<?php
// ############ ONLY for testing ############
// $oDate = time();
// $tYear = date("Y", $oDate);
// $oDate = strtotime("24 dec " . $tYear); // uncomment and change for testing
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
    $tDateStart = "<h3>-= ";
    $tDateEnd = " =-</h3>";
    $tEventStart = '<div class="eventBox">';

    while ($bLooking && $tEvents > "") {
            $iPos1 = strpos($tEvents, $tDateStart);
      $iPos2 = strpos($tEvents, $tDateEnd);
      $tEventDate = strtotime(substr($tEvents, $iPos1 + 7, $iPos2 - $iPos1 - 7));
      if ($tEventDate < $oDate) { // if the event is in the past
        if(strpos($tEvents, $tEventStart, $iPos2)>0){ // if there are more events
            $tEvents = substr($tEvents, strpos($tEvents, $tEventStart, $iPos2)); // move on
        }else{
            $bLooking = false;
            $tEvents = "";
        }
      } else {
        $bLooking = false;
      }
    }
  return $tEvents;
}
