<?php
class DatabaseHelper
{
    /* Returns a connection object to a database */
    public static function createConnection($values = array())
    {
        $connString = $values[0];
        $user = $values[1];
        $password = $values[2];
        $pdo = new PDO($connString, $user, $password);
        $pdo->setAttribute(
            PDO::ATTR_ERRMODE,
            PDO::ERRMODE_EXCEPTION
        );
        $pdo->setAttribute(
            PDO::ATTR_DEFAULT_FETCH_MODE,
            PDO::FETCH_ASSOC
        );
        return $pdo;
    }
    /*
     Runs the specified SQL query using the passed connection and
     the passed array of parameters (null if none)
     */
    public static function runQuery(
        $connection,
        $sql,
        $parameters = array()
    ) {
        // Ensure parameters are in an array
        if (!is_array($parameters)) {
            $parameters = array($parameters);
        }
        $statement = null;
        if (count($parameters) > 0) {
            // Use a prepared statement if parameters
            $statement = $connection->prepare($sql);
            $executedOk = $statement->execute($parameters);
            if (!$executedOk) throw new PDOException;
        } else {
            // Execute a normal query
            $statement = $connection->query($sql);
            if (!$statement) throw new PDOException;
        }
        return $statement;
    }
}

class GalleryDB
{
    private static $baseSQL = "SELECT * FROM Galleries";

    public function __construct($connection)
    {
        $this->pdo = $connection;
    }

    public function getAll()
    {
        $sql = self::$baseSQL;
        $statement =
            DatabaseHelper::runQuery($this->pdo, $sql, null);
        return $statement->fetchAll();
    }

    public function getAllForGallery($galleryID)
    {
        $sql = self::$baseSQL . " WHERE GalleryID=?";
        $statement = DatabaseHelper::runQuery(
            $this->pdo,
            $sql,
            array($galleryID)
        );
        return $statement->fetchAll();
    }
}

class PaintingDB
{
    private static $baseSQL = "SELECT * FROM Paintings";

    public function __construct($connection)
    {
        $this->pdo = $connection;
    }

    public function getAll()
    {
        $sql = self::$baseSQL;
        $statement =
            DatabaseHelper::runQuery($this->pdo, $sql, null);
        return $statement->fetchAll();
    }

    public function getAllForPainting($galleryID)
    {
        $sql = self::$baseSQL . " WHERE GalleryID=?";
        $statement = DatabaseHelper::runQuery(
            $this->pdo,
            $sql,
            array($galleryID)
        );
        return $statement->fetchAll();
    }

    public function getDetailPainting($paintingID)
    {
        $sql = 'SELECT GalleryID, Title, YearOfWork, FirstName, LastName, ImageFileName, Medium, Description, Width, Height, CopyrightText, WikiLink, MuseumLink, JsonAnnotations FROM Paintings INNER JOIN Artists ON Paintings.ArtistID = Artists.ArtistID WHERE PaintingID=?';
        $statement = DatabaseHelper::runQuery(
            $this->pdo,
            $sql,
            array($paintingID)
        );
        return $statement->fetchAll();
    }
}

class ArtistDB
{
    private static $baseSQL = "SELECT * FROM Artists";

    public function __construct($connection)
    {
        $this->pdo = $connection;
    }

    public function getAll()
    {
        $sql = self::$baseSQL;
        $statement =
            DatabaseHelper::runQuery($this->pdo, $sql, null);
        return $statement->fetchAll();
    }

    public function getAllForArtist($artistID)
    {
        $sql = self::$baseSQL . " WHERE ArtistID=?";
        $statement = DatabaseHelper::runQuery(
            $this->pdo,
            $sql,
            array($artistID)
        );
        return $statement->fetchAll();
    }
}

class CustomerLogonDB
{
    private static $baseSQL = "SELECT * FROM customerlogon";

    public function __construct($connection)
    {
        $this->pdo = $connection;
    }

    public function getAll()
    {
        $sql = self::$baseSQL;
        $statement =
            DatabaseHelper::runQuery($this->pdo, $sql, null);
        return $statement->fetchAll();
    }

    public function getAllForArtist($aristID)
    {
        $sql = self::$baseSQL . " WHERE ArtistID=?";
        $statement = DatabaseHelper::runQuery(
            $this->pdo,
            $sql,
            array($artistID)
        );
        return $statement->fetchAll();
    }
}
