<?php
require_once("zapcallib.php");

$tFileCal = "calendar/Real Father Xmas appearances_rfxelves@gmail.com.ics";
$tFileToday = "calendar/today.txt";
$iFileModTime = filemtime($tFileToday);
$tLine = "";

$tDateTimeBEG = "DTSTART;TZID=Europe/London:";
$tDateTimeEND = "DTEND;TZID=Europe/London:";

$tEventDateTime = "";
$tDate = "";

$tFileModDate = date("d:m", $iFileModTime);
$tTodayYear = date("Y");
$tTodayMonth = date("m");
$tTodayDay = date("d");

$maxdate = strtotime($tTodayYear . "-12-31");

if ($tFileModDate != date("d:m")) { // If we've not yet done the process today we need to.
    $myfile = fopen($tFileCal, "r") or die("Unable to open file!");

    $bLogging = false;
    do {
        $tLine = trim(fgets($myfile));

        if ($tLine == "BEGIN:VEVENT") {
            $bLogging = true;
            $tEventSummary = "";
            $tEventDescription = "";
            $tEventLocation = "";
        } else {
            if ($bLogging) { // it may just have changed!
                getDateTime($tLine, $tDateTimeBEG);
            }

            if ($bLogging) { // it may just have changed!
                getDateTime($tLine, $tDateTimeEND);
            }

            if ($bLogging) { // it may just have changed!
                $tTag = "SUMMARY:";
                $iStart = strlen($tTag);
                if (substr($tLine, 0, $iStart) == $tTag) {
                    $tEventSummary = getValue($tLine, $tTag);
                }
            }

            if ($bLogging) { // it may just have changed!
                $tTag = "DESCRIPTION:";
                $iStart = strlen($tTag);
                if (substr($tLine, 0, $iStart) == $tTag) {
                    $tEventDescription = getValue($tLine, $tTag);
                }
            }

            if ($bLogging) { // it may just have changed!
                $tTag = "LOCATION:";
                $iStart = strlen($tTag);
                if (substr($tLine, 0, $iStart) == $tTag) {
                    $tEventLocation = getValue($tLine, $tTag);
                }
            }

            if ($bLogging) { // it may just have changed!
                $tTag = "RRULE:";
                $iStart = strlen($tTag);
                if (substr($tLine, 0, $iStart) == $tTag) {
                    $tRepeatRule = getValue($tLine, $tTag);
                    $rd = new ZCRecurringDate($tRepeatRule, strtotime($tDate));
                    $dates = $rd->getDates($maxdate);
                    foreach($dates as $d)
                    {
                        echo $tEventSummary . date('l, F j, Y ',$d) . "<br>\n";
                    }
                }
            }

            if ($tLine == "END:VEVENT") {
                $bLogging = false;
                echo $tEventSummary . " " . $tEventDateTime . " at " . $tEventLocation . "<br>" . $tEventDescription . "<br><br>";
            }
        }
    } while ($tLine > "");
    fclose($myfile);
}

function getDateTime($tLine, $tTag)
{
    global $tTodayYear, $tDate, $tEventDateTime, $tDateTimeBEG, $bLogging;
    $iStart = strlen($tTag);

    if (substr($tLine, 0, $iStart) == $tTag) {
        if (substr($tLine, $iStart, 4) == $tTodayYear) { // this year
            $tTextDate = "";
            $tTime = "";
            // month
            $iStart = $iStart + 4;
            $tMonthNum  = substr($tLine, $iStart, 2);
            $dateObj  = DateTime::createFromFormat('!m', $tMonthNum);
            $tMonthName = $dateObj->format('F');
            $tTextDate .= $tMonthName;
            // day
            $iStart = $iStart + 2;
            $tDay = substr($tLine, $iStart, 2);
            $tTextDate .= " " . ltrim($tDay,"0");

            // hour
            $iStart = $iStart + 3; // skip "T"
            $tTime .= " " . substr($tLine, $iStart, 2);
            // minute
            $iStart = $iStart + 2;
            $tTime .=  ":" . substr($tLine, $iStart, 2);

            if ($tTag == $tDateTimeBEG) { // beginning of date
                $tEventDateTime = $tTextDate . " " . $tTime;
                $tDate = $tTodayYear . "-" . $tMonthNum . "-" . $tDay ;
            } else {
                $tEventDateTime .= " to " . $tTime;
            }
        } else { // ignore previous or future years
            $bLogging = false;
        }
    }
    return;
}

function getValue($tLine, $tTag)
{
    $iStart = strlen($tTag);
   
    $tText = "";
    if (substr($tLine, 0, $iStart) == $tTag) {
        $tText = substr($tLine, $iStart);
    }
    return $tText;
}

$myfile = fopen($tFileToday, "r") or die("Unable to open file!");
echo fgets($myfile);
fclose($myfile);
