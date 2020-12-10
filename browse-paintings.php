<?php 
// Adding the database connection to recieve saved rows 
session_start();
function getSingleArtist($row){
  echo "<option value='" . $row['ArtistID'] . "'>" . $row['LastName'] . "</option>";
}

// Doesn't work for some reason....
// try{
//   $conn = DatabaseHelper::createConnection(array(DBCONNSTRING,DBUSER,DBPASS));

// } catch (Exception $e) {
//   die( $e->getMessage() );
// }

function getGalleries(){
  $galleriesURL = 'https://assignment2-297900.uc.r.appspot.com/api-galleries.php';
  $galleriesData = json_decode(file_get_contents($galleriesURL));

  foreach ($galleriesData as $gallery)
    echo "<option value='$gallery->GalleryName'>$gallery->GalleryName</option>";
}

function getArtists(){
  $artistsURL = 'https://assignment2-297900.uc.r.appspot.com/api-artists.php';
  $artistsData = json_decode(file_get_contents($artistsURL));

  foreach ($artistsData as $artist)
    echo "<option value='$artist->ArtistID'>$artist->FirstName $artist->LastName</option>";
}

function generateRows(){
  // if any of the filters are set, then display the filters
 if( isset($_GET['title']) || isset($_GET['artist']) || isset($_GET['gallery']) || isset($_GET['before-text']) || isset($_GET['after-text']) || isset($_GET['between-text']) ){
    echo "<script>console.log('');</script>";

 }
  //if not, display the top 20 paintings by year
  $paintingsURL = 'https://assignment2-297900.uc.r.appspot.com/api-paintings.php';
  $paintingsData = json_decode(file_get_contents($paintingsURL));
  usort($paintingsData, "cmp");

  for($i=0; $i<20; $i++){
    getSinglePainting($paintingsData[$i]);
  }
}

function cmp($a, $b) {
  return strcmp($a->YearOfWork, $b->YearOfWork);
}

function getSinglePainting($painting){
  echo "<tr class='left'>";
  echo "<td><img src='./images/paintings/square/$painting->ImageFileName.jpg' title='$painting->ImageFileName' class='table-img'/></td>";
  echo "<td>".getArtistNameWhereIDis($painting->ArtistID)."</td>";
  echo "<td>$painting->Title</td>";
  echo "<td>$painting->YearOfWork</td>";
  echo "<td><a href='add-to-favourites.php?painting=" . $painting->PaintingID . "' class='atf-button'>Add To Favourites</a></td>";
  echo "<td><a class='view-button'>View</a></td>";
  echo "</tr>";
}

function getArtistNameWhereIDis($ArtID){
  $artistURL = 'https://assignment2-297900.uc.r.appspot.com/api-artists.php';
  $artistData = json_decode(file_get_contents($artistURL));

  foreach($artistData as $artist){
    if($artist->ArtistID === $ArtID){
      return ("".$artist->FirstName." ".$artist->LastName);
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
  <link href="./style/browse.css" rel='stylesheet'>
</head>

<body>
<style>
       body{
background-image: url('images/payson-wick-vGLXKqCY66Y-unsplash.jpg');
background-size: auto;
background-repeat: repeat;
/* margin: 50px auto;
    text-align: center; */
    width: 100%;
}

</style>

  <?php include("header.php"); ?>
  <main class="grid">

    <section class="grid-box" id="paintingFilter">
      <h2>Painting Filter</h2>
      <form action="./browse-paintings.php" method="GET">
        
        <label class="filter-label">Title</label>
        <?php
          if ( isset($_SESSION['title'])) {
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

        <?php 
          generateRows();
        ?>
      </table>

    </section>



  </main>
</body>