<?php
// Adding the database connection to recieve saved rows 
session_start();
function getSingleArtist($row)
{
  echo "<option value='" . $row['ArtistID'] . "'>" . $row['LastName'] . "</option>";
}

function getGalleries()
{
  $galleriesURL = 'https://assignment2-297900.uc.r.appspot.com/api-galleries.php';
  $galleriesData = json_decode(file_get_contents($galleriesURL));

  foreach ($galleriesData as $gallery)
    echo "<option value='$gallery->GalleryName'>$gallery->GalleryName</option>";
}

function getArtists()
{
  $artistsURL = 'https://assignment2-297900.uc.r.appspot.com/api-artists.php';
  $artistsData = json_decode(file_get_contents($artistsURL));

  foreach ($artistsData as $artist)
    echo "<option value='$artist->ArtistID'>$artist->FirstName $artist->LastName</option>";
}

function generateRows()
{
  //getting all the paintings
  $paintingsURL = 'https://assignment2-297900.uc.r.appspot.com/api-paintings.php';
  $paintingsData = json_decode(file_get_contents($paintingsURL));
  usort($paintingsData, "cmp");
  $tablePaintings = array();

  if (isset($_GET['sort'])) {
    $sort = $_GET['sort'];
    if ($sort == "t") {
      usort($paintingsData, "cmpByTitle");
      echo "<script>console.log('Sort by Title');</script>";
    } else if ($sort == "a") {
      usort($paintingsData, "cmpByArtist");
      echo "<script>console.log('Sort by Artist');</script>";
    } else if ($sort == "y") {
      usort($paintingsData, "cmpByYear");
      echo "<script>console.log('Sort by Year');</script>";
    }
  }

  $title = "";
  if (isset($_GET['title']))
    $title = $_GET['title'];
  if (isset($_GET['artist']))
    $artist = $_GET['artist'];
  if (isset($_GET['gallery']))
    $gallery = $_GET['gallery'];
  if (isset($_GET['before']))
    $before = $_GET['before'];
  if (isset($_GET['after']))
    $after = $_GET['after'];
  if (isset($_GET['between']))
    $between = $_GET['between'];

  // if any of the filters are set, then display the filters
  if ($title != "" || (isset($artist) && $artist != 0) || (isset($_GET['gallery']) && $_GET['gallery'] != 0) || isset($_GET['before-text']) || isset($_GET['after-text']) || isset($_GET['between-text'])) {
    echo "<script>console.log('Filters found: Title:$title, Artist:$artist, Gallery:$gallery');</script>";

    //if a title isset
    if ($title != "") {
      foreach ($paintingsData as $painting) {
        if (strpos($painting->Title, $title) != false) { //if the title form data is part of the title
          //echo "<script>console.log('Adding PaintingID:$painting->$PaintingID');</script>";
          array_push($tablePaintings, $painting); //add the painting to the list of paintings to be added to the talbe
        }
      }
    }

    //if an artist isset
    if ($artist !== 0 && isset($artist)) { //if there is an artist selected
      foreach ($paintingsData as $painting) {
        echo "<script>console.log('$painting->ArtistID');</script>";
        if ($artist == $painting->ArtistID) { //if the ArtistIDs are the same
          //echo "<script>console.log('Adding PaintingID:$painting->$PaintingID');</script>";
          array_push($tablePaintings, $painting);
        }
      }
    }

    //if a gallery isset
    if ($_GET['gallery'] !== 0 && isset($_GET['gallery'])) { //if there is a gallery selected
      foreach ($paintingsData as $painting) {
        if ($_GET['gallery'] == $painting->GalleryID) {
          array_push($tablePaintings, $painting);
        }
      }
    }

    //if before-text is set
    if (isset($_GET['before-text'])) {
      foreach ($paintingsData as $painting) {
        if ($painting->YearOfWork < $_GET['before-text']) {
          array_push($tablePaintings, $painting);
        }
      }
    }

    //if after-text is set
    if (isset($_GET['after-text'])) {
      foreach ($paintingsData as $painting) {
        if ($_GET['after-text'] < $painting->YearOfWork) {
          array_push($tablePaintings, $painting);
        }
      }
    }

    //if between-text is set
    if (isset($_GET['before-between']) || isset($_GET['after-between'])) {
    }


    foreach ($tablePaintings as $tablePainting) {
      getSinglePainting($tablePainting);
    }
  } else {
    //if not, display the top 20 paintings by year

    echo "<script>console.log('No filters found');</script>";
    for ($i = 0; $i < 20; $i++) {
      getSinglePainting($paintingsData[$i]);
    }
  }
}

function cmpByYear($a, $b)
{
  return strcmp($a->YearOfWork, $b->YearOfWork);
}
function cmpByArtist($a, $b)
{
  return strcmp($a->ArtistID, $b->ArtistID);
}
function cmpByTitle($a, $b)
{
  return strcmp($a->Title, $b->Title);
}

function getSinglePainting($painting)
{
  echo "<tr class='left'>";
  echo "<td><img src='https://assignment2-297900.uc.r.appspot.com/painting.php?file=$painting->ImageFileName&size=square-medium' title='$painting->ImageFileName' class='table-img'/></td>";
  echo "<td>" . getArtistNameWhereIDis($painting->ArtistID) . "</td>";
  echo "<td>$painting->Title</td>";
  echo "<td>$painting->YearOfWork</td>";
  //echo "<td><a href='add-to-favourites.php?painting=" . $painting->PaintingID . "' class='atf-button'>Add To Favourites</a></td>";
  if (isset($_SESSION['user']) && isset($_SESSION['favs']) && in_array($painting->PaintingID, $_SESSION['favs'])) {
    echo "<td><a href='remove-from-favourites.php?painting=" . $painting->PaintingID . "'><img src='./images/star/star.png'  class='atf-button'/></a></td>";
  } else {
    echo "<td><a href='add-to-favourites.php?painting=" . $painting->PaintingID . "'><img src='./images/star/empty-star.png'  class='atf-button'/></a></td>";
  }
  //echo "<td><a class='view-button'>View</a></td>";

  echo "<td><a href='single-painting.php?paintings=" . $painting->PaintingID . "'><img src='./images/view/view.png'  class='view-button'/></a></td>";
  echo "</tr>";
}

function getArtistNameWhereIDis($ArtID)
{
  $artistURL = 'https://assignment2-297900.uc.r.appspot.com/api-artists.php';
  $artistData = json_decode(file_get_contents($artistURL));

  foreach ($artistData as $artist) {
    if ($artist->ArtistID === $ArtID) {
      return ("" . $artist->FirstName . " " . $artist->LastName);
    }
  }
}

?>

<!DOCTYPE html>
<html lang=en>

<head>
  <title>Assignment 2 - Paintings</title>
  <meta charset=utf-8>
  <!-- These 3 references are taken from Lab14a. Might remove and remodel to our own CSS if we have time. -->
  <link href='http://fonts.googleapis.com/css?family=Merriweather' rel='stylesheet' type='text/css'>
  <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.4.1/semantic.min.css" rel="stylesheet">
  <!-- This reference is for the hamburger icon, taken from: fontawesome.com-->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <style>
    <?php include 'style/browse.css'; ?>
  </style>
</head>

<body style="background-image: url(./images/payson-wick-vGLXKqCY66Y-unsplash.jpg);
background-size: cover;
background-repeat: no-repeat;">
  <?php include("header.php"); ?>
  <main class="grid">

    <section class="grid-box" id="paintingFilter">
      <h2>Painting Filter</h2>
      <form action="./browse-paintings.php" method="GET">

        <label class="filter-label">Title</label>
        <?php
        if (isset($_SESSION['title'])) {
          echo "<input class='filter-input' name='title' id='title' content=" . $_SESSION['title'] . ">";
        } else {
          echo "<input class='filter-input' name='title' id='title'>";
        }
        ?>
        </select></br>
        <label class="filter-label">Artist</label>
        <select class="filter-input" name='artist' id="artist">
          <option value='0'>Select Artist</option>
          <?php
          getArtists();
          ?>
        </select></br>
        <label class="filter-label">Gallery</label>
        <select class="filter-input" name='gallery' id="gallery">
          <option value="0">Select Gallery</option>
          <?php
          getGalleries();
          ?>
        </select></br>

        <h4>Year</h4>
        <input type="Radio" id="before" name="year" value="before">
        <label for="before" class="filter-label">Before</label>
        <input class="filter-input" id="before-text"></br>

        <input type="Radio" id="after" name="year" value="after">
        <label for="after" class="filter-label">After</label>
        <input class="filter-input" id="after-text"></br>

        <input type="Radio" id="between" name="year" value="between">
        <label for="between" class="filter-label">Between</label>
        <input class="filter-input" id="between-text"></br>

        <input type="submit" value="Filter" class="filter-button" id="filter">
        <input type="submit" value="Clear" class="filter-button" id="clear">
      </form>

    </section>


    <section class="grid-box" id="paintings">
      <h2>Paintings</h2>

      <table class="table">

        <tr class="left top">
          <th></th> <!-- This col is where the paintings will go -->
          <th><a class="filter-button" href="./browse-paintings.php?title=<?= $_GET['title'] ?>&artist=<?= $_GET['artist'] ?>&gallery=<?= $_GET['gallery'] ?>&sort=a">Artist</a></th>
          <th><a class="filter-button" href="./browse-paintings.php?title=<?= $_GET['title'] ?>&artist=<?= $_GET['artist'] ?>&gallery=<?= $_GET['gallery'] ?>&sort=t">Title</a></th>
          <th><a class="filter-button" href="./browse-paintings.php?title=<?= $_GET['title'] ?>&artist=<?= $_GET['artist'] ?>&gallery=<?= $_GET['gallery'] ?>&sort=y">Year</a></th>
          <th></th> <!-- This col is where the Add Favorite buttons go -->
          <th></th> <!-- This col is where the View buttons go -->
        </tr>

        <?php
        generateRows();
        ?>
      </table>

    </section>



  </main>
</body>