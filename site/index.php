<?php
$bSnow = false;
require_once 'header.php';
?>
<div class="main">
  <div class="imageContainer">
    <img src="images/MrCSnoozeTop.jpg" alt="Mr C snoozing after a long Christmas season!" style="width:100%; min-height: 423px;">
    <div class="centerMiddle">
      <h2 style="color:#fff">Mr C is still <em>very</em> tired!</h2>
      <p class="centerText" style="color: #fff;">But the elves are ready to help with bookings and anything else - just send us
        an <a href="mailto:elves@realfatherxmas.com" style="font-weight:bold;">email</a> or fill in the form below.</p>
    </div>
  </div>
</div>
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
require_once 'footer.php';
?>