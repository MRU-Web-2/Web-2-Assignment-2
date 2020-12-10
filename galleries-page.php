<?php
/* add your PHP code here */

//https://www.codegrepper.com/code-examples/php/php+sort+json+array
function getGalleries()
{
    $galleriesURL = 'https://assignment2-297900.uc.r.appspot.com/api-galleries.php';
    $galleriesData = json_decode(file_get_contents($galleriesURL));

    usort($galleriesData, 'sortByName');

    foreach ($galleriesData as $row) {
        echo "<li>";
        echo "<a href='" . $_SERVER['PHP_SELF'] . "?gallery=" . $row->GalleryID . "'>";
        echo $row->GalleryName;
        echo "</a></li>";
    }
}

function sortByName($a, $b)
{
    return  $a->GalleryName > $b->GalleryName;
}

function sortByArtist($a, $b) { 
    return a$->ArtistLastName 
}

function getPaintings()
{
    $paintingsURL = 'https://assignment2-297900.uc.r.appspot.com/api-paintings.php';
    $paintingsData = json_decode(file_get_contents($paintingsURL));
    echo "<h3 class='is-size-5 has-text-weight-medium'>Paintings</h3>";
    echo "<table class='table'>";
    echo "<tr>";
    echo "<th>Artist</th>";
    echo "<th>Title</th>";
    echo "<th>Year</th>";
    echo "</tr>";
    foreach ($paintingsData as $row) {
        if ($row->GalleryID == $_GET['gallery']) {
            echo "<tr>";
            $filename = generateFile($row->ImageFileName) . ".jpg";
            echo "<td>" . "<img src='./images/paintings/square/" . $filename . "' class='table-img'></td>";
            echo "<td>" . $row->Title . "</td>";
            echo "<td>" . $row->YearOfWork . "</td>";
            echo "</tr>";
        }
    }
    echo "</table>";
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

?>
<!DOCTYPE html>
<html lang=en>

<head>
    <title>Lab 14</title>
    <meta charset=utf-8>
    <!-- These 3 references are taken from Lab14a. Might remove and remodel to our own CSS if we have time. -->
    <link href='http://fonts.googleapis.com/css?family=Merriweather' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.4.1/semantic.min.css" rel="stylesheet">
    <!-- This reference is for the hamburger icon, taken from: fontawesome.com-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="./style/galleries.css" rel='stylesheet'>
</head>

<body>
    <?php include("header.php"); ?>
    <main class="grid">
        <section class="grid-box" id="paintingFilter">
            <h2>Painting Filter</h2>
            <?php
            getGalleries();
            ?>
        </section>

        <section class="grid-box" id="paintings">
            <h2>Paintings</h2>
            <?php
            getPaintings();
            ?>
        </section>
    </main>
    <footer class="ui black inverted segment">
        <div class="ui container">This is the footer</div>
    </footer>
</body>