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
<main>



    <section class="grid-box" id="paintingFilter">
        <h2>Painting Filter</h2>
        <form>
            <label>Title</label>
            <input name="title">
            </select></br>
            <label>Artist</label>
            <select name="title">
            </select></br>
            <label>Gallery</label>
            <select name="title">
            </select></br>

            <input type="Radio" id="before" name="year" value="before">
            <label for="before">Before</label></br>
            <input type="Radio" id="after" name="year" value="after">
            <label for="after">After</label></br>
            <input type="Radio" id="between" name="year" value="between">
            <label for="between">Between</label></br>

            <input type="submit" value="Filter">
            <input type="submit" value="Clear">
        </form>

    </section>

    
    <section class="grid-box" id="paintings">
        <h2>Paintings</h2>
    </section>



</main>
<footer class="ui black inverted segment">
  <div class="ui container">This is the footer</div>
</footer>
</body>