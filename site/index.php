<?php
$bSnow = false;
require_once 'header.php';

$iMonth = 12;
$iMonthActive = 10;
$tImage = "images/MrCTop.jpg";
$tImageAlt = "Mr C sitting by his tree!";
if($iMonth < $iMonthActive){
  $tImage = "images/MrCSnoozeTop.jpg";
  $tImageAlt = "Mr C snoozing after a long Christmas season!";
}

$tHeading = "";
$tParaStart = 'But the elves are always ready to help with bookings and anything else - just ';
$tParaEmail = 'send us an <a href="mailto:elves@realfatherxmas.com" style="font-weight:bold;">email</a>';

$bForm = false;
$tFormFill = "";
if ($bForm){
  $tFormFill = " or fill in the form below";
}
?>
<div class="main">
  <div class="imageContainer">
    <img src="<?php echo $tImage;?>" alt="<?php echo $tImageAlt;?>" style="width:100%; min-height: 423px;">
    <div class="centerMiddle">
<?php
      if ($iMonth >= 1) {
        $tHeading = "Mr C is very tired.";
        $tParaStart = "Try popping back in a few months time! In the meantime you can ";
      } 
      if ($iMonth >= 6) {
        $tHeading = "Mr C is still rather sleepy... Zzz!";
        $tParaStart = "The elves are available - do ";
      }
      if ($iMonth >= 8) {
        $tHeading = "Mr C is <em>still</em> very tired.";
      }
      if ($iMonth >= $iMonthActive) {
        $tHeading = "Visit Mr C from the comfort of your own home!";
      }
?>
      <h2 style="color:#fff"><?php echo $tHeading;?></h2>
      <p class="centerText" style="color: #fff;"><?php echo $tParaStart . $tParaEmail . $tFormFill;?>.</p>
    </div>
  </div>
</div>
<?php
if ($bForm){
?>
<div class="contactForm">
  <h3>Contact Form</h3>
  <form action="action_page.php">

    <label for="fname">First Name</label>
    <input type="text" id="fname" name="firstname" placeholder="Your name...">

    <label for="lname">Last Name</label>
    <input type="text" id="lname" name="lastname" placeholder="Your last name...">

    <label for="subject">Subject</label>
    <input type="text" id="subject" name="subject" placeholder="Subject...">

    <label for="message">Message</label>
    <textarea id="message" name="message" placeholder="Write something.." style="height:200px"></textarea>

    <input type="submit" value="Submit" class="center">

  </form>
</div>
<?php
}
?>
<?php
require_once 'footer.php';
?>