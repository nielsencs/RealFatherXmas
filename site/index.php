<?php
$bSnow = false;
require_once 'header.php';

$oDate = time();
$tYear = date("Y", $oDate);
$oLateDate = strtotime("25 dec " . $tYear);

require_once "eventsLoad.php";
$tEvent = getNextEvent($tEvents, $oDate);

$iMonth = date("m", $oDate);
$iDay = date("j", $oDate);

$iMonthActive = 10;
$tImage = "images/MrCTop.jpg";
$tImageAlt = "Mr C sitting by his tree!";
if ($iMonth < $iMonthActive || ($iMonth == 12 && $iDay > 24)) {
  $tImage = "images/MrCSnoozeTop.jpg";
  $tImageAlt = "Mr C snoozing after a long Christmas season!";
}

$tHeading = "";
$tParaStart = 'But the elves are always ready to help with bookings and anything else - just ';
$tParaEmail = 'send us an <a href="mailto:elves@realfatherxmas.com" style="font-weight:bold;">email</a>';
$tParaBott = '';

$bForm = false;
$tFormFill = "";
if ($bForm) {
  $tFormFill = " or fill in the form below";
}

if ($iMonth >= 1) {
  $tHeading = "Mr C is very tired.";
  $tParaStart = "Try popping back in a few months time! In the meantime you can ";
}

if ($iMonth >= 6) {
  $tHeading = "Mr C is still rather sleepy... Zzz!";
  $tParaStart = "But the elves are always available - do ";
}

if ($iMonth >= 8) {
  $tHeading = "Mr C is <em>still</em> very tired.";
}

if ($iMonth >= $iMonthActive && $oDate < $oLateDate) {
  // $tHeading = "Visit Mr C from the comfort of your own home!";
  $tHeading = "Have you ever met the Real Father Christmas?";
  // $tParaStart = 'Get the elves to organise it for you - just ';
  $tParaStart = 'Well, your next chance is';
  $tParaBott = 'or you could get the elves to organise a special one for you - just ';
}

if ($iMonth == 12 && $iDay > 24) {
  $tHeading = "Mr C is <em>ever so</em> tired but wishes you a Happy Christmas!";
  $tParaStart = "If you need anything, do ";
}
?>
<div class="main">
  <div class="imageContainer">
    <img src="<?php echo $tImage; ?>" alt="<?php echo $tImageAlt; ?>" style="width:100%;">
    <div class="centerMiddle brightA">
      <h2 style="color:#fff"><?php echo $tHeading; ?></h2>
      <?php if ($iMonth >= $iMonthActive) { ?>
        <p class="centerText" style="color: #fff; line-height: 133%;"><?php echo $tParaStart; ?></p>
        <?php
        echo $tEvent;
        ?>
        <p class="centerText" style="color: #fff; line-height: 133%;"><?php echo $tParaBott . $tParaEmail . $tFormFill; ?>.</p>
      <?php } else { ?>
        <p class="centerText" style="color: #fff; line-height: 133%;"><?php echo $tParaStart . $tParaEmail . $tFormFill; ?>.</p>
      <?php } ?>

    </div>
  </div>
</div>
<?php if ($bForm) { ?>
  <div class="contactForm">
    <h3>Contact Form</h3>
    <form action="action_page.php">

      <label for="fname">Name</label>
      <input type="text" id="fname" name="firstname" placeholder="Your name...">

      <label for="subject">Subject</label>
      <input type="text" id="subject" name="subject" placeholder="Subject...">

      <label for="message">Message</label>
      <textarea id="message" name="message" placeholder="Write something.." style="height:200px"></textarea>

      <input type="submit" value="Submit" class="center">

    </form>
  </div>
<?php } ?>
<?php
require_once 'footer.php';

function getNextEvent($tEvents, $oDate)
{
  $tEvent = "";
    $tDateStart = "<h3>-= ";
    $tDateEnd = " =-</h3>";
    $tEventStart = '<div class="eventBox">';

    while ($tEvent == "" && $tEvents > "") {
      $iPos1 = strpos($tEvents, $tDateStart);
      $iPos2 = strpos($tEvents, $tDateEnd);
      $tEventDate = strtotime(substr($tEvents, $iPos1 + 7, $iPos2 - $iPos1 - 7));
      if ($tEventDate < $oDate) { // if the event is in the past
        $tEvents = substr($tEvents, strpos($tEvents, $tEventStart, $iPos2)); // move on
      } else {
        $iEventPos2 = strpos($tEvents, '</p></div>');
        $tEvent = substr($tEvents, 0, $iEventPos2 + 10);
        $tEvents = "";
      }
    }
  return $tEvent;
}

?>
