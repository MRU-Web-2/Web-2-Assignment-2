<?php
require_once('includes/stock-config.inc.php');
require_once('lib/assignment2-db-classes.inc.php');

session_start();
$msg = "Please enter your email and password";
if ( isLoginDataPresent() ) {

    // Check if the email exists in the api (database)
    $customersURL = 'https://assignment2-297900.uc.r.appspot.com/api-customers.php';
    $customerData = json_decode(file_get_contents($customersURL));

    // if the email exists in the array
    if ( in_array( $_POST['email'], $customerData )) {
        foreach ($customerData as $c) {
            if ( $_POST['email'] == $c ) {
                $customer = $c;
                break;
            }
        }
        // this method will do the Bcrypt verification for us
        if ( password_verify( $_POST['pass'], $customer['Pass'] )) {
            // 3. We have a match, login the user
            $_SESSION['user'] = $data['CustomerID'];
            // Redirect somewhere else
            echo "Nice work!";
            header('Location: loggedIn.php');

        } else {
            $msg = "Password did not match";
        }
    } else {
        $msg = "Email not found";
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