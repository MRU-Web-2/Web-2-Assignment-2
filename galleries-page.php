<?php
/* add your PHP code here */
require_once 'asg2-helpers.inc.php';
include("header.php");

//function gets galleries data, invokes a sort function and returns data of galleries 
//https://www.codegrepper.com/code-examples/php/php+sort+json+array
function getGalleries()
{
    $galleriesURL = 'https://assignment2-297900.uc.r.appspot.com/api-galleries.php';
    $galleriesData = json_decode(file_get_contents($galleriesURL));

    usort($galleriesData, 'sortByName');

    return $galleriesData;
}

//function sorts galleries data by gallery name, then returns it
function sortByName($a, $b)
{
    return  $a->GalleryName > $b->GalleryName;
}

//function returns paintings url 
function getPaintings()
{
    return 'https://assignment2-297900.uc.r.appspot.com/api-paintings.php?gallery=';
}

//function gets artists data and returns it. Sadly it is defunct and doesn't work. 
function getArtists()
{
    $artistURL = "https://assignment2-297900.uc.r.appspot.com/api-artists.php";
    $artistData = json_decode(file_get_contents($artistURL));
    return $artistData;
}

//generates details of box A which hosts gallery details 
function boxA_Gen()
{
    echo "<section>";
    echo "<label></label>";
    echo "<h2 id='galleryName'></h2>";
    echo "<label>Native Name:</label>";
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

//generates details of box b which has a list of outputted galleries for the user to choose from 
function boxB_Gen()
{
    echo "<section>";
    echo "<h2>Galleries</h2>";
    echo "<ul id='galleryList'></ul>";
    echo "</section>";
}

//generates details of box c which hosts a list of paintings located within a gallery 
function boxC_Gen()
{
    echo "<section>";
    echo "<h2>Famous Paintings</h2>";
    echo "<table id='paintingList'>";
    echo "</table>";
    echo "</section>";
}
?>
<!DOCTYPE html>
<html>

<head>
    <title>Assignment 2 Galleries Page</title>
    <meta charset=utf-8>
    <!-- These 3 references are taken from Lab14a. Might remove and remodel to our own CSS if we have time. -->
    <!-- Note: These fonts are unique and I can't find them when I want do font-family in css. I say keep em -->
    <link href='http://fonts.googleapis.com/css?family=Merriweather' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.4.1/semantic.min.css" rel="stylesheet">
    <!-- This reference is for the hamburger icon, taken from: fontawesome.com-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <style>
        <?php include 'style/galleries.css'; ?>
    </style>
</head>

<body>
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
    <script type="text/javascript">
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

        //fetch gallery data from PHP side of code 
        //retrieve data from database, if local storage is filled then retrieve from local storage 
        let galleriesData;
        if (localStorage.hasOwnProperty("galleries")) {
            galleriesData = JSON.parse(localStorage.getItem("galleries"));
        } else {
            galleriesData = Array.from(<?php echo json_encode(getGalleries()); ?>);
            localStorage.setItem("galleries", galleriesData);
            console.log(galleriesData);
        }

        //loop through GalleriesData, then send each individual element to populate the list 
        galleriesData.forEach(g => {
            populateGallery(g);
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

                document.querySelector(".box.a section").style.display = "grid";


                //obtain a painting.php url for future operations involving paintings
                let paintURL = "<?php echo getPaintings(); ?>".concat(e.target.id);
                //calls several functions to fulfill rest of the functionality
                //box a filled with gallery details
                galDetails(name, natName, city, address, country, home);
                //marker created at location of gallery
                createMarker(map, lat, lon, city);
                //map is moved to location of gallery
                moveLocation(lat, lon);
                //painting list is generated based on gallery
                createPaintings(e.target, paintURL);
            });
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

            //loop through galleries to produce list items of gallerys
            //contains information about particular gallery in it's attributes
            let li = document.createElement('li');
            li.textContent = galleries.GalleryName;
            li.setAttribute('natName', galleries.GalleryNativeName);
            li.setAttribute('city', galleries.GalleryCity);
            li.setAttribute('address', galleries.GalleryAddress);
            li.setAttribute('country', galleries.GalleryCountry);
            li.setAttribute('home', galleries.GalleryWebSite);
            li.setAttribute('latitude', galleries.Latitude);
            li.setAttribute('longitude', galleries.Longitude);
            li.setAttribute('id', galleries.GalleryID);
            uList.appendChild(li);
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

        function createPaintings(gallery, paintURL) {

            //generate table
            let table = document.querySelector('#paintingList');
            table.innerHTML = "";

            //distinguishes headings from body of table  
            let tableHeading = document.createElement('tHead');

            //generates area where headers are to be located 
            //headers are appended to this 
            let tHeader = document.createElement('tr');
            tHeader.setAttribute('id', "tableHeading");

            let imageHeading = document.createElement('th');

            let artist = document.createElement('th');
            artist.textContent = 'Artist';

            let title = document.createElement('th');
            title.textContent = 'Title';

            let year = document.createElement('th');
            year.textContent = 'Year';

            //distinguishes table body elements from header 
            let tableBody = document.createElement('tbody');

            //appends header details to header, appends header and body to table 
            tHeader.appendChild(imageHeading);
            tHeader.appendChild(artist);
            tHeader.appendChild(title);
            tHeader.appendChild(year);
            tableHeading.appendChild(tHeader);
            table.appendChild(tableHeading);
            table.appendChild(tableBody);

            //fetches for paintings from a specific gallery
            fetch(paintURL)
                .then(response => response.json())
                .then(paintings => {
                    //grabs array of paintings from paintURL
                    pTableSorter = Array.from(paintings);

                    //calls array to perform a default sort based on year 
                    yearSort(pTableSorter);

                    //events appended to headers to sort based on lastname or title (Note: Last Name sort does not work)       
                    year.addEventListener('click', (e) => {
                        yearSort(pTableSorter);
                    });
                    title.addEventListener('click', (e) => {
                        titleSort(pTableSorter);
                    });
                    artist.addEventListener('click', (e) => {
                        lastNameSort(pTableSorter);
                    });
                })
                .catch(error => console.log(error));
        }

        /**
         * Sorts based on year when user selects heading "Year"  
         *
         * @param pTableSorter   
         * Passes Array of paintings to sort   
         *
         */

        function yearSort(pTableSorter) {

            //sorts based on last name 
            pTableSorter.sort((a, b) => {
                return a.YearOfWork < b.YearOfWork ? -1 : 1;
            });
            paintingTableCreate(pTableSorter);
        }

        /**
         * Sorts based on a painting title when user selects heading "Title"  
         *
         * @param pTableSorter   
         * Passes Array of paintings to sort  
         *
         */

        function titleSort(pTableSorter) {

            //sorts based on title
            pTableSorter.sort((a, b) => {
                return a.Title < b.Title ? -1 : 1;
            });
            paintingTableCreate(pTableSorter);

        }

        /**
         * Sorts based on an artist's last name when user selects heading "Artist"  
         *
         * @param pTableSorter   
         * Passes Array of paintings to sort 
         * 
         */

        function lastNameSort(pTableSorter) {

            //sorts based on last name 
            pTableSorter.sort((a, b) => {
                return a.LastName < b.ArtistID ? -1 : 1;
            });
            paintingTableCreate(pTableSorter);
        }

        /**
         * Generates a gallery of paintings to populate the paintbox  
         *
         * @param pArraySort   
         * Passes a sorted Array of paintings to populate the table 
         *
         */

        function paintingTableCreate(pArraySort) {
            let artistData = Array.from(<?php echo json_encode(getArtists()); ?>);
            let imgPath = "./images/paintings/square/";


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
                thumbnail.setAttribute('src', imgPath.concat(imgFileNameFix(p.ImageFileName.toString())));
                thumbnail.setAttribute('id', p.PaintingID);
                thumbnailCell.appendChild(thumbnail);

                //produces cell where artist names are to be listed 
                //if conditional to test whether said artist is referred to by only his last name or not
                let artistCell;
                artistData.forEach(a => {
                    if (p.ArtistID == a.ArtistID) {
                        if (a.FirstName == null) {
                            artistCell = document.createElement('td');
                            artistCell.textContent = a.LastName;
                        } else {
                            artistCell = document.createElement('td');
                            artistCell.textContent = (a.FirstName + " " + a.LastName);
                        }
                    }
                });

                //produces titlecell where titles are to be listed             
                //attaches website link to single-painting.php onto title  
                let titleCell = document.createElement('td');
                titleCell.setAttribute('id', 'title');
                link = document.createElement('a')
                link.setAttribute('href', "single-painting.php?paintings=".concat(p.PaintingID));
                link.textContent = p.Title;
                titleCell.appendChild(link);

                //produces yearcell where years are to be listed             
                let yearCell = document.createElement('td');
                yearCell.setAttribute('id', 'year');
                yearCell.textContent = p.YearOfWork;

                //appends all row details into the row. Then appends row into the table body 
                row.appendChild(thumbnailCell);
                row.appendChild(artistCell);
                row.appendChild(titleCell);
                row.appendChild(yearCell);
                tableBody.appendChild(row);

                //display box c 
                document.querySelector(".box.c section").style.display = "block";
            });
        }


        /**
         * Fixes file name of images with a leading zeroes  
         *
         * @param imageFileName
         * Passes filename of image so that if affected by leading zero error, is fixed 
         *
         */

        function imgFileNameFix(imageFileName) {
            //tests if image file name is about 4 or 5 numbers in length, fixes and attaches filetype .jpg
            //if 4, attaches two zeroes. Returns a fixed filename img 
            //if 5, attaches one zero. Returns fixed filename img
            //if not needed to be fixed, return img. 
            if (imageFileName.length == 4) {
                let fixLink = "00".concat(imageFileName);
                return fixLink.concat(".jpg");
            } else if (imageFileName.length == 5) {
                let fixLink = "0".concat(imageFileName);
                return fixLink.concat(".jpg");
            }
            return imageFileName.concat(".jpg");
        }
    </script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCf0RTnL9CUUj4anLvw-IpSgzU4g7rcYfg&callback=initMap" async defer></script>
</body>

</html>