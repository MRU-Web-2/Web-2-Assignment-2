<?php
require_once('includes/stock-config.inc.php');
require_once('lib/assignment2-db-classes.inc.php');

// Tell the browser to expect JSON rather than HTML
header('Content-type: application/json');
// indicate whether other domains can use this API
header("Access-Control-Allow-Origin: *");

try {
    $conn = DatabaseHelper::createConnection(array(DBCONNECTION, DBUSER, DBPASS));
    $gateway = new ArtistDB($conn);
    $artists = $gateway->getAll();


    echo json_encode($galleries, JSON_NUMERIC_CHECK);
} catch (Exception $e) {
    die($e->getMessage());
}

function isCorrectQueryStringInfo($param)
{
    if (isset($_GET[$param]) && !empty($_GET[$param])) {
        return true;
    } else {
        return false;
    }
}
