<?php
/* add your PHP code here */

//https://www.codegrepper.com/code-examples/php/php+sort+json+array
function getGalleries()
{
    $galleriesURL = 'https://assignment2-297900.uc.r.appspot.com/api-galleries.php';
    $galleriesData = json_decode(file_get_contents($galleriesURL));

    usort($galleriesData, 'sortByName');

    return $galleriesData;
}

function sortByName($a, $b)
{
    return  $a->GalleryName > $b->GalleryName;
}

function getPaintings($galleryID)
{
    $paintingsURL = 'https://assignment2-297900.uc.r.appspot.com/api-paintings.php?gallery=' . $galleryID;
    $paintingsData = json_decode(file_get_contents($paintingsURL));
    return $paintingsData;

    /* echo "<h3 class='is-size-5 has-text-weight-medium'>Paintings</h3>";
    echo "<table class='table'>";
    echo "<tr>";
    echo "<th id='artist'>Artist</th>";
    echo "<th id='title'>Title</th>";
    echo "<th id='year'>Year</th>";
    echo "</tr>";
    foreach ($paintingsData as $row) {
        if ($row->GalleryID == $_GET['gallery']) {
            echo "<tr>";
            $filename = generateFile($row->ImageFileName) . ".jpg";
            echo "<td>" . "<img src='./images/paintings/square/" . $filename . "' class='table-img'></td>";
            echo "<td>" . $row->Title . "</td>";
            echo "<td>" . $row->YearOfWork . "</td>";
            echo "</tr>";
        }
    }
    echo "</table>";
    */
}

function boxA_Gen()
{
    echo "<section>";
    echo "<label></label>";
    echo "<h2 id='galleryName'></h2>";
    echo "<label>'Native Name:'</label>";
    echo "<span id='galleryNative'></span>";
    echo "<label>City:</label>";
    echo "<span id='galleryCity'></span>";
    echo "<label>Address:</label>";
    echo "<span id='galleryAddress'></span>";
    echo "<label>Country:</label>";
    echo "<span id='galleryCountry'></span>";
    echo "<label>Home:</label>";
    echo "<span><a href='' id='galleryHome'></a></span>";
    echo "</section>";
}

function boxB_Gen()
{
    echo "<section>";
    echo "<h2>Galleries</h2>";
    echo "<ul id='galleryList'></ul>";
    echo "</section>";
}

function boxC_Gen()
{
    echo "<section>";
    echo "<h2>Famous Paintings</h2>";
    echo "<table id='paintingList'>";
    echo "</table>";
    echo "</section>";
}

function generateFile($file)
{
    if (strlen((string)$file) == 4) {
        return "00" . (string)$file;
    } else if (strlen((string)$file) == 5) {
        return "0" . (string)$file;
    }
    return (string)$file;
}
?>
<!DOCTYPE html>
<html>

<head>
    <title>Lab 14</title>
    <meta charset=utf-8>
    <!-- These 3 references are taken from Lab14a. Might remove and remodel to our own CSS if we have time. -->
    <link href='http://fonts.googleapis.com/css?family=Merriweather' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.4.1/semantic.min.css" rel="stylesheet">
    <!-- This reference is for the hamburger icon, taken from: fontawesome.com-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="./style/galleries.css" rel='stylesheet'>
</head>

<body>
    <?php include("header.php"); ?>
    <main class="container">
        <div class="box a">
            <?php
            boxA_Gen();
            ?>
        </div>
        <div class="box b">
            <?php
            boxB_Gen();
            ?>
        </div>
        <div class="box d">
            <div id="map"></div>
        </div>
        <div class="box c">
            <?php
            boxC_Gen();
            ?>
        </div>
    </main>
    <footer class="ui black inverted segment">
        <div class="ui container">This is the footer</div>
    </footer>
    <script>
        /** 
         * Borrows design elements of Lab 10 test your knowledge 5, though it has been altered 
         * CSS modal help from https://www.w3schools.com/howto/tryit.asp?filename=tryhow_css_modal_img
         *
         * @Author: Moonum Azmi 
         * @Class: COMP3512 
         *
         */


        var map;


        /**
         * Initializes google map
         *
         */

        function initMap() {

            map = new google.maps.Map(document.getElementById('map'), {
                center: {
                    lat: 41.89474,
                    lng: 12.4839
                },
                zoom: 18
            });
        }

        /**
         * Automatically moves to location on google maps 
         * Functionality from https://stackoverflow.com/questions/12699300/move-google-map-center-javascript-api
         *
         * @param lat 
         * Passes in the latitude of location that is to be travelled to
         *
         * @param lng
         * Passes in the longitude of location that is to be travelled to
         *
         */

        function moveLocation(lat, lng) {

            const center = new google.maps.LatLng(lat, lng);
            // using global variable:
            window.map.panTo(center);
        }


        /**
         * Automatically moves to location on google maps 
         * Method borrowed from https://stackoverflow.com/questions/12699300/move-google-map-center-javascript-api
         *
         * @param map
         * Passes in map to perform google map functionality
         *
         * @param latitude
         * Passes in the latitude of location that is to be marked
         *
         * @param longitude
         * Passes in the longitude of location that is to be marked
         *
         * @param city
         * Passes in name of city to use as name
         *
         */

        function createMarker(map, latitude, longitude, city) {

            let imageLatLong = {
                lat: latitude,
                lng: longitude
            };
            let marker = new google.maps.Marker({
                position: imageLatLong,
                title: city,
                map: map
            });
            document.getElementById('map')
        }

        document.addEventListener("DOMContentLoaded", function() {
            //fetch gallery data from url 
            alert("This should be running");

            if (localStorage.hasOwnProperty("galleries")) {
                let galleriesData = Array.from(localStorage.getItem("galleries"));
            } else {
                let galleriesData = Array.from(<?php echo json_encode(getGalleries()); ?>);
            }

            //pass that data to populateGallery function
            galleriesData.foreach(g => {
                populateGallery(g);
            });

            /**
             * Populates box b with fetched array of galleries
             *
             * @param galleries
             * Passes fetched array of galleries to populate gallery list
             *
             */

            function populateGallery(galleries) {

                //Select unordered list
                //Populate it with list items that contain attribute data of gallery to pass on
                let uList = document.querySelector('#galleryList');
                uList.innerHTML = "";

                //loop through galleries to produce list items of gallerys
                //contains information about particular gallery in it's attributes
                galleries.forEach(g => {
                    let li = document.createElement('li');
                    li.textContent = g.GalleryName;
                    li.setAttribute('natName', g.GalleryNativeName);
                    li.setAttribute('city', g.GalleryCity);
                    li.setAttribute('address', g.GalleryAddress);
                    li.setAttribute('country', g.GalleryCountry);
                    li.setAttribute('home', g.GalleryWebSite);
                    li.setAttribute('latitude', g.Latitude);
                    li.setAttribute('longitude', g.Longitude);
                    li.setAttribute('id', g.GalleryID);
                    uList.appendChild(li);
                });

                //adds event listeners on all list items so their attributes populate box a.
                document.querySelectorAll("li").forEach(listItem => {
                    listItem.addEventListener('click', (e) => {

                        //assign variables to transfer to galDetails function
                        let name = e.target.textContent;
                        let natName = e.target.getAttribute('natName');
                        let city = e.target.getAttribute('city');
                        let address = e.target.getAttribute('address');
                        let country = e.target.getAttribute('country');
                        let home = e.target.getAttribute('home');
                        let lat = parseFloat(e.target.getAttribute('latitude'));
                        let lon = parseFloat(e.target.getAttribute('longitude'));

                        //Concat from https://www.w3schools.com/jsref/jsref_concat_string.asp
                        //Combines url with id of paintings to generate a specific gallery's list of paintings
                        let paintData = Array.from(<?php echo json_encode(getPaintings()); ?>);

                        //calls several functions to fulfill rest of the functionality
                        //box a filled with gallery details
                        galDetails(name, natName, city, address, country, home);
                        //marker created at location of gallery
                        createMarker(map, lat, lon, city);
                        //map is moved to location of gallery
                        moveLocation(lat, lon);
                        //painting list is generated based on gallery
                        createPaintings(e.target, paintData);
                    });
                });
            }

            /**
             * Generates and populates the details of galleries listed in Box a
             *
             * @param name
             * Passes the name of the gallery
             *
             * @param native
             * Passes the local name of the gallery
             *
             * @param city
             * Passes the name of the city the gallery is located in
             *
             * @param address
             * Passes the exact address its located
             *
             * @param country
             * Passes the name of the country the gallery is located
             *
             * @param home
             * Passes an updated URL of paintings to
             *
             */

            function galDetails(name, native, city, address, country, home) {

                //populates existing elements in HTML to populate box a
                let detail1 = document.querySelector('#galleryName');
                detail1.textContent = name;
                let detail2 = document.querySelector('#galleryNative');
                detail2.textContent = native;
                let detail3 = document.querySelector('#galleryCity');
                detail3.textContent = city;
                let detail4 = document.querySelector('#galleryAddress');
                detail4.textContent = address;
                let detail5 = document.querySelector('#galleryCountry');
                detail5.textContent = country;
                let detail6 = document.querySelector('#galleryHome');
                detail6.textContent = home;
            }

            /**
             * Sorts based on an artist's last name when user selects heading "Artist"  
             *
             * @param pTableSorter   
             * Passes Array of paintings to sort 
             *
             * @param gallery    
             * Passes details about Gallery for eventual use of populating details of large painting box 
             *
             */

            function artistLastNameSort(pTableSorter, gallery) {

                //sorts based on last name 
                pTableSorter.sort((a, b) => {
                    return a.LastName < b.LastName ? -1 : 1;
                });

                paintingTableCreate(pTableSorter, gallery);
            }

            /**
             * Sorts based on a painting title when user selects heading "Title"  
             *
             * @param pTableSorter   
             * Passes Array of paintings to sort  
             *
             * @param gallery    
             * Passes details about Gallery for eventual use of populating details of large painting box 
             *
             */

            function titleSort(pTableSorter, gallery) {

                //sorts based on title
                pTableSorter.sort((a, b) => {
                    return a.Title < b.Title ? -1 : 1;
                });

                paintingTableCreate(pTableSorter, gallery);
            }

            /**
             * Sorts based on year when user selects heading "Year"  
             *
             * @param pTableSorter   
             * Passes Array of paintings to sort  
             *
             * @param gallery    
             * Passes details about Gallery for eventual use of populating details of large painting box 
             *
             */

            function yearSort(pTableSorter, gallery) {

                //sorts based on year         
                pTableSorter.sort((a, b) => {
                    return a.YearOfWork < b.YearOfWork ? -1 : 1;
                });

                paintingTableCreate(pTableSorter, gallery);
            }

            /**
             * Generates a gallery of paintings to populate the paintbox  
             *
             * @param pArraySort   
             * Passes a sorted Array of paintings to populate the table 
             *
             * @param gallery    
             * Passes element gallery for event to transfer to largePaintingBox function
             *
             */

            function paintingTableCreate(pArraySort, gallery) {

                removeLoader(document.querySelector(".box.a section"));
                removeLoader(document.querySelector(".box.c section"));

                //creates tableBody to differentiate between contents and headings
                //empties itself to generate a new list based on a new passed sorted array
                let tableBody = document.querySelector('tbody');
                tableBody.innerHTML = "";

                //iterates through sorted array
                //generates a table of paintings and associated values through passed value  
                pArraySort.forEach(p => {
                    let row = document.createElement('tr');
                    row.setAttribute('id', 'tableRow');

                    //produces cell where painting thumnails are to be located 
                    let thumbnailCell = document.createElement('td');
                    let thumbnail = document.createElement('img');
                    thumbnail.setAttribute('src', imageBoxURL.concat(p.ImageFileName));
                    thumbnail.setAttribute('class', 'link');
                    thumbnail.setAttribute('id', p.PaintingID);
                    thumbnailCell.appendChild(thumbnail);

                    //produces cell where artist names are to be listed 
                    //if conditional to test whether said artist is referred to by only his last name or not
                    let artistCell = document.createElement('td');
                    if (p.FirstName == null) {
                        artistCell.textContent = p.LastName;
                    } else {
                        artistCell.textContent = (p.FirstName + " " + p.LastName);
                    }

                    //produces titlecell where titles are to be listed             
                    let titleCell = document.createElement('td');
                    titleCell.setAttribute('id', 'title');
                    titleCell.textContent = p.Title;

                    //produces yearcell where years are to be listed             
                    let yearCell = document.createElement('td');
                    yearCell.setAttribute('id', 'year');
                    yearCell.textContent = p.YearOfWork;

                    row.appendChild(thumbnailCell);
                    row.appendChild(artistCell);
                    row.appendChild(titleCell);
                    row.appendChild(yearCell);
                    tableBody.appendChild(row);

                    //display box c 
                    document.querySelector(".box.c section").style.display = "block";
                });

                //creating event handlers for all thumbnails
                //additionally generating an updated URL for further passing 
                document.querySelectorAll(".link").forEach(rows => {
                    rows.addEventListener('click', (e) => {
                        let paintUrlUpdate = url2.replace("gallery=", "id=").concat(e.target.getAttribute('id'));
                        paintBigWindow(e.target.src, paintUrlUpdate, gallery);
                    });
                });
            }
            alert("I have run");
        });
    </script>
</body>

</html>