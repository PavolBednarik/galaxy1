<?php

require_once("header.php");



$cinemaName = $_GET['name'] ?? '';

if ($cinemaName == 'Galaxy Coolock') {
    echo get_coolock_movies();
} elseif ($cinemaName == 'Galaxy Rathmines') {
    echo get_rathmines_movies();
} else {
    echo json_encode([]);
}
?>
<br>
<br>
<br>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Booking Form</h5>
                </div>
                <div class="card-body">
                    <form>
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" class="form-control" id="name" placeholder="Enter your name">
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" class="form-control" id="email" placeholder="Enter your email">
                        </div>
                        <div class="form-group">
                            <label for="cinema">Cinema</label>
                            <select class="form-control" id="cinema" name="cinema" onchange="populateMovies()">
                                <option value="">Select Cinema</option>
                                <option value="Galaxy Coolock">Galaxy Coolock</option>
                                <option value="Galaxy Rathmines">Galaxy Rathmines</option>
                            </select>

                        </div>
                        <div class="form-group">
                            <label for="movie">Movie</label>
                            <select class="form-control" id="movie" name="movie">
                                <option value="">Select Movie</option>
                                <!-- Movie options will be added here by populateMovies() -->
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="date">Date</label>
                            <input type="date" class="form-control" id="date">
                        </div>
                        <div class="form-group">
                            <label for="time">Time</label>
                            <select class="form-control" id="time">
                                <option value="">Select Time</option>
                                <option value="14:00">14:00</option>
                                <option value="16:00">16:00</option>
                                <option value="18:00">18:00</option>
                                <option value="20:00">20:00</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    document.getElementById("cinema").addEventListener("change", function() {
        populateMovies();
    });

    function populateMovies() {
        const cinemaName = document.getElementById('cinema').value;
        if (!cinemaName) {
            document.getElementById("movie").innerHTML = '<option>Select a cinema first</option>';
            return;
        }


        fetch('fetch_movies_by_cinema.php?cinemaName=' + encodeURIComponent(cinemaName))
            .then(response => response.json())
            .then(data => {
                const movieSelect = document.getElementById("movie");
                movieSelect.innerHTML = '<option value="">Select Movie</option>'; // Clear existing options
                data.forEach(movie => {
                    const option = new Option(movie.title, movie.movie_id);
                    movieSelect.add(option);
                });
            })
            .catch(error => console.error('Error fetching movies:', error));
    }

    document.addEventListener('DOMContentLoaded', function() {
        const today = new Date();
        const todayFormatted = today.toISOString().split('T')[0];
        document.getElementById("date").setAttribute('min', todayFormatted);

        // Function to update available times
        function updateAvailableTimes() {
            const timeSelect = document.getElementById("time");
            const selectedDate = new Date(document.getElementById("date").value);
            selectedDate.setHours(0, 0, 0, 0);
            today.setHours(0, 0, 0, 0);

            // Clear existing options
            timeSelect.innerHTML = '<option value="">Select Time</option>';

            // Define your booking times
            const times = ["14:00", "16:00", "18:00", "20:00"];
            const currentTime = new Date();

            times.forEach(function(time) {
                const [hours, minutes] = time.split(':');
                const optionDate = new Date(selectedDate.getTime());
                optionDate.setHours(hours, minutes);

                // Add option if it's for a future date or time
                if (selectedDate > today || (selectedDate.getTime() === today.getTime() && currentTime < optionDate)) {
                    const option = new Option(time, time);
                    timeSelect.options.add(option);
                }
            });
        }

        // Update times when the date changes
        document.getElementById("date").addEventListener('change', updateAvailableTimes);

        // Set initial available times
        updateAvailableTimes();
    });

    function populateMovies(cinemaName) {
        if (!cinemaName) {
            document.getElementById("movie").innerHTML = '<option>Select a cinema first</option>';
            return;
        }


        fetch('fetch_movies_by_cinema.php?cinemaName=' + encodeURIComponent(cinemaName))
            .then(response => response.json())
            .then(data => {
                const movieSelect = document.getElementById("movie");
                movieSelect.innerHTML = '<option value="">Select Movie</option>'; // Clear existing options
                data.forEach(movie => {
                    const option = new Option(movie.title, movie.movie_id);
                    movieSelect.add(option);
                });
            })
            .catch(error => console.error('Error fetching movies:', error));
    }
</script>
<br>
<br>
<br>
<br>


<?php

require_once("footer.php");

?>