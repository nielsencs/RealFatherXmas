<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php require_once 'config.php'; ?>
    <title><?php echo SITE_NAME; ?></title>

    <link rel="icon" sizes="192x192" href="images/RFXIcon.png">
    <link rel="shortcut icon" href="images/RFXIcon.png">
    <link rel="apple-touch-icon" href="images/RFXIcon.png">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Nunito+Sans:wght@400;700&family=Playfair+Display:ital,wght@0,400;0,700;1,400;1,700&display=swap"
        rel="stylesheet">

    <link rel="canonical" href="https://www.realfatherxmas.com">
    <link rel="stylesheet" type="text/css" href="styles/style.css">

    <?php
    header("Content-Security-Policy: frame-ancestors 'self'");
    header("X-Content-Type-Options: nosniff");
    header("X-Frame-Options: SAMEORIGIN");
    header("X-XSS-Protection: 1; mode=block");
    if ($bSnow) {
        echo '<script src="scripts/snow.js"></script>';
    }
    ?>
</head>

<body>
    <div class="content" <?php if ($bSnow) {
                                echo ' style="background-image: url(/images/SnowTrees.jpg);"';
                            } ?>>
        <header>
            <div class="newLogoBox">
                <div class="newLogoBox__inner">
                    <img class="newLogoBox__image"
                         src="images/IMG_6545_Face.png"
                         alt="RealFatherXmas Logo - Mr C's smiling face!">
                    <div class="newLogoBox__content">
                        <h1 class="newLogoBox__heading-1">Real Father Xmas</h1>
                        <div class="newLogoBox__strapline">I&nbsp;look&nbsp;like&nbsp;him.
                            I&nbsp;sound&nbsp;like&nbsp;him. I&nbsp;am&nbsp;him!
                        </div>
                    </div>
                </div>
            </div>

            <div class="navBox">
                <ul class="nav">
                    <li><a href="index">Home</a></li>
                    <li><a href="events">Events</a></li>
                    <li><a href="inPerson">In Person</a></li>
                    <li><a href="reviews">Reviews</a></li>
                    <li><a href="fun">Fun Stuff</a></li>
                </ul>
            </div>
        </header>
