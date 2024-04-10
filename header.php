<?php

require_once("connection.php");
require_once("helpers.php");

// Start session if not already started to store error messages
if (!session_id()) {
    session_start();
}

// Redirect not logged in user to login.php if not currently at login.php
if (!is_user_logged_in() && !is_login_page()) {
    header("Location: " . get_home_url() . "login.php");
}

?>

<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">


    <style>
        .carousel-item img {

            max-height: 900px;
            width: 100%;
            object-fit: cover;
        }

        /* styling for poster */
        .object-fit-cover {
            width: 100%;
            height: 100%;
            object-fit: cover;
            object-position: center;
        }

        /* styling for footer */
        .blog-footer {
            padding: 2.5rem 0;
            color: #fbf9f9;
            text-align: center;
            background-color: black;
            border-top: 0.05rem solid #e5e5e5;
        }

        /* movie template styling */
        #movie-template {
            margin-bottom: 50px;
        }

        body {
            height: 100%;
            background-color: #060516c1;
        }

        /* Autocomplete dropdown styling */
        .autocomplete-items {
            position: absolute;
            border: 1px solid #d4d4d4;
            border-radius: 4px;
            max-height: 200px;
            overflow-y: auto;
            z-index: 99;
            background-color: white;
            top: 54px;
        }

        /* autocomlete list item styling */
        .autocomplete-item {
            padding: 5px 10px;
            cursor: pointer;
        }

        .autocomplete-item:hover {
            background-color: #e9e9e9;
        }

        .captcha-container {
            margin-bottom: 20px;
        }

        .captcha-input {
            margin-right: 10px;
        }

        .modal-body {
            background-color: #e9ecef;
            /* Light grey background color */
            padding: 20px;
            /* Add some padding for spacing */
            border-radius: 5px;
            /* Add rounded corners */
        }
    </style>

    <title>Galaxy Cinema</title>
</head>
<!-- navigation bar from Bootstrap adjusted for webside need -->

<body>
    <div class="container">
        <nav class="navbar navbar-expand-lg fixed-top navbar-dark bg-dark">
            <?php if(is_user_logged_in()) { ?>
                <a class="navbar-brand" href="<?php echo get_home_url(); ?>index.php">Galaxy Cinema</a>
                
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
            <?php } ?>
            
            <div class="collapse navbar-collapse d-flex justify-content-end" id="navbarSupportedContent">
                <?php if(is_user_logged_in()) { ?>

                    <ul class="navbar-nav mr-auto">
                        <li class="nav-item active">
                            <a class="navbar-brand" href="<?php echo get_home_url(); ?>index.php">Home</a>
                        </li>

                        <li class="nav-item dropdown">
                            <a class="nav-link btn dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Cinemas</a>

                            <div class="dropdown-menu" aria-labelledby="navbarDropdown" style="padding: 0.5rem 1rem;">
                                <a class="dropdown-item" href="cinema-coolock.php">Galaxy Coolock</a>
                                <a class="dropdown-item" href="cinema-rathmines.php">Galaxy Rathmines</a>
                            </div>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link btn dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Movies</a>

                            <div class="dropdown-menu" aria-labelledby="navbarDropdown" style="padding: 0.5rem 1rem;">
                                <?php if (!is_admin()) { ?>
                                    <a class="dropdown-item" href="all-movies.php">Available movies</a>
                                <?php } ?>

                                <a class="dropdown-item" href="upcoming-movies.php">Comming soon</a>
                            </div>
                        </li>
                    </ul>

                    <form class="form-inline my-2 my-lg-0">
                        <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search" id="search-field">
                        <div id="autocomplete-dropdown" class="autocomplete-items" style="display: none;"></div>

                        <button class="btn btn-outline btn-secondary my-2 my-sm-0" id="search-btn" type="submit">Search</button>
                    </form>
                <?php } ?>
 
                <?php
                if (!is_user_logged_in()) { ?>
                    <div class="d-flex justify-content-end">
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#loginModal">Login</button>
                        <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#signInModal">Sign In</button>
                    </div>
                <?php } else { ?>
                    <a href="/logout-action.php" class="btn btn-danger">Log Out</a>
                <?php } ?>
            </div>
        </nav>
        
        <div class="container">
            <div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" style="display: none;" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="loginModalLabel">Login to Galaxy Cinema</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form action="login-action.php" method="post">
                                <div class="mb-3">
                                    <label for="loginUsername" class="form-label formdesign">Username</label>
                                    <input name="username" type="text" class="form-control" id="loginUsername" aria-describedby="usernameHelp" required>
                                </div>
                                <div class="mb-3">
                                    <label for="loginPassword" class="form-label formdesign">Password</label>
                                    <input name="pass" type="password" class="form-control" id="loginPassword" required>
                                </div>

                                <?php

                                // // Display session errors if any
                                if (!empty($_SESSION['login_error'])) {
                                    echo "<div class='alert alert-danger mt-3' role='alert'>" . $_SESSION['login_error'] . "</div>";
                                }

                                // Display success message if any
                                if (!empty($_SESSION['login_success'])) {
                                    echo "<div class='alert alert-success mt-3' role='alert'>" . $_SESSION['login_success'] . "</div>";
                                }
                                
                                ?>
                                <button type="submit" class="btn btn-primary but">Login</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="modal fade" id="signInModal" tabindex="-1" aria-labelledby="signInModalLabel" style="display: none;" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="signInModalLabel">Sign in to Galaxy Cinema</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form id="sign-in-form" name="myForm" action="register-action.php" method="post" onsubmit="return validateForm()">
                                <div class="form-group">
                                    <label for="inputName" class="formdesign">Name:</label>
                                    <input type="text" class="form-control" id="inputName" name="fname" required="">
                                    <b><span class="formerror"></span></b>
                                </div>

                                <div class="form-group">
                                    <label for="inputSurname" class="formdesign">Surname:</label>
                                    <input type="text" class="form-control" id="inputSurname" name="fsurname" required="">
                                    <b><span class="formerror"></span></b>
                                </div>

                                <div class="form-group">
                                    <label for="inputUsername" class="formdesign">Username:</label>
                                    <input type="text" class="form-control" id="inputUsername" name="fusername" required="">
                                    <b><span class="formerror"></span></b>
                                </div>

                                <div class="form-group">
                                    <label for="inputEmail" class="formdesign">Email:</label>
                                    <input type="email" class="form-control" id="inputEmail" name="femail" required="">
                                    <b><span class="formerror"></span></b>
                                </div>

                                <div class="form-group">
                                    <label for="inputPhone" class="formdesign">Mobile phone number:</label>
                                    <input type="tel" class="form-control" id="inputPhone" name="fphone" required="">
                                    <b><span class="formerror"></span></b>
                                </div>

                                <div class="form-group">
                                    <label for="inputPassword" class="formdesign">Password:</label>
                                    <input type="password" class="form-control" id="inputPassword" name="fpass" required="">
                                    <b><span class="formerror"></span></b>
                                </div>

                                <div class="form-group">
                                    <label for="confirmPassword" class="formdesign">Confirm Password:</label>
                                    <input type="password" class="form-control" id="confirmPassword" name="fcpass" required="">
                                    <b><span class="formerror"></span></b>
                                </div>
                                <div class="captcha-container">
                                    <label for="captcha">Verify you're human:</label>
                                    <input type="text" id="captcha" name="captcha" class="captcha-input">
                                    <span id="captchaText"></span>
                                </div>
                                <button type="submit" class="btn btn-primary but">Submit</button>

                                <?php

                                // // Display session errors if any
                                if (!empty($_SESSION['register_error'])) {
                                    echo "<div class='alert alert-danger mt-3' role='alert'>" . $_SESSION['register_error'] . "</div>";
                                }

                                // Display success message if any
                                if (!empty($_SESSION['register_success'])) {
                                    echo "<div class='alert alert-success mt-3' role='alert'>" . $_SESSION['register_success'] . "</div>";
                                }
                                
                                ?>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
