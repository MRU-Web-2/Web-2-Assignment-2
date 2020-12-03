<?php
if (isset($_GET['file']) && isset($_GET['size'])) {
    $file = $_GET['file'];
    $size = $_GET['size'];
    if (strlen((string)$file) == 4) {
        $file =  "00" . (string)$file;
    } else if (strlen((string)$file) == 5) {
        $file =  "0" . (string)$file;
    }
    header('Content-Type: image/jpeg');
    $imgname = "images/paintings/$size/$file.jpg";
    $img = imagecreatefromjpeg($imgname);
    imagejpeg($img);
}
