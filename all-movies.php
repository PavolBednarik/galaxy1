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
GROUP BY 
m.movie_id
ORDER BY 
m.movie_id;";
$result = $conn->query($sql);
$all_movies = array(); // Initialize an empty array to store all movies
while($row = $result->fetch_assoc()) {
    $all_movies[] = $row; // Append each movie row to the array
}
$all_movies_json = json_encode($all_movies);

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
        <br>
        <br>
        <br>

        <a href="#" class="btn btn-primary" id="movie-link">View More</a>
        <a href="booking.html" class="btn btn-primary">Book now</a>
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
         movieClone.querySelector('#movie-poster').setAttribute('src', movie.poster);
         movieClone.querySelector('#movie-poster').setAttribute('alt', movie.title);
         movieClone.querySelector('#movie-link').setAttribute('href', `movie-detail.php?movie-id=${movie.movie_id
           }`);
        movieClone.style.display = "flex";
        // Append the populated template to the container
        container.appendChild(movieClone);
      });
    }

    // Event listener for the search button
    document.querySelector('#search-btn').addEventListener('click', function (event) {
      event.preventDefault(); // Prevent form submission
      // Get the search query from the input field
      const searchQuery = document.querySelector('input[type="search"]').value.toLowerCase();
      // Filter movies based on the search query
      const filteredMovies = moviesData.filter(movie => {
        return movie.title.toLowerCase().includes(searchQuery) || movie.star.toLowerCase().includes(searchQuery) || movie.genres.some(genre => genre.toLowerCase().includes(searchQuery));
      });
      // Render filtered movies
      renderMovies(filteredMovies);
    });

    // Event listener for search field input
    document.querySelector('#search-field').addEventListener('input', function (event) {
      // Get the search query from the input field
      const searchQuery = event.target.value.toLowerCase();
      const autocompleteDropdown = document.getElementById('autocomplete-dropdown');

      // Filter movies based on search query
      const matchedMovies = moviesData.filter(movie => movie.title.toLowerCase().includes(searchQuery));

      // Populate autocomplete dropdown with matched movie titles
      autocompleteDropdown.innerHTML = '';
      matchedMovies.forEach(movie => {
        const autocompleteItem = document.createElement('div');
        autocompleteItem.classList.add('autocomplete-item');
        autocompleteItem.textContent = movie.title;
        autocompleteItem.addEventListener('click', function () {
          document.querySelector('#search-field').value = movie.title;
          autocompleteDropdown.style.display = 'none';
        });
        autocompleteDropdown.appendChild(autocompleteItem);
      });

      // Show/hide autocomplete dropdown based on search query length
      if (searchQuery.length > 0) {
        autocompleteDropdown.style.display = 'block';
      } else {
        autocompleteDropdown.style.display = 'none';
      }
    });
  </script>

<?php

require_once ("footer.php");

?>