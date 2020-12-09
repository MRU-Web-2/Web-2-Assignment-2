<!-- <?php

include('config.inc.php');





?> -->
<html>

<head>
<title>
 Home Page
</title>
<style>

* {
    padding: 0;
    margin: 0;
    box-sizing: border-box;
}
body{
background-image: url('images/payson-wick-vGLXKqCY66Y-unsplash.jpg');
background-size: cover;
background-repeat: no-repeat;
margin: 50px auto;
    text-align: center;
    width: 800px;
}
 a{
     position: relative;
    padding: 25px;
    font-size: 1.5rem;
    font-family: 'Lato';
    font-weight: 100;
    background:lightgrey;
    color: black;
    border: none;
    text-align: center;
    margin:50px ;
    margin-top:auto;
    border-color:darkblue;
 
    border-radius: 20px;
    
  
    
}

a:link {
  text-decoration: none;
}

a:visited {
  text-decoration: none;
}

a:hover {
  text-decoration: underline;
}

a:active {
  text-decoration: underline;
}
/* .button{
    background-color: black;
    border-radius: 20px;
    border: none;
  color: white;
  padding: 20px;
  text-align: center;
  text-decoration: none;
  display: inline-block;
  font-size: 16px;
  margin: 4px 2px;
  cursor: pointer;
} */
@media screen {
    
}
input {
    position: relative;
    border: 1px solid #ccc;
    border-radius: 1em;
    font-size: 1.5rem;
    
    font-family:sans-serif;
    padding: 10px;
}



.SearchBar input {
     width: 600px;
}
h1 {
    font-family:'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif;
    font-size: 3rem;
    text-transform: uppercase;
    margin-right: auto;
 margin-left: 0px;
}



</style>
</head>
<body ><center>
    <h1>Assignment 2</h1><br><br><br>
    <a href="#" id="a" type="button" name="register" value="register" on>Log In</a>
    <a href="#" id="b" type="button" name="register" value="register">Join</a><br><br><br><br>
    <div class="Searchbar">;
    <form action="browse.php" method="get" style="width: 800px; height: 150px">


        <!-- <select class="ui fluid dropdown" name="museum">
            <option value='0'>Select Museum</option>  
            <?php  
            //    /* add your PHP code here */
            //    try {
            //     $pdo = new PDO(DBCONNSTRING,DBUSER,DBPASS);
            //     $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            //     $sql = "select * from Galleries order by GalleryName";
            //     $result = $pdo->query($sql);
            //     $data = $result -> fetchAll(PDO::FETCH_ASSOC);
              
                
            //   foreach($data as $row){
            //     echo "<option value=" . $row['GalleryID'] .">" . $row['GalleryName'] . "</option>"; 
            //   }
              
            //   }
              
            //   catch (PDOException $e) {
            //     die( $e->getMessage() );
            //    }

            ?> -->
        </select>
    <input type="search" name="search"  />
    </form>
   </center>
</body>
</html>