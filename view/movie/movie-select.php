<?php
namespace Anax\View;

?>

<form method="post" action="movie-add-process">
<p>
    <input type="submit" name="doAdd" value="Add new movie">
</p>
</form>

<form method="get" action="movie-edit">
    <fieldset>
    <legend>Select Movie</legend>

    <p>
        <label>Movie:<br>
        <select name="movieId">
            <option value="">Select movie...</option>
            <?php foreach ($movies as $movie) : ?>
            <option value="<?= $movie->id ?>"><?= $movie->title ?></option>
            <?php endforeach; ?>
        </select>
    </label>
    </p>

    <p>
        <input type="submit" name="doSelect" value="Select">
    </p>
    <p><a href="<?= url("movie") ?>">Show all movies</a></p>
    </fieldset>
</form>
