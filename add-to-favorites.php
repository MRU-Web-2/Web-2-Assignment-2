<?php
include_once('includes/stock-config.inc.php');
include_once('lib/assignment2-db-classes.inc.php');

// session_set_cookie_params(0);
// session_start();
// $list = $_SESSION['favorite'];
// array_push($list, $_GET['id']);
// $_SESSION['favorite'] = $list;
header("Access-Control-Allow-Origin: *");

try {
    echo "TEST";
    $conn = DatabaseHelper::createConnection(array(DBCONNECTION, DBUSER, DBPASS));
    $gateway = new CustomerDB($conn);

    $customer = $gateway->getAll();
} catch (Exception $e) {
    die($e->getMessage());
}

?>
<html>

<head>
    <meta charset="utf-8" />
    <title>Painting Details Page</title>
</head>

<body>
    <main>
        <p>painting sucessfully added</p>
        <form action='single-painting.php' method="get">
            <input type='hidden' name='painting' value='7'>
            <input type='submit' value='Close'>
        </form>
    </main>
</body>
<!-- <?= $_GET["id"] ?> -->
</html>