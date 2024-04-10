<?php

require_once("header.php");
require_once("helpers.php");

?>

<div id="carouselExampleCaptions" class="carousel slide carousel-fade" data-ride="carousel">
    <ol class="carousel-indicators">
        <li data-target="#carouselExampleCaptions" data-slide-to="0" class="active"></li>
        <li data-target="#carouselExampleCaptions" data-slide-to="1"></li>
        <li data-target="#carouselExampleCaptions" data-slide-to="2"></li>
    </ol>
    <div class="carousel-inner">
        <div class="carousel-item active">
            <img src="img1/index/pic1.jpg" class="d-block w-100 img-fluid" alt="...">
            <div class="carousel-caption d-none d-md-block">
                <h5>Become a member</h5>
                <p>With membership is life easier!</p>
                <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#signInModal">
                        Sign In
                    </button>
            </div>
        </div>
        <div class="carousel-item">
            <img src="img1/index/pic2.jpg" class="d-block w-100 img-fluid" alt="...">
            <div class="carousel-caption d-none d-md-block">
                <h5>Book your movie </h5>
                <p>Chose cinema and enjoy your movie </p>
                <a href="booking.php" class="btn btn-primary">Book now</a>

            </div>
        </div>
        <div class="carousel-item">
            <img src="img1/index/pic3.jpg" class="d-block w-100 img-fluid" alt="...">
            <div class="carousel-caption d-none d-md-block">
                <h5>COMMING SOON</h5>
                <p>Movies arriving soon </p>
                <a href="upcoming-movies.php" class="btn btn-primary">View</a>

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
    </div>  
<div class="container">
    <div class="pricing-header p-3 pb-md-4 mx-auto text-center">
        <h1 class="display-4 fw-normal text-body-emphasis text-light">Popular movies</h1>

    </div>

<div class="container" id="movies-container">
    <div class="row" id="movie-template" style="display: none;">
        <div class="col-md-3">
            <img src="" alt="" id="movie-poster" class="img-thumbnail object-fit-cover">
        </div>
        <div class="col-md-8">
            <h3 class="text-light" id="movie-title"></h3>
            <p class="text-light">Main protagonist:
                <br>
                <span class="badge bg-secondary" id="movie-actor"></span>
            </p>
            <p class="text-light">Genre:
                <br>
                <span class="badge bg-secondary" id="movie-genre"></span>
            </p>
            <br>
            <br>
            <br>

            <a href="#" class="btn btn-primary" id="movie-link">View More</a>
            <a href="booking.php" class="btn btn-primary booking-btn">Book now</a>
        </div>
    </div>
</div>



<script>
    // get the container element where movie will be display
    const container = document.getElementById("movies-container");
    // Get the template for displaying each movie
    const movieTemplate = document.getElementById("movie-template");
    // Initialize an empty array to store movie data
    let moviesData = <?php echo get_featured_movies(); ?>;
    renderMovies(moviesData);

    // Function to render movies based on the provided data
    function renderMovies(data) {
        container.innerHTML = ""; // Clear previous movies from the container
        // Loop through each movie in the data
        data.forEach(movie => {
            // Clone the movie template
            const movieClone = movieTemplate.cloneNode(true);

            // Populate the cloned template with movie data
            movieClone.querySelector('#movie-title').textContent = movie.title;
            movieClone.querySelector('#movie-genre').textContent = movie.genres;
            movieClone.querySelector('#movie-actor').textContent = movie.actors;
            movieClone.querySelector('#movie-poster').setAttribute('src', movie.poster);
            movieClone.querySelector('#movie-poster').setAttribute('alt', movie.title);
            movieClone.querySelector('#movie-link').setAttribute('href', `movie-details.php?movie-id=${movie.movie_id}`);
            movieClone.style.display = "flex";
            // Append the populated template to the container
            container.appendChild(movieClone);
        });
    }
</script>

<?php

require_once("footer.php");

?>