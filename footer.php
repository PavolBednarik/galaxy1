<div class="row">
      <div class="col"></div>
      <div class="col"></div>
      <div class="col"></div>
      <div class="col"></div>
    </div>
    <div class="row">
      <div class="col-8"></div>
      <div class="col-4"></div>
    </div>
  </div>
</div>

<footer class="blog-footer">
    <p>Galaxy Cinema all right reserved.</p>
    <a href="#">Back to top</a>
    </p>
  </footer>
  
  <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"
    integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n"
    crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"
    integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo"
    crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/js/bootstrap.min.js"
    integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6"
    crossorigin="anonymous"></script>

    <script>
    // Initialize an empty array to store movie data
    const searchMoviesData = <?php echo get_all_movies(); ?>;

    // Event listener for the search button
    document.querySelector('#search-btn').addEventListener('click', function (event) {
      event.preventDefault(); // Prevent form submission
      // Get the search query from the input field
      const searchQuery = document.querySelector('input[type="search"]').value.toLowerCase();
      // Filter movies based on the search query
      const filteredMovies = searchMoviesData.filter(movie => {
        return movie.title.toLowerCase().includes(searchQuery);
      });

      // Check if renderMovies function is available
      if (typeof renderMovies === 'function') {
        renderMovies(filteredMovies);

        return;
      }

      // Redirect to the movie detail
      if (filteredMovies.length > 0) {
        window.location.href = `movie-details.php?movie-id=${filteredMovies[0].movie_id}`;
      }

      return;
    });

    // Event listener for search field input
    document.querySelector('#search-field').addEventListener('input', function (event) {
      // Get the search query from the input field
      const searchQuery = event.target.value.toLowerCase();
      const autocompleteDropdown = document.getElementById('autocomplete-dropdown');

      // Filter movies based on search query
      const matchedMovies = searchMoviesData.filter(movie => movie.title.toLowerCase().includes(searchQuery));

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
</body>

</html>