<?php
$bSnow = false;
require_once 'header.php';
?>
<div class="main">
    <h2>Upcoming events</h2>
    <?php
    require_once "eventsLoad.php";
    echo $tEvents;
    ?>
    <div class="responsive-iframe-container">
        <iframe src="https://calendar.google.com/calendar/embed?height=600&wkst=1&bgcolor=%23ffffff&ctz=Europe%2FLondon&mode=MONTH&hl=en_GB&showTitle=1&showNav=1&showDate=1&showPrint=1&showTabs=1&showCalendars=0&showTz=0&src=cmZ4ZWx2ZXNAZ21haWwuY29t&color=%232f4d36" style="border-width:0" width="800" height="600"></iframe>
    </div>
</div>
<?php
require_once 'footer.php';
?>
