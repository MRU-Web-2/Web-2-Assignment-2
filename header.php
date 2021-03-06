<!-- This content is taken from this website that gives help in creating a responsive navbar:
    https://itnext.io/how-to-build-a-responsive-navbar-using-flexbox-and-javascript-eb0af24f19bf -->

<nav class="navbar">

    <span class='navbar-toggle' id='js-navbar-toggle'>
        <i style="font-size:34px" class="fa">&#xf0c9;</i>
    </span>

    <a href="index.php" class="logo"><img src="images/rhondak-native-florida-folk-artist-_Yc7OtfFn-0-unsplash.jpg"></a>


    <ul class="main-nav" id="js-menu">
        <li>
            <a href="index.php" class="nav-links">Home</a>
        </li>
        <li>
            <a href="galleries-page.php" class="nav-links">Galleries</a>
        </li>
        <li>
            <a href="browse-paintings.php" class="nav-links">Browse</a>
        </li>
        <li>
            <a href="about.php" class="nav-links">About</a>
        </li>
        <?php
        # This code is courteysy of: 
        # https://thisinterestsme.com/check-if-session-started-php/
        # If no session currently exists, this header will start a session
        if (session_status() == PHP_SESSION_NONE) {
            //session has not started
            session_start();
        }
        # If a user is loged in, then use the 'Logout' keyphrase
        if (isset($_SESSION['user'])) {
            echo "
                <li>
                    <a href='favourites.php' class='nav-links'>Favourites</a>
                </li>
                <li>
                    <a href='logout.php' class='nav-links'>Logout</a>
                </li>";
        } else {
            echo "
                <li>
                    <a href='login.php' class='nav-links'>Login</a>
                </li>";
        }
        ?>
</nav>
<script>
    let mainNav = document.getElementById('js-menu');
    let navBarToggle = document.getElementById('js-navbar-toggle');

    navBarToggle.addEventListener('click', function() {
        mainNav.classList.toggle('active');
    });
</script>

<style>
    * {
        font-family: 'Josefin Sans', sans-serif;
    }

    /* Navbar taken from:
    https://itnext.io/how-to-build-a-responsive-navbar-using-flexbox-and-javascript-eb0af24f19bf */
    .navbar {
        grid-column: 1/3;
        border: #eeeeee solid 10px;
        margin: 10px;
        padding: 5px 20px;
        background-color: #cccccc;
    }

    .main-nav {
        list-style-type: none;
        display: none;
    }

    .nav-links,
    .logo {
        text-decoration: none;
        font-size: 20px;
        font-weight: 600;
        color: rgba(0, 0, 0, 0.8);
    }

    .main-nav li {
        text-align: center;
        margin: 15px auto;
    }

    .logo {
        display: inline-block;
        font-size: 22px;
        margin-top: 10px;
        margin-left: 20px;
    }

    img {
        border: 1px solid #ddd;
        border-radius: 4px;
        padding: 1px;
        width: 50px;
    }

    .navbar-toggle {
        position: absolute;
        top: 35px;
        right: 43px;
        cursor: pointer;
        color: rgb(48, 48, 48);
        font-size: 24px;
    }

    .active {
        display: block;
    }

    @media screen and (min-width: 900px) {
        .navbar {
            display: flex;
            justify-content: space-between;
            padding-bottom: 0;
            height: 70px;
            align-items: center;
        }

        .main-nav {
            display: flex;
            margin-right: 30px;
            flex-direction: row;
            justify-content: flex-end;
        }

        .main-nav li {
            margin: 0;
        }

        .nav-links {
            margin-left: 40px;
        }

        .logo {
            margin-top: 0;
        }

        .navbar-toggle {
            display: none;
        }

        .logo:hover,
        .nav-links:hover {
            color: rgba(255, 255, 255, 1);
        }
    }
</style>