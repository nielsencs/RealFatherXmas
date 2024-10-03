<?php
$bSnow = false;
require_once 'header.php';
?>
<div class="main">
    <?php
    require_once "eventsLoad.php";
    if ($tEvents > '') {
        echo '<h2>Upcoming Events</h2>';
        echo $tEvents;
    } else { ?>
        <h2>Events</h2>
        <p>So sorry, you&rsquo;ve missed all the most recent events. However they happen every year around
          November and December, so check back later on and see when you can catch me!</p>
        <div class="eventBox"><h3>-= Someday not tooooooo long from now =-</h3>
        <h4>--- Sometime ---</h4>
        <p>Location: Somewhwere there'll be a Christmas Event</p>
        <p><img class="eventImage" src="images\NewHopeSmall.jpg" alt="Event Image"></p>
        </div>

        <?php 
    }

    ?>
    <!-- h2>Mr C&rsquo;s Calendar</h2>
    <div class="responsive-iframe-container">
        <iframe src="https://calendar.google.com/calendar/embed?height=600&wkst=1&bgcolor=%23ffffff&ctz=Europe%2FLondon&mode=MONTH&hl=en_GB&showTitle=1&showNav=1&showDate=1&showPrint=1&showTabs=1&showCalendars=0&showTz=0&src=cmZ4ZWx2ZXNAZ21haWwuY29t&color=%232f4d36" style="border-width:0" width="800" height="600"></iframe>
    </div -->
</div>
<?php
require_once 'footer.php';
?>