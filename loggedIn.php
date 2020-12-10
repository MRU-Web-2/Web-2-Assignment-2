<?php

session_start();
// if user id not in session then redirect back to login screen
if ( ! isset($_SESSION['user'])) {
  header('Location: login.php');
  exit();
}


$paintingsURL = 'https://assignment2-297900.uc.r.appspot.com/api-paintings.php';
$paintingsData = json_decode(file_get_contents($paintingsURL));

// If the favourites exist and is not empty, this will run (view below to see where used)
function printAllPaintingsAsImages($paintingsData) {
    $favourites = $_SESSION['favs'];
    foreach ($favourites as $paintingID) {
        printSinglePainting($paintingID, $paintingsData);
    }
}
function printSinglePainting($paintingID, $paintingsData) {
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
function noFavourites() {
    echo "<div id='emptyFavourites'>There are no favourites here yet</div>";
}


?>

<html>

<head>
<title>
Assignment 2 - Home Page
</title>
<style>
  body{
background-image: url('images/payson-wick-vGLXKqCY66Y-unsplash.jpg');
background-size: cover;
background-repeat: no-repeat;
margin: 50px auto;
    text-align: center;
    width: 100%;
}
.row {
  display: flex;
  height:700px;	
}
.row1 {
  display: block;
  border:5px solid white;
  height:400px;
  text-align:center;
  
}.row2 {
  display: flex;
  border:5px solid white;
  height:300px;
}
.row3 {
  display: flex;
 
  height:150px;
  text-align:center;
  
}.row4 {
  display: flex;
  border-top:10px solid white;
  height:300px;
}
h1{

margin:15px auto;
}
#c {
  flex: 50%;
  
  background-color:lightgrey;
}
.column1 {
  border:10px solid white;
  
}
.column2 {
  border:15px solid white;
}
input {
    position: relative;
    border: 1px solid #ccc;
    border-radius: 1em;
    font-size: 1.5rem;
    margin:10 180;
    font-family:sans-serif;
    padding: 10px;
	
 
}
header{
  display: flex;
  height:80px;	
background-color:lightgrey;
border-top:0px solid white;
border-left:15px solid white;
border-right:15px solid white;

}
</style>
</head>
<body>
<?php include("header.php");?>
<center>
<div class="row">
  <div id="c" class="column1">	
  <div class="row1">
    <h1 >User Info</h1>
    <h2>Email Adress:       <u>test@gmail.com</u> </h2>
    <h2>Password:  <u> test1 </u></h2>
   
  
</div>
   <div class="row2"><h1>Favourites Paintings</h1></div>
  </div>
  <div id="c" class="column2">
   <div class="row3"> 
   <form action="search.php" method="GET">
    <h1>Search Paintings</h1>
    <input type="search" name="search"/>
    </form>
	</div>
   <div class="row4"><h1>Paintings You may like</h1></div>
  </div>
</div>
</center>

</body>
</html>