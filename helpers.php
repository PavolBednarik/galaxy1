<?php

function get_all_movies($upcoming = false)
{
    global $conn;

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
        LEFT JOIN actors a ON am.actor_id = a.actor_id";

    if ($upcoming) {
        $sql .= " WHERE m.release_date > CURDATE()";
    }

    $sql .= " GROUP BY 
        m.movie_id
        ORDER BY 
        m.movie_id;";

    $result = $conn->query($sql);

    $all_movies = array(); // Initialize an empty array to store all movies

    while ($row = $result->fetch_assoc()) {
        $all_movies[] = $row; // Append each movie row to the array
    }

    return $all_movies;
}

function get_all_movies_json()
{
    return json_encode(get_all_movies());
}


function get_upcoming_movies_json()
{
    return json_encode(get_all_movies(true));
}
