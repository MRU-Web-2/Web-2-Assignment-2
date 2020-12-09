<!DOCTYPE html>
<html lang=en>
<head>
    <title>Paintings</title>
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

<?php 
// Adding the database connection to recieve saved rows 
// try{
//   $conn = DatabaseHelper::createConnection(array(DBCONNSTRING,DBUSER,DBPASS));
// } catch (Exception $e) {
//   die( $e->getMessage() );
// }
if (isset($_GET['painting'])) {
  $paintingID = $_GET['painting'];
  $paintingURL = 'https://assignment2-297900.uc.r.appspot.com/api-paintings.php?painting=' . $paintingID;
  $paintingData = json_decode(file_get_contents($paintingURL));
  $color = json_decode($paintingData[0]->JsonAnnotations);
  $file = generateFile($paintingData[0]->GalleryID);

  echo "<option value='1'>Gallery</option>";

} else {
}
//   if (isset($_GET['painting'])) {
//     $paintingID = $_GET['painting'];
//     $paintingURL = 'https://assignment2-297900.uc.r.appspot.com/api-paintings.php?painting=' . $paintingID;
//     $galleryData = json_decode(file_get_contents($paintingURL));
//     $color = json_decode($galleryData[0]->JsonAnnotations);
//     $file = generateFile($galleryData[0]->ImageFileName);
// } else {
// }
}

?>

<main class="grid">

    <?php include("header.php");?>


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
                getGalleries();
              ?>
            </select></br>
            <label class="filter-label">Gallery</label>
            <select class="filter-input" id="gallery">
              <option value="0">Select Gallery</option>
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
          <td><img src="./images/paintings/square/001050.jpg" class="table-img"/></td> <!--Photo-->
          <td>Pedro Janikan</td> <!--Artist-->
          <td>Self Portrait; Senhor homem bonito.</td> <!--Title-->
          <td>2021</td><!--Year-->
          <td><a class="atf-button">Add To Favourites</a></td>
          <td><a class="view-button">View</a></td>
        </tr>      

      </table>

    </section>



</main>
<footer class="ui black inverted segment">
  <div class="ui container">This is the footer</div>
</footer>
</body>