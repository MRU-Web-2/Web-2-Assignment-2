<?php
session_start();

if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit();
}

if (!isset($_SESSION['favs'])) {
    $_SESSION['favs'] = array();
}
if (isset($_GET['painting']) && !in_array($_GET['painting'], $_SESSION['favs'])) {
    array_push($_SESSION['favs'], $_GET['painting']);
}

header('Location: favourites.php');
