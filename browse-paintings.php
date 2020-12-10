<?php 

require_once('includes/stock-config.inc.php');
require_once('lib/assignment2-db-classes.inc.php');

// Adding the database connection to recieve saved rows 

try {
  $conn = DatabaseHelper::createConnection(array(DBCONNECTION, DBUSER, DBPASS));
  $artGateway = new ArtistDB($conn);
  $artists = $artGateway->getAll();
  $conn = null;
} catch (Exception $e) {
  die($e->getMessage());
}

function getAllArtists($artists) {
  foreach($artists as $row){
      getSingleArtists($row);
  }
}

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
  $paintingsURL = 'https://assignment2-297900.uc.r.appspot.com/api-paintings.php';
  $paintingsData = json_decode(file_get_contents($paintingsURL));
  $artists = array();
  $i = 0;
  foreach ($paintingsData as $painting) {
    echo "<script>console.log('Debug Objects: " . $i++ . "' );</script>";
    $found = false;
    foreach ($artists as $artist) {
      if ($painting->ArtistID == $artist->id) {
        $found = true;
        echo "<script>console.log('Debug Objects: FOUND'" . $artist->id . " );</script>";
      }
    }

    if ($found === false) { //if the artist is not already found in the array, add it to the array. 
      // $newArtist = (object) array('id' => $painting->ArtistID, 'name' => $painting->ArtistName);
      // array_push($artists, $newArtist);//adds a new element to the end of the array
      echo "<option value='$painting->ArtistID'>$painting->LastName</option>";
    }
  }

  // //now that the $artists array is complete, let's pump out the artists
  // foreach($artists as $artist){
  //   echo "<script>console.log('Debug Objects: " . $artist->id . "' );</script>";
  //   echo "<option value='$artist->id'>$artist->name</option>";
  // }
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
  <link href="./style/browse.css" rel='stylesheet'>
</head>

<body>

  <?php include("header.php"); ?>
  <main class="grid">

    <section class="grid-box" id="paintingFilter">
      <h2>Painting Filter</h2>
      <form>
        <label class="filter-label">Title</label>
        <input class="filter-input" id="title">
        </select></br>
        <label class="filter-label">Artist</label>
        <select class="filter-input" id="artist">
          <option value='0'>Select Artist</option>
          <?php
          getAllArtists($connection);
          ?>
        </select></br>
        <label class="filter-label">Gallery</label>
        <select class="filter-input" id="gallery">
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

        <tr class="left">
          <th></th> <!-- This col is where the paintings will go -->
          <th>Artist</th>
          <th>Title</th>
          <th>Year</th>
          <th></th> <!-- This col is where the Add Favorite buttons go -->
          <th></th> <!-- This col is where the View buttons go -->
        </tr>

        <tr class="left">
          <td><img src="./images/paintings/square/001050.jpg" class="table-img" /></td>
          <!--Photo-->
          <td>Pedro Janikan</td>
          <!--Artist-->
          <td>Self Portrait; Senhor homem bonito.</td>
          <!--Title-->
          <td>2021</td>
          <!--Year-->
          <td><a class="atf-button">Add To Favourites</a></td>
          <td><a class="view-button">View</a></td>
        </tr>

      </table>

    </section>



  </main>
</body>