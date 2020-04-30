<?php
namespace Anax\View;

?>

<form method="get" action="<?= url("movie/search-title") ?>">
    <input type="hidden" name="route" value="search-title">
    <p>
        <label>Title (use % as wildcard):
            <input type="search" name="searchTitle" value="<?= $searchTitle ?>"/>
        </label>
        <input type="submit" name="doSearch" value="Search">
    </p>
</form>
