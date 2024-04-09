<?php

require_once("header.php");

$all_movies_json = get_upcoming_movies_json();

?>
<br>
<br>
<br>

<!-- template with ID for dinamic website -->
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
        <p class="text-light">Comming:
          <br>
          <span class="badge bg-secondary" id="release-date"></span>
        </p>
        <br>
        <br>
        <br>

        <a href="#" class="btn btn-primary" id="movie-link">View More</a>
        
      </div>
    </div>
  </div>
  
  

  <script>
    // get the container element where movie will be display
    const container = document.getElementById("movies-container");
    // Get the template for displaying each movie
    const movieTemplate = document.getElementById("movie-template");
    // Initialize an empty array to store movie data
    let moviesData = <?php echo $all_movies_json; ?>;
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
        movieClone.querySelector('#release-date').textContent = movie.release_date;
         movieClone.querySelector('#movie-poster').setAttribute('src', movie.poster);
         movieClone.querySelector('#movie-poster').setAttribute('alt', movie.title);
         movieClone.querySelector('#movie-link').setAttribute('href', `movie-details.php?movie-id=${movie.movie_id
           }`);
        movieClone.style.display = "flex";
        // Append the populated template to the container
        container.appendChild(movieClone);
      });
    }
  </script>

<?php

require_once("footer.php");

?>