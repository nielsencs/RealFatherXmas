<?php
$tFile = 'calendar/RFX.txt';
$myfile = fopen('calendar/RFX.txt', 'r') or die('Unable to open file!');
$tEvents = fread($myfile, filesize($tFile));
fclose($myfile);
// $tEvents =  htmlspecialchars($tEvents);
// echo str_replace("£", "&pound;", $tEvents);
$tEvents .= '</p></div>' // terrible kludge - missing last one in RFX.txt
?>
