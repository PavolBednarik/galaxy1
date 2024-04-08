<?php

require_once ("header.php");


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
WHERE
  m.release_date < CURDATE() 
GROUP BY 
m.movie_id
ORDER BY 
m.movie_id;";;
$result = $conn->query($sql);
$all_movies = array(); // Initialize an empty array to store all movies
while($row = $result->fetch_assoc()) {
    $all_movies[] = $row; // Append each movie row to the array
}
$all_movies_json = json_encode($all_movies);

?>

 <div id="carouselExampleCaptions" class="carousel slide carousel-fade" data-ride="carousel">
        <ol class="carousel-indicators">
            <li data-target="#carouselExampleCaptions" data-slide-to="0" class="active"></li>
            <li data-target="#carouselExampleCaptions" data-slide-to="1"></li>
            <li data-target="#carouselExampleCaptions" data-slide-to="2"></li>
        </ol>
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="popcorn1.jpg" class="d-block w-100 img-fluid" alt="...">
                <div class="carousel-caption d-none d-md-block">
                    <h5>Become a member</h5>
                    <p>With membership is life easier!</p>
                    <a href="Singin.html" class="btn btn-danger">Sign In</a>

                </div>
            </div>
            <div class="carousel-item">
                <img src="kino1.jpg" class="d-block w-100 img-fluid" alt="...">
                <div class="carousel-caption d-none d-md-block">
                    <h5>Book your movie </h5>
                    <p>Chose cinema and enjoy your movie </p>
                    <a href="booking.html" class="btn btn-primary">Book now</a>

                </div>
            </div>
            <div class="carousel-item">
                <img src="Movies1.jpg" class="d-block w-100 img-fluid" alt="...">
                <div class="carousel-caption d-none d-md-block">
                    <h5>COMMING SOON</h5>
                    <p>Movies arriving soon </p>
                    <a href="upcomingMovies.html" class="btn btn-primary">View</a>

                </div>
            </div>
        </div>
        <a class="carousel-control-prev" href="#carouselExampleCaptions" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#carouselExampleCaptions" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
        </a>
    </div>

    <div class="container">
        <div class="pricing-header p-3 pb-md-4 mx-auto text-center">
            <h1 class="display-4 fw-normal text-body-emphasis text-light">Popular movies</h1>

        </div>
    </div>
    <!-- card container from bootstrap -->
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <div class="card" style="width: 24rem;">
                    <img src="img1/17/poster.jpg" class="card-img-top img-fluid" alt="..." />
                    <div class="card-body">
                        <h5 class="card-title">Killers of the Flower Moon</h5>
                        <p>Main protagonist: <br>
                            <span class="badge bg-secondary">Leonardo DiCaprio</span>
                        </p>
                        <p>Genre: <br>
                            <span class="badge bg-secondary">Crime, History, Drama </span>
                        </p>
                        <button type="button" class="btn btn-primary" onclick="viewMore(17)" data-movie-id="17">View
                            More</button>
                        <a href="booking.html" class="btn btn-primary">Book now</a>

                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card" style="width: 24rem;">
                    <img src="img1/19/poster.jpg" class="card-img-top" alt="..." />
                    <div class="card-body">
                        <h5 class="card-title">Dune: Part Two</h5>
                        <p>Main protagonist: <br>
                            <span class="badge bg-secondary">Timothee Chalamet</span>
                        </p>
                        <p>Genre: <br>
                            <span class="badge bg-secondary">Adventure, Action, Drama </span>
                        </p>
                        <button type="button" class="btn btn-primary" onclick="viewMore(18)" data-movie-id="18">View
                            More</button>
                        <a href="booking.html" class="btn btn-primary">Book now</a>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <br>
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <div class="card" style="width: 24rem;">
                    <img src="img1/18/poster.jpg" class="card-img-top" alt="..." />
                    <div class="card-body">
                        <h5 class="card-title">Indiana Jones and the Dial of Destiny</h5>
                        <p>Main protagonist: <br>
                            <span class="badge bg-secondary">Harrison Ford</span>
                        </p>
                        <p>Genre: <br>
                            <span class="badge bg-secondary">Adventure, Action </span>
                        </p>
                        <button type="button" class="btn btn-primary" onclick="viewMore(18)" data-movie-id="18">View
                            More</button>
                        <a href="booking.html" class="btn btn-primary">Book now</a>

                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card" style="width: 24rem;">
                    <img src="img1/11/poster.jpg" class="card-img-top" alt="..." />
                    <div class="card-body">
                        <h5 class="card-title">Barbie</h5>
                        <p>Main protagonist: <br>
                            <span class="badge bg-secondary">Margot Robbie</span>
                        </p>
                        <p>Genre: <br>
                            <span class="badge bg-secondary">Comedy, Adventure, Fantasy </span>
                        </p>
                        <button type="button" class="btn btn-primary" onclick="viewMore(11)" data-movie-id="11">View
                            More</button>
                        <a href="booking.html" class="btn btn-primary">Book now</a>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php

require_once ("footer.php");

?>