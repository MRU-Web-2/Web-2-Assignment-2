<?php
if (isset($_GET['painting'])) {
    $paintingID = $_GET['painting'];
    $paintingURL = 'http://localhost/COMP%203512/Web-2-Assignment-2/api-paintings.php?painting=' . $paintingID;
    $paintingData = json_decode(file_get_contents($paintingURL));
    echo gettype($paintingData[0]->JsonAnnotations);
}

?>
<html>

<head>
    <meta charset="utf-8" />
    <title>Painting Details Page</title>
</head>

<body>
    <main>
        <div>
            <header>
                <p>Header</p>
            </header>
        </div>
        <div>
            <img src='painting.php?file=00<?= $paintingData[0]->ImageFileName ?>&size=square-medium'>
            <P>Painting Title: <?= $paintingData[0]->Title ?></P>
            <P>Artist Name: <?= $paintingData[0]->FirstName . " " . $paintingData[0]->LastName ?></P>
            <P>Gallery Name</P>
            <P>Year: <?= $paintingData[0]->YearOfWork ?></P>
            <div>
                <div>
                    <P>Desciption: <?= $paintingData[0]->Description ?></P>
                </div>
                <div>
                    <p>Details</p>
                    <p>Medium: <?= $paintingData[0]->Medium ?></p>
                    <p>Width: <?= $paintingData[0]->Width ?></p>
                    <p>Height: <?= $paintingData[0]->Height ?></p>
                    <p>Copyright: <?= $paintingData[0]->CopyrightText ?></p>
                    <p>Wiki link: </p><a href="<?= $paintingData[0]->WikiLink ?>"><?= $paintingData[0]->WikiLink ?></a>
                    <p>Museum link: </p><a href="<?= $$paintingData[0]->MuseumLink ?>"><?= $paintingData[0]->MuseumLink ?></a>
                </div>
                <div>
                    <P>Colors: display the dominant colors field (color box, hex, color name)</P>
                    <?= $paintingData[0]->JsonAnnotations ?>
                </div>

            </div>

        </div>
    </main>
</body>

</html>