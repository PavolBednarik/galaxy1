<?php

require_once("header.php");

$movie_id = !empty($_GET['movie-id']) ? $_GET['movie-id'] : 1;

?>
<br>
<br>
<br>
<div class="container">
 <div class="row">
      <div class="col-md-5">
        <a href="#" id="movie-poster-link" data-lightbox="gallery">
          <img src="#" id="movie-poster" alt="Movie poster" class="img-thumbnail object-fit-cover">
        </a>
      </div>
      <div class="col-md-7">
        <h3 class="text-light text-end" id="movie-title"></h3>
        <p class="text-light text-end">
          <span class="badge bg-secondary" id="movie-genre"></span>
        </p>
        <p class="text-light text-end" id="movie-synopsis">
        </p>
        <p class="text-light text-end">
        <span class="badge bg-secondary" id="movie-actor"></span>
        </p>
        <p class="text-light text-end">
        <span class="badge bg-secondary" id="movie-year"></span>
        </p>
        <p class="text-light text-end">
          <span class="badge bg-secondary" id="movie-time"></span>
        </p>
        <p class="text-light text-end">
          <span class="badge bg-secondary" id="movie-cinema"></span>
        </p>
        <div class="d-flex align-items-center">
          <a href="<?php echo get_home_url(); ?>booking.php" class="btn btn-primary" id="book-now-btn">Book now</a>
        </div>
      </div>

    </div>
  </div>
  </div>
  </div>
  <br>
  <div class="container">
    <div class="row">
      <div class="col-md-6 offset-md-3">
        <div class="ratio ratio-16x9 mw-100">
          <iframe id="movie-video" class="mw-100" width="560" height="315"
            src="https://www.youtube.com/embed/" title="YouTube video player"
            frameborder="0"
            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
            allowfullscreen></iframe>
        </div>
      </div>
    </div>
  </div>
  <br>
  <div class="container">
    <div class="row">
      <div class="col-md-4">
        <a href="#" id="movie-gallery-link-1" data-lightbox="gallery">
          <img src="#" id="movie-gallery-1" alt="Movie poster" class="img-thumbnail object-fit-cover">
        </a>
      </div>
      <div class="col-md-4">
        <a href="#" id="movie-gallery-link-2" data-lightbox="gallery">
          <img src="#" id="movie-gallery-2" alt="Movie poster" class="img-thumbnail object-fit-cover">
        </a>
      </div>
      <div class="col-md-4">
        <a href="#" id="movie-gallery-link-3" data-lightbox="gallery">
          <img src="#" id="movie-gallery-3" alt="Movie poster" class="img-thumbnail object-fit-cover">
        </a>
      </div>
    </div>
  </div>
  <br>
  <script>
    let movie = <?php echo get_movie($movie_id); ?>;

    if (movie) {
      // Populate various elements on the page with movie details
      document.getElementById('movie-title').textContent = movie.title;
      document.getElementById('movie-synopsis').textContent = movie.synopsis;
      document.getElementById('movie-actor').textContent = `Actor: ${movie.actors}`;
      document.getElementById('movie-genre').textContent = `Genre: ${movie.genres}`;
      document.getElementById('movie-year').textContent = `Year: ${new Date(movie.release_date).getFullYear()}`;
      document.getElementById('movie-time').textContent = `${movie.runtime} minutes`;
      document.getElementById('movie-cinema').textContent = `Available at: ${movie.cinema}`;
      document.getElementById('movie-poster-link').setAttribute("href", movie.poster);
      document.getElementById('movie-poster').setAttribute("src", movie.poster);
      document.getElementById('movie-video').setAttribute("src", "https://www.youtube.com/embed/" + movie.youtube_id);
      document.getElementById('movie-gallery-link-1').setAttribute("href", movie.picture1);
      document.getElementById('movie-gallery-1').setAttribute("src", movie.picture1);
      document.getElementById('movie-gallery-link-2').setAttribute("href", movie.picture2);
      document.getElementById('movie-gallery-2').setAttribute("src", movie.picture2);
      document.getElementById('movie-gallery-link-3').setAttribute("href", movie.picture3);
      document.getElementById('movie-gallery-3').setAttribute("src", movie.picture3);
      if (movie.cinema) {
      document.getElementById('movie-cinema').textContent = `Available at: ${movie.cinema}`;
    } else {
      document.getElementById('movie-cinema').textContent = 'Cinema information avalable soon';
    }
      const releaseDate = new Date(movie.release_date);
  const today = new Date();
  if (releaseDate > today) {
    document.getElementById('book-now-btn').style.display = 'none';
    }
  }
  </script>

<?php

require_once("footer.php");

?>