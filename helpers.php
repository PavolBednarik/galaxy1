<?php

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

function get_coolock_movies()
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
        JOIN cinema_movies cm ON m.movie_id = cm.movies_id  
        JOIN cinema c ON cm.cinema_id = c.cinema_id AND c.name = 'Galaxy Coolock'  
        GROUP BY 
        m.movie_id
        ORDER BY 
        m.movie_id;";

    return json_encode(execute_query($sql));
}

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
