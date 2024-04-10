<?php

// Execute SQL query and return data as array
function execute_query($sql)
{
    global $conn;
    $result = $conn->query($sql);
    $data = array();
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
    return $data;
}

// Get featured movies for homepage
function get_featured_movies()
{
    $featured_movies_ids = [17, 18, 19, 20]; // Featured movies IDs

    $sql = "SELECT 
    m.movie_id,
    m.title,
    m.synopsis,
    m.release_date,
    m.runtime,
    m.poster,
    m.picture1,
    m.picture2,
    m.picture3,
    m.youtube_id,
    GROUP_CONCAT(DISTINCT g.name ORDER BY g.name SEPARATOR ', ') AS genres,
    GROUP_CONCAT(DISTINCT a.name ORDER BY a.name SEPARATOR ', ') AS actors
    FROM 
        movies m
    LEFT JOIN 
        movie_genre mg ON m.movie_id = mg.movies_id
    LEFT JOIN 
        genres g ON mg.genre_id = g.genre_id
    LEFT JOIN 
        actor_movie am ON m.movie_id = am.movie_id
    LEFT JOIN 
        actors a ON am.actor_id = a.actor_id
    WHERE
        m.movie_id IN (" . implode(',', $featured_movies_ids) . ")
    GROUP BY 
        m.movie_id
    ORDER BY 
        m.movie_id;";

    return json_encode(execute_query($sql));
}

// Get all movies
function get_all_movies()
{
    $sql = "SELECT 
    m.movie_id,
    m.title,
    m.synopsis,
    m.release_date,
    m.runtime,
    m.poster,
    m.picture1,
    m.picture2,
    m.picture3,
    m.youtube_id,
    GROUP_CONCAT(DISTINCT g.name ORDER BY g.name SEPARATOR ', ') AS genres,
    GROUP_CONCAT(DISTINCT a.name ORDER BY a.name SEPARATOR ', ') AS actors
    FROM 
    movies m
    LEFT JOIN movie_genre mg ON m.movie_id = mg.movies_id
    LEFT JOIN genres g ON mg.genre_id = g.genre_id
    LEFT JOIN actor_movie am ON m.movie_id = am.movie_id
    LEFT JOIN actors a ON am.actor_id = a.actor_id
    GROUP BY 
    m.movie_id
    ORDER BY 
    m.movie_id;";

    return json_encode(execute_query($sql));
}

// Get upcoming movies
function get_upcoming_movies()
{
    $sql = "SELECT 
        m.movie_id,
        m.title,
        m.release_date,
        m.poster,
        GROUP_CONCAT(DISTINCT g.name ORDER BY g.name SEPARATOR ', ') AS genres,
        GROUP_CONCAT(DISTINCT a.name ORDER BY a.name SEPARATOR ', ') AS actors
        FROM 
        movies m
        LEFT JOIN movie_genre mg ON m.movie_id = mg.movies_id
        LEFT JOIN genres g ON mg.genre_id = g.genre_id
        LEFT JOIN actor_movie am ON m.movie_id = am.movie_id
        LEFT JOIN actors a ON am.actor_id = a.actor_id
        WHERE
        m.release_date > CURDATE()
        GROUP BY 
        m.movie_id
        ORDER BY 
        m.movie_id;";

    return json_encode(execute_query($sql));
}

// Get movies by coolock cinema
function get_coolock_movies()
{
    return get_cinema_movies('Galaxy Coolock');
}

// Get movies by rathmines cinema
function get_rathmines_movies()
{
    return get_cinema_movies('Galaxy Rathmines');
}

// Get movies by cinema
function get_cinema_movies($cinema)
{
    if (!$cinema) {
        return null;
    }

    $sql = "SELECT 
        m.movie_id,
        m.title,
        m.synopsis,
        m.release_date,
        m.runtime,
        m.poster,
        m.picture1,
        m.picture2,
        m.picture3,
        m.youtube_id,
        GROUP_CONCAT(DISTINCT g.name ORDER BY g.name SEPARATOR ', ') AS genres,
        GROUP_CONCAT(DISTINCT a.name ORDER BY a.name SEPARATOR ', ') AS actors
        FROM 
        movies m
        LEFT JOIN movie_genre mg ON m.movie_id = mg.movies_id
        LEFT JOIN genres g ON mg.genre_id = g.genre_id
        LEFT JOIN actor_movie am ON m.movie_id = am.movie_id
        LEFT JOIN actors a ON am.actor_id = a.actor_id
        JOIN cinema_movies cm ON m.movie_id = cm.movies_id  
        JOIN cinema c ON cm.cinema_id = c.cinema_id AND c.name = '$cinema'
        GROUP BY 
        m.movie_id
        ORDER BY 
        m.movie_id;";

    return json_encode(execute_query($sql));
}

// Get single movie by ID
function get_movie($movie_id = null)
{
    if ($movie_id == null) {
        return null;
    }

    $sql = "SELECT 
        m.movie_id,
        m.title,
        m.synopsis,
        m.release_date, 
        m.runtime,
        m.poster,
        m.picture1,
        m.picture2,
        m.picture3,
        m.youtube_id,
        GROUP_CONCAT(DISTINCT g.name ORDER BY g.name SEPARATOR ', ') AS genres,
        GROUP_CONCAT(DISTINCT a.name ORDER BY a.name SEPARATOR ', ') AS actors,
        GROUP_CONCAT(DISTINCT c.name ORDER BY c.name SEPARATOR ', ') AS cinema

        FROM 
        movies m
        LEFT JOIN movie_genre mg ON m.movie_id = mg.movies_id
        LEFT JOIN genres g ON mg.genre_id = g.genre_id
        LEFT JOIN actor_movie am ON m.movie_id = am.movie_id
        LEFT JOIN actors a ON am.actor_id = a.actor_id
        LEFT JOIN cinema_movies cm ON m.movie_id = cm.movies_id  
        LEFT JOIN cinema c ON cm.cinema_id = c.cinema_id
        WHERE m.movie_id = $movie_id
        GROUP BY 
        m.movie_id
        ORDER BY 
        m.movie_id;";

    $movie = execute_query($sql);

    return count($movie) > 0 ? json_encode($movie[0]) : null;
}

// Insert new user into database
function insert_user()
{
    // Check if form is submitted and call the insertUser function
    if ($_SERVER["REQUEST_METHOD"] != "POST") {
        return;
    }

    $name = $_POST["fname"] ?? null;
    $surname = $_POST["fsurname"] ?? null;
    $username = $_POST["fusername"] ?? null;
    $email = $_POST["femail"] ?? null;
    $phone = $_POST["fphone"] ?? null;
    $password = $_POST["fpass"] ?? null;
    $is_admin = 0;
    $username = !empty($_POST["fname"]) ? $_POST["fname"] : null;

    if ($username == null) {
        $_SESSION['register_error'] = "Name cannot be empty!";

        // Redirect back to location from which the request was made
        header("Location: " . $_SERVER["HTTP_REFERER"]);
        return;
    }

    $email = !empty($_POST["femail"]) ? $_POST["femail"] : null;

    if ($email == null) {
        $_SESSION['register_error'] = "Email cannot be empty!";
        // Redirect back to location from which the request was made
        header("Location: " . $_SERVER["HTTP_REFERER"]);
        return;
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['register_error'] = "Invalid email address";
        // Redirect back to location from which the request was made
        header("Location: " . $_SERVER["HTTP_REFERER"]);
        return;
    }

    $password = !empty($_POST["fpass"]) ? $_POST["fpass"] : null;

    if ($password == null) {
        $_SESSION['register_error'] = "Password cannot be empty!";
        // Redirect back to location from which the request was made
        header("Location: " . $_SERVER["HTTP_REFERER"]);
        return;
    }

    $is_admin = 0; // New users are not administrators by default

    // Prepare and execute SQL statement to insert data into users table
    $sql = "INSERT INTO users (name, surname, username, phone, password, email, is_admin) VALUES ('$name', '$surname', '$username', '$phone', '$password', '$email', $is_admin)";

    global $conn;

    try {
        $conn->query($sql);
    } catch (Exception $e) {
        $_SESSION['register_error'] = "Error: " . $sql . "<br>" . $conn->error;

        header("Location: " . $_SERVER["HTTP_REFERER"]);
        return;
    }

    // Set success message
    $_SESSION['register_success'] = "User successfully registered.";

    header("Location: " . $_SERVER["HTTP_REFERER"]);
    return;
}

// Login user
function login_user()
{
    // Check if form is submitted and call the insertUser function
    if ($_SERVER["REQUEST_METHOD"] != "POST") {
        return;
    }

    // Get username and password from POST request
    $username = $_POST["username"] ?? null;
    $password = $_POST["pass"] ?? null;

    if ($username == null || $password == null) {
        $_SESSION['login_error'] = "Username and password are required!";

        header("Location: " . $_SERVER["HTTP_REFERER"]);
        return;
    }

    // Prepare and execute SQL statement to get user with provided username and password
    $sql = "SELECT user_id FROM users WHERE username = '$username' AND password = '$password'";
    global $conn;
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $user_id = (int) $row['user_id'];

        // Set logged in user ID in cookie
        setcookie('logged_in_user_id', $user_id, time() + (86400 * 30), "/");

        // Redirect to home page
        header("Location: " . get_home_url() . "index.php");
        return;

    } else {
        $_SESSION['login_error'] = "Invalid username or password!";

        header("Location: " . $_SERVER["HTTP_REFERER"]);
        return;
    }
}

// Get current logged in user ID
function get_current_logged_in_user_id()
{
    return !empty($_COOKIE['logged_in_user_id']) ? (int) $_COOKIE['logged_in_user_id'] : 0;
}

// Check if user is logged in
function is_user_logged_in()
{
    $logged_in_user_id = get_current_logged_in_user_id();

    if ($logged_in_user_id <= 0) {
        return false;
    }

    return true;
}

// Check if current user is an admin
function is_admin()
{
    $logged_in_user_id = get_current_logged_in_user_id();

    if ($logged_in_user_id <= 0) {
        return false;
    }

    global $conn;

    $sql = "SELECT is_admin FROM users WHERE user_id = $logged_in_user_id";

    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        return (int) $row['is_admin'] == 1;
    }

    return false;
}

// Logout user
function logout_user()
{
    // Unset logged in user ID cookie
    setcookie('logged_in_user_id', '', time() - 3600, "/");
    unset($_COOKIE['logged_in_user_id']);

    // Redirect to home page
    header("Location: " . get_home_url() . "index.php");

    return;
}

// Get home url
function get_home_url()
{
    // Check if HTTPS is used, else fallback to HTTP
    $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' ? 'https' : 'http';

    // Get the server's host, e.g., localhost or domain.local
    $host = $_SERVER['HTTP_HOST'];

    // Get the script's directory path, excluding the script filename, to handle subdirectories
    $script_path = dirname($_SERVER['SCRIPT_NAME']);

    // Construct and normalize the base URL
    $base_url = $protocol . '://' . $host . $script_path;

    // Ensure the base URL ends with a slash for consistency
    $base_url = rtrim($base_url, '/');

    return $base_url;
}
