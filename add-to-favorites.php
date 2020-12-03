<?php
session_start();
$list = $_SESSION['favorite'];
array_push($list, $_GET['id']);
$_SESSION['favorite'] = $list;
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
            <input type='hidden' name='painting' value='<?= $_GET["id"] ?>'>
            <input type='submit' value='Close'>
        </form>
    </main>
</body>

</html>