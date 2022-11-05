<?php

/**
 * readical.php, Adapted from:
 *  
 * parseicalendar.php
 *
 * @package	ZapCalLib
 * @author	Dan Cogliano <http://zcontent.net>
 * @copyright   Copyright (C) 2006 - 2017 by Dan Cogliano
 * @license     GNU GPLv3 <http://www.gnu.org/licenses/gpl.html>
 * @link	http://icalendar.org/php-library.html
 */

require_once("zapcallib.php");

$tEventDateTime = "";
$oDate = time();
$tDateFormat = "l, F j, Y ";
// $tFileModDate = date("d:m", $iFileModTime);
$tTodayYear = date("Y");
$tTodayMonth = date("m");
$tTodayDay = date("d");

$icalfile = "calendar/Real Father Xmas appearances_rfxelves@gmail.com.ics";
$icalfeed = file_get_contents($icalfile);

// create the ical object
$icalobj = new ZCiCal($icalfeed);

echo "<pre style='color:blue'>";
var_dump($icalobj);
echo "</pre>";

// read back icalendar data that was just parsed
if (isset($icalobj->tree->child)) {
    foreach ($icalobj->tree->child as $node) {
        if ($node->getName() == "VEVENT") {
            foreach ($node->data as $tTag => $tValue) {
                if ($tTag == "DTSTART" || $tTag == "DTEND") {
                    getDateTime($tValue->getValues(), $tTag);
                    echo "<p style='color:blue'>$tEventDateTime</p>";
                    // echo "<p style='color:red'>red" . $tValue->getValues() . "</p>";
                }
                if ($tTag == "SUMMARY") {
                    echo "<br>SUMMARY!<br>";
                }
                if ($tTag == "DESCRIPTION") {
                    echo "<br>DESCRIPTION!<br>";
                }
                if ($tTag == "LOCATION") {
                    echo "<br>LOCATION!<br>";
                }

                if ($tTag == "RRULE") {
                    echo "<br>REPEAT!<br>";
                }
                // if (is_array($tValue)) {
                //     for ($i = 0; $i < count($tValue); $i++) {
                //         $p = $tValue[$i]->getParameters();
                //         echo "  $tTag: " . $tValue[$i]->getValues() . "<br>\n";
                //     }
                // } else {
                //     echo "  $tTag: " . $tValue->getValues() . "<br>\n";
                // }
            }
        }
    }
}

function fred($tTag, $tValue)
{
    if (is_array($tValue)) {
        for ($i = 0; $i < count($tValue); $i++) {
            $p = $tValue[$i]->getParameters();
            echo "  $tTag: " . $tValue[$i]->getValues() . "<br>\n";
        }
    } else {
        echo "  $tTag: " . $tValue->getValues() . "<br>\n";
    }
}

function getDateTime($tLine, $tTag)
{
    global $tTodayYear, $oDate, $tDateFormat, $tEventDateTime, $tDateTimeBEG, $bLogging;

    $iStart = 0;
echo '-=|' . $tLine . '|=-'; // 20221211T173000Z
    if (substr($tLine, $iStart, 4) == $tTodayYear) { // this year
        echo "2022!";
        $tTime = "";
        // month
        $iStart = $iStart + 4;
        $tMonthNum  = substr($tLine, $iStart, 2);
        echo "[$tMonthNum]";
        // day
        $iStart = $iStart + 2;
        $tDay = substr($tLine, $iStart, 2);
        echo "[$tDay]";

        // hour
        $iStart = $iStart + 3; // skip "T"
        $tTime .= " " . substr($tLine, $iStart, 2);
        // minute
        $iStart = $iStart + 2;
        $tTime .=  ":" . substr($tLine, $iStart, 2);

        if (strpos("START", $tTag)>0) { // beginning of date
            $oDate = strtotime($tTodayYear . "-" . $tMonthNum . "-" . $tDay);
            $tEventDateTime = date($tDateFormat, $oDate) . " " . $tTime;
        } else {
            $tEventDateTime .= " to " . $tTime;
        }
    } else { // ignore previous or future years
        $bLogging = false;
    }
    return;
}
