<?php

require_once ("connection.php");

?>

<!doctype html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css"
    integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

    
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
  </style>

  <title>Galaxy Cinema</title>
</head>
<!-- navigation bar from Bootstrap adjusted for webside need -->

<body>
  <nav class="navbar navbar-expand-lg fixed-top navbar-dark bg-dark">
    <a class="navbar-brand" href="#">Galaxy Cinema</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
      aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav mr-auto">
        <li class="nav-item active">
          <a class="navbar-brand" href="GalaxyCinema.html">Home</a>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link btn dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown"
            aria-haspopup="true" aria-expanded="false">
            Cinemas
          </a>
          <div class="dropdown-menu" aria-labelledby="navbarDropdown" style="padding: 0.5rem 1rem;">
            <a class="dropdown-item" href="Cinema-Coolock.php">Galaxy Coolock</a>
            <a class="dropdown-item" href="Cinema-Rathmines.php">Galaxy Rathmines</a>
          </div>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link btn dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown"
            aria-haspopup="true" aria-expanded="false">
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
        <a href="Singin.html" class="btn btn-danger">Sign In</a>
      </div>
    </div>
  </nav>

  <div class="container">