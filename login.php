<?php
require_once('includes/stock-config.inc.php');
require_once('lib/assignment2-db-classes.inc.php');

session_start();
$msg = "Demonstrates how to use form authentication";
if ( isLoginDataPresent() ) {
    try {
        // 1. First see if this email is in the database
        $connection = DatabaseHelper::createConnection($connectionDetails);
        $gate = new CustomerLogonDB($connection);
        $data = $gate->getByUserName($_POST['email']);
        $connection = null;

        // if $data is empty then the supplied email was not found
        // 'Pass' comes from database
        if ( issset($data['Pass']) ) {
            // 2. Does this password match the digest saved in the Pass field
            // this method will do the Bcrypt verification for us
            if ( password_verify( $_POST['pass'], $data['Pass'] )) {
                // 3. We have a match, login the user
                $_SESSION['user'] = $data['CustomerID'];
                // Redirect somewhere else
                header('Location: loggedIn.php');

            } else {
                $msg = "Password did not match";
            }
        } else {
            $msg = "Email not found";
        }
    } catch (Exception $_ENV) {
        die( $E->getMessage() );
    }
}

function isLoginDataPresent() {
    if ( isset($_POST['email']) && isset($_POST['pass']) ) {
        return true;
    } else {
        return false;
    }
}   

?>

<!DOCTYPE html>
<html lang=en>
<head>
    <title>Assignment 2 - Login Page</title>
    <meta charset=utf-8>
    <!-- These 3 references are taken from Lab14a. Might remove and remodel to our own CSS if we have time. -->
    <link href='http://fonts.googleapis.com/css?family=Merriweather' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.4.1/semantic.min.css" rel="stylesheet">
</head>
<body>
<main>
    <?php include("header.php");?>
    <section>
        <div calss="container">
            <h2>Login</h2>
            <p><?= $msg ?></p>
            <form method="post" action="loggedin.php">
                <label for="email">Email</label>
                <input type="email" name="email">
                <label for="pass">Password</label>
                <input type="password" name="pass">
                <input type="submit" value="Login">
        </div>
    </section>
</main>
</body>