<?php
require_once 'config.inc.php';
require_once 'assignment2-db-classes.inc.php';

// Tell the browser to expect JSON rather than HTML
header('Content-type: application/json');
// indicate whether other domains can use this API
header("Access-Control-Allow-Origin: *");

try {
    $conn = DatabaseHelper::createConnection(array(
        DBCONNSTRING,
        DBUSER, DBPASS
    ));
    $gateway = new PaintingDB($conn);
    if (isCorrectQueryStringInfo("gallery")) {
        $paintings = $gateway->getAllForPainting($_GET["gallery"]);
    } else if (isCorrectQueryStringInfo("painting")) {
        $paintings = $gateway->getDetailPainting($_GET["painting"]);
    } else {
        $paintings = $gateway->getAll();
    }

    echo json_encode($paintings, JSON_NUMERIC_CHECK);
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
