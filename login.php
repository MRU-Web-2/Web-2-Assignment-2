<?php
require_once('includes/stock-config.inc.php');
require_once('lib/assignment2-db-classes.inc.php');

session_start();
if ( isset($_SESSION['user'])) {
    header('Location: loggedIn.php');
    exit();
}
// $msg = "Please enter your email and password";
// if ( isLoginDataPresent() ) {
//     try {
//         $conn = DatabaseHelper::createConnection(array(DBCONNECTION, DBUSER, DBPASS));
//         $gate = new CustomerLogonDB($conn);
//         $data = $gate->getByUserName($_POST['email']);
//         $conn = null;

//         if ( isset($data['Pass']) ) {
//             if ( password_verify($_POST['pass'], $data['Pass']) ) {
//                 $_SESSION['user'] = $data['CustomerID'];
//                 header('Location: loggedIn.php');
//             } else {
//                 $msg = "Password is incorrect";
//             }
//         } else {
//             $msg = "Email not found";
//         }

//     } catch (Exception $e) {
//         die( $e->getMessage() );
//     }
// }

$msg = "Please enter your email and password";
if ( isLoginDataPresent() ) {
    
    // Check if the email exists in the api (database)
    $customersURL = 'https://assignment2-297900.uc.r.appspot.com/api-customers.php';
    $customerData = json_decode(file_get_contents($customersURL));
    
    foreach ($customerData as $c) {
        if ( $_POST['email'] == $c->UserName ) {
            $customer = $c;
            break;
        }
    }
    // if the email exists in the array
    if ( isset($customer)) {
        // I tried making this work, but it doesn't want to.
        // $digest = password_hash( $_POST['pass'], PASSWORD_BCRYPT, ['cost' => 12] );
        // var_dump($digest);
        // this method will do the Bcrypt verification for us
        if ( password_verify($_POST['pass'], $customer->Pass)) {
            // 3. We have a match, login the user
            echo "We made it here at least";
            $_SESSION['user'] = $customer->CustomerID;
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
</head>
<body>
    <?php include("header.php");?>
    <!-- <link href="./style/style.css" rel='stylesheet'> -->
   <style>
       body{
background-image: url('images/payson-wick-vGLXKqCY66Y-unsplash.jpg');
background-size: cover;
background-repeat: no-repeat;
margin: 50px auto;
    text-align: center;
    width: 100%;
}

</style>
    
    <section class="containter">
        <div class="formData">
            <h2>Login</h2>
            <p><?= $msg ?></p>
            <form method="post" action="login.php">
            <div class="topnav">
                <label for="email">Email</label>
                
                    
                <input type="email" name="email">
                
                
                
                <label for="pass">Password</label>
                <input type="password" name="pass">
                <input type="submit" id="button" type=button value="Login">
                </div><br>
               
            </form>
        </div>
    </section>
</body>