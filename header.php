<?php

require_once("connection.php");
require_once("helpers.php");

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
            <a class="navbar-brand" href="#">Galaxy Cinema</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item active">
                        <a class="navbar-brand" href="GalaxyCinema.html">Home</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link btn dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Cinemas
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdown" style="padding: 0.5rem 1rem;">
                            <a class="dropdown-item" href="cinema-coolock.php">Galaxy Coolock</a>
                            <a class="dropdown-item" href="Cinema-Rathmines.php">Galaxy Rathmines</a>
                        </div>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link btn dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Movies
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdown" style="padding: 0.5rem 1rem;">
                            <a class="dropdown-item" href="all-movies.php">Available movies</a>
                            <a class="dropdown-item" href="upcoming-movies.php">Comming soon</a>
                        </div>
                    </li>
                    <!-- login, sign in  and search button-->

                </ul>
                <form class="form-inline my-2 my-lg-0">
                    <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search" id="search-field">
                    <div id="autocomplete-dropdown" class="autocomplete-items" style="display: none;"></div>

                    <button class="btn btn-outline btn-secondary my-2 my-sm-0" id="search-btn" type="submit">Search</button>
                </form>
                <div class="d-flex justify-content-end">
                    <a href="Login.html" class="btn btn-primary ">Login</a>
                    <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#signInModal">
                        Sign In
                    </button>
                </div>
            </div>
        </nav>
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
                            <form id="sign-in-form" name="myForm" onsubmit="return validateForm()">
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
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script>
            // Generate a random CAPTCHA code
            function generateCaptcha() {
                var captcha = '';
                var characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
                for (var i = 0; i < 6; i++) {
                    captcha += characters.charAt(Math.floor(Math.random() * characters.length));
                }
                return captcha;
            }

            // Populate the CAPTCHA text and store it in session storage
            var captchaText = generateCaptcha();
            document.getElementById('captchaText').textContent = captchaText;
            sessionStorage.setItem('captcha', captchaText);

            // Validate the CAPTCHA on form submission
            document.getElementById('sign-in-form').addEventListener('submit', function(event) {
                var userInput = document.getElementById('captcha').value;
                var storedCaptcha = sessionStorage.getItem('captcha');
                if (userInput !== storedCaptcha) {
                    alert('CAPTCHA incorrect!');
                    event.preventDefault(); // Prevent form submission
                }
            });

            function validateForm() {
                var name = document.getElementById('inputName').value.trim();
                var surname = document.getElementById('inputSurname').value.trim();
                var username = document.getElementById('inputUsername').value.trim();
                var email = document.getElementById('inputEmail').value.trim();
                var phone = document.getElementById('inputPhone').value.trim();
                var password = document.getElementById('inputPassword').value;
                var confirmPassword = document.getElementById('confirmPassword').value;

                // Check if any field is empty
                if (name === '' || surname === '' || email === '' || phone === '' || password === '' || confirmPassword === '') {
                    alert('Please fill in all fields.');
                    return false;
                }

                // Check if email is valid
                var emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                if (!emailPattern.test(email)) {
                    alert('Please enter a valid email address.');
                    return false;
                }
                var phonePattern = /^0\d{9}$/;
                if (!phonePattern.test(phone)) {
                    alert('Please enter a valid Irish mobile phone number starting with "0" and consisting of exactly 10 digits.');
                    return false;
                }

                // Check if passwords match
                if (password !== confirmPassword) {
                    alert('Passwords do not match.');
                    return false;
                }

                // Check if password meets criteria (e.g., minimum length)
                if (password.length < 8) {
                    alert('Password must be at least 8 characters long.');
                    return false;
                }

                // If all validation passes, return true to submit the form
                return true;
            }

           
        </script>
    </div>
    <div class="container">