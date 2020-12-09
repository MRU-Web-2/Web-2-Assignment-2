<?php
session_start();
$_SESSION['favorite'] = [5];
$_SESSION['loginStatus'] = true;
$isLogin = $_SESSION['loginStatus'];

if (isset($_GET['painting'])) {
    $paintingID = $_GET['painting'];
    $paintingURL = 'http://localhost/COMP%203512/Web-2-Assignment-2/api-paintings.php?painting' . $paintingID;
    $paintingData = json_decode(file_get_contents($paintingURL));
    $color = json_decode($paintingData[0]->JsonAnnotations);
    $file = generateFile($paintingData[0]->ImageFileName);
} else {
}

function generateFile($file)
{
    if (strlen((string)$file) == 4) {
        return "00" . (string)$file;
    } else if (strlen((string)$file) == 5) {
        return "0" . (string)$file;
    }
    return (string)$file;
}

function displayColors($color)
{
    foreach ($color->dominantColors as $value) {
        $hex = $value->web;
        $name = $value->name;
        echo "<div class='color' style='background-color:$hex'><span>$name: $hex</span></div>";
    }
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
?>
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
</head>

<body>
    <main>
        <div>
            <header>
                <p>Header</p>
            </header>
        </div>
        <div>
            <img src='painting.php?file=<?= $paintingData[0]->ImageFileName ?>&size=square'>
            <P>Painting Title: <?= $paintingData[0]->Title ?></P>
            <P>Artist Name: <?= $paintingData[0]->FirstName . " " . $paintingData[0]->LastName ?></P>
            <P>Gallery Name: </P>
            <P>Year: <?= $paintingData[0]->YearOfWork ?></P>
            <div>
                <?php
                addToFavorites($isLogin);
                ?>
            </div>
            <!-- Tab links -->
            <div class="tab">
                <button class="tablinks" onclick="openMenu(event, 'Description')">Description</button>
                <button class="tablinks" onclick="openMenu(event, 'Details')">Details</button>
                <button class="tablinks" onclick="openMenu(event, 'Colors')">Colors</button>
            </div>

            <!-- Tab content -->
            <div id="Description" class="tabcontent">
                <h3>Description</h3>
                <P><?= $paintingData[0]->Description ?></P>
            </div>

            <div id="Details" class="tabcontent">
                <h3>Details</h3>
                <p>Medium: <?= $paintingData[0]->Medium ?></p>
                <p>Width: <?= $paintingData[0]->Width ?></p>
                <p>Height: <?= $paintingData[0]->Height ?></p>
                <p>Copyright: <?= $paintingData[0]->CopyrightText ?></p>
                <p>Wiki link: </p><a href="<?= $paintingData[0]->WikiLink ?>"><?= $paintingData[0]->WikiLink ?></a>
                <p>Museum link: </p><a href="<?= $$paintingData[0]->MuseumLink ?>"><?= $paintingData[0]->MuseumLink ?></a>
            </div>

            <div id="Colors" class="tabcontent">
                <h3>Colors</h3>
                <?php
                displayColors($color);
                ?>
            </div>

            <script>
                function openMenu(evt, tabs) {
                    // Get all elements with class="tabcontent" and hide them
                    let tabcontent = document.querySelectorAll(".tabcontent");
                    for (i = 0; i < tabcontent.length; i++) {
                        tabcontent[i].style.display = "none";
                    }

                    // Get all elements with class="tablinks" and remove the class "active"
                    let tablinks = document.querySelectorAll(".tablinks");
                    for (i = 0; i < tablinks.length; i++) {
                        tablinks[i].className = tablinks[i].className.replace(" active", "");
                    }

                    // Show the current tab, and add an "active" class to the button that opened the tab
                    document.getElementById(tabs).style.display = "block";
                    evt.currentTarget.className += " active";
                }
            </script>
        </div>
    </main>
</body>

</html>