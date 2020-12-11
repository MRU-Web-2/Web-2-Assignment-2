<?php
include_once('includes/stock-config.inc.php');
include_once('lib/assignment2-db-classes.inc.php');

session_start();

$paintingsURL = 'https://assignment2-297900.uc.r.appspot.com/api-paintings.php';
$paintingsData = json_decode(file_get_contents($paintingsURL));

// If the favourites exist and is not empty, this will run (view below to see where used)
function printAllPaintingsAsImages($paintingsData)
{
    $favourites = $_SESSION['favs'];
    foreach ($favourites as $paintingID) {
        printSinglePainting($paintingID, $paintingsData);
    }
}
function printSinglePainting($paintingID, $paintingsData)
{
    foreach ($paintingsData as $p) {
        if ($p->PaintingID == $paintingID) {
            $painting = $p;
        }
    }
    echo "<div><a href='single-painting.php?painting=" . $paintingID . "'>";
    echo "<img src='painting.php?file=" . $painting->ImageFileName . "&size=square' style='width:200px;height:200px' alt='" . $painting->Title . "'>";
    echo "</a>";
    echo "<p>" . $painting->Title . "</p></div>";
    echo "<td><a href='remove-from-favourites.php?painting=" . $paintingID . "'>Remove from Favourites</a></td>";
}

// If there are no favourites yet, run this code
function noFavourites()
{
    echo "<div id='emptyFavourites'>There are no favourites here yet</div>";
}

?>
<html>

<head>
    <meta charset="utf-8" />
    <title>Painting Details Page</title>
    <style>
        <?php include 'style/favourites.css'; ?>
    </style>
</head>

<body style="background-image: url(./images/payson-wick-vGLXKqCY66Y-unsplash.jpg);
background-size: cover;
background-repeat: no-repeat;">
    <?php include("header.php"); ?>
    <main>
        <?php
        if (isset($_SESSION['favs']) && !empty($_SESSION['favs'])) {
            printAllPaintingsAsImages($paintingsData);
        } else {
            noFavourites();
        }
        ?>
    </main>
</body>

</html>