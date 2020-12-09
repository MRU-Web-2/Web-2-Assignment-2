<?php
/* This code was originally copied from lab14a */

function addSortAndLimit($sqlOld) {
    $sqlNew = $sqlOld . " ORDER BY YearOfWork limit 20";
    return $sqlNew;
}


function makeArtistName($first, $last) {
    return utf8_encode($first . ' ' . $last);
}


/*
  You will likely need to implement functions such as these ...
*/
function getAllGalleries($connection) {

    $galGateway = new GalleryDB($connection);
    $galleries = $galGateway->getAll();

    foreach($galleries as $row){
        getSingleGallery($row);
    }

}

function getSingleGallery($row){
    echo "<option value='" . $row['GalleryID'] . "'>" . $row['GalleryName'] . "</option>";
}

function getAllPaintings($connection) {
    $paintGateway = new PaintingDB($connection);
    $paintings = $paintGateway->getTop20();

    foreach($paintings as $row){
        getSinglePainting($row['PaintingID'], $row['ImageFileName'], $row['Title'], $row['FirstName'], $row['LastName'], $row['Excerpt'], $row['YearOfWork']);
    }
}

function getSinglePainting($id, $src, $title, $first, $last, $desc, $year){
    echo "<li class='item'>";
    echo "<a class='ui small image' href='single-painting.php?id=$id'><img src='images/art/works/square-medium/$src.jpg'></a>";
    echo "<div class='content'>";
    echo "<a class='header' href='single-painting.php?id=$id'>$title</a>";
    echo "<div class='meta'><span class='cinema'>$first $last</span></div>";        
    echo "<div class='description'>";
    echo "<p>$desc</p>";
    echo "</div>";
    echo "<div class='meta'>";     
    echo "<strong>$year</strong>";
    echo "</div>";        
    echo "</div>";      
    echo "</li>";
}

function getPaintingsByGallery($connection, $gallery) {
    $paintGateway = new PaintingDB($connection);
    $paintings = $paintGateway->getAllForGallery($gallery);

    foreach($paintings as $row){
        getSinglePainting($row['PaintingID'], $row['ImageFileName'], $row['Title'], $row['FirstName'], $row['LastName'], $row['Excerpt'], $row['YearOfWork']);
    }
}


?>