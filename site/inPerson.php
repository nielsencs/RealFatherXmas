<?php
$bSnow = false;
require_once 'header.php';

$bForm = false;
$tFormFill = "";
if ($bForm) {
    $tFormFill = " or fill in the form below";
}
?>
<div class="main">
    <div class="blocks" style="background-color: #2f341b;">
        <h2>Come and see him In Person</h2>
        <p>You can come and see Mr C in person on Wednesdays, Thursdays, Fridays and Saturday mornings during December at:</p>
        <address>
            The Way Inn<br>
            268 High Street<br>
            Berkhamsted<br>
            Hertfordshire<br>
            HP4 1BL<br>
        </address>
    </div>
    <div class="blocks MrCBackground brightA">
        <h2>He could come to Your Place!</h2>
        <p>Wouldn't it be wonderful to have an encounter with the Real Father Christmas? Well, you can! It doesn't matter whether you're young or old;
            a small group or a crowd. Maybe you're planning a special party at home with the kids, or you'd like him to appear at your business opening?</p>
        <p>Whatever the occasion throughout November and December - just drop us an <a href="mailto:elves@realfatherxmas.com">email</a> <?php echo $tFormFill; ?> and we'll get back to you with a quotation.</p>
    </div>
<?php
if ($bForm) {
?>
    <div class="blocks" style="background-color: #8c9d52;">
        <h2 style="color: #4c150e">Booking Enquiry</h2>
        <p>Name</p>
        <p>Name</p>
        <p>Email</p>
        <p>Email</p>
        <p>Subject</p>
        <p>Booking Enquiry</p>
        <p>Select a date</p>
        <p>14/09/2022</p>
        <p>Choose a time</p>
        <p>Morning</p>
        <p>Afternoon</p>
        <p>Postcode</p>
        <p>e.g. SS15 3BQ</p>
        <p>Company</p>
        <p>Company</p>
        <p>Phone</p>
        <p>Phone</p>
        <p>Requirements</p>
        <p>Tell us anything you want for the visit to include</p>
        <p></p>
        <p>Submit</p>
    </div>
    <?php
}
?>
    <div style="clear:left"></div>
</div>
<?php
require_once 'footer.php';
?>