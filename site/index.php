<?php
$bSnow = false;
require_once 'header.php';

$oDate = time();
$tYear = date("Y", $oDate);
$oLateDate = strtotime("25 dec " . $tYear);

require_once "eventsLoad.php";
$tEvent = getFirstEvent($tEvents);

$iMonth = date("m", $oDate);
$iDay = date("j", $oDate);

$iMonthActive = 10;
$tImage = "/images/MrC.jpg";
$tImageAlt = "Mr C sitting by his tree!";
if ($iMonth < $iMonthActive || ($iMonth == 12 && $iDay > 24)) {
  $tImage = "/images/MrCSnooze.jpg";
  $tImageAlt = "Mr C snoozing after a long Christmas season!";
}

$tHeading = "";
$tParaStart = 'But the elves are always ready to help with bookings and anything else - just ';
$tParaEmail = 'send us an <a href="mailto:elves@realfatherxmas.com" style="font-weight:bold;">email</a>';
$tParaBott = '';

$bForm = true;
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
  if($tEvent > "") {
    $tParaStart = 'Well, your next chance is';
    $tParaBott = 'or you could get the elves to organise a special one for you - just ';
  } else {
    $tParaStart = 'Get the elves to organise it for you - just ';
  }
}

if ($iMonth == 12 && $iDay > 24) {
  $tHeading = "Mr C is <em>ever so</em> tired but wishes you a Happy Christmas!";
  $tParaStart = "If you need anything, do ";
}
?>
<div class="main home">
  <div class="item imageContainer">
    <img src="<?php echo $tImage; ?>" class="main__img" alt="<?php echo $tImageAlt; ?>">
  </div>
  <div class="item">
      <h2><?php echo $tHeading; ?></h2>
      <?php if ($iMonth >= $iMonthActive) { ?>
        <p class="centerText"><?php echo $tParaStart; ?></p>

        <?php echo $tEvent; ?>

        <p><?php echo $tParaBott . $tParaEmail . $tFormFill; ?>.</p>
      <?php } else { ?>
        <p><?php echo $tParaStart . $tParaEmail . $tFormFill; ?>.</p>
      <?php } ?>

    </div>
  </div>
<?php if ($bForm) { ?>
  <div class="main contactForm" id="contact">
    <h3>Contact the elves</h3>
    <p class="contactForm__intro">Tell us what you have in mind and how to get back to you.</p>
    <form class="contactForm__form" action="/action_page" method="post">
      <div class="contactForm__field">
        <label for="name">Name</label>
        <input type="text" id="name" name="name" placeholder="Your name" autocomplete="name" required>
      </div>

      <div class="contactForm__field contactForm__field--half">
        <label for="email">Email</label>
        <input type="email" id="email" name="email" placeholder="you@example.com" autocomplete="email" required>
      </div>

      <div class="contactForm__field contactForm__field--half">
        <label for="phone">Phone <span class="contactForm__optional">optional</span></label>
        <input type="tel" id="phone" name="phone" placeholder="Best number to call" autocomplete="tel">
      </div>

      <div class="contactForm__field">
        <label for="subject">Subject <span class="contactForm__optional">optional</span></label>
        <input type="text" id="subject" name="subject" placeholder="Booking enquiry, event visit, question...">
      </div>

      <div class="contactForm__field">
        <label for="message">Message</label>
        <textarea id="message" name="message" rows="7" placeholder="Dates, location, ages, event details, or anything else the elves should know" required></textarea>
      </div>

      <div class="contactForm__field contactForm__field--trap" aria-hidden="true">
        <label for="website">Website</label>
        <input type="text" id="website" name="website" tabindex="-1" autocomplete="off">
      </div>

      <button type="submit" class="contactForm__submit">Send message</button>
    </form>
  </div>
<?php } ?>
<?php
require_once 'footer.php';

function getFirstEvent($tEvents)
{
  $iEventPos = strpos($tEvents, '</div>');
  return substr($tEvents, 0, $iEventPos + 6); //
}

?>
