<?php

// Allow only POST requests
if ($_SERVER["REQUEST_METHOD"] != "POST") {
    return;
}

 // Start session if not already started to store error messages
if (!session_id()) {
    session_start();
}

require_once('connection.php');
require_once('helpers.php');

login_user();