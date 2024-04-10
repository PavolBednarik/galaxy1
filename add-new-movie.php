<?php

require_once("header.php");
require_once("helpers.php");
?>
<br>
<br>
<br>
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Add New Movie Form</h5>
                </div>
                <div class="card-body">

                    <form action="/path/to/server/endpoint" method="post" enctype="multipart/form-data">
                        <div>
                            <label for="title">Title:</label>
                            <input type="text" id="title" name="title" required>
                        </div>

                        <div>

                            <label for="synopsis">Synopsis:</label>
                            <textarea id="synopsis" name="synopsis" required></textarea>
                        </div>
                        <div>
                            <select id="actors" name="actors[]" multiple required></select>
                            <button type="button" id="addActorBtn">Add New Actor</button>
                        </div>
                        <div>
                            <div>
                                <select id="genre" name="genre[]" multiple required>
                                    <?php if (!empty($genres)) : ?>
                                        <?php foreach ($genres as $genre) : ?>
                                            <option value="<?php echo htmlspecialchars($genre['genre_id']); ?>">
                                                <?php echo htmlspecialchars($genre['name']); ?>
                                            </option>
                                        <?php endforeach; ?>
                                    <?php else : ?>
                                        <option value="">No genres available</option>
                                    <?php endif; ?>
                                </select>
                            </div>

                        </div>
                        <div>
                            <label for="runtime">Runtime (in minutes):</label>
                            <input type="number" id="runtime" name="runtime" required>
                        </div>

                        <div>
                            <label for="poster">Movie Poster:</label>
                            <input type="file" id="poster" name="poster" accept="image/*" required>
                        </div>
                        <div>
                            <label for="picture1">Additional Picture 1:</label>
                            <input type="file" id="picture1" name="picture1" accept="image/*">
                        </div>
                        <div>
                            <label for="picture2">Additional Picture 2:</label>
                            <input type="file" id="picture2" name="picture2" accept="image/*">
                        </div>
                        <div>
                            <label for="picture3">Additional Picture 3:</label>
                            <input type="file" id="picture3" name="picture3" accept="image/*">
                        </div>
                        <div>
                            <label for="video_name">Video Name:</label>
                            <input type="text" id="video_name" name="video_name" required>
                        </div>
                        <div>
                            <label for="youtube_id">YouTube ID:</label>
                            <input type="text" id="youtube_id" name="youtube_id" required>
                        </div>
                        <div>
                            <button type="submit">Add Movie</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<br>
<br>
<br>



<?php

require_once("footer.php");

?>