<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Real Father Xmas</title>

    <link rel="icon" sizes="192x192" href="images/RFXIcon.png">
    <link rel="shortcut icon" href="images/RFXIcon.png">
    <link rel="apple-touch-icon" href="images/RFXIcon.png">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Nunito+Sans:wght@400;700&family=Playfair+Display:ital,wght@0,400;0,700;1,400;1,700&display=swap" rel="stylesheet">

    <link rel="canonical" href="https://www.realfatherxmas.com">
    <link rel="stylesheet" type="text/css" href="styles/resetRichardClark.css">

    <link rel="stylesheet" type="text/css" href="styles/standard.css">

    <?php
    if ($bSnow) {
        echo '<script src="scripts/snow.js"></script>';
    }
    ?>
</head>

<body>
    <header>
        <div class="logoBox">
        <img class="logo" src="images/IMG_6545_Face.png" alt="RealFatherXmas Logo">

            <h1>Real Father Xmas</h1>
            <p class="centerText" style="font-size: smaller;">I&nbsp;look&nbsp;like&nbsp;him. I&nbsp;sound&nbsp;like&nbsp;him. I&nbsp;am&nbsp;him!</p>
        </div>
        <div class="navBox">
            <div class="navBoxLeft">
                <ul class="nav">
                    <li><a href="index">Home</a></li>
                    <li><a href="events">Events</a></li>
                    <li><a href="inPerson">In Person</a></li>
                    <li><a href="reviews">Reviews</a></li>
                    <li><a href="fun">Fun Stuff</a></li>
                    <li><a href="privacy">Privacy Policy</a></li>
                </ul>
            </div>
            <div class="navBoxRight">
                <div class="navLinks">
                    <a href="mailto:elves@realfatherxmas.com">elves@realfatherxmas.com</a>
                    <a rel="noreferrer" href="https://www.facebook.com/realfatherxmas" target="_blank"><img src="images/Facebook.png" alt="Facebook" class="FB"></a>
                </div>
            </div>
        </div>
    </header>
    <div class="content" <?php if ($bSnow) {
                                echo ' style="background-image: url(/images/SnowTrees.jpg);"';
                            } ?>>
