<?php
session_start();
if (!$_SESSION['favs']) {
    $_SESSION['favs'] = [];
}
$list = $_SESSION['favs'];
$_SESSION['loginStatus'] = true;
$isLogin = $_SESSION['loginStatus'];

if (isset($_GET['paintings'])) {
    $paintingID = $_GET['paintings'];
    $paintingURL = 'https://assignment2-297900.uc.r.appspot.com/api-paintings.php?painting=' . $paintingID;
    $paintingData = json_decode(file_get_contents($paintingURL));
    $color = json_decode($paintingData[0]->JsonAnnotations);
}

function addToFavorites()
{
    echo "<td><a href='add-to-favourites.php?painting=" . $_GET['paintings'] . "'>Add to Favourites</a></td>";
}
function removeFromFavorites()
{
    echo "<td><a href='remove-from-favourites.php?painting=" . $_GET['paintings'] . "'>Remove From Favourites</a></td>";
}

function displayTabs($data, $colors)
{
    echo "<div id='Description' class='tabcontent'>";
    echo "<h3>Description</h3>";
    echo "<P>$data->Description</P>";
    echo "</div>";

    echo "<div id='Details' class='tabcontent'>";
    echo "<h3>Details</h3>";
    echo "<p>Medium: $data->Medium </p>";
    echo "<p>Width: $data->Width </p>";
    echo "<p>Height: $data->Height</p>";
    echo "<p>Copyright: $data->CopyrightText </p>";
    echo "<p>Wiki link: </p><a href='$data->WikiLink'>$data->WikiLink</a>";
    echo "<p>Museum link: </p><a href='$data->MuseumLink'>$data->MuseumLink</a>";
    echo "</div>";

    echo "<div id='Colors' class='tabcontent'>";
    echo "<h3>Colors</h3>";
    foreach ($colors->dominantColors as $value) {
        $hex = $value->web;
        $name = $value->name;
        echo "<div class='color' style='background-color:$hex'><span>$name: $hex</span></div>";
    }
    echo "</div>";
}
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <title>Painting Details Page</title>
    <style>
        <?php include "style/single-painting.css"; ?>
    </style>
    <script>
        function openMenu(evt, tabs) {
            console.log(document.querySelectorAll('.tabcontent'));
            // Get all elements with class="tabcontent" and hide them
            let tabcontent = document.querySelectorAll('.tabcontent');
            for (i = 0; i < tabcontent.length; i++) {
                tabcontent[i].style.display = "none";
            }

            // Get all elements with class="tablinks" and remove the class "active"
            let tablinks = document.querySelectorAll('.tabcontent');
            for (i = 0; i < tablinks.length; i++) {
                tablinks[i].className = tablinks[i].className.replace(" active", "");
            }

            // Show the current tab, and add an "active" class to the button that opened the tab
            document.getElementById(tabs).style.display = "block";
            evt.currentTarget.className += " active";
        }
    </script>
</head>

<body style="background-image: url(./images/payson-wick-vGLXKqCY66Y-unsplash.jpg);
background-size: cover;
background-repeat: no-repeat;">
    <main>
        <header>
            <?php include("header.php"); ?>
        </header>
        <div class='content'>
            <img src='painting.php?file=<?= $paintingData[0]->ImageFileName ?>&size=square' style='width:800px;height:800px'>
            <div class='info'>
                <P>Painting Title: <?= $paintingData[0]->Title ?></P>
                <P>Artist Name: <?= $paintingData[0]->FirstName . " " . $paintingData[0]->LastName ?></P>
                <P>Gallery Name: <?= $paintingData[0]->GalleryName ?></P>
                <P>Year: <?= $paintingData[0]->YearOfWork ?></P>
                <?php
                if (isset($_SESSION['favs']) && in_array($_GET['paintings'], $_SESSION['favs'])) {
                    removeFromFavorites();
                } else {
                    addToFavorites();
                }
                ?>
                <!-- Tab links -->
                <div class="tab">
                    <button class="tablinks" onclick="openMenu(event, 'Description')">Description</button>
                    <button class="tablinks" onclick="openMenu(event, 'Details')">Details</button>
                    <button class="tablinks" onclick="openMenu(event, 'Colors')">Colors</button>
                </div>
                <!-- Tab content -->
                <?php
                displayTabs($paintingData[0], $color);
                ?>
            </div>
        </div>
    </main>
</body>

</html>