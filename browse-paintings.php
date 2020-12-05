<?php
require_once 'header.php';


?>

<!DOCTYPE html>
<html lang=en>
<head>
    <title>Lab 14</title>
    <meta charset=utf-8>
    <link href='http://fonts.googleapis.com/css?family=Merriweather' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.4.1/semantic.min.css" rel="stylesheet">
    <link href="./style/browse.css" rel='stylesheet'>
</head>
<body>
    <?= createHeader(); ?>
<main class="grid">



    <section class="grid-box" id="paintingFilter">
        <h2>Painting Filter</h2>
        <form>
            <label>Title</label>
            <input name="title">
            </select></br>
            <label>Artist</label>
            <select name="artist">
            </select></br>
            <label>Gallery</label>
            <select name="gallery">
            </select></br>

            <h4>Year</h4>
            <input type="Radio" id="before" name="year" value="before">
            <label for="before">Before</label>
            <input name="before-text"></br>

            <input type="Radio" id="after" name="year" value="after">
            <label for="after">After</label>
            <input name="after-text"></br>

            <input type="Radio" id="between" name="year" value="between">
            <label for="between">Between</label>
            <input name="between-text"></br>

            <input type="submit" value="Filter">
            <input type="submit" value="Clear">
        </form>

    </section>

    
    <section class="grid-box" id="paintings">
      <h2>Paintings</h2>

      <table>

        <th></th> <!-- This col is where the paintings will go -->
        <th>Artist</th>
        <th>Title</th>
        <th>Year</th>
        <th></th> <!-- This col is where the Add Favorite buttons go -->
        <th></th> <!-- This col is where the View buttons go -->

        

      </table>

    </section>



</main>
<footer class="ui black inverted segment">
  <div class="ui container">This is the footer</div>
</footer>
</body>