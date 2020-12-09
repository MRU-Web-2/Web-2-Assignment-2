<!-- This content is taken from this website that gives help in creating a responsive navbar:
    https://itnext.io/how-to-build-a-responsive-navbar-using-flexbox-and-javascript-eb0af24f19bf -->

<nav class="navbar">

    <span class='navbar-toggle'  id='js-navbar-toggle'>
        <i style="font-size:34px" class="fa">&#xf0c9;</i>
    </span>

    <a href="#" class="logo">Logo</a>

    <ul class="main-nav" id="js-menu">
        <li>
            <a href="#" class="nav-links">Home</a>
        </li>
        <li>
            <a href="#" class="nav-links">Galleries</a>
        </li>
        <li>
            <a href="browse-paintings.php" class="nav-links">Browse</a>
        </li>
        <?php
            $var = 1;
            # If a user is loged in, then use the 'Logout' keyphrase
            if ($var == 1) {
                echo "
                <li>
                    <a href='#' class='nav-links'>Logout</a>
                </li>";
            } else {
                echo "
                <li>
                    <a href='#' class='nav-links'>Login</a>
                </li>";
            }
        ?>
</nav>
<script>
let mainNav = document.getElementById('js-menu');
let navBarToggle = document.getElementById('js-navbar-toggle');

navBarToggle.addEventListener('click', function () {
    mainNav.classList.toggle('active');
});
</script>