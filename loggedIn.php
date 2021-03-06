<?php

session_start();
// if user id not in session then redirect back to login screen
if (!isset($_SESSION['user'])) {
  header('Location: login.php');
  exit();
}

$customersURL = 'https://assignment2-297900.uc.r.appspot.com/api-customers.php';
$customerData = json_decode(file_get_contents($customersURL));

foreach ($customerData as $cd) {
  if ($cd->CustomerID == $_SESSION['user']) {
    $customer = $cd;
    break;
  }
}

$paintingsURL = 'https://assignment2-297900.uc.r.appspot.com/api-paintings.php';
$paintingsData = json_decode(file_get_contents($paintingsURL));

// If the favourites exist and is not empty, this will run (view below to see where used)
function printAllPaintingsAsImages($paintingsData)
{
  $favourites = $_SESSION['favs'];
  foreach ($favourites as $paintingID) {
    printSinglePainting($paintingID, $paintingsData);
  }
}
function printSinglePainting($paintingID, $paintingsData)
{
  foreach ($paintingsData as $p) {
    if ($p->PaintingID == $paintingID) {
      $painting = $p;
    }
  }
  echo "<a href='single-painting.php?painting=" . $paintingID . "'>";
  echo "<img src='painting.php?file=" . $painting->ImageFileName . "&size=square' style='width:200px;height:200px' alt='" . $painting->Title . "'>";
  echo "</a>";
}

// If there are no favourites yet, run this code
function noFavourites()
{
  echo "<div id='emptyFavourites'>There are no favorites here yet</div>";
}

function printUserInfo($customer)
{
  echo "<div>User Name: " . $customer->UserName . "</div>";
  echo "<div>Date Joined: " . $customer->DateJoined . "</div>";
}


?>
<!DOCTYPE html>
<html>

<head>
  <title>
    Assignment 2 - Home Page
  </title>
  <meta charset=utf-8>
  <!-- Hamburger Icon -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <style>
    <?php include 'style/loggedIn.css'; ?>
  </style>
</head>

<body style="background-image: url(./images/payson-wick-vGLXKqCY66Y-unsplash.jpg);
background-size: cover;
background-repeat: no-repeat;">
  <?php include("header.php"); ?>
  <main>
    <section class="boxStuff" id="userinfo">
      <h2>User Info</h2>
      <?php
      printUserInfo($customer);
      ?>
    </section>
    <section class="boxStuff" id="favourites">
      <h2>Favourites</h2>
      <?php
      if (isset($_SESSION['favs']) && !empty($_SESSION['favs'])) {
        printAllPaintingsAsImages($paintingsData);
      } else {
        noFavourites();
      }
      ?>
    </section>
    <section class="boxStuff" id="search">
      <h2>Search</h2>
      <form action="browse-paintings.php" method="GET">
        <input type="search" name="title" />
      </form>
    </section>
    <section class="boxStuff" id="maylike">
      <h2>Paintings You May Like</h2>

    </section>
  </main>
</body>

</html>