<?php
/* add your PHP code here */
require_once('config.inc.php');
require_once('api-galleries');

try {
    $pdo = new PDO(DBCONNSTRING, DBUSER, DBPASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $galleries = getGalleries($pdo);
    if (isset($_GET['gallery'])) {
        $paintings = getPaintings($pdo, $_GET['gallery']);
    }
    $pdo = null;
} catch (PDOException $e) {
    die($e->getMessage());
}

function getGalleries($pdo)
{
    $sql = "SELECT GalleryID, GalleryName FROM Galleries
   ORDER BY GalleryName";
    $result = $pdo->query($sql);
    return $result->fetchAll(PDO::FETCH_ASSOC);
}

function getPaintings($pdo, $id)
{
    $sql = "SELECT PaintingID, Title, YearOfWork, ImageFileName
 FROM Paintings WHERE GalleryID=?";
    $statement = $pdo->prepare($sql);
    $statement->bindValue(1, $id);
    $statement->execute();
    return $statement->fetchAll(PDO::FETCH_ASSOC);
}

function outputGalleries($galleries)
{
    foreach ($galleries as $row) {
        echo "<li>";
        echo "<a href='" . $_SERVER['PHP_SELF'] . "?gallery=" . $row['GalleryID'] . "'>";
        echo $row['GalleryName'];
        echo "</a></li>";
    }
}
function outputPaintings($paintings)
{
    echo "<h3 class='is-size-5 has-text-weight-medium'>Paintings</h3>";
    echo "<table class='table'>";
    echo "<tr>";
    echo "<th>Artist</th>";
    echo "<th>Title</th>";
    echo "<th>Year</th>";
    echo "</tr>";
    foreach ($paintings as $row) {
        echo "<tr>";
        $filename = "./images/paintings/square/" . $row['ImageFileName'] . '.jpg';
        echo "<td>" . "<img src='" . $filename . "' class='table-img'></td>";
        echo "<td>" . $row['Title'] . "</td>";
        echo "<td>" . $row['YearOfWork'] . "</td>";
        echo "</tr>";
    }
    echo "</table>";
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
    <main class="grid">

        <?php include("header.php"); ?>
        <section class="grid-box" id="paintingFilter">
            <h2>Painting Filter</h2>
            <?php
            outputGalleries($galleries);
            ?>
        </section>

        <section class="grid-box" id <section class="grid-box" id="paintings">
            <h2>Paintings</h2>
            <?php
            if (isset($paintings) && count($paintings) > 0) {
                outputPaintings($paintings);
            }
            ?>
        </section>
    </main>
    <footer class="ui black inverted segment">
        <div class="ui container">This is the footer</div>
    </footer>
</body>