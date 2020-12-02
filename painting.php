<?php
if (isset($_GET['file']) && isset($_GET['size'])) {
    $file = $_GET['file'];
    $size = $_GET['size'];
    header('Content-Type: image/jpeg');
    $imgname = "images/paintings/$size/$file.jpg";

    $img = imagecreatefromjpeg($imgname);
    imagejpeg($img);
}
