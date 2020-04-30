<?php
namespace Anax\View;

?>

<form method="get" action="<?= url("movie/search-year") ?>">
    <input type="hidden" name="route" value="search-year">
    <p>
        <label>Created between:
        <input type="number" name="year1" value="<?= $year1 ?: 1900 ?>" min="1900" max="2100"/>
        -
        <input type="number" name="year2" value="<?= $year2  ?: 2100 ?>" min="1900" max="2100"/>
        </label>
        <input type="submit" name="doSearch" value="Search">
    </p>
</form>

<p>
<a href="<?= url("movie") ?>">Show all movies</a>
</p>
