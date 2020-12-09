

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
    <link href="./style/browse.css" rel='stylesheet'>
</head>
<body>
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
            </select></br>
            <label class="filter-label">Gallery</label>
            <select class="filter-input" id="gallery">
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
          <th><img src="./images/paintings/square/001050.jpg" class="table-img"/></th> <!--Photo-->
          <th>Pedro Janikan</th> <!--Artist-->
          <th>Self Portrait; Senhor homem bonito.</th> <!--Title-->
          <th>2021</th><!--Year-->
          <th><a class="atf-button">Add To Favourites</a></th>
          <th><a class="view-button">View</a></th>
        </tr>      

      </table>

    </section>



</main>
<footer class="ui black inverted segment">
  <div class="ui container">This is the footer</div>
</footer>
</body>