<?php
session_start();

if ( ! isset($_SESSION['user'])) {
    header('Location: login.php');
    exit();
}


if ( isset($_GET['painting']) && in_array($_GET['painting'], $_SESSION['favs'])) {
    $var=array_search($_GET['painting'], $_SESSION['favs']);
    unset($_SESSION['favs'][$var]);
}

header('Location: favourites.php');
?>