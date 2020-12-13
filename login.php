<?php
require_once('includes/stock-config.inc.php');
require_once('lib/assignment2-db-classes.inc.php');

session_start();
if (isset($_SESSION['user'])) {
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
if (isLoginDataPresent()) {

    // Check if the email exists in the api (database)
    $customersURL = 'https://assignment2-297900.uc.r.appspot.com/api-customers.php';
    $customerData = json_decode(file_get_contents($customersURL));

    foreach ($customerData as $c) {
        if ($_POST['email'] == $c->UserName) {
            $customer = $c;
            break;
        }
    }
    // if the email exists in the array
    if (isset($customer)) {
        // I tried making this work, but it doesn't want to.
        // $digest = password_hash( $_POST['pass'], PASSWORD_BCRYPT, ['cost' => 12] );
        // var_dump($digest);
        // this method will do the Bcrypt verification for us
        if (password_verify($_POST['pass'], $customer->Pass)) {
            // 3. We have a match, login the user
            $_SESSION['user'] = $customer->CustomerID;
            // Redirect somewhere else
            header('Location: loggedIn.php');
        } else {
            $msg = "Password did not match";
        }
    } else {
        $msg = "Email not found";
    }
}



function isLoginDataPresent()
{
    if (isset($_POST['email']) && isset($_POST['pass'])) {
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
    <?php include("header.php"); ?>
    <!-- <link href="./style/style.css" rel='stylesheet'> -->
    <style>
        body {
            background-image: url('images/payson-wick-vGLXKqCY66Y-unsplash.jpg');
            background-size: cover;
            background-repeat: no-repeat;
            /* margin: 50px auto;  */
            text-align: center;
            width: 100%;
        }
    </style>
    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
        }


        input[type=email],
        input[type=password] {
            width: 300px;
            padding: 12px 20px;
            margin: 8px 0;
            display: inline-block;
            border: 1px solid #ccc;
            box-sizing: border-box;
            border-radius: 25px;
        }

        input[type=email] {
            margin-left: 25px;
        }
        input[type=password]{
            margin-left: 0px;
        }

        button {
            background-color: #4CAF50;
            color: white;
            padding: 14px 20px;
            margin: 8px 0;
            border: none;
            cursor: pointer;
            width: 70px;
            border-radius: 25px;
        }

        button:hover {
            opacity: 0.8;
            color: black;
        }


        .imgcontainer {
            text-align: center;
            margin: 24px 0 12px 0;
        }



        .container {
            padding: 16px;
        }

        span.psw {
            float: right;
            padding-top: 16px;
        }
    </style>
    </head>

    <body>


        <section class="containter">
            <div class="formData">
                <h2>Login Form</h2>
                <p><?= $msg ?></p>
                <form method="post" action="login.php">
                    <div class="topnav">
                        <label for="email"><b>Email</b> </label>


                        <input type="email" placeholder="Enter Email" name="email"><br>



                        <label for="pass"><b>Password </b></label>
                        <input type="password" placeholder="Enter Password" name="pass"> <br>
                        <button type="submit" id="button" type=button value="Login">Login</button>
                    </div>

                </form>
            </div>
        </section>
    </body>