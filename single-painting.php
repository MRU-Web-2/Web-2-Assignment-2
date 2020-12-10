<?php
session_set_cookie_params(0);
session_start();
if (!$_SESSION['favorite']) {
    $_SESSION['favorite'] = [];
}
$list = $_SESSION['favorite'];
$_SESSION['loginStatus'] = true;
$isLogin = $_SESSION['loginStatus'];

if (isset($_GET['painting'])) {
    $paintingID = $_GET['painting'];
    $paintingURL = 'https://assignment2-297900.uc.r.appspot.com/api-paintings.php?painting=' . $paintingID;
    $paintingData = json_decode(file_get_contents($paintingURL));
    $color = json_decode($paintingData[0]->JsonAnnotations);
} else {
}

function addToFavorites($isLogin)
{
    if ($isLogin) {
        $favorited = false;
        foreach ($_SESSION['favorite'] as $value) {
            if ($value == $_GET['painting']) {
                $favorited = true;
            }
        }
        if (!$favorited) {
            $id = $_GET['painting'];
            echo "<form action='add-to-favorites.php' method='get'>";
            echo "<input name='id' value='$id' type='hidden'>";
            echo "<button type='submit' >Add to Favorites</button>";
            echo "</form>";
        }
    }
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
        .color {
            display: inline-block;
            width: 100px;
            height: 100px;

        }

        .color span {
            color: white;
        }

        /* Style the tab */
        .tab {
            overflow: hidden;
            border: 1px solid #ccc;
            background-color: #f1f1f1;
        }

        /* Style the buttons that are used to open the tab content */
        .tab button {
            background-color: inherit;
            float: left;
            border: none;
            outline: none;
            cursor: pointer;
            padding: 14px 16px;
            transition: 0.3s;
        }

        /* Change background color of buttons on hover */
        .tab button:hover {
            background-color: #ddd;
        }

        /* Create an active/current tablink class */
        .tab button.active {
            background-color: #ccc;
        }

        /* Style the tab content */
        .tabcontent {
            display: none;
            padding: 6px 12px;
            border: 1px solid #ccc;
            border-top: none;
        }
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

<body>
    <main>
        <header>
            <?php include("header.php"); ?>
        </header>
        <div>
            <img src='painting.php?file=<?= $paintingData[0]->ImageFileName ?>&size=square'>
            <P>Painting Title: <?= $paintingData[0]->Title ?></P>
            <P>Artist Name: <?= $paintingData[0]->FirstName . " " . $paintingData[0]->LastName ?></P>
            <P>Gallery Name: <?= $paintingData[0]->GalleryName ?></P>
            <P>Year: <?= $paintingData[0]->YearOfWork ?></P>
            <?php
            addToFavorites($isLogin);
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
    </main>
</body>

</html>