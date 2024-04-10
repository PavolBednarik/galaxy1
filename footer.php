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

    // Generate a random CAPTCHA code
        function generateCaptcha() {
            var captcha = '';
            var characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
            for (var i = 0; i < 6; i++) {
                captcha += characters.charAt(Math.floor(Math.random() * characters.length));
            }
            return captcha;
        }

        // Populate the CAPTCHA text and store it in session storage
        var captchaText = generateCaptcha();
        document.getElementById('captchaText').textContent = captchaText;
        sessionStorage.setItem('captcha', captchaText);

        // Validate the CAPTCHA on form submission
        document.getElementById('sign-in-form').addEventListener('submit', function(event) {
            var userInput = document.getElementById('captcha').value;
            var storedCaptcha = sessionStorage.getItem('captcha');
            if (userInput !== storedCaptcha) {
                alert('CAPTCHA incorrect!');
                event.preventDefault(); // Prevent form submission
            }
        });

        function validateForm() {
            var name = document.getElementById('inputName').value.trim();
            var surname = document.getElementById('inputSurname').value.trim();
            var username = document.getElementById('inputUsername').value.trim();
            var email = document.getElementById('inputEmail').value.trim();
            var phone = document.getElementById('inputPhone').value.trim();
            var password = document.getElementById('inputPassword').value;
            var confirmPassword = document.getElementById('confirmPassword').value;

            // Check if any field is empty
            if (name === '' || surname === '' || email === '' || phone === '' || password === '' || confirmPassword === '') {
                alert('Please fill in all fields.');
                return false;
            }

            // Check if email is valid
            var emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailPattern.test(email)) {
                alert('Please enter a valid email address.');
                return false;
            }
            var phonePattern = /^0\d{9}$/;
            if (!phonePattern.test(phone)) {
                alert('Please enter a valid Irish mobile phone number starting with "0" and consisting of exactly 10 digits.');
                return false;
            }

            // Check if passwords match
            if (password !== confirmPassword) {
                alert('Passwords do not match.');
                return false;
            }

            // Check if password meets criteria (e.g., minimum length)
            if (password.length < 8) {
                alert('Password must be at least 8 characters long.');
                return false;
            }

            // If all validation passes, return true to submit the form
            return true;
        }
        
        // If session contains error or success message, open sign in modal
        if ('<?php echo isset($_SESSION['register_error']) || isset($_SESSION['register_success']); ?>') {
            $('#signInModal').modal('show');
        }

        // If session contains error or success message, open sign in modal
        if ('<?php echo isset($_SESSION['login_error']) || isset($_SESSION['login_success']); ?>') {
            $('#loginModal').modal('show');
        }
  </script>
</body>
</html>
<?php

// Unset session variables
unset($_SESSION['login_error']);
unset($_SESSION['register_error']);
unset($_SESSION['register_success']);
