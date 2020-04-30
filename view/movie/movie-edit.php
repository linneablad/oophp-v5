<?php
namespace Anax\View;

?>

<form method="post" action="movie-edit-process">
    <fieldset>
    <legend>Edit</legend>
    <input type="hidden" name="movieId" value="<?= $movie->id ?>"/>

    <p>
        <label>Title:<br>
        <input type="text" name="movieTitle" value="<?= $movie->title ?>"/>
        </label>
    </p>

    <p>
        <label>Year:<br>
        <input type="number" name="movieYear" value="<?= $movie->year ?>"/>
    </p>

    <p>
        <label>Image:<br>
        <input type="text" name="movieImage" value="<?= $movie->image ?>"/>
        </label>
    </p>

    <p>
        <input type="submit" name="doSave" value="Save">
        <input type="reset" value="Reset">
        <input type="submit" name="doDelete" value="Delete">
    </p>
    <p>
        <a href="<?= url("movie/movie-select") ?>">Select movie</a> |
        <a href="<?= url("movie") ?>">Show all movies</a>
    </p>
    </fieldset>
</form>
